<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Laxmisoft
 */
class Pages extends CI_Controller {

    function __construct() {
        parent::__construct();
		
		
		
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->load->model('admin/m_pages', 'objpage');
        }
    }

    function index() {
        $data['pages'] = $this->objpage->getPages();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/pages', $data);
        $this->load->view('admin/admin_footer');
    }

    function getContent() {
        $pageid = $this->input->post('pageid');
		$res = $this->objpage->getContent($pageid);
        if($res){
			echo $res->content;
		}else{
			echo 0;
		}
    }

    function update() {
		//ini_set('memory_limit', '96M');
		//ini_set('post_max_size', '64M');
		//ini_set('upload_max_filesize', '64M');
		//ini_set('display_errors', 'true');
        $post = $this->input->post();
		//echo '<pre>';
		//echo "LENGTH : ".strlen($post['content']).'<br>';
		//print_r($post);
		//die();
        $this->objpage->update($post);
        header('location:' . site_url() . 'admin/pages?id=' . $post['pageid']);
    }

}
