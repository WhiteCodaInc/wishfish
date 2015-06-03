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
            $this->load->model('admin/m_admin_contacts', 'objcontact');
            $this->load->model('admin/m_admin_contact_groups', 'objgrp');
            $this->load->model('admin/m_admin_sms_template', 'objsmstmplt');
            $this->load->model('admin/m_admin_email_template', 'objemailtmplt');
            $this->load->model('admin/m_sms', 'objsms');
            $this->load->model('admin/m_email', 'objemail');
            $this->load->model('admin/m_admin_calender', 'objcal');
        }
    }

    function index() {
        $data['individual'] = $this->objcontact->getContactDetail();
        $data['template'] = $this->objsmstmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/calender', $data);
        $this->load->view('admin/admin_footer');
    }

    function createEvent($type, $userid) {
        $t = $this->input->get('type');
        $res = $this->objcal->createEvent($type, $userid);
        if ($res) {
            $data['individual'] = $this->objcontact->getContactDetail();
            $data['template'] = $this->objsmstmplt->getTemplates();
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
        $group = $this->objgrp->getContactGroups("simple");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function allSMSList() {
        $group = $this->objgrp->getContactGroups("sms");
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
            $templates = $this->objsmstmplt->getTemplates();
        } else if ($type == "email") {
            $templates = $this->objemailtmplt->getTemplates();
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
        $data = $this->objcal->addEvent($post);
        if ($data) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function getEvents() {
        $post = $this->input->post();
        $this->objcal->getEvents($post);
    }

    function getCards() {
        $this->objcal->getCards();
    }

    function getEvent($eid) {
        $event = $this->objcal->getEvent($eid);
        echo json_encode($event);
    }

    function updateEvent() {
        $flag = $this->objcal->updateEvent();
        echo ($flag) ? 1 : 0;
    }

    function deleteEvent($eid) {
        $flag = $this->objcal->deleteEvent($eid);
        echo ($flag) ? 1 : 0;
    }

}
