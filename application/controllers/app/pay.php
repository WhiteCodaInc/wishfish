<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pay extends CI_Controller {

    var $userid;

    function __construct() {
        parent::__construct();
        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        $this->load->library('paypal_lib');
        $this->userid = $this->session->userdata('userid');
    }

    function index() {
        $gatewayInfo = $this->common->getPaymentGatewayInfo("PAYPAL");
        $this->paypal_lib->set_acct_info($gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->api_signature);

        $requestParams = array(
            'RETURNURL' => site_url() . 'app/pay/consolidate',
            'CANCELURL' => site_url() . 'app/dashboard',
        );

        $recurring = array(
            'L_BILLINGTYPE0' => 'RecurringPayments',
            'L_BILLINGAGREEMENTDESCRIPTION0' => "wishfish-personal"
        );
        $response = $this->paypal_lib->request('SetExpressCheckout', $requestParams + $recurring);

        if (is_array($response) && $response['ACK'] == 'Success') { //Request successful
            $token = $response['TOKEN'];

            if ($this->paypal_lib->is_sandbox)
                echo 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
            else
                echo 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
        } else {
            return false;
        }
    }

    function consolidate() {
        if ($this->input->get('token')) { // Token parameter exists
            $gatewayInfo = $this->common->getPaymentGatewayInfo("PAYPAL");
            $this->paypal_lib->set_acct_info(
                    $gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->api_signature
            );
            $checkoutDetails = $this->paypal_lib->request('GetExpressCheckoutDetails', array('TOKEN' => $this->input->get('token')));
            // Complete the checkout transaction
            $requestParams = array(
                'TOKEN' => $this->input->get('token'),
                'PROFILESTARTDATE' => $checkoutDetails['TIMESTAMP'],
                'DESC' => "wishfish-personal",
                'BILLINGPERIOD' => 'Month',
                'PROFILEREFERENCE' => $this->userid,
                'BILLINGFREQUENCY' => 1,
                'TOTALBILLINGCYCLES' => 0,
                'AMT' => '9.99',
                'CURRENCYCODE' => 'USD',
                'MAXFAILEDPAYMENTS' => 3,
                'FAILEDINITAMTACTION' => 'CancelOnFailure'
            );

            $response = $this->paypal_lib->request('CreateRecurringPaymentsProfile', $requestParams);
            if (is_array($response) && $response['ACK'] == 'Success') {
                $currPlan = $this->common->getLatestPlan($this->userid);
                if ($currPlan->plan_status == 1) {
                    try {
                        $uInfo = $this->common->getUserInfo($this->userid);
                        $customer = Stripe_Customer::retrieve($uInfo->customer_id);
                        if (isset($customer->subscriptions->data[0]->id)) {
                            $subs = $customer->subscriptions->data[0]->id;
                            $customer->subscriptions->retrieve($subs)->cancel();
                        }
                    } catch (Exception $e) {
                        
                    }
                }
                $this->updateUser($checkoutDetails);
                $this->insertPlanDetail($response);
                header('Location:' . site_url() . 'app/dashboard');
            } else {
                $this->session->set_flashdata('error', "Transaction Failed..!Try Again..!");
                header('Location:' . site_url() . 'app/profile');
            }
        }
    }

    function updateUser($data) {
        $user_set = array(
            'customer_id' => $data['payer_id'],
            'gateway' => "PAYPAL",
            'is_set' => 1
        );
        $this->db->update('user_mst', $user_set, array('user_id' => $this->userid));
    }

    function insertPlanDetail($data) {

        $start_dt = date('Y-m-d', strtotime($data['TIMESTAMP']));
        $expiry_date = $this->common->getNextDate($start_dt, '1 months');

        $planInfo = $this->common->getPlan(2);
        $plan_set = array(
            'user_id' => $this->userid,
            'plan_id' => 2,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => '9.99',
            'plan_status' => 1,
            'start_date' => $start_dt,
            'expiry_date' => $expiry_date
        );
        $this->db->insert('plan_detail', $plan_set);
        return true;
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function cancelled() {
        header('location:' . site_url() . 'app/profile');
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

        return $this->common->sendAutoMail($post['EMAIL'], $subject, $body, $from, $name);
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */    