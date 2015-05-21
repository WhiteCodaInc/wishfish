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
use Mailgun\Mailgun;

class Backup extends CI_Controller {

    private $profileid;
    private $bucket;
    private $accessKey;
    private $secretKey;
    private $mgClient, $listAddress, $domain;

//put your code here
    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->library('amazons3');

        $this->profileid = $this->session->userdata('profile_id');

        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));

        require_once APPPATH . 'third_party/mailgun-php/vendor/autoload.php';
        $this->mgClient = new Mailgun('key-acfdb718a88968c616bcea83e1020909');
        $this->listAddress = 'mikhail@mg.mikhailkuznetsov.com';
        $this->domain = 'mg.mikhailkuznetsov.com';
    }

    function index() {
        $backup = & $this->dbutil->backup();
        //$path = 'd:/Work/www.mikhailkuznetsov.com/back-end/assets/backup/' . 'mikhail_db_' . date('Y-m-d') . '.gz';
        $path = FCPATH . 'assets/backup/' . 'mikhail_db_' . date('Y-m-d') . '.gz';

        write_file($path, $backup);
        $this->uploadDB($path);

        $set = array(
            'from' => 'Mikhail <notification@mikhailkuznetsov.com>',
            'to' => 'notifications@mikhailkuznetsov.com',
            'subject' => 'MVK Database Backup [' . date('Y-m-d') . ']',
            'html' => 'This is Wish-Fish Database Backup'
        );
        $attach = array('attachment' => array($path));

        $result = $this->mgClient->sendMessage($this->domain, $set, $attach);
        if ($result->http_response_code == 200) {
            echo "<h1>Mail Successfully Send..!</h1>";
        } else {
            echo "<h1>Failed To Send..!" . "</h1>";
        }

//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => "ssl://smtp.googlemail.com",
//            'smtp_port' => "465",
//            'mailtype' => "html",
//            'smtp_timeout' => "180",
//            'smtp_user' => "vishaltesting7@gmail.com", // change it to yours
//            'smtp_pass' => "vishal789" // change it to yours
//        );
//        $this->load->library('email', $config);
//        $this->email->from("info@mikhailkuznetsov.com", "Mikhail");
//        $this->email->to('vishalsavaliya3@gmail.com');
//        $this->email->subject('Mikhail Database Backup Mail');
//        $this->email->message('This is Database Backup mail please keep this mail attachment file safe..');
//        $this->email->attach($path);
//        if ($this->email->send()) {
//            echo "<h1>Mail Successfully Send..!</h1>";
//        } else {
//            echo "<h1>Failed To Send..!" . "</h1>";
//        } 
    }

    function uploadDB($path) {
        $this->s3->setAuth($this->accessKey, $this->secretKey);
        $fname = 'mikhail-db-backup/mikhail_db_' . date('Y-m-d') . '.gz';
        if ($this->s3->putObjectFile($path, $this->bucket, $fname, "public-read")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
