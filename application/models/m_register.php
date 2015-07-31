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
class M_register extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();

        $this->load->library('simple_html_dom');
        $this->load->library('amazons3');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getPageContent($pname) {
        $query = $this->db->get_where('pages', array('name' => $pname));
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function getSections() {
        $section = array();
        $query = $this->db->get('sections');
        foreach ($query->result() as $value) {
            $section[$value->name][] = $value->title;
            $section[$value->name][] = $value->content;
        }
        return $section;
    }

    function register($post) {
        $flag = FALSE;
        $this->db->trans_start();
        $planInfo = $this->wi_common->getPlan(1);
        $this->db->insert('wi_user_mst', $post);
        $insertid = $this->db->insert_id();

        $this->session->set_userdata('d-userid', $insertid);
        $this->session->set_userdata('d-name', $post['name']);
        //--------------Insert Plan Detail-----------------//
        $set = array(
            'plan_id' => 1,
            'user_id' => $insertid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => 0,
            'plan_status' => 1,
            'start_date' => date('Y-m-d'),
            'expiry_date' => $this->wi_common->getNextDate(date('Y-m-d'), "14 Days")
        );
        $this->db->insert('wi_plan_detail', $set);
        $planid = $this->db->insert_id();
        //-------------------------------------------------//
        //--------------Insert Google API Credential-----------------//
        $set = array(
            'user_id' => $insertid,
            'redirect_uri' => site_url() . 'app/calender'
        );
        $this->db->insert('wi_user_setting', $set);
        //-------------------------------------------------//
        //---------------Add Customer To Stripe------------//

        if ($this->addCustomerToStripe($post, $planid, $insertid)) {
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->sendMail($post, $insertid);
                $flag = TRUE;
            } else {
                $flag = FALSE;
            }
        } else {
            $flag = FALSE;
        }
        //-------------------------------------------------//
        return $flag;
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function isUserExist($data) {
        $where = array(
            'email' => $data['email']
        );
        $query = $this->db->get_where('wi_user_mst', $where);
        $res = $query->row();
        if ($query->num_rows() !== 1) {
            return false;
        } else {
            if ($res->status) {
                if ($res->join_type == NULL) {
                    return "RN";
                } else if ($res->join_type == "google") {
                    return "RG";
                } else if ($res->join_type == "facebook") {
                    return "RF";
                }
            } else {
                return -1;
            }
        }
    }

    function isUserLogin($data, $type) {
        $where = array(
            'email' => $data['email']
        );
        $query = $this->db->get_where('wi_user_mst', $where);
        $res = $query->row();

        if ($query->num_rows() !== 1) {
            return false;
        } else {
//            if ($res->status) {
            if ($res->join_type == $type) {
                return ($type == "google") ?
                        (($res->status) ? "LG" : -1) :
                        (($res->status) ? "LF" : -1);
            } else if ($res->join_type == NULL) {
                return "LN";
            } else if ($res->join_type == "google") {
                return "LG";
            } else if ($res->join_type == "facebook") {
                return "LF";
            }
//            } else {
//                return -1;
//            }
        }
    }

    function registerWithSocial($data, $type = NULL) {
        $join = $this->input->cookie('JoinVia', TRUE);
        delete_cookie('JoinVia', '.wish-fish.com', '/');
        if ($join == "home") {
            $joinVia = ($type == "google") ?
                    site_url() . "<br/>Join With Google" :
                    site_url() . "<br/>Join With Facebook";
        } else {
            $joinVia = ($type == "google") ?
                    site_url() . "register<br/>Join With Google" :
                    site_url() . "register<br/>Join With Facebook";
        }
        $set = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'user_unique_id' => $data['id'],
            'join_type' => $type,
            'join_via' => $joinVia
        );
        $this->db->trans_start();

        $this->db->insert('wi_user_mst', $set);
        $insertid = $this->db->insert_id();

        $d_userid = array(
            'name' => 'd-userid',
            'value' => $insertid,
            'expire' => time() + 86500,
            'domain' => '.wish-fish.com'
        );
        $this->input->set_cookie($d_userid);

        $planInfo = $this->wi_common->getPlan(1);
        $plan_set = array(
            'plan_id' => 1,
            'user_id' => $insertid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'amount' => 0,
            'plan_status' => 1,
            'start_date' => date('Y-m-d'),
            'expiry_date' => $this->wi_common->getNextDate(date('Y-m-d'), "14 Days")
        );
        $this->db->insert('wi_plan_detail', $plan_set);
        $pid = $this->db->insert_id();
        if ($this->addCustomerToStripe($set, $pid, $insertid)) {
            $this->db->trans_complete();
            $this->sendMail($set, $insertid);
            $flag = ($this->db->trans_status()) ? TRUE : FALSE;
        } else {
            $flag = FALSE;
        }
        if ($flag) {
            if (isset($data['picture'])) {
                $ext = explode('.', basename($data['picture']));
                copy($data['picture'], FCPATH . basename($data['picture']));
                $fname = 'wish-fish/users/profile_' . $insertid . '.' . $ext[1];
                $ext_url = FCPATH . basename($data['picture']);
            } else {
                copy("https://graph.facebook.com/{$data['id']}/picture?width=215&height=215", FCPATH . "user.jpg");
                $fname = 'wish-fish/users/profile_' . $insertid . '.jpg';
                $ext_url = FCPATH . "user.jpg";
            }
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            if ($this->s3->putObjectFile($ext_url, $this->bucket, $fname, "public-read")) {
                unlink($ext_url);
                $this->db->update('wi_user_mst', array('profile_pic' => $fname), array('user_id' => $insertid));
            }
        }
        return $flag;
    }

    function sendMail($post, $userid) {
        $uid = $this->encryption->encode($userid);
        $templateInfo = $this->wi_common->getAutomailTemplate("NEW USER REGISTRATION");
        $url = site_url() . 'app/dashboard?uid=' . $uid;
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
            'NAME' => $post['name'],
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

    function addCustomerToStripe($post, $planid, $insertid) {
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        try {
            $customer = Stripe_Customer::create(array(
                        "email" => $post['email'],
                        "metadata" => array("planid" => $planid, "userid" => $insertid),
                        "plan" => "wishfish-free"
            ));
            $success = 1;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $success = 0;
        }
        if (!$success) {
            return FALSE;
        } else {
            $this->db->update('wi_user_mst', array('customer_id' => $customer->id), array('user_id' => $insertid));
            return TRUE;
        }
    }

    function linkWithProfile($post) {
        $email = (is_array($post)) ? $post['email'] : $post;
        $query = $this->db->get_where('wi_user_mst', array('email' => $email));
        $res = $query->row();
        $profile_type = (is_array($post)) ? $post['profile_type'] : $res->profile_type;
        $profile_link = (is_array($post)) ? $post['profile_link'] : $res->profile_link;
        if ($profile_type != "" && $profile_link != "") {
            switch ($profile_type) {
                case "facebook":
                    $src = "";
                    $base_url = "https://www.facebook.com/";
                    $html = $this->curl_file_get_contents($base_url . $profile_link);

                    $page = str_replace(array('<!--', '-->'), '', $html);
                    $dom = new DOMDocument();
                    @$dom->loadHTML($page, 0);

                    $images = $dom->getElementsByTagName('img');
                    foreach ($images as $image) {
                        if ($image->getAttribute('class') == "profilePic img") {
                            $src = $image->getAttribute('src');
                        }
                    }
                    $nodes = $dom->getElementsByTagName('title');
                    $name = explode('|', $nodes->item(0)->nodeValue);
                    if (isset($name[0]) && ($name[0] != "Page Not Found" || $name[0] != "Facebook")) {
                        copy($src, FCPATH . "user.jpg");
                        $this->updateProfile($res, $name[0]);
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "linkedin":
                    $html = @file_get_html($profile_link);
                    if ($html) {
                        foreach ($html->find('span.full-name') as $e)
                            $name = $e->plaintext;
                        foreach ($html->find('.profile-picture img') as $e)
                            $src = $e->src;
                        if (isset($name) && isset($src)) {
                            copy($src, FCPATH . "user.jpg");
                            $this->updateProfile($res, $name);
                            return TRUE;
                        } else {
                            return FALSE;
                        }
                    } else {
                        return FALSE;
                    }
                    break;
                case "twitter":
                    $base_url = "https://twitter.com/" . $profile_link;
                    $html = @file_get_html($base_url);
                    if ($html) {
                        foreach ($html->find('h1.ProfileHeaderCard-name a') as $e)
                            $name = $e->plaintext;
                        foreach ($html->find('.ProfileAvatar img') as $e)
                            $src = $e->src;
                        copy($src, FCPATH . "user.jpg");
                        $this->updateProfile($res, $name);
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    break;
                default:
                    return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function updateProfile($res, $name) {
        $fname = 'wish-fish/users/profile_' . $res->user_id . '.jpg';
        $this->s3->setAuth($this->accessKey, $this->secretKey);
        $this->s3->putObjectFile(FCPATH . "user.jpg", $this->bucket, $fname, "public-read");
        unlink(FCPATH . "user.jpg");
        $set = array(
            'u_name' => $name,
            'u_profile_pic' => $fname
        );
        $update_set = array(
            'name' => $name,
            'profile_pic' => $fname
        );
        $this->session->set_userdata($set);
        $this->db->update('wi_user_mst', $update_set, array('user_id' => $res->user_id));
    }

    function curl_file_get_contents($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //To stop cURL from verifying the peer's certificate.
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

    function checkCoupon($code) {
        $where = array(
            'coupon_code' => $code,
            'status' => 1,
            'no_of_use >' => 0
        );
        $this->db->where($where);
        $this->db->where("(expiry_date IS NULL or expiry_date > '" . date('Y-m-d') . "')");
        $query = $this->db->get('coupons');
        return ($query->num_rows()) ? $query->row() : FALSE;
    }

    function updateCoupon($code) {
        $where = array(
            'coupon_code' => $code
        );
        $query = $this->db->get_where('coupons', $where);
        $set = array(
            'no_of_use' => $query->row()->no_of_use - 1
        );
        $this->db->update('coupons', $set, $where);
        return TRUE;
    }

    function applyCoupon($coupon, $post) {
        if ($coupon->coupon_validity != '3') {
            $amt = ($coupon->disc_type == "F") ?
                    $post['amount'] - $coupon->disc_amount :
                    $post['amount'] - ($post['amount'] * ($coupon->disc_amount / 100));
            return number_format($amt, 2);
        } else {
            $amt = ($coupon->disc_type == "F") ?
                    $post['amount'] - $coupon->disc_amount :
                    $post['amount'] - ($post['amount'] * ($coupon->disc_amount / 100));
            return number_format($amt, 2);
        }
    }

}
