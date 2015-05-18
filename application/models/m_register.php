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

        $this->load->library('amazons3');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function register($post) {
        $flag = FALSE;
        $post['password'] = $this->generateRandomString(5);
        $login = array(
            'email' => $post['email'],
            'password' => $post['password']
        );
        $this->db->trans_start();
        $planInfo = $this->common->getPlan(1);

        $this->db->insert('user_mst', $post);
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
            'expiry_date' => $this->common->getNextDate(date('Y-m-d'), "14 Days")
        );
        $this->db->insert('plan_detail', $set);
        $planid = $this->db->insert_id();
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
            'user_unique_id' => $data['id'],
            'email' => $data['email']
        );
        $query = $this->db->get_where('user_mst', $where);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function registerWithSocial($data) {
        $set = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'user_unique_id' => $data['id']
        );
        $this->db->trans_start();

        $this->db->insert('user_mst', $set);
        $insertid = $this->db->insert_id();

        $this->session->set_userdata('d-userid', $insertid);
        $this->session->set_userdata('d-name', $set['name']);

        $planInfo = $this->common->getPlan(1);
        $plan_set = array(
            'plan_id' => 1,
            'user_id' => $insertid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'amount' => 0,
            'plan_status' => 1,
            'start_date' => date('Y-m-d'),
            'expiry_date' => $this->common->getNextDate(date('Y-m-d'), "14 Days")
        );
        $this->db->insert('plan_detail', $plan_set);
        $pid = $this->db->insert_id();
        if ($this->addCustomerToStripe($set, $pid, $insertid)) {
            $this->db->trans_complete();
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
                $this->db->update('user_mst', array('profile_pic' => $fname), array('user_id' => $insertid));
            }
        }
        return $flag;
    }

    function sendMail($post, $userid) {
        $uid = $this->encryption->encode($userid);
        $templateInfo = $this->common->getAutomailTemplate("NEW USER REGISTRATION");
        $url = site_url() . 'app/dashboard?uid=' . $uid;
        $link = "<table border='0' align='center' cellpadding='0' cellspacing='0' class='mainBtn' style='margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;'>";
        $link .= "<tr>";
        $link .= "<td align='center' valign='middle' class='btnMain' style='margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 12px;padding-bottom: 12px;padding-left: 22px;padding-right: 22px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: {$templateInfo['color']};height: 20px;font-size: 18px;line-height: 20px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;'>
                                            <a href='{$url}' style='padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #ffffff;font-weight: bold;'>
                                                <span style='text-decoration: none;color: #ffffff;'>
                                                    Active Your Account
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

        return $this->common->sendAutoMail($post['email'], $subject, $body, $from, $name);
    }

    function addCustomerToStripe($post, $planid, $insertid) {
        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        try {
            $customer = Stripe_Customer::create(array(
                        "email" => $post['email'],
                        "metadata" => array("planid" => $planid, "userid" => $insertid),
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
        if (!$success) {
            return FALSE;
        } else {
            $this->db->update('user_mst', array('customer_id' => $customer->id), array('user_id' => $insertid));
            return TRUE;
        }
    }

}
