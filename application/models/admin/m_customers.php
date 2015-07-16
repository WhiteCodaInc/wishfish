<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_admin_login
 *
 * @author Laxmisoft
 */
class M_customers extends CI_Model {

    private $profileid, $bucket, $accessKey, $secretKey;
    private $api_username, $api_password, $api_signature;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->profileid = $this->session->userdata('profileid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));

        $this->paypal = $this->load->library('paypal_lib');
        $paypalGatewayInfo = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
        $this->api_username = $paypalGatewayInfo->api_username;
        $this->api_password = $paypalGatewayInfo->api_password;
        $this->api_signature = $paypalGatewayInfo->api_signature;

        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function getCustomerDetail() {
        $this->db->select('U.user_id,profile_pic,U.register_date,name,email,phone,phone_verification,P.plan_name,status');
        $this->db->from('wi_user_mst as U');
        $this->db->join('wi_plan_detail as PD', 'U.user_id = PD.user_id', 'left outer');
        $this->db->join('wi_plans as P', 'PD.plan_id = P.plan_id');
        $this->db->where('PD.plan_status', 1);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function searchResult() {
        $post = $this->input->post();
        $name = $post['name_search'];
        $email = $post['email_search'];
        $from = $post['from_search'];
        $to = $post['to_search'];
        $plan = $post['plan_search'];
        $join = $post['join_search'];
        $status = $post['status_search'];

        ($name != "") ? $this->db->like('name', $name) : '';
        ($email != "") ? $this->db->like('email', $email) : '';
        ($from != "") ? $where['DATE(U.register_date) >='] = $this->common->getMySqlDate($from, "mm-dd-yyyy") : '';
        ($to != "") ? $where['DATE(U.register_date) <='] = $this->common->getMySqlDate($to, "mm-dd-yyyy") : '';
        ($join != "" && $join != "-1") ? $where['join_via'] = $join : '';
        ($status != "" && $status != "-1") ? $where['U.status'] = $status : '';
        ($plan != "" && $plan != "-1") ? $where['P.plan_id'] = $plan : '';

        $this->db->select('U.user_id,profile_pic,U.register_date,name,email,phone,phone_verification,P.plan_name,status');
        $this->db->from('wi_user_mst as U');
        $this->db->join('wi_plan_detail as PD', 'U.user_id = PD.user_id', 'left outer');
        $this->db->join('wi_plans as P', 'PD.plan_id = P.plan_id');
        $this->db->where('PD.plan_status', 1);
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';
        $query = $this->db->get();
        return $query->result();
    }

    function getCustomerInfo($cid) {
        $this->db->select('*,U.user_id,U.register_date');
        $this->db->from('wi_user_mst as U');
        $this->db->join('wi_plan_detail as PD', 'U.user_id = PD.user_id', 'left outer');
        $this->db->join('wi_plans as P', 'PD.plan_id = P.plan_id');
        $this->db->where('PD.plan_status', 1);
        $this->db->where('U.user_id', $cid);
        $query = $this->db->get();
        return $query->row();
    }

    function getPaymentHistory($cid) {
        $this->db->select('payment_id,transaction_id,mc_gross,gateway,payment_date,plan_name');
        $this->db->from('wi_payment_mst as P');
        $this->db->join('wi_plan_detail as PD', 'P.id = PD.id');
        $this->db->join('wi_plans as PL', 'PD.plan_id = PL.plan_id');
        $this->db->where('PD.user_id', $cid);
        $this->db->order_by('P.payment_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function setAction($type) {
        $ids = $this->input->post('customer');
        $msg = "";
        $where = 'user_id in (' . implode(',', $ids) . ')';
        $this->db->where($where);
        switch ($type) {
            case "Active":
                $this->db->update('wi_user_mst', array('status' => 1));
                $msg = "A";
                break;
            case "Deactive":
                $this->db->update('wi_user_mst', array('status' => 0));
                $msg = "DA";
                break;
            case "Delete":
                $this->db->delete('wi_user_mst');
                $msg = "D";
                break;
        }
        return $msg;
    }

    function updateCustomer($set) {
        $m = "";
        $cid = $set['customerid'];
        $customerInfo = $this->getCustomerInfo($cid);
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->wi_common->getMySqlDate($set['birthday'], $customerInfo->date_format) :
                NULL;

        unset($set['customerid']);
        unset($set['code']);

        if (isset($_FILES['profile_pic'])) {
            if ($_FILES['profile_pic']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $cid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['profile_pic'] = $msg;
                        $m = "U";
                        break;
                }
            } else {
                $m = "U";
            }
        } else {
            $m = "U";
        }
        (isset($set['password'])) ?
                        $set['password'] = sha1($set['password']) : "";
        $this->db->update('wi_user_mst', $set, array('user_id' => $cid));
        return $m;
    }

    function uploadImage($file, $cid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['profile_pic']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/users/profile_' . $cid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['profile_pic']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function extendTrial($post) {
        $dt = ($post['extend_date'] != "") ?
                $this->wi_common->getMySqlDate($post['extend_date'], "mm-dd-yyyy") :
                NULL;
//        $currPlan = $this->wi_common->getCurrentPlan($post['userid']);
        $this->db->update('wi_plan_detail', array('expiry_date' => $dt), array('id' => $post['planid']));
        return true;
    }

    function lifetimeAccess($post) {
        $is_lifetime = ($post['type'] == "assign") ? 1 : 0;
        $this->db->update('wi_plan_detail', array('is_lifetime' => $is_lifetime), array('id' => $post['planid']));
        return true;
    }

    function updateCustomerNotification() {
        $this->db->where('notification', 1);
        $this->db->update('wi_user_mst', array('notification' => 0));
    }

    function updatePaymentNotification() {
        $this->db->where('notification', 1);
        $this->db->update('wi_payment_mst', array('notification' => 0));
    }

    /* -------------------Card Detail---------------------------- */

    function getCardDetail($cid) {
        try {
            $uInfo = $this->wi_common->getUserInfo($cid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if (!$customer->deleted && $customer->cards->total_count != 0) {
                $cardid = $customer->cards->data[0]->id;
                $card = $customer->sources->retrieve($cardid);
                $cardDetail = array(
                    'last4' => $card->last4,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                );
                return $cardDetail;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function createCard($cid, $stripeToken) {
        try {
            $uInfo = $this->wi_common->getUserInfo($cid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            $customer->sources->create(array("source" => $stripeToken));
            $success = 1;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            $this->session->set_flashdata('error', $error);
            header('location:' . site_url() . 'admin/customers/profile/' . $cid);
        } else {
            $user_set = array(
                'gateway' => "STRIPE",
                'is_set' => 1
            );
            $this->db->update('wi_user_mst', $user_set, array('user_id' => $cid));
            return TRUE;
        }
    }

    function updateCard($cid, $stripeToken) {
        try {
            $uInfo = $this->wi_common->getUserInfo($cid);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
            if ($customer->cards->total_count != 0) {
                $cardid = $customer->cards->data[0]->id;
                $customer->sources->retrieve($cardid)->delete();
            }
            $customer->sources->create(array("source" => $stripeToken));
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function chargeUser($post) {
        try {
            $flag = FALSE;
            echo '<pre>';
            print_r($post);
//          die();
            $uInfo = $this->wi_common->getUserInfo($post['userid']);
            print_r($uInfo);
//          $pname = ($post['plan'] == '2') ? "wishfish-personal" : "wishfish-enterprise";
//          echo '<br>' . $pname . '<br>';
            if ($uInfo->is_set && $uInfo->gateway == "PAYPAL") {
                echo '<br>---------------PAYPAL CANCELD START-----------<br>';
                $currPlan = $this->wi_common->getLatestPlan($post['userid']);
//              print_r($currPlan);
                $profileId = $this->isExistProfileId($currPlan);
                if ($profileId) {
                    $status = $this->getRecurringProfile($profileId->transaction_id);
                    print_r($profileId);
                    echo "<br>------STATUS : $status -------------<br>";
                    echo "PROFILE ID : $profileId->transaction_id Cancelled";
//                    $this->cancelRecurringProfile($profileId->transaction_id);
                }
                try {
                    $customer = Stripe_Customer::create(array(
                                "email" => $uInfo->email,
                                "metadata" => array("userid" => $post['userid']),
                    ));
                    echo '<br>-------NEW CUSTOMER---------<br>';
                    print_r($customer);
                    $user_set = array(
                        'gateway' => "STRIPE",
                        'is_set' => 1,
                        'customer_id' => $customer->id
                    );
                } catch (Exception $e) {
                    $flag = FALSE;
                    $e->getMessage();
                }
            } else if (!$uInfo->is_set || ($uInfo->is_set && $uInfo->gateway == "STRIPE")) {
//              echo '<br>---------------STRIPE START-----------<br>';
                try {
                    $customer = Stripe_Customer::retrieve($uInfo->customer_id);
                    echo '<br>--------OLD CUSTOMER---------<br>';
                    print_r($customer);
                    if (isset($customer->subscriptions->data[0]->id)) {
                        $subs = $customer->subscriptions->data[0]->id;
                        echo "<br>Subscription ID : $subs Cancelled<br>";
//                        $customer->subscriptions->retrieve($subs)->cancel();
                    }
                    $user_set = array(
                        'gateway' => "STRIPE",
                        'is_set' => 1
                    );
                } catch (Exception $e) {
                    $flag = FALSE;
                    $e->getMessage();
                }
            }
            if ($flag) {
                $random = $this->wi_common->getRandomDigit(5);
                $planid = preg_replace('/\s\s+/', '_', trim($uInfo->name)) . '_' . $post['userid'] . '_' . $random;
//              echo "<br>Plan ID : $planid<br>";
                Stripe_Plan::create(array(
                    "amount" => $post['amount'] * 100,
                    "currency" => 'USD',
                    "interval" => 'month',
                    "interval_count" => $post['interval'],
                    "name" => $uInfo->name . '(Individual)',
                    "id" => $planid));
                $customer->sources->create(array("source" => $post['stripeToken']));
                $stripe = array(
                    "plan" => $planid,
                    "metadata" => array("userid" => $post['userid'], "payment_type" => $post['type'], "random" => $random),
                );
                $customer->subscriptions->create($stripe);
                $this->db->update('wi_user_mst', $user_set, array('user_id' => $post['userid']));
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
//            echo $e->getMessage();
            return FALSE;
        }
    }

    function isExistProfileId($currPlan) {
        $this->db->select('*');
        $this->db->limit(1);
        $query = $this->db->get_where('wi_payment_mst', array('id' => $currPlan->id));
        return ($query->num_rows()) ? $query->row() : FALSE;
    }

    function cancelRecurringProfile($id) {
        if ($this->getRecurringProfile($id)) {
            $this->paypal_lib->set_acct_info(
                    $this->api_username, $this->api_password, $this->api_signature
            );
            $requestParams = array(
                'PROFILEID' => $id,
                'ACTION' => 'Cancel', //Cancel,Suspend,Reactivate
            );
            $response = $this->paypal_lib->request('ManageRecurringPaymentsProfileStatus', $requestParams);
            return ($response['ACK'] == "Success") ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }

    function getRecurringProfile($id) {
        $this->paypal->set_acct_info(
                $this->api_username, $this->api_password, $this->api_signature
        );
        $requestParams = array(
            'PROFILEID' => $id
        );
        $response = $this->paypal_lib->request('GetRecurringPaymentsProfileDetails', $requestParams);
        return ($response['STATUS'] == "Active") ? TRUE : FALSE;
    }

}
