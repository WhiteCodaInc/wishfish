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
class Faq extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->load->model('admin/m_faq', 'objfaq');
        }
    }

    function index() {
        $data['faqs'] = $this->objfaq->getFaqDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/faqs', $data);
        $this->load->view('admin/admin_footer');
    }

    function addFaq() {
        $data['category'] = $this->objfaq->getFaqCategoryDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-faq', $data);
        $this->load->view('admin/admin_footer');
    }

    function createFaq() {
        $post = $this->input->post();
        $msg = $this->objfaq->createFaq($post);
        header('location:' . site_url() . 'admin/faq?msg=' . $msg);
    }

    function editFaq($fid) {
        $data['category'] = $this->objfaq->getFaqCategoryDetail();
        $data['faqs'] = $this->objfaq->getFaq($fid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-faq', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateFaq() {
        $post = $this->input->post();
        $msg = $this->objfaq->updateFaq($post);
        header('location:' . site_url() . 'admin/faq?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $msg = $this->objfaq->setAction();
            if ($msg) {
                header('location:' . site_url() . 'admin/faq?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/faq');
            }
        }
    }

    //-----------------------Faq Category Functionality----------------------//

    function faqCategory() {
        $data['category'] = $this->objfaq->getFaqCategoryDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/faq-category', $data);
        $this->load->view('admin/admin_footer');
    }

    function addFaqCategory() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-faq-category');
        $this->load->view('admin/admin_footer');
    }

    function createFaqCategory() {
        $post = $this->input->post();
        $this->objfaq->createFaqCategory($post);
        header('location:' . site_url() . 'admin/faq/faqCategory?msg=I');
    }

    function editFaqCategory($cid) {
        $data['category'] = $this->objfaq->getFaqCategory($cid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-faq-category', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateFaqCategory() {
        $post = $this->input->post();
        $this->objfaq->updateFaqCategory($post);
        header('location:' . site_url() . 'admin/faq/faqCategory?msg=U');
    }

    function delete() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Order") {
            $msg = $this->objfaq->delete($type);
            header('location:' . site_url() . 'admin/faq/faqCategory?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/faq/faqCategory');
        }
    }

}
