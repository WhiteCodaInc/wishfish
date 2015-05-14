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
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->load->library('common');
        $this->load->model('app/m_company_register', 'objCompanyRegsiter');
        $this->load->model('admin/m_affiliate', 'objaffiliate');
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

//            $payer_id = $this->input->post['recurring_payment_id'];
//            mail('bhadresh.sidapara@gmail.com', 'message', $payer_id);
//            if (file_exists('newfile.txt')) {
//                $myfile = fopen(FCPATH . 'newfile.txt', "a");
//                fwrite($myfile," New This is Successfully Done" );
//                fwrite($myfile, "\n");
//            } else {
//                $myfile = fopen(FCPATH . 'newfile.txt', "w");
//                fwrite($myfile,"This is Successfully Done \n");
//            }


            switch ($data['txn_type']) {
                case "subscr_signup":
                    $compid = $data['custom'];
                    $type = explode('+', $data['period3']);
                    $dt = date('Y-m-d', strtotime($data['subscr_date']));
                    $expiry_date = $this->getExpiryDate($dt, $type[0]);

                    $this->db->select('*');
                    $where = array(
                        'comp_id' => $compid,
                        'plan_status' => 1
                    );
                    $query = $this->db->get_where('plan_upgrade_mst', $where);
                    if ($query->num_rows() > 0) {
                        // Deactive Old Plan
                        $deactive_set = array(
                            'plan_status' => 0
                        );
                        $deactive_where = array(
                            'upgrade_id' => $query->row()->upgrade_id
                        );
                        $this->db->update('plan_upgrade_mst', $deactive_set, $deactive_where);

                        $active_set = array(
                            'plan_status' => 1,
                            'start_date' => date('Y-m-d', strtotime($data['subscr_date'])),
                            'expiry_date' => $expiry_date
                        );
                        $active_where = array(
                            'upgrade_id' => $data['invoice']
                        );
                        $this->db->update('plan_upgrade_mst', $active_set, $active_where);

                        // Delete Pending Plan
                        $delete_where = array(
                            'comp_id' => $compid,
                            'plan_status' => 2
                        );
                        $this->db->delete('plan_upgrade_mst', $delete_where);
                    } else {
                        $active_set = array(
                            'plan_status' => 1,
                            'start_date' => date('Y-m-d', strtotime($data['subscr_date'])),
                            'expiry_date' => $expiry_date
                        );
                        $active_where = array(
                            'upgrade_id' => $data['invoice']
                        );
                        $this->db->update('plan_upgrade_mst', $active_set, $active_where);
                    }
                    $result = $this->db->get_where('plan_upgrade_mst', array('upgrade_id' => $data['invoice']));
                    $notify = array(
                        'comp_id' => $compid,
                        'plan_id' => $result->row()->plan_id,
                        $result->row()->amount,
                        'type' => "new"
                    );
                    $this->db->insert('plan_notification', $notify);

                    //------------------- Affiliate Info----------------------//
                    $uname = get_cookie('affiliate_user', TRUE);
                    $setting = $this->objaffiliate->setting();

                    if ($this->authex->isAffiliateExist($uname)) {
                        $aff = $this->objaffiliate->getAffiliateDetail($uname);
                        $aff_detail = $this->objaffiliate->getAffiliateInfo($aff->affiliate_id);

                        $reff_set = array(
                            'affiliate_id' => $aff->affiliate_id,
                            'comp_id' => $compid,
                            'plan_id' => $result->row()->plan_id,
                            'register_date' => date('Y-m-d'),
                            'end_date' => $this->common->getNextDate(date('Y-m-d'), $setting->register_duration . ' months')
                        );
                        switch ($reff_set['plan_id']) {
                            case 2:
                                $reff_set['earn'] = $aff_detail->plan1;
                                break;
                            case 3:
                                $reff_set['earn'] = $aff_detail->plan2;
                                break;
                            case 4:
                                $reff_set['earn'] = $aff_detail->plan3;
                                break;
                        }
                        $this->db->insert('affiliate_referal', $reff_set);

                        $aff_set['pending'] = $aff->pending + $reff_set['earn'];
                        $this->db->update('affiliates', $aff_set, array('affiliate_id' => $aff->affilaite_id));
                        $compInfo = $this->common->getCompanyInfo($compid);
                        $this->sendEmail($aff_detail, $compInfo, $reff_set);
                    }
                    break;

                case "subscr_payment":
                    $insert_set = array(
                        'upgrade_id' => $data['invoice'],
                        'transaction_id' => $data['txn_id'],
                        'payer_id' => $data['payer_id'],
                        'payer_email' => $data['payer_email'],
                        'business' => $data['business'],
                        'mc_gross' => $data['mc_gross'],
                        'mc_fee' => $data['mc_fee'],
                        'payment_status' => $data['payment_status'],
                        'gateway' => "PAYPAL",
                        'payment_date' => date('Y-m-d', strtotime($data['payment_date']))
                    );
                    $this->db->insert('payment_mst', $insert_set);

                    $where_set = array(
                        'upgrade_id' => $data['invoice']
                    );
                    //-----------------------Plan Upgrade---------------------//
                    $result = $this->db->get_where('plan_upgrade_mst', $where_set);
                    $res = $query->result_array();

                    $interval = $this->getDateDiff($res[0]['start_date'], $res[0]['start_date']);
                    $nextdt = $this->getExpiryDate($insert_set['payment_date'], $interval);

                    $update_set = array(
                        'start_date' => $insert_set['payment_date'],
                        'expiry_date' => $nextdt
                    );
                    $this->db->update('plan_upgrade_mst', $update_set, $where_set);
                    //--------------------------------------------------------//
                    $this->sendMail($res[0], "PAYMENT NOTIFICATION", $insert_set);
                    break;
                case "subscr_eot":
                case "subscr_cancel":
                    $result = $this->db->get_where('plan_upgrade_mst', array('upgrade_id' => $data['invoice']));
                    $notify = array(
                        'comp_id' => $result->row()->comp_id,
                        'plan_id' => $result->row()->plan_id,
                        'amount' => $result->row()->amount,
                        'type' => "old"
                    );
                    $this->db->insert('plan_notification', $notify);
                    $this->db->update('plan_upgrade_mst', array('plan_status' => 0, 'cancel_date' => date('Y-m-d', strtotime($data['subscr_date']))), array('upgrade_id' => $data['invoice']));
                    $this->sendMail($notify, "ACCOUNT CANCELLED");
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

    function getDateDiff($dt1, $dt2) {
        $datetime1 = date_create($dt1);
        $datetime2 = date_create($dt2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format('%m');
    }

    function getExpiryDate($dt, $interval) {
        switch ($interval) {
            case 1:
                $expiry_date = $this->common->getNextDate($dt, '1 months');
                break;
            case 6:
                $expiry_date = $this->common->getNextDate($dt, '6 months');
                break;
            case 12:
                $expiry_date = $this->common->getNextDate($dt, '12 months');
                break;
        }
        return $expiry_date;
    }

    function sendMail($data, $type, $paypal = NULL) {

        $templateInfo = $this->common->getAdminEmailTemplate($type);
        $companyInfo = $this->common->getCompanyInfo($data['comp_id']);

        if ($type == "ACCOUNT CANCELLED") {
            $tag = array(
                'CONTACT_NAME' => $companyInfo->contact_name,
                'NAME' => $companyInfo->comp_name,
                'USERNAME' => $companyInfo->comp_username,
                'PLAN_NAME' => $this->objCompanyRegsiter->getPlanName($data['plan_id'])->plan_name,
                'DATE' => date('d-M-Y h:i:s')
            );
            $subject_tag = array();
        } else {
            $interval = $this->getDateDiff($data['start_date'], $data['expiry_date']);
            $expiry_date = $this->getExpiryDate($paypal['payment_date'], $interval);
            $tag = array(
                'CONTACT_NAME' => $companyInfo->contact_name,
                'NAME' => $companyInfo->comp_name,
                'USERNAME' => $companyInfo->comp_username,
                'AMOUNT' => $data['amount'],
                'PLAN_NAME' => $this->objCompanyRegsiter->getPlanName($data['plan_id'])->plan_name,
                'DATE' => date('d-M-Y', strtotime($paypal['payment_date'])),
                'EXPIRE_DATE' => date('d-M-Y', $expiry_date)
            );
            $subject_tag = array();
        }
        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $subject_tag, TRUE);

        $this->load->view('admin/email_format', $templateInfo);
        $body = $this->parser->parse('admin/email_format', $tag);

        $config = $this->common->getEmailConfig();
        if ($config) {
            $this->email->initialize($config);
        }

        $this->email->from($templateInfo['from'], $templateInfo['name']);
        $this->email->to($companyInfo->comp_email);
        $this->email->subject($subject);
        $this->email->message($body);

        if ($this->email->send())
            return TRUE;
        else
            echo $this->email->print_debugger();
    }

    function sendEmail($affInfo, $company, $referal) {
        $templateInfo = $this->common->getAffiliateEmailTemplate("NEW CUSTOMER JOIN");
        $tag = array(
            'CONTACT_NAME' => $affInfo->name,
            'COMPANY_NAME' => $company->comp_name,
            'AMOUNT' => $referal['earn']
        );
        $subject_tag = array();
        $email = $affInfo->email;
        $replyTo = $templateInfo['from'];
        $from = $templateInfo['name'];

        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $subject_tag, TRUE);

        $this->load->view('admin/email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('admin/email_format', $tag, TRUE);


        $config = $this->common->getEmailConfig();
        if ($config) {
            $this->email->initialize($config);
        }

        $this->email->from($replyTo, $from);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
        //echo $this->email->print_debugger();
    }

}
