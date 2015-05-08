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

        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function getProfile() {
        $query = $this->db->get_where('user_mst', array('user_id' => $this->userid));
        return $query->row();
    }

    function updateProfile($set) {
        $m = "";
        $userInfo = $this->common->getUserInfo($this->userid);
        $currPlan = $this->common->getCurrentPlan();
        if ($userInfo->customer_id != NULL) {
            if (isset($set['stripeToken'])) {
                ($currPlan->plan_id == 1) ?
                                $this->createCard($userInfo, $set['stripeToken']) :
                                $this->updateCard($userInfo, $set['stripeToken']);
            }
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

    function createCard($uInfo, $stripeToken) {
        try {
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            $customer->sources->create(array("source" => $stripeToken));
            $success = 1;
        } catch (Exception $e) {
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

    function updateCard($uInfo, $stripeToken) {
        try {
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

    function getCardDetail() {
        try {
            $uInfo = $this->common->getUserInfo($this->userid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if ($customer->cards->total_count != 0) {
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

}
