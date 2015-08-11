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
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));

        $this->userid = $this->session->userdata('u_userid');

        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function getProfile() {
        $query = $this->db->get_where('wi_user_mst', array('user_id' => $this->userid));
        return $query->row();
    }

    function updateProfile($set) {

        if (strlen($set['birthday']) <= 5) {
            
        }

        $userInfo = $this->wi_common->getUserInfo($this->userid);
        if ($userInfo->customer_id != NULL) {
            if (isset($set['stripeToken'])) {
                $this->createCard($userInfo, $set['stripeToken']);
            }
        }
        if ($this->session->userdata('u_name') == "") {
            $this->session->set_userdata('name', $set['name']);
        }
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;

        if (strlen($set['birthday']) <= 5) {
            $dt = ($set['birthday'] != "") ?
                    $this->wi_common->getCustomMySqlDate($set['birthday'], $this->session->userdata('u_date_format')) :
                    NULL;
            $set['birthday'] = ($dt != NULL) ? '1001-' . $dt : NULL;
        } else {
            $set['birthday'] = ($set['birthday'] != "") ?
                    $this->wi_common->getMySqlDate($set['birthday'], $this->session->userdata('u_date_format')) :
                    NULL;
        }
        $set['is_bill'] = (isset($set['is_bill'])) ? 1 : 0;

        if ($this->isEmailChange($set['email'])) {
            $set['email_verification'] = 0;
            $this->sendActivationLink($set['email']);
        }
        unset($set['code'], $set['stripeToken']);


        if ($set['importUrl'] != "") {
            $img_url = FCPATH . "import/user.jpg";
            copy($set['importUrl'], $img_url);

            $fname = 'wish-fish/users/profile_' . $this->userid . '.jpg';
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            if ($this->s3->putObjectFile($img_url, $this->bucket, $fname, "public-read")) {
                $set['profile_pic'] = $fname;
            }
            unlink($img_url);
        } else if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $msg = $this->uploadImage($_FILES);
            if ($msg) {
                $set['profile_pic'] = $msg;
                $this->session->set_userdata('profile_pic', $msg);
            }
        }
        unset($set['importUrl']);
        $sess_array = array(
            'name' => $set['name'],
            'timezone' => $set['timezones'],
            'date_format' => $set['date_format']
        );
        $this->session->set_userdata($sess_array);
        $this->db->trans_start();
        $this->db->update('wi_user_mst', $set, array('user_id' => $this->userid));
        $this->db->trans_complete();
        return TRUE;
    }

    function isEmailChange($email) {
        $checkWhere = array(
            'user_id' => $this->userid,
            'email' => $email
        );
        $query = $this->db->get_where('wi_user_mst', $checkWhere);
        return ($query->num_rows()) ? FALSE : TRUE;
    }

    function updateProfileSetup($set) {
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->wi_common->getMySqlDate($set['birthday'], $this->session->userdata('u_date_format')) :
                NULL;
        unset($set['code']);
        return ($this->db->update('wi_user_mst', $set, array('user_id' => $this->userid))) ? TRUE : FALSE;
    }

    function upload() {
        $flag = false;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $msg = $this->uploadImage($_FILES);
            if ($msg) {
                $set['profile_pic'] = $msg;
                $this->session->set_userdata('profile_pic', $msg);
                $this->db->update('wi_user_mst', $set, array('user_id' => $this->userid));
                $flag = true;
            } else {
                $flag = false;
            }
        } else {
            $flag = false;
        }
        return $flag;
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
                return FALSE;
            }
        } else {
            return FALSE;
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
            $user_set = array(
                'gateway' => "STRIPE",
                'is_set' => 1
            );
            $this->db->update('wi_user_mst', $user_set, array('user_id' => $this->userid));
            return TRUE;
        }
    }

    function updateCard($stripeToken) {
        try {
            $uInfo = $this->wi_common->getUserInfo($this->userid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if ($customer->sources->total_count != 0) {
                $cardid = $customer->sources->data[0]->id;
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
            $uInfo = $this->wi_common->getUserInfo($this->userid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
//            echo '<pre>';
//            print_r($customer);
//            echo $customer->deleted;
//            die();
            if (!$customer->deleted && $customer->sources->total_count != 0) {
                $cardid = $customer->sources->data[0]->id;
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

    function cancelCurrentPlan() {
        try {
            $success = 0;
            $uInfo = $this->wi_common->getUserInfo($this->userid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if (isset($customer->subscriptions->data[0]->id)) {
                $subs = $customer->subscriptions->data[0]->id;
                $customer->subscriptions->retrieve($subs)->cancel();
                $this->db->update('wi_user_mst', array('cancel_by' => 1), array('user_id' => $this->userid));
                $success = 1;
            } else {
                $error = "You have not currently subscribe any plan..!  <a href='" . site_url() . "app/upgrade'>Subscribe New Plan</a>";
                $this->session->set_flashdata('error', $error);
                $success = 0;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $this->session->set_flashdata('error', $error);
            $success = 0;
        }
        if ($success != 1) {
            header('Location:' . site_url() . 'app/profile');
        } else {
            header('Location:' . site_url() . 'app/dashboard');
        }
    }

    function getUserSetting() {
        $query = $this->db->get_where('wi_user_setting', array('user_id' => $this->userid));
        return $query->row();
    }

    function updateUserSetting($set) {
        $this->db->update('wi_user_setting', $set, array('user_id' => $this->userid));
        return true;
    }

    function sendActivationLink($to) {
        $uid = $this->encryption->encode($this->userid);
        $url = site_url() . 'app/dashboard?uid=' . $uid;

        $subject = "Email Verification";
        $body = "Your Verification Link is Below:\n\r";
        $body .= "{$url}";
        $from = "welcome@wish-fish.com";
        $name = "Wish-Fish";

        return $this->wi_common->sendAutoMail($to, $subject, $body, $from, $name);
    }

}
