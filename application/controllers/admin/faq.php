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
        $this->load->model('admin/m_faq', 'objfaq');
    }

    function index() {
        $this->load->view('faq-header');
        $this->load->view('faq-home');
        $this->load->view('faq-footer');
    }

    function getSearchTerm() {
        $this->objfaq->getSearchTerm();
    }

    function search() {
        $queid = $this->input->get('id');
        $res = $this->objfaq->search($queid);
        $data['categories'] = $this->objfaq->getFaqCategoryDetail();
        if ($res) {
            $data['question'] = $res;
            $data['isSearch'] = TRUE;
        } else {
            $data['isSearch'] = FALSE;
        }
        $this->load->view('faq-header');
        $this->load->view('faq-accordion', $data);
        $this->load->view('faq-footer');
    }

    //-----------------faq-accordion------------------------------------//

    function questions() {
        $data['que'] = $this->objfaq->getAllQuestions();
        $data['categories'] = $this->objfaq->getFaqCategoryDetail();
        $res = $this->objfaq->getFirst();
        if ($res) {
            $data['category'] = $res['category'];
            $data['questions'] = $res['questions'];
            $data['isFirst'] = TRUE;
        } else {
            $data['isFirst'] = FALSE;
        }
        $this->load->view('faq-header');
        $this->load->view('faq-accordion', $data);
        $this->load->view('faq-footer');
    }

    function getQuestions($catid) {
        $data['isFirst'] = TRUE;
        $data['category'] = $this->objfaq->getFaqCategory($catid);
        $data['questions'] = $this->objfaq->getQuestions($catid);
        $data['categories'] = $this->objfaq->getFaqCategoryDetail();
        $this->load->view('faq-header');
        $this->load->view('faq-accordion', $data);
        $this->load->view('faq-footer');
    }

    function faqs() {
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
        header('location:' . site_url() . 'faq/faqs?msg=' . $msg);
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
        header('location:' . site_url() . 'faq/faqs?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $msg = $this->objfaq->setAction();
            if ($msg) {
                header('location:' . site_url() . 'faq/faqs?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'faq/faqs');
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
        header('location:' . site_url() . 'faq/faqCategory?msg=I');
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
        header('location:' . site_url() . 'faq/faqCategory?msg=U');
    }

    function delete() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Order") {
            $msg = $this->objfaq->delete($type);
            header('location:' . site_url() . 'faq/faqCategory?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'faq/faqCategory');
        }
    }

}
