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
        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
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

        if (strcmp($res, "VERIFIED") == 0) {

            $data = $this->input->post();
            $myfile = fopen(FCPATH . 'paypal.txt', "a");
//            fwrite($myfile, $data . "\n");
            $planid = ($data['item_name'] == "wishfish-personal") ? 2 : 3;

            switch ($data['txn_type']) {
                case "subscr_signup":
                    $userid = $data['custom'];
                    if ($userid != "") {
                        $currPlan = $this->common->getLatestPlan($userid);
                        if ($currPlan->plan_status == 1) {
                            try {
                                $uInfo = $this->common->getUserInfo($userid);
                                $customer = Stripe_Customer::retrieve($uInfo->customer_id);
                                if (isset($customer->subscriptions->data[0]->id)) {
                                    $subs = $customer->subscriptions->data[0]->id;
                                    $customer->subscriptions->retrieve($subs)->cancel();
                                } else {
                                    fwrite($myfile, "PLAN DOES NOT EXIST....!" . "\n");
                                }
                            } catch (Exception $e) {
                                $error = $e->getMessage();
                                fwrite($myfile, $error . "\n");
                            }
                        }
                        $this->updateUser($userid, $data);
                        $pid = $this->insertPlanDetail($userid, $planid, $data);
                        $this->insertPaymentDetail($pid, $data);
                    } else {
                        $uid = $this->insertUser($data);
                        $pid = $this->insertPlanDetail($uid, $planid, $data);
                        $this->insertPaymentDetail($pid, $data);
                    }
                    break;
                case "subscr_payment":
                    break;
                case "subscr_eot":
                case "subscr_cancel":
                    $this->db->select('*');
                    $query = $this->db->get_where('payment_mst', array('transaction_id' => $data['subscr_id']));
                    $res = $query->row();
                    $set = array(
                        'plan_status' => 0,
                        'cancel_date' => date('Y-m-d')
                    );
                    $where = array(
                        'id' => $res->id
                    );
                    $this->db->update('plan_detail', $set, $where);
                    break;
            }


            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL, 3, LOG_FILE);
            }
        } else if (strcmp($res, "INVALID") == 0) {
            // log for manual investigation
            // Add business logic here which deals with invalid IPN messages
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
            }
        }
    }

    function updateUser($userid, $data) {
        $user_set = array(
            'customer_id' => $data['payer_id'],
            'gateway' => "PAYPAL",
            'is_set' => 1
        );
        $this->db->update('user_mst', $user_set, array('user_id' => $userid));
    }

    function insertUser($data) {
        $user_set = array(
            'email' => $data['payer_email'],
            'password' => $this->generateRandomString(5),
            'customer_id' => $data['payer_id'],
            'gateway' => "PAYPAL",
            'is_set' => 1,
            'register_date' => date('Y-m-d', strtotime($data['subscr_date']))
        );
        $this->db->insert('user_mst', $user_set);
        return $this->db->insert_id();
    }

    function insertPlanDetail($userid, $planid, $data) {

        $start_dt = date('Y-m-d', strtotime($data['subscr_date']));
        $expiry_date = $this->common->getNextDate($start_dt, '1 months');

        $amount = $data['mc_amount3'];
        $planInfo = $this->common->getPlan($planid);
        $plan_set = array(
            'user_id' => $userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => $start_dt,
            'expiry_date' => $expiry_date
        );
        $this->db->insert('plan_detail', $plan_set);
        return $this->db->insert_id();
    }

    function insertPaymentDetail($pid, $data) {
        $amount = $data['mc_amount3'];
        $insert_set = array(
            'id' => $pid,
            'transaction_id' => $data['subscr_id'],
            'payer_id' => $data['payer_id'],
            'payer_email' => $data['payer_email'],
            'mc_gross' => $amount,
            'gateway' => "PAYPAL",
            'payment_date' => date('Y-m-d', strtotime($data['subscr_date']))
        );
        $this->db->insert('payment_mst', $insert_set);
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function sendMail($post, $userid) {
        $uid = $this->encryption->encode($userid);
        $templateInfo = $this->common->getAutomailTemplate("NEW USER REGISTRATION");
        $url = site_url() . 'app/dashboard?uid=' . $uid;
        $link = "<table border='0' align='center' cellpadding='0' cellspacing='0' class='mainBtn' style='margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;'>";
        $link .= "<tr>";
        $link .= "<td align='center' valign='middle' class='btnMain' style='margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 12px;padding-bottom: 12px;padding-left: 22px;padding-right: 22px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: {$templateInfo['color']};height: 20px;font-size: 18px;line-height: 20px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;'>
                                            <a href='{$url}' style='padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #ffffff;font-weight: bold;'>
                                                <span style='text-decoration: none;color: #ffffff;'>
                                                    Active Your Account
                                                </span>
                                            </a>
                                        </td>";
        $link .= "</tr></table>";
        $tag = array(
            'NAME' => "User",
            'LINK' => $link,
            'THISDOMAIN' => "Wish-Fish"
        );
        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $tag, TRUE);
        $this->load->view('email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('email_format', $tag, TRUE);

        $from = ($templateInfo['from'] != "") ? $templateInfo['from'] : NULL;
        $name = ($templateInfo['name'] != "") ? $templateInfo['name'] : NULL;

        return $this->common->sendAutoMail($post['email'], $subject, $body, $from, $name);
    }

}
