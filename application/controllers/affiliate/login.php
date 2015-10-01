<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wish-Fish
 *
 * @author Laxmisoft
 */
class Login extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('affiliate/m_affiliate', 'objaffiliate');
    }

    function index() {
        $data['word'] = $this->wi_common->getRandomDigit(5);
        $this->session->set_userdata('captchaWord', $data['word']);
        $data['aemail'] = $this->input->cookie('affemail', TRUE);
        $data['apasswd'] = $this->input->cookie('affpassword', TRUE);
        $this->load->view('affiliate/affiliate-login');
    }

    function signin($get = NULL) {
        $post = $this->input->post();
        if ($get != NULL) {
            $get = $this->input->get();
            $post['email'] = $this->encryption->decode($get['u']);
            $post['password'] = $this->encryption->decode($get['p']);
        }

        if (is_array($post) && count($post) > 0) {
            if (isset($post['remember'])) {
                $remember = $post['remember'];
                unset($post['remember']);
            }
            $is_login = $this->wi_authex->alogin($post);
            if ($is_login === -1) {
                header('location:' . site_url() . 'affiliate/login?msg=DA');
            } else if ($is_login) {
                if (isset($remember) && $remember == "on")
                    $this->storeCookie($post);
                header('location:' . site_url() . 'affiliate/dashboard');
            } else {
                header('location:' . site_url() . 'affiliate/login?msg=F');
            }
        } else {
            header('location:' . site_url() . 'affiliate/login');
        }
    }

    function storeCookie($post) {
        $userid = array(
            'name' => 'affemail',
            'value' => $post['email'],
            'expire' => time() + (3600 * 24 * 7),
        );
        $this->input->set_cookie($userid);
        $password = array(
            'name' => 'affpassword',
            'value' => $post['password'],
            'expire' => time() + (3600 * 24 * 7),
        );
        $this->input->set_cookie($password);
        return TRUE;
    }

    function checkEmail() {
        $email = $this->input->post('email');
        $res = $this->wi_authex->aemail_exists($email);
        echo ($res) ? 1 : 0;
    }

    function sendMail() {
        $email = $this->input->post('email');
        $affInfo = $this->getAffInfo($email);
        $uid = $this->encryption->encode($affInfo->affiliate_id);
        $templateInfo = $this->wi_common->getAutomailTemplate("FORGOT PASSWORD");
        $url = site_url() . 'affiliate/dashboard?type=forgot&uid=' . $uid;
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
            'NAME' => $affInfo->fname . ' ' . $affInfo->fname,
            'LINK' => $link,
            'THISDOMAIN' => "Wish-Fish"
        );
        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $tag, TRUE);
        $this->load->view('email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('email_format', $tag, TRUE);

        $from = ($templateInfo['from'] != "") ? $templateInfo['from'] : NULL;
        $name = ($templateInfo['name'] != "") ? $templateInfo['name'] : NULL;

        $res = $this->wi_common->sendAutoMail($email, $subject, $body, $from, $name);
        echo ($res) ? 1 : 0;
    }

    function getAffInfo($mail) {
        $query = $this->db->get_where('affiliate_detail', array('email' => $mail));
        return $query->row();
    }

}
