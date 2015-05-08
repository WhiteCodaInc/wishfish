<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_admin_login
 *
 * @author Laxmisoft
 */
class M_profile extends CI_Model {

    private $userid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->userid = $this->session->userdata('userid');
        $this->bucket = "mikhailkuznetsov";
        $this->accessKey = "AKIAJWQAEAXONVCWQZKQ";
        $this->secretKey = "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";
    }

    function getProfile() {
        $query = $this->db->get_where('user_mst', array('user_id' => $this->userid));
        return $query->row();
    }

    function updateProfile($set) {
        $m = "";
        $userInfo = $this->common->getUserInfo($this->userid);
        if (!$userInfo->is_bill) {
            if (isset($set['stripeToken']) && $set['stripeToken'] != "")
                $this->addCustomerToStripe($userInfo, $set['stripeToken']);
        }
        if ($this->session->userdata('name') == "") {
            $this->session->set_userdata('name', $set['name']);
        }
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->common->getMySqlDate($set['birthday'], $this->session->userdata('date_format')) :
                NULL;
        $set['is_bill'] = (isset($set['is_bill'])) ? 1 : 0;

        unset($set['code'], $set['stripeToken']);
        if (isset($_FILES['profile_pic'])) {
            if ($_FILES['profile_pic']['error'] == 0) {
                $msg = $this->uploadImage($_FILES);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['profile_pic'] = $msg;
                        $this->session->set_userdata('profile_pic', $msg);
                        $m = "U";
                        break;
                }
            }
        }
        $sess_array = array(
            'name' => $set['name'],
            'timezone' => $set['timezones'],
            'date_format' => $set['date_format']
        );
        $this->session->set_userdata($sess_array);
        $this->db->trans_start();
        $m = "U";
        $this->db->update('user_mst', $set, array('user_id' => $this->userid));
        $this->db->trans_complete();
        return $m;
    }

    function uploadImage($file) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['profile_pic']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/users/profile_' . $this->userid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['profile_pic']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function addCustomerToStripe($uInfo, $stripeToken) {
        $payment = array();
        $success = 0;
        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        //require_once(FCPATH . 'stripe\lib\Stripe.php');
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        try {
            Stripe_Customer::create(array(
                "card" => $stripeToken,
                "email" => $uInfo->email,
                "metadata" => array("planid" => "wishfish-free", "userid" => $this->userid),
                "plan" => "wishfish-free"
            ));
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
            $this->session->set_flashdata('error', $error);
            header('Location:' . site_url() . 'app/profile');
        } else {
            return TRUE;
        }
    }

}
