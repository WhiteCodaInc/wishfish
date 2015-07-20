<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ipn_listener
 *
 * @author Laxmisoft
 */
class Plan_ipn_listener extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
//        require_once(FCPATH . 'stripe/lib/Stripe.php');
//        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function index() {

        define("DEBUG", 1);
        // Set to 0 once you're ready to go live
        define("USE_SANDBOX", 1);
        define("LOG_FILE", FCPATH . "ipn.log");

        // Read POST data
        // reading posted data directly from $this->input->post causes serialization
        // issues with array data in POST. Reading raw POST data from input stream instead.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Post IPN data back to PayPal to validate the IPN data is genuine
        // Without this step anyone can fake IPN data

        if (USE_SANDBOX == true) {
            $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        } else {
            $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
        }

        $ch = curl_init($paypal_url);
        if ($ch == FALSE) {
            return FALSE;
        }

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        if (DEBUG == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

        // CONFIG: Optional proxy configuration
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
        // of the certificate as shown below. Ensure the file is readable by the webserver.
        // This is mandatory for some environments.
        //$cert = __DIR__ . "./cacert.pem";
        //curl_setopt($ch, CURLOPT_CAINFO, $cert);

        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) { // cURL error
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
            exit;
        } else {
            // Log the entire HTTP response if debug is switched on.
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "HTTP request of validation request:" . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
                error_log(date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);

                // Split response headers and payload
                list($headers, $res) = explode("\r\n\r\n", $res, 2);
            }
            curl_close($ch);
        }

        // Inspect IPN validation result and act accordingly
        $myfile = fopen(FCPATH . 'paypal.txt', "a");
        fwrite($myfile, "-----------RES : {$res}-------------- \n");
        if (strcmp($res, "VERIFIED") == 0) {
            fwrite($myfile, "-----------VERIFIED-------------- \n");
            $data = $this->input->post();
            $cnt = 1;
            if (count($data)) {
                fwrite($myfile, "-----------POST DATA DESCRIBE BELOW :-------------- \n");
            } else {
                fwrite($myfile, "-----------POST DATA NOT SENT -------------- \n");
            }
            fwrite($myfile, "-----------{$data['txn_type']}-------------- \n");
            foreach ($data as $key => $value) {
                fwrite($myfile, "{$cnt}. {$key} => {$value} \n");
                $cnt++;
            }
            fwrite($myfile, "-----------END {$data['txn_type']}-------------- \n");
            switch ($data['txn_type']) {
                case "recurring_payment":
                    $userid = $data['rp_invoice_id'];
                    $currPlan = $this->wi_common->getLatestPlan($userid);
                    $this->insertPaymentDetail($currPlan->id, $data);
                    break;
                case "recurring_payment_profile_cancel":
                    $this->db->select('*');
                    $query = $this->db->get_where('wi_payment_mst', array('transaction_id' => $data['recurring_payment_id']));
                    $res = $query->row();
                    $set = array(
                        'plan_status' => 0,
                        'cancel_date' => date('Y-m-d')
                    );
                    $where = array(
                        'id' => $res->id
                    );
                    $this->db->update('wi_plan_detail', $set, $where);
                    break;
            }
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL, 3, LOG_FILE);
            }
        } else if (strcmp($res, "INVALID") == 0) {
            fwrite($myfile, "-----------INVALID-------------- \n");
            // log for manual investigation
            // Add business logic here which deals with invalid IPN messages
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
            }
        }
        fwrite($myfile, "-----------NOT CALLED-------------- \n");
    }

    function insertPaymentDetail($pid, $data) {
        $insert_set = array(
            'id' => $pid,
            'transaction_id' => $data['recurring_payment_id'],
            'invoice_ud' => $data['txn_id '],
            'payer_id' => $data['payer_id'],
            'payer_email' => $data['payer_email'],
            'mc_gross' => $data['mc_gross'],
            'mc_fee' => $data['mc_fee'],
            'gateway' => "PAYPAL",
            'payment_date' => date('Y-m-d', strtotime($data['payment_date']))
        );
        $this->db->insert('wi_payment_mst', $insert_set);
    }

}
