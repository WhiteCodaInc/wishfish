<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_upgrade_plans
 *
 * @author Laxmisoft
 */
class Stripe_payment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $this->load->model('m_register', 'objregister');
        /* if (!$this->wi_authex->logged_in()) {
          header('location:' . site_url() . 'login');
          } */
    }

    function pay() {
        $success = 0;
        $flag = TRUE;
        $set = $this->input->post();
        if ($set['coupon'] != "") {
            $flag = ($this->objregister->checkCoupon($set['coupon'])) ? TRUE : FALSE;
        }
        if ($flag) {
            $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
            require_once(FCPATH . 'stripe/lib/Stripe.php');
            Stripe::setApiKey($gatewayInfo->secret_key);
            if ($this->input->post('stripeToken') != "") {
                try {
                    $stripe = array(
                        "card" => $this->input->post('stripeToken'),
                        "email" => $this->input->post('stripeEmail'),
                        "plan" => $set['plan']
                    );
                    ($set['coupon'] != "") ? $stripe['coupon'] = $set['coupon'] : '';
                    $customer = Stripe_Customer::create($stripe);
                    if ($set['coupon'] != "")
                        $this->objregister->updateCoupon($set['coupon']);

                    $user_set = array(
                        'email' => $customer->email,
                        'customer_id' => $customer->id,
                        'gateway' => "STRIPE",
                        'is_set' => 1,
                        'register_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
                    );
                    $this->db->insert('wi_user_mst', $user_set);
                    $uid = $this->db->insert_id();


                    $this->session->set_userdata('d-userid', $uid);
                    $this->session->set_userdata('d-name', "");

                    $pid = $this->insertPlanDetail($uid, $set['planid'], $customer, $set);
                    $this->insertUserSetting($uid);

                    $data = array('planid' => $pid, 'userid' => $uid);
                    ($set['coupon'] != "") ? $data['coupon'] = $set['coupon'] : '';
                    $this->updateCardDetail($customer, $data);
                    $this->sendMail($user_set, $uid);
                    $success = 1;
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    $success = 0;
                }
                if ($success != 1) {
                    $data['error'] = $error;
                    $this->load->view('stripe_error', $data);
                } else {
                    header('location:' . site_url() . 'app/dashboard');
//                    header('Location:' . site_url() . 'login?msg=RS');
                }
            }
        } else {
            $data['error'] = "Coupon Code is Invalid...!";
            $this->load->view('stripe_error', $data);
        }
    }

    function insertPlanDetail($userid, $planid, $customer, $set) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $planInfo = $this->wi_common->getPlan($planid);

        $startDt = date('Y-m-d', $customer->subscriptions->data[0]->current_period_start);
//        $endDt = date('Y-m-d', $customer->subscriptions->data[0]->current_period_end);

        if ($set['coupon'] != "") {
            $coupon = $this->getCoupon($set['coupon']);
            $amount = ($coupon->disc_type == "F") ?
                    $amount - $coupon->disc_amount :
                    $amount - ($amount * ($coupon->disc_amount / 100));
        }

        $plan_set = array(
            'user_id' => $userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => $startDt
        );
//        $plan_set['expiry_date'] = ($type != NULL) ?
//                (($type == "onetime") ? $endDt : NULL) : NULL;
        $this->db->insert('wi_plan_detail', $plan_set);
        return $this->db->insert_id();
    }

    function insertUserSetting($uid) {
        $set = array(
            'user_id' => $uid,
            'redirect_uri' => site_url() . 'app/calender'
        );
        $this->db->insert('wi_user_setting', $set);
    }

    function updateCardDetail($customer, $data) {
        try {
            $customer->metadata = $data;
            $customer->save();
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function getCoupon($code) {
        $where = array(
            'coupon_code' => $code
        );
        $query = $this->db->get_where('coupons', $where);
        return $query->row();
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
            'NAME' => "User",
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
