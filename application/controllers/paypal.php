<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paypal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_register', 'objregister');
        $this->load->library('paypal_lib');
    }

    function index() {
        $post = $this->input->post();
//        echo '<pre>';
//        print_r($post);
//        die();
        $this->session->set_flashdata($post);
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
        $this->paypal_lib->set_acct_info($gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->api_signature);

        $requestParams = array(
            'RETURNURL' => site_url() . 'paypal/consolidate',
            'CANCELURL' => site_url() . 'home',
        );

        $recurring = array(
            'L_BILLINGTYPE0' => 'RecurringPayments',
            'L_BILLINGAGREEMENTDESCRIPTION0' => $post['item_name']
        );
        $response = $this->paypal_lib->request('SetExpressCheckout', $requestParams + $recurring);
        print_r($response);
        die();
        if (is_array($response) && $response['ACK'] == 'Success') { //Request successful
            $token = $response['TOKEN'];

            if ($this->paypal_lib->is_sandbox)
                echo 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
            else
                echo 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
        } else {
//            echo 'Not Called';
            return false;
        }
    }

    function consolidate() {
        if ($this->input->get('token')) { // Token parameter exists
            $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
            $this->paypal_lib->set_acct_info(
                    $gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->api_signature
            );
            $checkoutDetails = $this->paypal_lib->request('GetExpressCheckoutDetails', array('TOKEN' => $this->input->get('token')));

            $can_register = $this->wi_authex->email_exists($checkoutDetails['EMAIL']);
            if (!$can_register) {
                $this->db->trans_start();
                $uid = $this->insertUser($checkoutDetails);

                $planid = ($this->session->flashdata('item_name') == "wishfish-personal") ? 2 : 3;
                $planAmt = $this->session->flashdata('amount');
                $code = $this->session->flashdata('code');

                // Complete the checkout transaction
                $requestParams = array(
                    'TOKEN' => $this->input->get('token'),
                    'PROFILESTARTDATE' => $checkoutDetails['TIMESTAMP'],
                    'DESC' => $this->session->flashdata('item_name'),
                    'BILLINGPERIOD' => 'Month',
                    'PROFILEREFERENCE' => $uid,
                    'BILLINGFREQUENCY' => 1,
                    'TOTALBILLINGCYCLES' => 0,
                    'AMT' => $planAmt,
                    'CURRENCYCODE' => 'USD',
                    'MAXFAILEDPAYMENTS' => 3,
                    'FAILEDINITAMTACTION' => 'CancelOnFailure'
                );

                $coupon = $this->objregister->checkCoupon($code);
                if (!empty($coupon)) {
                    if ($coupon->coupon_validity != '3') {
                        $requestParams['TRIALBILLINGPERIOD'] = 'Month';
                        $requestParams['TRIALBILLINGFREQUENCY'] = 1;
                        $amt = ($coupon->disc_type == "F") ?
                                $planAmt - $coupon->disc_amount :
                                $planAmt - ($planAmt * ($coupon->disc_amount / 100));
                        $requestParams['TRIALAMT'] = number_format($amt, 2);
                        $requestParams['TRIALTOTALBILLINGCYCLES'] = ($coupon->coupon_validity == '1') ?
                                1 : $coupon->month_duration;
                    } else {
                        $amt = ($coupon->disc_type == "F") ?
                                $planAmt - $coupon->disc_amount :
                                $planAmt - ($planAmt * ($coupon->disc_amount / 100));
                        $requestParams['AMT'] = number_format($amt, 2);
                    }
                }

                $response = $this->paypal_lib->request('CreateRecurringPaymentsProfile', $requestParams);
                if (is_array($response) && $response['ACK'] == 'Success') {
                    if ($code != "")
                        $this->objregister->updateCoupon($code);
                    if (!empty($coupon) && $coupon->coupon_validity != '3') {
                        $response['AMT'] = $requestParams['TRIALAMT'];
                    } else {
                        $response['AMT'] = $requestParams['AMT'];
                    }

                    $this->insertPlanDetail($uid, $planid, $response);
                    $this->insertUserSetting($uid);
                    $this->session->set_userdata('d-userid', $uid);
                    $this->session->set_userdata('d-name', $checkoutDetails['FIRSTNAME'] . ' ' . $checkoutDetails['LASTNAME']);
                    $this->sendMail($checkoutDetails, $uid);
                    $this->db->trans_complete();
                    header('Location:' . site_url() . 'app/dashboard');
                } else {
                    $this->db->trans_off();
                    header('Location:' . site_url() . 'home');
                }
            } else {
                $this->load->view('stripe_error');
            }
        }
    }

    function insertUser($data) {
        $user_set = array(
            'referral_code' => $this->wi_common->getRandomDigit(6),
            'name' => $data['FIRSTNAME'] . ' ' . $data['LASTNAME'],
            'email' => $data['EMAIL'],
            'password' => $this->generateRandomString(5),
            'customer_id' => $data['PAYERID'],
            'gateway' => "PAYPAL",
            'is_set' => 1,
            'register_date' => date('Y-m-d H:i:s', strtotime($data['TIMESTAMP']))
        );
        $this->db->insert('wi_user_mst', $user_set);
        return $this->db->insert_id();
    }

    function insertPlanDetail($userid, $planid, $data) {

        $start_dt = date('Y-m-d', strtotime($data['TIMESTAMP']));
        $expiry_date = $this->wi_common->getNextDate($start_dt, '1 months');

        $amount = $data['AMT'];
        $planInfo = $this->wi_common->getPlan($planid);
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
        $this->db->insert('wi_plan_detail', $plan_set);
        return true;
    }

    function insertUserSetting($uid) {
        $set = array(
            'user_id' => $uid,
            'redirect_uri' => site_url() . 'app/calender'
        );
        $this->db->insert('wi_user_setting', $set);
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function cancelled() {
        header('location:' . site_url() . 'home');
    }

    function sendMail($post, $userid) {
        $uid = $this->encryption->encode($userid);
        $templateInfo = $this->wi_common->getAutomailTemplate("NEW USER REGISTRATION");
        $url = site_url() . 'app/dashboard?uid=' . $uid;
        $link = "<table border='0' align='center' cellpadding='0' cellspacing='0' class='mainBtn' style='margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;'>";
        $link .= "<tr>";
        $link .= "<td align='center' valign='middle' class='btnMain' style='margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 12px;padding-bottom: 12px;padding-left: 22px;padding-right: 22px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: {$templateInfo['color']};height: 20px;font-size: 18px;line-height: 20px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;'>
                                            <a href='{$url}' style='padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #ffffff;font-weight: bold;'>
                                                <span style='text-decoration: none;color: #ffffff;'>
                                                    Activate Your Account
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

        return $this->wi_common->sendAutoMail($post['EMAIL'], $subject, $body, $from, $name);
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */    