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
        $this->load->library("common");
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } else {
            $this->load->model('dashboard/m_contacts', 'objcontact');
            $this->load->model('dashboard/m_contact_groups', 'objgroup');
            $this->load->model('dashboard/m_sms_template', 'objsmstemplate');
            $this->load->model('dashboard/m_email_template', 'objemailtemplate');
            $this->load->model('dashboard/m_calender', 'objcalender');
        }
    }

    function index() {
        $data['template'] = $this->objsmstemplate->getTemplates();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/calender', $data);
        $this->load->view('dashboard/footer');
    }

    function createEvent($contactid) {
        $t = $this->input->get('type');
        $res = $this->objcalender->createEvent($contactid);
        if ($res) {
            $data['individual'] = $this->objcontact->getContactDetail();
            $data['template'] = $this->objsmstemplate->getTemplates();
            $data['contactInfo'] = $res;
        } else {
            $data['contactInfo'] = FALSE;
        }
        $data['flag'] = ($t == "bday") ? TRUE : FALSE;
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/calender', $data);
        $this->load->view('dashboard/footer');
    }

    function allGroup() {
        $group = $this->objgroup->getContactGroups("simple");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function allContacts($type) {
        $ids = $user = array();
        $individual = $this->objcontact->getContactDetail();
        foreach ($individual as $key => $value) {
            $res = $this->objcalender->checkTotalEvent($value->contact_id);
            switch ($type) {
                case "email":
                    if (!isset($res['email']) || (isset($res['email']) && $res['email'] < 4)) {
                        $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->email;
                        $ids[$key] = $value->contact_id;
                    }
                    break;
                case "sms":
                    if (!isset($res['sms']) || (isset($res['sms']) && $res['sms'] < 4)) {
                        $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->phone;
                        $ids[$key] = $value->contact_id;
                    }
                    break;
                default:
                    $adds = ($type == "email") ? $value->email : $value->phone;
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $adds;
                    $ids[$key] = $value->contact_id;
                    break;
            }
        }
        $data['user'] = $user;
        $data['ids'] = $ids;
        echo json_encode($data);
    }

    function getTemplate($type, $tmpid) {
        if ($type == "sms" || $type == "notification") {
            $this->objcalender->getSMSTemplate($tmpid);
        } else if ($type == "email") {
            $this->objcalender->getEmailTemplate($tmpid);
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
        $post = $this->input->post();
        $this->objcalender->getCards($post);
    }

    function getEvent($eid) {
        $event = $this->objcalender->getEvent($eid);
        echo json_encode($event);
    }

    function updateEvent() {
        $set = $this->input->post();
        if (is_array($set)) {
            $msg = $this->objcalender->updateEvent($set);
            switch ($msg) {
                case "U":
                    echo 1;
                    break;
                case "UF":
                    echo 0;
                    break;
                case "NA":
                    $title = ($set['event_type'] == "sms") ? "SMS" : "Email";
                    echo "You have already reach your {$title} event  limit..!\nYou can not add more..!";
                    break;
            }
        } else {
            header('location' . site_url() . 'app/calender');
        }
    }

    function deleteEvent($eid) {
        $flag = $this->objcalender->deleteEvent($eid);
        echo ($flag) ? 1 : 0;
    }

}
