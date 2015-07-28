<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email
 *
 * @author Laxmisoft
 */
class Email extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->email) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->library('parser');
            $this->load->library('common');
            $this->load->model('admin/m_email', 'objemail');
            $this->load->model('admin/m_admin_profile', 'objprofile');
            $this->load->model('admin/m_admin_contacts', 'objcon');
            $this->load->model('admin/m_affiliates', 'objaffiliate');
            $this->load->model('admin/m_customers', 'objcustomer');
            $this->load->model('admin/m_admin_contact_groups', 'objcongroup');
            $this->load->model('admin/m_affiliate_groups', 'objaffiliategroup');
            $this->load->model('admin/m_customer_groups', 'objcustomergroup');
            $this->load->model('admin/m_admin_email_template', 'objtmplt');
            $this->load->model('admin/m_list_builder', 'objbuilder');
        }
    }

    function send_email() {
        $data['individual'] = $this->objprofile->getProfiles();
        $data['template'] = $this->objtmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/send-email', $data);
        $this->load->view('admin/admin_footer');
    }

    function allUser($type) {
        $individual = $ids = $user = array();
        switch ($type) {
            case 1:
                $individual = $this->objprofile->getProfiles();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->email;
                    $ids[$key] = $value->profile_id;
                }
                break;
            case 2:
                $individual = $this->objcon->getContactDetail();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->email;
                    $ids[$key] = $value->contact_id;
                }
                break;
            case 3:
                $individual = $this->objaffiliate->getAffiliateDetail();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->email;
                    $ids[$key] = $value->affiliate_id;
                }
                break;
            case 4:
                $individual = $this->objcustomer->getCustomerDetail();
                foreach ($individual as $key => $value) {
                    $user[$key] = $value->name . ' || ' . $value->email;
                    $ids[$key] = $value->user_id;
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

    function allEmailList() {
        $group = $this->objcongroup->getContactGroups("email");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function getTemplate($tmpid) {
        $this->objemail->getTemplate($tmpid);
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
                if (count($user) && ($user->email != NULL || $user->email != "")) {
                    $tag = $this->common->setToken($user);
                    $is_send = $this->sendMail($user, $tag, $post);
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
                        $is_send = $this->sendMail($user, $tag, $post);
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
        header('location:' . site_url() . 'admin/email/send_email?msg=' . $msg);
    }

    function sendMail($user, $tag, $post) {
        $subject = $this->parser->parse_string($post['subject'], $tag, TRUE);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        return $this->common->sendMail($user->email, $subject, $body);
    }

}
