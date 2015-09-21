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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->faqi && !$this->p->faqu && !$this->p->faqd || !$this->p->faqci && !$this->p->faqcu && !$this->p->faqcd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_faq', 'objfaq');
        }
    }

    function index() {
        if ($this->p->faqi || $this->p->faqu || $this->p->faqd) {
            $data['faqs'] = $this->objfaq->getFaqDetail();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/faqs', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addFaq() {
        if ($this->p->faqi) {
            $data['category'] = $this->objfaq->getFaqCategoryDetail();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-faq', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createFaq() {
        if ($this->p->faqi) {
            $post = $this->input->post();
            $msg = $this->objfaq->createFaq($post);
            header('location:' . site_url() . 'admin/faq?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editFaq($fid) {
        if ($this->p->faqu) {
            $data['category'] = $this->objfaq->getFaqCategoryDetail();
            $data['faqs'] = $this->objfaq->getFaq($fid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-faq', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateFaq() {
        if ($this->p->faqu) {
            $post = $this->input->post();
            $msg = $this->objfaq->updateFaq($post);
            header('location:' . site_url() . 'admin/faq?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->faqd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $msg = $this->objfaq->setAction();
                if ($msg) {
                    header('location:' . site_url() . 'admin/faq?msg=' . $msg);
                } else {
                    header('location:' . site_url() . 'admin/faq');
                }
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    //-----------------------Faq Category Functionality----------------------//

    function faqCategory() {
        if ($this->p->faqci || $this->p->faqcu || $this->p->faqcd) {
            $data['category'] = $this->objfaq->getFaqCategoryDetail();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/faq-category', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addFaqCategory() {
        if ($this->p->faqci) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-faq-category');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createFaqCategory() {
        if ($this->p->faqci) {
            $post = $this->input->post();
            $this->objfaq->createFaqCategory($post);
            header('location:' . site_url() . 'admin/faq/faqCategory?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editFaqCategory($cid) {
        if ($this->p->faqcu) {
            $data['category'] = $this->objfaq->getFaqCategory($cid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-faq-category', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateFaqCategory() {
        if ($this->p->faqcu) {
            $post = $this->input->post();
            $this->objfaq->updateFaqCategory($post);
            header('location:' . site_url() . 'admin/faq/faqCategory?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function delete() {
        if ($this->p->faqcu || $this->p->faqcd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete" || $type == "Order") {
                $msg = $this->objfaq->delete($type);
                header('location:' . site_url() . 'admin/faq/faqCategory?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/faq/faqCategory');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
