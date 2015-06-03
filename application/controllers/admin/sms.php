<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sms
 *
 * @author Laxmisoft
 */
class Sms extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->sms) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_sms', 'objsms');
            $this->load->model('admin/m_admin_profile', 'objprofile');
            $this->load->model('admin/m_admin_contacts', 'objcon');
            $this->load->model('admin/m_affiliates', 'objaffiliate');
            $this->load->model('admin/m_customers', 'objcustomer');
            $this->load->model('admin/m_admin_contact_groups', 'objcongroup');
            $this->load->model('admin/m_affiliate_groups', 'objaffiliategroup');
            $this->load->model('admin/m_customer_groups', 'objcustomergroup');
            $this->load->model('admin/m_admin_sms_template', 'objtmplt');
            $this->load->model('admin/m_list_builder', 'objbuilder');
        }
    }

    function send_sms() {
        $data['individual'] = $this->objprofile->getProfiles();
        $data['template'] = $this->objtmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/send-sms', $data);
        $this->load->view('admin/admin_footer');
    }

    function inbox() {
        $from = array();
        $adminInfo = $this->common->getAdminInfo();
        $sms = $this->getInbox();
        foreach ($sms as $msg) {
            if ($msg->direction == "inbound" && $msg->to == $adminInfo->twilio_number) {
                if (!in_array($msg->from, $from)) {
                    $from[] = $msg->from;
                    $this->isExists($msg);
                }
            }
        }
        $data['inbox'] = $this->objsms->getInbox();
//        echo '<pre>';
//        print_r($data);
//        die();
        if ($this->input->get('type') == "ajax") {
            $this->load->view('admin/sms-inbox-view', $data);
        } else {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            if ($this->input->get('ver') != "mobile") {
                $this->load->view('admin/sms-inbox', $data);
            } else {
                $this->load->view('admin/sms-inbox-mob', $data);
            }
            $this->load->view('admin/admin_footer');
        }
    }

    function isExists($msg) {
        $userInfo = $this->objsms->getProfilePics($msg->from);
        if (count($userInfo)) {
            $where = array(
                'from' => $msg->from
            );
            $query = $this->db->get_where('inbox', $where);
            if ($query->num_rows() == 1) {
                if ($query->row()->from == $msg->from && $query->row()->sid != $msg->sid) {
                    $this->db->delete('inbox', array('from' => $msg->from));
                    $flag = TRUE;
                } else {
                    $flag = FALSE;
                }
            } else {
                $flag = TRUE;
            }
            if ($flag) {
                $set = array(
                    'from' => $msg->from,
                    'sid' => $msg->sid,
                    'body' => $msg->body,
                    'date_sent' => $msg->date_sent,
                    'contact_id' => $userInfo->contact_id
                );
                $this->db->insert('inbox', $set);
            }
        }
    }

    function allUser($type) {
        $individual = $ids = $user = array();
        switch ($type) {
            case 1:
                $individual = $this->objprofile->getProfiles();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->phone;
                    $ids[$key] = $value->profile_id;
                }
                break;
            case 2:
                $individual = $this->objcon->getContactDetail();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->phone;
                    $ids[$key] = $value->contact_id;
                }
                break;
            case 3:
                $individual = $this->objaffiliate->getAffiliateDetail();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->phone;
                    $ids[$key] = $value->affiliate_id;
                }
                break;
            case 4:
                $individual = $this->objcustomer->getCustomerDetail();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->phone;
                    $ids[$key] = $value->customer_id;
                }
                break;
        }
        $data['user'] = $user;
        $data['ids'] = $ids;
        echo json_encode($data);
    }

    function allGroup($type) {
        switch ($type) {
            case 2:
                $group = $this->objcongroup->getContactGroups("simple");
                break;
            case 3:
                $group = $this->objaffiliategroup->getAffiliateGroups();
                break;
            case 4:
                $group = $this->objcustomergroup->getCustomerGroups();
                break;
        }
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function allSMSList() {
        $group = $this->objcongroup->getContactGroups("sms");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function getTemplate($tmpid) {
        $this->objsms->getTemplate($tmpid);
    }

    function send_message() {
        $is_send = FALSE;
        $post = $this->input->post();
        $blackList = $this->objcon->getBlackList();
        switch ($post['assign']) {
            case 'all_c':
                switch ($post['user']) {
                    case 1:
                        $user = $this->objprofile->getProfile($post['user_id']);
                        break;
                    case 2:
                        if (!in_array($post['user_id'], $blackList)) {
                            $user = $this->objcon->getContactInfo($post['user_id']);
                        } else {
                            $user = array();
                        }
                        break;
                    case 3:
                        $user = $this->objaffiliate->getAffiliateInfo($post['user_id']);
                        break;
                    case 4:
                        $user = $this->objcustomer->getCustomerInfo($post['user_id']);
                        break;
                }
                if (count($user) && $user->phone != NULL) {
                    $tag = $this->common->setToken($user);
                    $body = $this->parser->parse_string($post['body'], $tag, TRUE);
                    $is_send = $this->sendSMS($user->phone, $body);
                } else {
                    $phoneNotExist = "F";
                }
                break;
            case 'all_gc':
            case 'all_l':
                switch ($post['user']) {
                    case 2:
                        if ($post['assign'] == "all_gc") {
                            $res = $this->objbuilder->getGroupContact($post['group_id']);
                            $ids = $res[1];
                        } else {
                            $ids = $this->objbuilder->getSubGroupContact($post['group_id']);
                        }
                        $flag = TRUE;
                        break;
                    case 3:
                        $res = $this->objbuilder->getGroupAffiliate($post['group_id']);
                        $ids = $res[1];
                        $flag = FALSE;
                        break;
                    case 4:
                        $res = $this->objbuilder->getGroupCustomer($post['group_id']);
                        $ids = $res[1];
                        $flag = FALSE;
                        break;
                }
                foreach ($ids as $value) {
                    if ($flag && !in_array($value, $blackList)) {
                        $user = $this->objcon->getContactInfo($value);
                    } else if ($post['user'] == 3 && !$flag) {
                        $user = $this->objaffiliate->getAffiliateInfo($value);
                    } else if ($post['user'] == 4 && !$flag) {
                        $user = $this->objcustomer->getCustomerInfo($value);
                    } else {
                        $user = array();
                    }
                    if (count($user) > 0) {
                        $tag = $this->common->setToken($user);
                        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
                        $is_send = $this->sendSMS($user->phone, $body);
                    }
                }
                break;
            default:
                break;
        }
        if (isset($phoneNotExist)) {
            $msg = $phoneNotExist;
        } else {
            $msg = ($is_send) ? "send" : "fail";
        }
        header('location:' . site_url() . 'admin/sms/send_sms?msg=' . $msg);
    }

    function sendSMS($to = NULL, $body = NULL) {

        if ($to == NULL && $body == NULL) {
            $post = $this->input->post();
            $to = $post['to'];
            $body = $post['msg'];
            $flag = TRUE;
        } else {
            $flag = FALSE;
        }
        if ($this->common->sendSMS($to, $body)) {
            $set = array('status' => 0, 'body' => $body);
            $where = array('from' => $to);
            $this->objsms->updateStatus($set, $where);
            if ($flag && !isset($post['ver'])) {
                $data['inbox'] = $this->objsms->getInbox();
                $this->load->view('admin/sms-inbox-view', $data);
            } else if ($flag && isset($post['ver'])) {
                header('location:' . site_url() . 'admin/sms/inbox?ver=mobile&msg=send');
            } else if (!$flag) {
                return TRUE;
            }
        } else {
            if ($flag && !isset($post['ver'])) {
                echo 0;
            } else if ($flag && isset($post['ver'])) {
                header('location:' . site_url() . 'admin/sms/inbox?ver=mobile&msg=fail');
            } else if (!$flag) {
                return FALSE;
            }
        }
    }

    function getInbox() {
        try {
            return $this->twilio->account->sms_messages;
        } catch (Services_Twilio_RestException $e) {
            //echo $e->getMessage();            
            return FALSE;
        }
    }

    function viewconversation() {
        $from = $this->input->post('from');
        $msg = array();
        $messages = $this->twilio->account->messages->getIterator(0, 50, array());
        foreach ($messages as $sms) {
            $msg[] = $sms;
        }
        $set = array('status' => 2);
        $where = array('from' => $from, 'status' => 1);
        $this->objsms->updateStatus($set, $where);
        $data['adminInfo'] = $this->common->getAdminInfo();
        $data['messages'] = array_reverse($msg);
        $data['contactInfo'] = $this->objsms->getProfilePics($from);
        $this->load->view('admin/sms-chat', $data);
    }

    function loadConversation() {
        $from = $this->input->get('from');
        $msg = array();
        $messages = $this->twilio->account->messages->getIterator(0, 50, array());
        foreach ($messages as $sms) {
            $msg[] = $sms;
        }
        $data['messages'] = array_reverse($msg);
        $data['contactInfo'] = $this->objsms->getProfilePics('+' . trim($from));
        $data['adminInfo'] = $this->common->getAdminInfo();
        $set = array('status' => 2);
        $where = array('from' => '+' . trim($from), 'status' => 1);
        $this->objsms->updateStatus($set, $where);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/sms-chat-mob', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateStatus($sid) {
        $where['sid'] = $sid;
        $set['status'] = 2;
        $this->objsms->updateStatus($set, $where);
    }

    function smsNotification() {
        $this->load->view('admin/sms-notification-view');
    }

}
