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
        echo '<pre>';
        print_r($_FILES);

        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        print_r($config);
        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            echo 'ERROR..!<br>';
            print_r($this->upload->display_errors());
        } else {
            echo 'SUCCESS..!<br>';
            $file_data = $this->upload->data();
            print_r($file_data);
            $file_path = FCPATH . 'uploads/' . $file_data['file_name'];
            echo $file_path . '<br>';

            $contacts = array();

            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $key => $row) {
                    $insert_data = array(
                        'name' => $row['firstname'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                    );
                    $contacts[] = $insert_data;
//                    print_r($insert_data);
                }
                $data['contacts'] = $contacts;
                unlink($file_path);
                $this->load->view('dashboard/csv-contacts', $data);
                echo '<br>Csv Data Imported Succesfully<br>';
            } else
                echo "Error occured";
        }
    }

}
