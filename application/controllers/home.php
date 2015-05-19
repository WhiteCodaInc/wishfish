<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Laxmisoft
 */
class Home extends CI_Controller {

    function __construct() {
        parent::__construct();


        if ($this->authex->logged_in()) {
            header('location:' . site_url() . 'app/dashboard');
        } else {
            require APPPATH . 'third_party/google-api/Google_Client.php';
            require APPPATH . 'third_party/google-api/contrib/Google_Oauth2Service.php';
            require_once APPPATH . 'third_party/facebook/facebook.php';
            $this->config->load('googleplus');
            $this->config->load('googlelogin');
            $this->config->load('facebook');
            $this->load->model('m_register', 'objregister');
            //-------------Google Sign Up---------------------------------//
            $this->signup = new Google_Client();
            $this->signup->setApplicationName($this->config->item('application_name', 'googleplus'));
            $this->signup->setClientId($this->config->item('client_id', 'googleplus'));
            $this->signup->setClientSecret($this->config->item('client_secret', 'googleplus'));
            $this->signup->setRedirectUri($this->config->item('redirect_uri', 'googleplus'));
            $this->signup->setDeveloperKey($this->config->item('api_key', 'googleplus'));

            $this->signup_service = new Google_Oauth2Service($this->signup);
            //-------------Google Sign In---------------------------------//
            $this->signin = new Google_Client();
            $this->signin->setApplicationName($this->config->item('application_name', 'googlelogin'));
            $this->signin->setClientId($this->config->item('client_id', 'googlelogin'));
            $this->signin->setClientSecret($this->config->item('client_secret', 'googlelogin'));
            $this->signin->setRedirectUri($this->config->item('redirect_uri', 'googlelogin'));
            $this->signin->setDeveloperKey($this->config->item('api_key', 'googlelogin'));

            $this->signin_service = new Google_Oauth2Service($this->signin);
        }
    }

    function index() {
        $gid = $this->input->cookie('googleid');
        $fid = $this->input->cookie('facebookid');
        if (isset($gid) && $gid != "") {
            $data['isLogin_g'] = TRUE;
            $this->signup->setApprovalPrompt('auto');
            $this->signin->setApprovalPrompt('auto');
        } else {
            $data['isLogin_g'] = FALSE;
            $this->signup->setApprovalPrompt('force');
            $this->signin->setApprovalPrompt('force');
        }
        $data['word'] = $this->common->getRandomDigit(5);
        $this->session->set_userdata('captchaWord', $data['word']);
        $data['isLogin_f'] = (isset($fid) && $fid != "") ? TRUE : FALSE;
        $data['signupUrl'] = $this->signup->createAuthUrl();
        $data['signinUrl'] = $this->signin->createAuthUrl();
        $data['pdetail'] = $this->common->getPlans();
        $data['stripe'] = $this->common->getPaymentGatewayInfo("STRIPE");
        $data['paypal'] = $this->common->getPaymentGatewayInfo("PAYPAL");
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

    function captcha_refresh() {
        echo $this->common->getRandomDigit(5);
    }

    function checkEmail() {
        $email = $this->input->post('email');
        $res = $this->authex->can_register($email);
        echo ($res) ? 0 : 1;
    }

    function sendMail() {
        $email = $this->input->post('email');
        $userInfo = $this->getUserInfo($email);
        $uid = $this->encryption->encode($userInfo->user_id);
        $templateInfo = $this->common->getAutomailTemplate("FORGOT PASSWORD");
        $url = site_url() . 'app/dashboard?type=forgot&uid=' . $uid;
        $link = "<table border='0' align='center' cellpadding='0' cellspacing='0' class='mainBtn' style='margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;'>";
        $link .= "<tr>";
        $link .= "<td align='center' valign='middle' class='btnMain' style='margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 12px;padding-bottom: 12px;padding-left: 22px;padding-right: 22px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: {$templateInfo['color']};height: 20px;font-size: 18px;line-height: 20px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;'>
                                            <a href='{$url}' style='padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #ffffff;font-weight: bold;'>
                                                <span style='text-decoration: none;color: #ffffff;'>
                                                    Reset My Password
                                                </span>
                                            </a>
                                        </td>";
        $link .= "</tr></table>";
        $tag = array(
            'NAME' => $userInfo->name,
            'LINK' => $link,
            'THISDOMAIN' => "Wish-Fish"
        );
        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $tag, TRUE);
        $this->load->view('email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('email_format', $tag, TRUE);

        $from = ($templateInfo['from'] != "") ? $templateInfo['from'] : NULL;
        $name = ($templateInfo['name'] != "") ? $templateInfo['name'] : NULL;

        $res = $this->common->sendAutoMail($email, $subject, $body, $from, $name);
        echo ($res) ? 1 : 0;
    }

    function getUserInfo($mail) {
        $query = $this->db->get_where('user_mst', array('email' => $mail));
        return $query->row();
    }

    function contactus() {
        $post = $this->input->post();
        if (!$post)
            exit;
        $address = "contact@wish-fish.com";

        // Email address verification, do not edit this part.
        function isEmail($email) {
            return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
        }

        if (!defined("PHP_EOL"))
            define("PHP_EOL", "\r\n");

        $name = $post['name'];
        $email = $post['email'];
        $subject = $post['subject'];
        $msg = $post['msg'];

        if (trim($name) == '') {
            echo '<div class="error_message">Please Enter Your Name :) .</div>';
            exit();
        } else if (trim($email) == '') {
            echo '<div class="error_message"> Please enter a valid email address :) .</div>';
            exit();
        } else if (!isEmail($email)) {
            echo '<div class="error_message">You have enter an invalid e-mail address.</div>';
            exit();
        }
        if (trim($subject) == '') {
            echo '<div class="error_message">Please enter a subject.</div>';
            exit();
        } else if (trim($msg) == '') {
            echo '<div class="error_message">Please enter your message.</div>';
            exit();
        }
        if (get_magic_quotes_gpc()) {
            $msg = stripslashes($msg);
        }

        $e_subject = 'You\'ve been contacted by ' . $name . '.';
        $body = "Name : {$name}<br>";
        $body .= "Subject : {$subject}<br>";
        $body .= "Email : {$email}<br>";
        $body .= "Message : {$msg}<br>";
        if ($this->common->sendMail($address, $e_subject, $body)) {
            echo "<fieldset>";
            echo "<div id='success_page'>";
            echo "<h1>Email Sent Successfully.</h1>";
            echo "<p>Thank you <strong>$name</strong>, your message has been submitted to us.</p>";
            echo "<p>We Will reply asap :)</p>";
            echo "</div>";
            echo "</fieldset>";
        } else {
            echo 'ERROR!';
        }
    }

}
