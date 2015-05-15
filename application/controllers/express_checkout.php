<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Express_checkout extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('expresscheckout');
    }

    function index() {
        $post = $this->input->post();
        echo '<pre>';
        print_r($post);
        die();
        $gatewayInfo = $this->common->getPaymentGatewayInfo("EC");
        $this->expresscheckout->set_acct_info($gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->api_signature);

        $requestParams = array(
            'RETURNURL' => site_url() . 'express_checkout/consolidate',
            'CANCELURL' => site_url() . 'express_checkout/cancelled',
        );

        $recurring = array(
            'L_BILLINGTYPE0' => 'RecurringPayments',
            'L_BILLINGAGREEMENTDESCRIPTION0' => 'Recurring Profile'
        );
        $response = $this->expresscheckout->request('SetExpressCheckout', $requestParams + $recurring);

        if (is_array($response) && $response['ACK'] == 'Success') { //Request successful
            $token = $response['TOKEN'];

            if ($this->expresscheckout->is_sandbox)
                echo 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
            else
                echo 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
        } else {
            return false;
        }
    }

    function consolidate() {
        if ($this->input->get('token')) { // Token parameter exists
            $gatewayInfo = $this->common->getPaymentGatewayInfo("EC");
            $this->expresscheckout->set_acct_info(
                    $gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->signature
            );

            $checkoutDetails = $this->expresscheckout->request('GetExpressCheckoutDetails', array('TOKEN' => $this->input->get('token')));

            // Complete the checkout transaction
            $requestParams = array(
                'TOKEN' => $this->input->get('token'),
                'PROFILESTARTDATE' => $checkoutDetails['TIMESTAMP'],
                'DESC' => 'Recurring Profile',
                'BILLINGPERIOD' => 'Month',
                'BILLINGFREQUENCY' => 1,
                'TOTALBILLINGCYCLES' => 0,
                'AMT' => 9.99,
                'INITAMT' => 9.99,
                'CURRENCYCODE' => 'USD',
                'MAXFAILEDPAYMENTS' => 3,
                'FAILEDINITAMTACTION' => 'CancelOnFailure'
            );

            $response = $this->expresscheckout->request('CreateRecurringPaymentsProfile', $requestParams);
            if (is_array($response) && $response['ACK'] == 'Success') { // Payment successful
                //$this->objrecurring->expressCO($set['recurid']);
                $this->session->set_flashdata('msg', "success");
            } else {
                $this->session->set_flashdata('error', $response['ACK']);
            }
            header('Location:' . site_url() . 'app/profile/expressCO');
        }
    }

    function cancelled() {
        header('location:' . site_url() . 'client/client_recurring');
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */    