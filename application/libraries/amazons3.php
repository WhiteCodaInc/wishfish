<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of amazon_s3
 *
 * @author Laxmisoft
 */
class Amazons3 {

//put your code here

    public function __construct() {

        require_once APPPATH . 'third_party/S3.php';
        $s3 = new S3();
        $CI = & get_instance();
        $CI->s3 = $s3;
    }

}
