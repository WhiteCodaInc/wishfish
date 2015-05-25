<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_access
 *
 * @author Laxmisoft
 */
class Calender extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library('common');
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->calender) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_contacts', 'objcontact');
            $this->load->model('admin/m_contact_groups', 'objgroup');
            $this->load->model('admin/m_sms_template', 'objsmstemplate');
            $this->load->model('admin/m_email_template', 'objemailtemplate');
            $this->load->model('admin/m_sms', 'objsms');
            $this->load->model('admin/m_email', 'objemail');
            $this->load->model('admin/m_calender', 'objcalender');
        }
    }

    function index() {
        $data['individual'] = $this->objcontact->getContactDetail();
        $data['template'] = $this->objsmstemplate->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/calender', $data);
        $this->load->view('admin/admin_footer');
    }

    function createEvent($type, $userid) {
        $t = $this->input->get('type');
        $res = $this->objcalender->createEvent($type, $userid);
        if ($res) {
            $data['individual'] = $this->objcontact->getContactDetail();
            $data['template'] = $this->objsmstemplate->getTemplates();
            $data['contactInfo'] = $res;
        } else {
            $data['contactInfo'] = FALSE;
        }
        $data['flag'] = ($t == "bday") ? TRUE : FALSE;
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/calender', $data);
        $this->load->view('admin/admin_footer');
    }

    function allGroup() {
        $group = $this->objgroup->getContactGroups("simple");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function allSMSList() {
        $group = $this->objgroup->getContactGroups("sms");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function getTemplate($type, $tmpid) {
        if ($type == "sms" || $type == "notification") {
            $this->objsms->getTemplate($tmpid);
        } else if ($type == "email") {
            $this->objemail->getTemplate($tmpid);
        }
    }

    function getTemplates($type) {
        if ($type == "sms" || $type == "notification") {
            $templates = $this->objsmstemplate->getTemplates();
        } else if ($type == "email") {
            $templates = $this->objemailtemplate->getTemplates();
        } else {
            echo 0;
        }
        echo '<option value="-1">--Select--</option>';
        foreach ($templates as $value) {
            echo "<option value='$value->template_id'>";
            echo ($type == "sms") ? $value->title : $value->name;
            echo "</option>";
        }
    }

    function addEvent() {
        $post = $this->input->post();
        $data = $this->objcalender->addEvent($post);
        if ($data) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function getEvents() {
        $post = $this->input->post();
        $this->objcalender->getEvents($post);
    }

    function getCards() {
        $this->objcalender->getCards();
    }

    function getEvent($eid) {
        $event = $this->objcalender->getEvent($eid);
        echo json_encode($event);
    }

    function updateEvent() {
        $flag = $this->objcalender->updateEvent();
        echo ($flag) ? 1 : 0;
    }

    function deleteEvent($eid) {
        $flag = $this->objcalender->deleteEvent($eid);
        echo ($flag) ? 1 : 0;
    }

}
