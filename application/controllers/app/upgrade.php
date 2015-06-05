<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_upgrade_plans
 *
 * @author Laxmisoft
 */
class Upgrade extends CI_Controller {

    private $userid;

    function __construct() {
        parent::__construct();

        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        if (!$this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } else {
            $this->userid = $this->session->userdata('userid');
            $this->load->model('dashboard/m_profile', 'objprofile');
            $this->load->model('m_register', 'objregister');
        }
    }

    function index() {
        $data['currPlan'] = $this->wi_common->getLatestPlan();
        $data['pdetail'] = $this->wi_common->getPlans();
        $data['stripe'] = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        $data['paypal'] = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
        $data['userInfo'] = $this->wi_common->getUserInfo($this->userid);
        $data['card'] = $this->objprofile->getCardDetail();
//        echo '<pre>';
//        print_r($data);
//        die();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/upgrade', $data);
        $this->load->view('dashboard/footer');
    }

    function pay() {
        $success = 0;
        $flag = TRUE;
        $set = $this->input->post();
        if ($set['coupon'] != "") {
            $flag = ($this->objregister->checkCoupon($set['coupon'])) ? TRUE : FALSE;
        }
        if ($flag) {
            $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
            require_once(FCPATH . 'stripe/lib/Stripe.php');
            Stripe::setApiKey($gatewayInfo->secret_key);
            if ($this->input->post('stripeToken') != "") {
                try {
                    $userInfo = $this->wi_common->getUserInfo($this->userid);
                    $customer = Stripe_Customer::retrieve($userInfo->customer_id);
                    $customer->sources->create(array("source" => $this->input->post('stripeToken')));
                    if ($customer->subscriptions->total_count) {
                        $subs = $customer->subscriptions->data[0]->id;
                        $customer->subscriptions->retrieve($subs)->cancel();
                    }
                    $customer->subscriptions->create(array(
                        "plan" => $set['plan'],
                        "metadata" => array("userid" => $this->userid)
                    ));
                    $this->objregister->updateCoupon($set['coupon']);
                    $success = 1;
                } catch (Stripe_CardError $e) {
                    $error = $e->getMessage();
                    $success = 0;
                } catch (Stripe_InvalidRequestError $e) {
                    // Invalid parameters were supplied to Stripe's API
                    $error = $e->getMessage();
                    $success = 0;
                } catch (Stripe_AuthenticationError $e) {
                    // Authentication with Stripe's API failed
                    $error = $e->getMessage();
                    $success = 0;
                } catch (Stripe_ApiConnectionError $e) {
                    // Network communication with Stripe failed
                    $error = $e->getMessage();
                    $success = 0;
                } catch (Stripe_Error $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    $error = $e->getMessage();
                    $success = 0;
                } catch (Exception $e) {
                    // Something else happened, completely unrelated to Stripe
                    $error = $e->getMessage();
                    $success = 0;
                }
                if ($success != 1) {
                    $data['error'] = $error;
                    $this->load->view('dashboard/stripe_error', $data);
                } else {
                    header('Location:' . site_url() . 'app/dashboard');
                }
            }
        } else {
            $data['error'] = "Coupon Code is Invalid...!";
            $this->load->view('stripe_error', $data);
        }
    }

    function upgradePlan() {
        $flag = TRUE;
        $plan = $this->input->post('plan');
        $code = $this->input->post('code');
        if ($code != "") {
            $flag = ($this->objregister->checkCoupon($code)) ? TRUE : FALSE;
        }
        if ($flag) {
            $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
            require_once(FCPATH . 'stripe/lib/Stripe.php');
            Stripe::setApiKey($gatewayInfo->secret_key);
            try {
                $userInfo = $this->wi_common->getUserInfo($this->userid);
                $customer = Stripe_Customer::retrieve($userInfo->customer_id);

                if ($customer->subscriptions->total_count) {
                    $subs = $customer->subscriptions->data[0]->id;
                    $customer->subscriptions->retrieve($subs)->cancel();
                }
                $customer->subscriptions->create(array(
                    "plan" => $plan,
                    "metadata" => array("userid" => $this->userid)
                ));
                $this->objregister->updateCoupon($code);
                $success = 1;
            } catch (Exception $e) {
                $error = $e->getMessage();
                $success = 0;
            }
            if (!$success) {
                echo $error;
            } else {
                echo 1;
            }
        } else {
            echo "Coupon Code is Invalid..!";
        }
    }

    function isAllowToDowngrade() {
        $planInfo = $this->wi_common->getPlan(2);
        $tcontacts = $this->wi_common->getTotal($this->userid, 'wi_contact_detail');
        if ($planInfo->contacts == "-1" || $planInfo->contacts > $tcontacts) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function checkCoupon() {
        $code = $this->input->post('code');
        echo ($this->objregister->checkCoupon($code)) ? 1 : 0;
    }

    /* function checkout() {
      $data['error'] = $this->session->flashdata('error');
      $data['msg'] = $this->session->flashdata('msg');
      $this->load->view('dashboard/stripesuccess', $data);
      } */
}
