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

    private $mgClient, $listAddress, $domain;

//put your code here
    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->library('amazons3');

        require_once APPPATH . 'third_party/mailgun-php/vendor/autoload.php';
        $this->mgClient = new Mailgun('key-acfdb718a88968c616bcea83e1020909');
        $this->listAddress = 'wish-fish@mg.mikhailkuznetsov.com';
        $this->domain = 'mg.wish-fish.com';

        $this->bucket = "mikhailkuznetsov";
        $this->accessKey = "AKIAJWQAEAXONVCWQZKQ";
        $this->secretKey = "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";
    }

    function index() {
        $backup = & $this->dbutil->backup();

        //$path = 'd:/Work/www.wish-fish.com/wish-fish/assets/backup/' . 'wishfish_db_' . date('Y-m-d') . '.gz';
        $path = FCPATH . 'assets/backup/' . 'wishfish_db_' . date('Y-m-d') . '.gz';

        write_file($path, $backup);
        $this->uploadDB($path);

        $set = array(
            'from' => 'Wish-Fish <notification@wish-fish.com>',
            'to' => 'notifications@mikhailkuznetsov.com',
            'subject' => 'Wish-Fish Database Backup [' . date('Y-m-d') . ']',
            'html' => 'This is MVK Database Backup'
        );
        $attach = array('attachment' => array($path));

        $result = $this->mgClient->sendMessage($this->domain, $set, $attach);
        if ($result->http_response_code == 200) {
            echo "<h1>Mail Successfully Send..!</h1>";
        } else {
            echo "<h1>Failed To Send..!" . "</h1>";
        }

        //$this->load->library('email', $config);
        //$this->email->from("info@mikhailkuznetsov.com", "Mikhail");
        //$this->email->to('vishalsavaliya3@gmail.com');
        //$this->email->subject('Wish-Fish Database Backup Mail');
        //$this->email->message('This is Database Backup mail please keep this mail attachment file safe..');
        //$this->email->attach($path);
//        if ($this->email->send()) {
//            echo "<h1>Mail Successfully Send..!</h1>";
//        } else {
//            echo "<h1>Failed To Send..!" . "</h1>";
//        }
    }

    function uploadDB($path) {
        $this->s3->setAuth($this->accessKey, $this->secretKey);
        $fname = 'wishfish-db-backup/wishfish_db_' . date('Y-m-d') . '.gz';
        if ($this->s3->putObjectFile($path, $this->bucket, $fname, "public-read")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
