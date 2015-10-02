<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_aboutus
 *
 * @author Laxmisoft
 */
class M_affiliate extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function login($post) {
        $query = $this->db->get_where('affiliate_detail', $post);
        $res = $query->row();
        if ($query->num_rows() > 0) {
            $this->session->set_userdata('name', $res->fname . ' ' . $res->lname);
            $this->session->set_userdata('userid', $res->affiliate_id);
            $this->session->set_userdata('type', "affiliate");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function register($post) {
        $name = explode(' ', $post['fullname']);
        $post['fname'] = $name[0];
        $post['lname'] = $name[1];
        unset($post['fullname']);

        $row = $this->db->get_where('payout_setting', array('payout_id' => 1));
        $post['normal_payout'] = $row->normal;
        $post['recurring_payout'] = $row->recurring;

        $this->db->insert('affiliate_detail', $post);
        $insertid = $this->db->insert_id();

        $this->session->set_userdata('d-affid', $insertid);
        $this->session->set_userdata('d-name', $post['fname'] . ' ' . $post['lname']);

        $this->sendMail($post, $insertid);
        return TRUE;
    }

    function isAffiliateExist($post) {
        $where = array(
            'email' => $post['email']
        );
        $query = $this->db->get_where('affiliate_detail', $where);
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function sendMail($post, $affid) {
        $uid = $this->encryption->encode($affid);
        $templateInfo = $this->wi_common->getAutomailTemplate("NEW USER REGISTRATION");
        $url = site_url() . 'affiliate/dashboard?aid=' . $uid;
        $link = "<table border='0' align='center' cellpadding='0' cellspacing='0' class='mainBtn' style='margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;'>";
        $link .= "<tr>";
        $link .= "<td align='center' valign='middle' class='btnMain' style='margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 12px;padding-bottom: 12px;padding-left: 22px;padding-right: 22px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: {$templateInfo['color']};height: 20px;font-size: 18px;line-height: 20px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;'>
                                            <a href='{$url}' style='padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #ffffff;font-weight: bold;'>
                                                <span style='text-decoration: none;color: #ffffff;'>
                                                    Activate Your Account
                                                </span>
                                            </a>
                                        </td>";
        $link .= "</tr></table>";
        $tag = array(
            'NAME' => $post['fname'] . ' ' . $post['lname'],
            'LINK' => $link,
            'THISDOMAIN' => "Wish-Fish"
        );
        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $tag, TRUE);
        $this->load->view('email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('email_format', $tag, TRUE);

        $from = ($templateInfo['from'] != "") ? $templateInfo['from'] : NULL;
        $name = ($templateInfo['name'] != "") ? $templateInfo['name'] : NULL;

        return $this->wi_common->sendAutoMail($post['email'], $subject, $body, $from, $name);
    }

    

}
