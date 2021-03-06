<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pay extends CI_Controller {

    var $userid, $api_username, $api_password, $api_signature;

    function __construct() {
        parent::__construct();
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        $paypalGatewayInfo = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        $this->load->model('m_register', 'objregister');
        $this->load->library('paypal_lib');
        $this->userid = $this->session->userdata('u_userid');
        $this->api_username = $paypalGatewayInfo->api_username;
        $this->api_password = $paypalGatewayInfo->api_password;
        $this->api_signature = $paypalGatewayInfo->api_signature;
    }

    function index() {
        $currPlan = $this->wi_common->getLatestPlan($this->userid);
        $userInfo = $this->wi_common->getUserInfo($this->userid);

        if (!$userInfo->is_set || ($userInfo->is_set && $this->isExistProfileId($currPlan))) {
            $post = $this->input->post();
            $this->session->set_flashdata($post);
            $this->paypal_lib->set_acct_info($this->api_username, $this->api_password, $this->api_signature);

            $returnUrl = (isset($post['upgrade']) && $post['upgrade'] == 1) ?
                    site_url() . 'app/upgrade' :
                    site_url() . 'app/profile';

            $requestParams = array(
                'RETURNURL' => site_url() . 'app/pay/consolidate',
                'CANCELURL' => $returnUrl,
            );

            $recurring = array(
                'L_BILLINGTYPE0' => 'RecurringPayments',
                'L_BILLINGAGREEMENTDESCRIPTION0' => $post['item_name']
            );
            $response = $this->paypal_lib->request('SetExpressCheckout', $requestParams + $recurring);

            if (is_array($response) && $response['ACK'] == 'Success') { //Request successful
                $token = $response['TOKEN'];

                if ($this->paypal_lib->is_sandbox)
                    echo 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
                else
                    echo 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    function consolidate() {
        if ($this->input->get('token')) { // Token parameter exists
            $this->paypal_lib->set_acct_info(
                    $this->api_username, $this->api_password, $this->api_signature
            );
            $checkoutDetails = $this->paypal_lib->request('GetExpressCheckoutDetails', array('TOKEN' => $this->input->get('token')));


            $planid = ($this->session->flashdata('item_name') == "wishfish-personal") ? 2 : 3;
            $planAmt = $this->session->flashdata('amount');
            $code = $this->session->flashdata('code');

            // Complete the checkout transaction
            $requestParams = array(
                'TOKEN' => $this->input->get('token'),
                'PROFILESTARTDATE' => $checkoutDetails['TIMESTAMP'],
                'DESC' => $this->session->flashdata('item_name'),
                'BILLINGPERIOD' => 'Month',
                'PROFILEREFERENCE' => $this->userid,
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

                $currPlan = $this->wi_common->getLatestPlan($this->userid);
                $userInfo = $this->wi_common->getUserInfo($this->userid);
                if ($currPlan->plan_status == 1) {
                    if (!$userInfo->is_set) {
                        $uInfo = $this->wi_common->getUserInfo($this->userid);
                        $customer = Stripe_Customer::retrieve($uInfo->customer_id);
                        if (isset($customer->subscriptions->data[0]->id)) {
                            $subs = $customer->subscriptions->data[0]->id;
                            $customer->subscriptions->retrieve($subs)->cancel();
                        }
                        $this->updateUser($checkoutDetails);
                    } else {
                        $profileid = $this->isExistProfileId($currPlan);
                        if ($profileid)
                            $this->cancelRecurringProfile($profileid->transaction_id);
                    }
                }
                $this->insertPlanDetail($planid, $response);
                header('Location:' . site_url() . 'app/dashboard');
            } else {
                $this->session->set_flashdata('error', "Transaction Failed..!Try Again..!");
                header('Location:' . site_url() . 'app/profile');
            }
        }
    }

    function updateUser($data) {
        $user_set = array(
            'customer_id' => $data['PAYERID'],
            'gateway' => "PAYPAL",
            'is_set' => 1
        );
        $this->db->update('wi_user_mst', $user_set, array('user_id' => $this->userid));
    }

    function insertPlanDetail($planid, $data) {

        $start_dt = date('Y-m-d', strtotime($data['TIMESTAMP']));
        $expiry_date = $this->wi_common->getNextDate($start_dt, '1 months');

        $planInfo = $this->wi_common->getPlan(2);
        $plan_set = array(
            'user_id' => $this->userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => $data['AMT'],
            'plan_status' => 1,
            'start_date' => $start_dt,
            'expiry_date' => $expiry_date
        );
        $this->db->insert('wi_plan_detail', $plan_set);
        return true;
    }

    function cancelRecurringProfile($id) {
        if ($this->getRecurringProfile($id)) {
//            $this->paypal_lib->set_acct_info(
//                    $this->api_username, $this->api_password, $this->api_signature
//            );
            $requestParams = array(
                'PROFILEID' => $id,
                'ACTION' => 'Cancel', //Cancel,Suspend,Reactivate
            );
            $response = $this->paypal_lib->request('ManageRecurringPaymentsProfileStatus', $requestParams);
            return ($response['ACK'] == "Success") ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }

    function getRecurringProfile($id) {
//        $this->paypal_lib->set_acct_info(
//                $this->api_username, $this->api_password, $this->api_signature
//        );
        $requestParams = array(
            'PROFILEID' => $id
        );
        $response = $this->paypal_lib->request('GetRecurringPaymentsProfileDetails', $requestParams);
        return ($response['STATUS'] == "Active") ? TRUE : FALSE;
    }

    function isExistProfileId($currPlan) {
        $this->db->select('*');
        $this->db->limit(1);
        $query = $this->db->get_where('wi_payment_mst', array('id' => $currPlan->id));
        return ($query->num_rows()) ? $query->row() : FALSE;
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */    