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

}
