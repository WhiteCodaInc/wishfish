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
        $this->directLogin = $this->input->get('d');
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
            $this->wi_authex->loginBySocial($id);
        }

        $this->load->model('dashboard/m_dashboard', 'objdashboard');
        $this->load->model('dashboard/m_calender', 'objcalender');
        $this->load->model('m_register', 'objregister');
    }

    function index() {

        if ($this->uid) {
            $this->objdashboard->verifyEmail($this->uid);
        }
        if (!$this->directLogin && $this->wi_authex->logged_in()) {
            $card = $this->objcalender->getCards();
            $uid = $this->session->userdata('u_userid');
            $card['userInfo'] = $this->wi_common->getUserInfo($uid);
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');
            $this->load->view('dashboard/dashboard', $card);
            $this->load->view('dashboard/footer');
        } else {
            $userInfo = $this->wi_common->getUserInfo($this->uid);
            if ($this->uid != "" && count($userInfo) == 1) {
                if ($this->type != "forgot" && $userInfo->password != NULL) {
                    $login = array(
                        'email' => $userInfo->email
                    );
                    if ($this->wi_authex->login($login)) {
                        header('location:' . site_url() . 'app/dashboard');
                    } else {
                        header('location:' . site_url() . 'login');
                    }
                } else {
                    $data['userInfo'] = $userInfo;
                    $data['isForgot'] = ($this->type == "forgot") ? TRUE : FALSE;
                    $data['userId'] = FALSE;
                    $this->load->view('dashboard/dummy-dashboard', $data);
                }
            } else if ($this->duid != "") {
                $data['isForgot'] = FALSE;
                $data['userInfo'] = FALSE;
                $data['userId'] = $this->duid;
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

    function setReminder() {
        $post = $this->input->post();
        if (isset($post) && is_array($post)) {
            $this->objdashboard->setReminder($post);
        }
    }

    function sendQuery() {
        if ($this->wi_authex->logged_in()) {
            $post = $this->input->post();
            if (isset($post['query'])) {
                $this->objdashboard->addFeedback($post);
                $name = $this->session->userdata('u_name');
                $email = $this->session->userdata('u_email');
                $body = "Customer Name : {$name}<br>";
                $body .= "Customer Email : {$email}<br>";
                (isset($post['country']) && $post['country'] != "" && $post['country'] != "-1") ?
                                $body .= "Customer Country : {$post['country']}<br>" : "";
                $body .= "Customer Query : {$post['query']}<br>";

                $this->email->from($email, $name);
                $this->email->to("support@wish-fish.com");
                $this->email->subject("Feedback From {$name}");
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

//    function sendReview() {
//        if ($this->wi_authex->logged_in()) {
//            $post = $this->input->post();
//            if (isset($post['query'])) {
//                $name = $this->session->userdata('u_name');
//                $email = $this->session->userdata('u_email');
//                $body = "Customer Name : {$name}<br>";
//                $body .= "Customer Email : {$email}<br>";
//                $body .= "Customer Feedback: {$post['query']}<br>";
//
//                $this->email->from($email, $name);
//                $this->email->to("support@wish-fish.com");
//                $this->email->subject("Feddback From {$name}");
//                $this->email->message($body);
//                if ($this->email->send()) {
//                    echo 1;
//                } else {
//                    echo 0;
//                }
//            } else {
//                header('location:' . site_url() . 'app/dashboard');
//            }
//        } else {
//            header('location:' . site_url() . 'home');
//        }
//    }

    function sendVerificationCode() {
        if ($this->wi_authex->logged_in()) {
            $userid = $this->session->userdata('u_userid');
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
            $userid = $this->session->userdata('u_userid');
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

    function checkPhoneVerification() {
        $userid = $this->session->userdata('u_userid');
        $uInfo = $this->wi_common->getUserInfo($userid);
        echo ($uInfo->phone_verification) ? 1 : 0;
    }

    function verifyTour() {
        $userid = $this->session->userdata('u_userid');
        $this->objdashboard->verifyTour($userid);
    }

    function getTimelineEvent() {
        $events = $this->objcalender->getTimelineEvent();
        $dt = $this->wi_common->getUTCDate();
        $currDate = $this->wi_common->getMySqlDate($dt, $this->session->userdata('u_date_format'));
        $ev = array();
        foreach ($events as $key => $value) {
            $ev[$key]['id'] = "event{$value->event_id}";
            $ev[$key]['title'] = $value->event;
            $ev[$key]['description'] = $value->body;
            $ev[$key]['startdate'] = $value->date;
            $ev[$key]['high_threshold'] = 50;
            $ev[$key]['date_display'] = 'da';
            $ev[$key]['importance'] = "35";

            switch ($value->event_type) {
                case "sms":
                    $ev[$key]['icon'] = "sms.png";
                    break;
                case "email":
                    $ev[$key]['icon'] = "email.png";
                    break;
                case "notification":
                    $ev[$key]['icon'] = "notification.png";
                    break;
            }

            if ($value->group_type == "individual") {
                if ($value->notify == "them") {
                    $cInfo = $this->wi_common->getContactInfo($value->contact_id);
                    $img_src = ($cInfo->contact_avatar != "") ?
                            "http://mikhailkuznetsov.s3.amazonaws.com/" . $cInfo->contact_avatar :
                            base_url() . 'assets/dashboard/img/default-avatar.png';
                } else {
                    $uInfo = $this->wi_common->getUserInfo($value->user_id);
                    $img_src = ($uInfo->profile_pic != "") ?
                            "http://mikhailkuznetsov.s3.amazonaws.com/" . $uInfo->profile_pic :
                            base_url() . 'assets/dashboard/img/default-avatar.png';
                }
                $ev[$key]['image'] = $img_src;
            }
        }

        $legend = array(
            array("title" => "Individual Event", "icon" => "square_blue.png"),
            array("title" => "Group Event", "icon" => "circle_purple.png"),
        );
        $initialize = array(
            "id" => "timeline",
            "title" => "Birthday Events Timeline",
            "focus_date" => $currDate . " 12:00:00",
            "initial_zoom" => "39",
            "events" => $ev,
            "legend" => $legend
        );
        echo "[" . json_encode($initialize) . "]";
    }

    function get12HourFormat($time) {
        $t = explode(':', $time);
    }

}
