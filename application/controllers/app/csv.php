<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_profile
 *
 * @author Laxmisoft
 */
class Csv extends CI_Controller {

    private $userid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('csvimport');
        $this->load->library('amazons3');
        $this->userid = $this->session->userdata('u_userid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));

        if (!$this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } elseif (!$this->wi_authex->isActivePlan()) {
            header('location:' . site_url() . 'app/upgrade');
        } else {
            $this->load->model('dashboard/m_csv', 'csv');
        }
    }

    function index() {
        $data['contacts'] = array();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/csv', $data);
        $this->load->view('dashboard/footer');
    }

    function importcsv() {
        if (!empty($_FILES)) {
            $error = "";
            $config['upload_path'] = FCPATH . 'uploads/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '1000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload')) {
                $error = $this->upload->display_errors();
            } else {
                $file_data = $this->upload->data();
                $file_path = FCPATH . 'uploads/' . $file_data['file_name'];

                $contacts = array();

                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);

                    foreach ($csv_array as $row) {

                        $set = array(
                            'fname' => ($row['first_name'] != "") ? $row['first_name'] : "",
                            'lname' => ($row['last_name'] != "") ? $row['last_name'] : "",
                            'phone' => ($row['phone'] != "") ? $row['phone'] : "",
                            'email' => ($row['email'] != "") ? $row['email'] : "",
                            'birthday' => ($row['birthdate'] != "") ? $row['birthdate'] : "",
                            'contact_avatar' => ($row['profile_pic_url'] != "") ? $row['profile_pic_url'] : "",
                        );
                        $contacts[] = $set;
                    }
                    $data['contacts'] = $contacts;
                    unlink($file_path);
                } else {
                    $error = "Error occur during importing contact..! Try Again..!";
                    $data['contacts'] = $contacts;
                }
            }
            $this->session->set_flashdata('error', $error);
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');
            $this->load->view('dashboard/csv', $data);
            $this->load->view('dashboard/footer');
        } else {
            header('location:' . site_url() . 'app/csv');
        }
    }

    function addContacts() {
        $post = $this->input->post();
        
        if (isset($post['contact']) && count($post['contact']) > 0) {
            foreach ($post['contact'] as $value) {
                $set = array(
                    'user_id' => $this->userid,
                    'fname' => ($post['fname'][$value] != "") ? $post['fname'][$value] : NULL,
                    'lname' => ($post['lname'][$value] != "") ? $post['lname'][$value] : NULL,
                    'phone' => ($post['phone'][$value] != "") ? $post['phone'][$value] : NULL,
                    'email' => ($post['email'][$value] != "") ? $post['email'][$value] : NULL,
                );

                $set['birthday'] = ($set['birthday'] != "") ?
                        $this->wi_common->getMySqlDate($set['birthday'], "mm-dd-yyyy") :
                        NULL;

                $this->db->insert('wi_contact_detail', $set);
                $insertid = $this->db->insert_id();

                if ($post['contact_avatar'][$value] != "") {
                    $img_url = FCPATH . "import/user.jpg";
                    copy($post['contact_avatar'][$value], $img_url);
                    $fname = 'wish-fish/contacts/contact_avatar_' . $insertid . '.jpg';
                    $this->s3->setAuth($this->accessKey, $this->secretKey);
                    if ($this->s3->putObjectFile($img_url, $this->bucket, $fname, "public-read")) {
                        $this->db->update('wi_contact_detail', array('contact_avatar' => $fname), array('contact_id' => $insertid));
                    }
                    unlink($img_url);
                }

                if ($set['birthday'] != NULL) {
                    $event_data = array(
                        'user_id' => $this->userid,
                        'is_birthday' => 1,
                        'event' => 'Birthday : ' . $set['fname'],
                        'event_type' => "notification",
                        'group_type' => "individual",
                        'contact_id' => $insertid,
                        'color' => "#BDBDBD",
                        'notification' => "0",
                        'notify' => "them",
                        'date' => $this->getFutureDate($set['birthday'])
                    );
                    $this->db->insert('wi_schedule', $event_data);
                }
            }
            header('location:' . site_url() . 'app/contacts');
        } else {
            header('location:' . site_url() . 'app/csv');
        }
    }

}
