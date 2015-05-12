<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->library('encryption');

        $bucket = "mikhailkuznetsov";
        $access = "AKIAJTSSWQFVK3YRSDNQ";
        $secret = "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";

        echo '-------------Original--------------<br>';

        echo $bucket . '<br>';
        echo $access . '<br>';
        echo $secret . '<br>';

        echo '-------------Encryption--------------<br>';

        echo 'BUCKET : ' . $this->encryption->encode($bucket) . '<br>';
        echo 'ACCESS KEY : ' . $this->encryption->encode($access) . '<br>';
        echo 'SECRET KEY : ' . $this->encryption->encode($secret) . '<br>';

        echo '-------------Decryption--------------<br>';

        echo 'BUCKET : ' . $this->encryption->decode("ShLvoZAkeBrawkThnA-akEfhitL4Vcgr-oBnwAn-bUU") . '<br>';
        echo 'ACCESS KEY : ' . $this->encryption->decode("kjruBRpR5XOSbsqgGLeRMJwFasiaIUrZsNaqjc_LLic") . '<br>';
        echo 'SECRET KEY : ' . $this->encryption->decode("jN86kD3vVS_wSPV0HOpfkr8UtTIQ2BbdX85scQqywnG82fMIY9aPlxHtsFTvUJiSzD3IjjSg2F6Re_ZUbiUJmg") . '<br>';

        //$this->load->view('welcome_message');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */