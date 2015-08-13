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

    function __construct() {
        parent::__construct();
        $this->load->library('csvimport');
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
                    $insert_data = array(
                        'name' => $row['firstname'],
                        'phone' => $row['phone'],
                        'email' => $row['email']
                    );
                    $contacts[] = $insert_data;
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
    }

}
