<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author Laxmisoft
 */
class Dashboard extends CI_Controller {

    private $uid, $duid;

    //put your code here
    function __construct() {
        parent::__construct();


        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        $this->load->library("authex");

        $this->load->helper('cookie');

        $userid = $this->input->get('uid');
        $this->type = $this->input->get('type');
        $this->duid = $this->session->userdata('d-userid');
        $this->uid = ($userid != "") ? $this->encryption->decode($userid) : '';

        if (!$this->duid && !$this->uid) {
            $gid = $this->input->cookie('googleid', TRUE);
            $fid = $this->input->cookie('facebookid', TRUE);
            $g_isSignup = $this->input->cookie('g_isSignup', TRUE);
            ($g_isSignup) ? delete_cookie('g_isSignup', '.wish-fish.com', '/') : '';
            $f_isSignup = $this->input->cookie('f_isSignup', TRUE);
            ($f_isSignup) ? delete_cookie('f_isSignup', '.wish-fish.com', '/') : '';
            $flag = FALSE;


            if (!$this->authex->logged_in()) {
                if ($gid != "" && $g_isSignup) {
                    $flag = (!$this->authex->loginByGoogle($gid)) ? FALSE : TRUE;
                } else if ($fid != "" && $f_isSignup) {
                    $flag = (!$this->authex->loginByFacebook($fid)) ? FALSE : TRUE;
                }
            }
            if (!$flag && !$this->authex->logged_in()) {
                header('location:' . site_url() . 'home');
            }
        }
        $this->load->library("common");
        $this->load->model('dashboard/m_dashboard', 'objdashboard');
        $this->load->model('dashboard/m_calender', 'objcalender');
    }

    function index() {
        if ($this->authex->logged_in()) {
            $card = $this->objcalender->getCards();
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');
            $this->load->view('dashboard/dashboard', $card);
            $this->load->view('dashboard/footer');
        } else {
            $userInfo = $this->common->getUserInfo($this->uid);
            if ($this->uid != "" && count($userInfo) == 1) {
                $data['flag'] = TRUE;
                $data['userInfo'] = $userInfo;
                $data['isForgot'] = ($this->type != "" && $this->type == "forgot") ? TRUE : FALSE;
                $this->load->view('dashboard/dummy-dashboard', $data);
            } else if ($this->duid != "") {
                $data['flag'] = FALSE;
                $data['userInfo'] = FALSE;
                $this->load->view('dashboard/dummy-dashboard', $data);
            } else {
                header('location:' . site_url() . 'home');
            }
        }
    }

//    function error($error) {
//        $this->load->view('header');
//        $this->load->view('top');
//        $this->load->view('navbar');
//        $this->load->view($error);
//        $this->load->view('footer');
//    }

    function uploadProfilePic() {
        $msg = $this->objdashboard->uploadProfilePic();
        if ($msg == "UF") {
            echo 'Profile Picture Not Uploaded..!';
        } else if ($msg == "IF") {
            echo 'Invalid File Format..!';
        } else if ($msg == "U") {
            echo 'Picture Successfully Uploaded..!';
        }
    }

    function updatePassword() {
        $login = $this->objdashboard->updatePassword();
        if ($login && $this->authex->login($login)) {
            header('location:' . site_url() . 'app/dashboard');
        } else {
            header('location:' . site_url() . 'app/dashboard?uid=' . $this->uid);
        }
    }

    function sendQuery() {
        $query = $this->input->post('query');
        $name = $this->session->userdata('name');
        $email = $this->session->userdata('email');
        $body = "Customer Name : {$name}<br>";
        $body .= "Customer Email : {$email}<br>";
        $body .= "Customer Query : {$query}<br>";


        $this->load->library('email');
        $this->email->from($email, $name);
        $this->email->to("support@wish-fish.com");
//        $this->email->to("vishaltesting7@gmail.com");
        $this->email->subject("Support / Feddback From {$name}");
        $this->email->message($body);
        if ($this->email->send()) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function sendVerificationCode() {
        $userid = $this->session->userdata('userid');
        $set = $this->input->post();
        $phone = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        if ($phone) {
            $code = $this->common->getRandomDigit(6);
            $str = "Hey,This is Wish-Fish ! Your Verification code is:{$code}";
            if ($this->common->sendSMS($phone, $str)) {
                $userinfo = $this->common->getUserInfo($userid);
                if ($userinfo->phone == NULL) {
                    $this->db->update('user_mst', array('phone' => $phone), array('user_id' => $userid));
                }
                $this->session->set_userdata('verificationCode', $code);
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    function checkVerificationCode() {
        $code = $this->input->post('code');
        $userid = $this->session->userdata('userid');
        $set = array(
            'phone_verification' => 1
        );
        $where = array(
            'user_id' => $userid
        );
        if ($code == $this->session->userdata('verificationCode')) {
            $this->db->update('user_mst', $set, $where);
            $userInfo = $this->common->getUserInfo($userid);
            $text = "Congratulations! You have verified your phone number successfully!";
            $this->common->sendSMS($userInfo->phone, $text);
            echo 1;
        } else {
            echo 0;
        }
    }

}
