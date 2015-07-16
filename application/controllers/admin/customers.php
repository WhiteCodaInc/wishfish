<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_profile
 *
 * @author Laxmisoft
 */
class Customers extends CI_Controller {

    private $api_username, $api_password, $api_signature;

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->customers) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {

            $paypalGatewayInfo = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
            $this->api_username = $paypalGatewayInfo->api_username;
            $this->api_password = $paypalGatewayInfo->api_password;
            $this->api_signature = $paypalGatewayInfo->api_signature;

            $this->load->model('admin/m_customers', 'objcustomer');
            $this->load->library('paypal_lib');

            $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
            require_once(FCPATH . 'stripe/lib/Stripe.php');
            Stripe::setApiKey($gatewayInfo->secret_key);
        }
    }

    function index() {
        $data['customers'] = $this->objcustomer->getCustomerDetail();
        $data['plans'] = $this->wi_common->getPlans();
//        echo '<pre>';
//        print_r($data);
//        die();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objcustomer->searchResult();
        $data['plans'] = $this->wi_common->getPlans();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($cid) {
        $data['customer'] = $this->objcustomer->getCustomerInfo($cid);
        $data['phistory'] = $this->objcustomer->getPaymentHistory($cid);
        $data['card'] = $this->getCardDetail($cid);
        $data['gatewayInfo'] = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        $data['plans'] = $this->wi_common->getPlans();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function editCustomer($cid) {
        $data['customers'] = $this->objcustomer->getCustomerInfo($cid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/edit-customer', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCustomer() {
        $post = $this->input->post();
        $msg = $this->objcustomer->updateCustomer($post);
        header('location:' . site_url() . 'admin/customers?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Active" || $type == "Deactive") {
            $msg = $this->objcustomer->setAction($type);
            header('location:' . site_url() . 'admin/customers?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function loginAsUser($cid) {
        $customer = $this->objcustomer->getCustomerInfo($cid);
        if ($customer->status) {
            $uid = $this->encryption->encode($customer->user_id);
            $url = 'https://wish-fish.com/app/dashboard?uid=' . $uid;
            header('location:' . $url);
        } else {
            echo '<script>alert("Customer account currently was deactivated..!");close();</script>';
        }
    }

    function extendTrial() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $this->objcustomer->extendTrial($post);
            header('location:' . site_url() . 'admin/customers/profile/' . $post['userid']);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function lifetimeAccess() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $this->objcustomer->lifetimeAccess($post);
            header('location:' . site_url() . 'admin/customers/profile/' . $post['userid']);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function updateCustomerNotification() {
        $this->objcustomer->updateCustomerNotification();
    }

    function updatePaymentNotification() {
        $this->objcustomer->updatePaymentNotification();
    }

    /* -------------------Card Detail---------------------------- */

    function getCardDetail($cid) {
        try {
            $uInfo = $this->wi_common->getUserInfo($cid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if (!$customer->deleted && $customer->cards->total_count != 0) {
                $cardid = $customer->cards->data[0]->id;
                $card = $customer->sources->retrieve($cardid);
                $cardDetail = array(
                    'last4' => $card->last4,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                );
                return $cardDetail;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function updatePaymentDetail() {
        $post = $this->input->post();
        if ($post['stripeToken'] != "" && $post['userid'] != "") {
            (isset($post['isNew']) && $post['isNew']) ?
                            $this->createCard($post['userid'], $post['stripeToken']) :
                            $this->updateCard($post['userid'], $post['stripeToken']);
            header('location:' . site_url() . 'admin/customers/profile/' . $post['userid']);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function createCard($cid, $stripeToken) {
        try {
            $uInfo = $this->wi_common->getUserInfo($cid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            $customer->sources->create(array("source" => $stripeToken));
            $success = 1;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            $this->session->set_flashdata('error', $error);
            header('location:' . site_url() . 'admin/customers/profile/' . $cid);
        } else {
            $user_set = array(
                'gateway' => "STRIPE",
                'is_set' => 1
            );
            $this->objcustomer->updateCustomerInfo($cid, $user_set);
            return TRUE;
        }
    }

    function updateCard($cid, $stripeToken) {
        try {
            $uInfo = $this->wi_common->getUserInfo($cid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if ($customer->cards->total_count != 0) {
                $cardid = $customer->cards->data[0]->id;
                $customer->sources->retrieve($cardid)->delete();
            }
            $customer->sources->create(array("source" => $stripeToken));
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function getRecurDate() {
        $post = $this->input->post();
        echo date('m-d-Y', strtotime($this->wi_common->getNextDate(date('Y-m-d'), $post['interval'] . ' months')));
    }

    function chargeUser() {
        $post = $this->input->post();
        try {
            $flag = TRUE;
            echo '<pre>';
//            print_r($post);
//          die();
            $uInfo = $this->wi_common->getUserInfo($post['userid']);
//            print_r($uInfo);
//          $pname = ($post['plan'] == '2') ? "wishfish-personal" : "wishfish-enterprise";
//          echo '<br>' . $pname . '<br>';
            if ($uInfo->is_set && $uInfo->gateway == "PAYPAL") {
//                echo '<br>---------------PAYPAL CANCELD START-----------<br>';
                $currPlan = $this->wi_common->getLatestPlan($post['userid']);
//              print_r($currPlan);
                $profileId = $this->objcustomer->isExistProfileId($currPlan);
                if ($profileId) {
//                    $status = $this->getRecurringProfile($profileId->transaction_id);
//                    print_r($profileId);
//                    echo "<br>------STATUS : $status -------------<br>";
//                    echo "PROFILE ID : $profileId->transaction_id Cancelled";
                    $this->cancelRecurringProfile($profileId->transaction_id);
                }
                try {
                    $customer = Stripe_Customer::create(array(
                                "email" => $uInfo->email,
                                "metadata" => array("userid" => $post['userid']),
                    ));
//                    echo '<br>-------NEW CUSTOMER---------<br>';
//                    print_r($customer);
                    $user_set = array(
                        'gateway' => "STRIPE",
                        'is_set' => 1,
                        'customer_id' => $customer->id
                    );
                    $this->objcustomer->updateCustomerInfo($post['userid'], $user_set);
                } catch (Exception $e) {
                    $flag = FALSE;
                    $e->getMessage();
                }
            } else if (!$uInfo->is_set || ($uInfo->is_set && $uInfo->gateway == "STRIPE")) {
//              echo '<br>---------------STRIPE START-----------<br>';
                try {
                    $customer = Stripe_Customer::retrieve($uInfo->customer_id);
//                    echo '<br>--------OLD CUSTOMER---------<br>';
//                    print_r($customer);
                    if (isset($customer->subscriptions->data[0]->id)) {
                        $subs = $customer->subscriptions->data[0]->id;
//                        echo "<br>Subscription ID : $subs Cancelled<br>";
                        $customer->subscriptions->retrieve($subs)->cancel();
                    }
                    $user_set = array(
                        'gateway' => "STRIPE",
                        'is_set' => 1
                    );
                    $this->objcustomer->updateCustomerInfo($post['userid'], $user_set);
                } catch (Exception $e) {
                    $flag = FALSE;
                    echo $e->getMessage();
                }
            }
            if ($flag) {
                $random = $this->wi_common->getRandomDigit(5);
                $planid = preg_replace('/\s\s+/', '_', trim($uInfo->name)) . '_' . $post['userid'] . '_' . $random;
//              echo "<br>Plan ID : $planid<br>";
                Stripe_Plan::create(array(
                    "amount" => $post['amount'] * 100,
                    "currency" => 'USD',
                    "interval" => 'month',
                    "interval_count" => $post['interval'],
                    "name" => $uInfo->name . '(Individual)',
                    "id" => $planid));
                $customer->sources->create(array("source" => $post['stripeToken']));
                $stripe = array(
                    "plan" => $planid,
                    "metadata" => array("userid" => $post['userid'], "payment_type" => $post['type'], "planid" => $post['plan']),
                );
                $customer->subscriptions->create($stripe);
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    function getRecurringProfile($id) {

        $this->paypal_lib->set_acct_info(
                $this->api_username, $this->api_password, $this->api_signature
        );
        $requestParams = array(
            'PROFILEID' => $id
        );
        $response = $this->paypal_lib->request('GetRecurringPaymentsProfileDetails', $requestParams);
        return ($response['STATUS'] == "Active") ? TRUE : FALSE;
    }

    function cancelRecurringProfile($id) {
        if ($this->getRecurringProfile($id)) {
            $this->paypal_lib->set_acct_info(
                    $this->api_username, $this->api_password, $this->api_signature
            );
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

}
