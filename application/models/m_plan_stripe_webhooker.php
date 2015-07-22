<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stripe_webhooker
 *
 * @author Laxmisoft
 */
class M_plan_stripe_webhooker extends CI_Model {

//put your code here
    function __construct() {
        parent::__construct();
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function stripe($event_json) {
        $event = $event_json->type;

        $customer_id = $event_json->data->object->customer;
        $customer = Stripe_Customer::retrieve($customer_id);
        $myfile = fopen(FCPATH . 'events.txt', "a");
        fwrite($myfile, "Event :" . $event . "\n");



        switch ($event) {
            case "charge.succeeded":
                $charge = fopen(FCPATH . 'charge', "a");
                fwrite($charge, $event_json->data->object->id);
                break;
            case "customer.subscription.created":
                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);

                $pname = $event_json->data->object->plan->id;
//                fwrite($myfile, "Plan ID :" . $pname . "\n");
                $plan_array = array("wishfish-free", "wishfish-personal", "wishfish-enterprise");

                if (in_array($pname, $plan_array)) {
//                    fwrite($myfile, "------------REGULAR------------\n");
                    $planid = ($pname == "wishfish-free") ? 1 :
                            (($pname == "wishfish-personal") ? 2 : 3);
                    if ($planid != 1 && !isset($event_json->data->object->metadata->userid)) {
                        $user_set = array(
                            'email' => $customer->email,
                            'password' => $this->generateRandomString(5),
                            'customer_id' => $customer->id,
                            'gateway' => "STRIPE",
                            'is_set' => 1,
                            'register_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
                        );
                        $this->db->insert('wi_user_mst', $user_set);
                        $uid = $this->db->insert_id();

                        $pid = $this->insertPlanDetail($uid, $planid, $customer);
                        $this->insertUserSetting($uid);
                        $this->insertPaymentDetail($pid, $customer);
                        $this->updateCardDetail($customer, $uid, $pid);
                        $this->sendMail($user_set, $uid);
                    } else {
                        if (isset($event_json->data->object->metadata->userid)) {
                            $uid = $event_json->data->object->metadata->userid;
                            $pid = $this->insertPlanDetail($uid, $planid, $customer);
                        } else {
                            $pid = $customer->metadata->planid;
                        }
                        $this->insertPaymentDetail($pid, $customer);
                    }
                } else {

//                    fwrite($myfile, "------------NEW PLAN------------\n");

                    $ptype = $event_json->data->object->metadata->payment_type;
                    $uid = $event_json->data->object->metadata->userid;
                    $planid = $event_json->data->object->metadata->planid;

//                    fwrite($myfile, "------------$ptype------------\n");
//                    fwrite($myfile, "------------$uid------------\n");
//                    fwrite($myfile, "------------$planid------------\n");

                    $pid = $this->insertPlanDetail($uid, $planid, $customer, $ptype);
                    $this->insertPaymentDetail($pid, $customer);
                }
                break;
            case "invoice.payment_succeeded":
                break;
            case "customer.subscription.deleted":
                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
                $subsid = $event_json->data->object->id;
                $userid = $customer->metadata->userid;

                $userInfo = $this->wi_common->getUserInfo($userid);
                $this->db->select('*');
                $query = $this->db->get_where('wi_payment_mst', array('transaction_id' => $subsid));
                $res = $query->row();
                $set = array(
                    'plan_status' => 0,
                    'cancel_date' => date('Y-m-d')
                );
                $where = array(
                    'id' => $res->id
                );
                $this->db->update('wi_plan_detail', $set, $where);

                if ($this->isFreePlan($res)) {
                    if ($userInfo->is_bill) {
                        $customer->subscriptions->create(array(
                            "plan" => "wishfish-personal",
                            "metadata" => array("userid" => $userid)
                        ));
                    }
                }
                break;
            case "customer.subscription.trial_will_end":
                /*
                  $userid = $customer->metadata->userid;
                  $userInfo = $this->wi_common->getUserInfo($userid);
                  $subs = $customer->subscriptions->data[0]->id;
                  $customer->subscriptions->retrieve($subs)->cancel();
                  if ($userInfo->is_bill) {
                  $customer->subscriptions->create(array("plan" => "wishfish-personal"));
                  } else {
                  $where = array(
                  'user_id' => $userid,
                  'plan_status' => 1
                  );
                  $this->db->update('wi_plan_detail', array('plan_status' => 0), $where);
                  }
                 * 
                 */
                break;
        }
    }

    function isFreePlan($res) {
        $query = $this->db->get_where('wi_plan_detail', array('id' => $res->id));
        return ($query->row()->plan_id == 1) ? TRUE : FALSE;
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function insertPlanDetail($userid, $planid, $customer, $type = NULL) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $planInfo = $this->wi_common->getPlan($planid);

        $startDt = date('Y-m-d', $customer->subscriptions->data[0]->current_period_start);
        $endDt = date('Y-m-d', $customer->subscriptions->data[0]->current_period_end);

        if (isset($customer->metadata->coupon)) {
            $coupon = $this->getCoupon($customer->metadata->coupon);
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
        $plan_set['expiry_date'] = ($type != NULL) ?
                (($type == "onetime") ? $endDt : NULL) : NULL;
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

    function insertPaymentDetail($pid, $customer) {

        $charge = fopen(FCPATH . 'charge', 'r');
        $chargeid = fread($charge, filesize(FCPATH . 'charge'));
        unlink(FCPATH . 'charge');

        $amount = $customer->subscriptions->data[0]->plan->amount / 100;

        if (isset($customer->metadata->coupon)) {
            $coupon = $this->getCoupon($customer->metadata->coupon);
            $amount = ($coupon->disc_type == "F") ?
                    $amount - $coupon->disc_amount :
                    $amount - ($amount * ($coupon->disc_amount / 100));
        }
        $insert_set = array(
            'id' => $pid,
            'transaction_id' => $customer->subscriptions->data[0]->id,
            'invoice_id' => $chargeid,
            'payer_id' => $customer->id,
            'payer_email' => $customer->email,
            'mc_gross' => $amount,
            'mc_fee' => ($amount != 0) ? ($amount * 0.029) + 0.30 : 0,
            'gateway' => "STRIPE",
            'payment_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
        );
        $this->db->insert('wi_payment_mst', $insert_set);
    }

    function updateCardDetail($customer, $uid, $pid) {
        try {
            $customer->metadata = array('planid' => $pid, 'userid' => $uid);
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
