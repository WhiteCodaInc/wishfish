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
            $this->userid = $this->session->userdata('u_userid');
            $this->load->model('dashboard/m_profile', 'objprofile');
            $this->load->model('m_register', 'objregister');
            $this->load->model('dashboard/m_upgrade', 'objupgrade');
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
//                    $customer->sources->create(array("source" => $this->input->post('stripeToken')));
                    if ($customer->subscriptions->total_count) {
                        $subs = $customer->subscriptions->data[0]->id;
                        $customer->subscriptions->retrieve($subs)->cancel();
                    }
//                    $stripe = array(
//                        "plan" => $set['plan'],
//                        "metadata" => array("userid" => $this->userid),
//                    );
                    $stripe = array(
                        "plan" => $set['plan'],
                        "source" => $set['stripeToken']
                    );
                    ($set['coupon'] != "") ? $stripe['coupon'] = $set['coupon'] : '';
                    $customer->subscriptions->create($stripe);

                    if ($set['coupon'] != "")
                        $this->objregister->updateCoupon($set['coupon']);

                    $pid = $this->objcustomer->insertPlanDetail($set['planid'], $customer, $set);

                    $data = array("userid" => $this->userid, "planid" => $pid);
                    ($set['coupon'] != "") ? $data['coupon'] = $set['coupon'] : '';
                    $customer->metadata = $data;
                    $customer->save();

                    $user_set = array(
                        'gateway' => "STRIPE",
                        'is_set' => 1
                    );
                    $this->db->update('wi_user_mst', $user_set, array('user_id' => $this->userid));

                    $success = 1;
                } catch (Exception $e) {
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

        $set = $this->input->post();
//        $plan = $this->input->post('plan');
//        $planid = $this->input->post('planid');
//        $code = $this->input->post('code');

        if ($set['coupon'] != "") {
            $flag = ($this->objregister->checkCoupon($set['coupon'])) ? TRUE : FALSE;
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
//                $stripe = array(
//                    "plan" => $plan,
//                    "metadata" => array("userid" => $this->userid),
//                );
                $stripe = array(
                    "plan" => $set['plan']
                );
                ($set['coupon'] != "") ? $stripe['coupon'] = $set['coupon'] : '';
                $customer->subscriptions->create($stripe);

                if ($set['coupon'] != "")
                    $this->objregister->updateCoupon($set['coupon']);

                $pid = $this->objupgrade->insertPlanDetail($set['planid'], $customer, $set);

                $data = array("userid" => $this->userid, "planid" => $pid);
                ($set['coupon'] != "") ? $data['coupon'] = $set['coupon'] : '';
                $customer->metadata = $data;
                $customer->save();

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
        $post = $this->input->post();
        $coupon = $this->objregister->checkCoupon($post['code']);
//        echo ($this->objregister->checkCoupon($code)) ? 1 : 0;
        if (!$coupon) {
            echo 0;
        } else {
            $discAmt = $this->objregister->applyCoupon($coupon, $post);
            if ($coupon->disc_type == "P" && $coupon->disc_amount == 100.00) {
                $data['flag'] = 2;
                $data['discAmt'] = $discAmt;
                echo json_encode($data);
            } else {
                $data['flag'] = 1;
                $data['discAmt'] = $discAmt;
                echo json_encode($data);
            }
        }
    }

    /* function checkout() {
      $data['error'] = $this->session->flashdata('error');
      $data['msg'] = $this->session->flashdata('msg');
      $this->load->view('dashboard/stripesuccess', $data);
      } */
}
