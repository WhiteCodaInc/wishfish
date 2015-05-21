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
class Stripe_payment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        /* if (!$this->wi_authex->logged_in()) {
          header('location:' . site_url() . 'login');
          } */
    }

    function pay() {
        $success = 0;
        $set = $this->input->post();
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        if ($this->input->post('stripeToken') != "") {

            try {
                $customer = Stripe_Customer::create(array(
                            "card" => $this->input->post('stripeToken'),
                            "email" => $this->input->post('stripeEmail'),
                            "metadata" => array(),
                            "plan" => $set['plan']));
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
                $this->load->view('stripe_error', $data);
            } else {
                header('Location:' . site_url() . 'login');
            }
        }
    }

    /* function checkout() {
      $data['error'] = $this->session->flashdata('error');
      $data['msg'] = $this->session->flashdata('msg');
      $this->load->view('dashboard/stripesuccess', $data);
      } */
}
