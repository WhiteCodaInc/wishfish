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
class Cms extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library('parser');
        $this->load->library('common');

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->cms) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_cms', 'objcms');
        }
    }

    function index() {
        $data['blogs'] = $this->objcms->getBlogDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/blogs', $data);
        $this->load->view('admin/admin_footer');
    }

    function addBlog() {
        $data['category'] = $this->objcms->getBlogCategoryDetail();
//        $data['shortcode'] = $this->objcms->getShortcode();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-blog', $data);
        $this->load->view('admin/admin_footer');
    }

    function createBlog() {
        $post = $this->input->post();
        $msg = $this->objcms->createBlog($post);
        header('location:' . site_url() . 'admin/cms?msg=' . $msg);
    }

    function editBlog($bid) {
        $data['category'] = $this->objcms->getBlogCategoryDetail();
        $data['blogs'] = $this->objcms->getBlog($bid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-blog', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateBlog() {
        $post = $this->input->post();
        $msg = $this->objcms->updateBlog($post);
        header('location:' . site_url() . 'admin/cms?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Default" || $type == "Publish" || $type == "Draft") {
            $msg = $this->objcms->setAction($type);
            if ($msg) {
                header('location:' . site_url() . 'admin/cms?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/cms');
            }
        }
    }

    function getBlog() {
        $bid = $this->input->post('blogid');
        $data['blog'] = $this->objcms->getBlog($bid);
        $this->load->view('admin/blog-preview', $data);
    }

    function updateOrder() {
        $post = $this->input->post();
        $this->objcms->updateOrder($post);
    }

    //-----------------------Blog Category Functionality----------------------//

    function blogcategory() {
        $data['category'] = $this->objcms->getBlogCategoryDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/blog-category', $data);
        $this->load->view('admin/admin_footer');
    }

    function addCategory() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-blog-category');
        $this->load->view('admin/admin_footer');
    }

    function createCategory() {
        $post = $this->input->post();
        $this->objcms->createBlogCategory($post);
        header('location:' . site_url() . 'admin/cms/blogcategory?msg=I');
    }

    function editCategory($cid) {
        $data['category'] = $this->objcms->getBlogCategory($cid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-blog-category', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCategory() {
        $post = $this->input->post();
        $this->objcms->updateBlogCategory($post);
        header('location:' . site_url() . 'admin/cms/blogcategory?msg=U');
    }

    function delete() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objcms->delete();
        }
        header('location:' . site_url() . 'admin/cms/blogcategory?msg=D');
    }

    //------------------------About Us----------------------------------------//

    function aboutus() {
        $data['flag'] = $this->objcms->isExistAboutus();
        if ($data['flag']) {
            $data['aboutus'] = $this->objcms->getAboutusContent();
        }
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/aboutus', $data);
        $this->load->view('admin/admin_footer');
    }

    function addAboutus() {
        $post = $this->input->post();
        $this->objcms->addAboutus($post);
        header('location:' . site_url() . 'admin/cms/aboutus?msg=I');
    }

    function updateAboutus() {
        $post = $this->input->post();
        $this->objcms->updateAboutus($post);
        header('location:' . site_url() . 'admin/cms/aboutus?msg=U');
    }

    //--------------------------Upload Video----------------------------------//
    function video() {
        $data['video'] = $this->objcms->getVideos();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/video', $data);
        $this->load->view('admin/admin_footer');
    }

    function upload_video() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/upload-video');
        $this->load->view('admin/admin_footer');
    }

    function upload() {
        $post = $this->input->post();
        $this->objcms->upload($post);
        header('location:' . site_url() . 'admin/cms/video?msg=I');
    }

    function deleteVideo() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objcms->deleteVideo();
        }
        header('location:' . site_url() . 'admin/cms/video?msg=D');
    }

}
