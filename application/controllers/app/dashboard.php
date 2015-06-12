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

        $userid = $this->input->get('uid');
        $this->type = $this->input->get('type');
        $this->uid = ($userid != "") ? $this->encryption->decode($userid) : '';
        if ($this->session->userdata('d-userid')) {
            $this->duid = $this->session->userdata('d-userid');
        } else if ($this->input->cookie('d-userid')) {
            $this->duid = $this->input->cookie('d-userid', TRUE);
            delete_cookie('d-userid', '.wish-fish.com', '/');
        } else if ($this->uid) {
            
        }

        if ($this->input->cookie('isLogin')) {
            $id = $this->input->cookie('isLogin', TRUE);
            delete_cookie('isLogin', '.wish-fish.com', '/');
            $login = $this->wi_authex->loginBySocial($id);
        }

        $this->load->model('dashboard/m_dashboard', 'objdashboard');
        $this->load->model('dashboard/m_calender', 'objcalender');
        $this->load->model('m_register', 'objregister');
    }

    function index() {
        if ($this->uid) {
            $this->objdashboard->verifyEmail($this->uid);
        }
        if ($this->wi_authex->logged_in()) {
            $card = $this->objcalender->getCards();
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');
            $this->load->view('dashboard/dashboard', $card);
            $this->load->view('dashboard/footer');
        } else {
            $userInfo = $this->wi_common->getUserInfo($this->uid);
            if ($this->uid != "" && count($userInfo) == 1) {
                if ($userInfo->password != NULL) {
                    $login = array(
                        'email' => $userInfo->email,
                        'password' => $userInfo->password
                    );
                    if ($this->wi_authex->login($login)) {
                        header('location:' . site_url() . 'app/dashboard');
                    } else {
                        header('location:' . site_url() . 'app/login');
                    }
                } else {
                    $data['flag'] = TRUE;
                    $data['userInfo'] = $userInfo;
                    $data['isForgot'] = ($this->type != "" && $this->type == "forgot") ? TRUE : FALSE;
                    $this->load->view('dashboard/dummy-dashboard', $data);
                }
            } else if ($this->duid != "") {
                $data['flag'] = FALSE;
                $data['userInfo'] = FALSE;
                $this->load->view('dashboard/dummy-dashboard', $data);
            } else {
                header('location:' . site_url() . 'home');
            }
        }
    }

    function uploadProfilePic() {
        if ($this->wi_authex->logged_in()) {
            if (isset($_FILES['profile'])) {
                $msg = $this->objdashboard->uploadProfilePic();
                if ($msg == "UF") {
                    echo 'Profile Picture Not Uploaded..!';
                } else if ($msg == "IF") {
                    echo 'Invalid File Format..!';
                } else if ($msg == "U") {
                    echo 'Picture Successfully Uploaded..!';
                }
            } else {
                header('location:' . site_url() . 'app/dashboard');
            }
        } else {
            header('location:' . site_url() . 'home');
        }
    }

    function updatePassword() {
        $post = $this->input->post();
        if (isset($post) && is_array($post)) {
            $login = $this->objdashboard->updatePassword($post);
            if ($login && $this->wi_authex->login($login)) {
                header('location:' . site_url() . 'app/dashboard');
            } else {
                header('location:' . site_url() . 'app/dashboard?uid=' . $this->uid);
            }
        } else if ($this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'app/dashboard');
        } else {
            header('location:' . site_url() . 'home');
        }
    }

    function sendQuery() {
        if ($this->wi_authex->logged_in()) {
            $query = $this->input->post('query');
            if (isset($_POST['query'])) {
                $this->objdashboard->addFeedback($query);
                $name = $this->session->userdata('name');
                $email = $this->session->userdata('email');
                $body = "Customer Name : {$name}<br>";
                $body .= "Customer Email : {$email}<br>";
                $body .= "Customer Query : {$query}<br>";

                $this->email->from($email, $name);
                $this->email->to("support@wish-fish.com");
                $this->email->subject("Support / Feddback From {$name}");
                $this->email->message($body);
                if ($this->email->send()) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                header('location:' . site_url() . 'app/dashboard');
            }
        } else {
            header('location:' . site_url() . 'home');
        }
    }

    function sendVerificationCode() {
        if ($this->wi_authex->logged_in()) {
            $userid = $this->session->userdata('userid');
            $set = $this->input->post();
            $phone = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                    str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                    NULL;

            if ($phone) {
                $code = $this->wi_common->getRandomDigit(6);
                $str = "Hey,This is Wish-Fish ! Your Verification code is: {$code}";
                if ($this->wi_common->sendSMS($phone, $str)) {
                    $userinfo = $this->wi_common->getUserInfo($userid);
                    if ($userinfo->phone == NULL) {
                        $this->db->update('wi_user_mst', array('phone' => $phone), array('user_id' => $userid));
                    }
                    $this->session->set_userdata('verificationCode', $code);
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        } else {
            header('location:' . site_url() . 'home');
        }
    }

    function checkVerificationCode() {
        if ($this->wi_authex->logged_in()) {
            $code = $this->input->post('code');
            $userid = $this->session->userdata('userid');
            $set = array(
                'phone_verification' => 1
            );
            $where = array(
                'user_id' => $userid
            );
            if ($code == $this->session->userdata('verificationCode')) {
                $this->db->update('wi_user_mst', $set, $where);
                $userInfo = $this->wi_common->getUserInfo($userid);
                $msg1 = "Congratulations! You have verified your phone number successfully!";
                $this->wi_common->sendSMS($userInfo->phone, $msg1);
                $msg2 = "Please save this number as 'Wish-Fish'.";
                $this->wi_common->sendSMS($userInfo->phone, $msg2);
                echo 1;
            } else {
                echo 0;
            }
        } else {
            header('location:' . site_url() . 'home');
        }
    }

    function getTimelineEvent() {
        $events = $this->objcalender->getTimelineEvent();
        $dt = $this->wi_common->getUTCDate();
        $currDate = $this->wi_common->getMySqlDate($dt, $this->session->userdata('date_format'));

        $ev = array();
        foreach ($events as $key => $value) {
            $ev[$key]['id'] = "event{$value->event_id}";
            $ev[$key]['title'] = $value->event;
            $ev[$key]['description'] = $value->body;
            $ev[$key]['startdate'] = $value->date . ' ' . $value->time;
            $ev[$key]['high_threshold'] = 50;
            $ev[$key]['importance'] = "30";
            $ev[$key]['icon'] = "triangle_orange.png";
        }



        $initialize = array(
            "id" => "timeline",
            "title" => "Birthday Events Timeline",
            "focus_date" => $currDate . " 12:00:00",
            "initial_zoom" => "39"
        );
        $timeline = json_encode($initialize);

        echo '<pre>';
//        print_r($ev);
        print_r($timeline);
        die();
    }

}
