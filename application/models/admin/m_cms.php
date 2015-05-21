<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_admin_login
 *
 * @author Laxmisoft
 */
class M_cms extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->load->library('common');
        $this->profileid = $this->session->userdata('profile_id');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getBlogDetail() {
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('blogs');
        return $query->result();
    }

    function updateOrder($set) {
        $data = array();
        foreach ($set['blogid'] as $key => $value) {
            $data[] = array(
                'blog_id' => $value,
                'order' => ++$key
            );
        }
        $this->db->update_batch('blogs', $data, 'blog_id');
    }

    function getBlog($bid) {
        $this->db->where('blog_id', $bid);
        $query = $this->db->get('blogs');
        return $query->row();
    }

    function createBlog($set) {
        $msg = "";
        $set['status'] = ($set['submit'] == "publish") ? 1 : 0;
        unset($set['submit']);
        $this->db->insert('blogs', $set);
        $insertid = $this->db->insert_id();
        if (isset($_FILES['feature_img']) || isset($_FILES['feature_video'])) {
            if ($_FILES['feature_img']['error'] == 0 || $_FILES['feature_video']['error'] == 0) {
                if ($_FILES['feature_img']['error'] == 0) {
                    $msg = $this->uploadImage($_FILES, $insertid);
                    if ($msg != "UF" && $msg != "IF") {
                        $data['feature_img'] = $msg;
                        $msg = "I";
                    }
                }
                if ($_FILES['feature_video']['error'] == 0) {
                    $msg = $this->uploadVideo($_FILES, $insertid);
                    if ($msg != "UF" && $msg != "IF") {
                        $data['feature_video'] = $msg;
                        $msg = "I";
                    }
                }
                $this->db->update('blogs', $data, array('blog_id' => $insertid));
            }
        } else {
            $msg = "I";
        }
        ($set['status'] == 1) ? $this->sendEmail($set) : "";
        return "I";
    }

    function updateBlog($set) {
        $set['status'] = ($set['submit'] == "draft") ? 0 : 1;
        unset($set['submit']);
        $blogid = $set['blogid'];
        unset($set['blogid']);

        if (isset($_FILES['feature_img']) || isset($_FILES['feature_video'])) {
            if ($_FILES['feature_img']['error'] == 0 || $_FILES['feature_video']['error'] == 0) {
                if ($_FILES['feature_img']['error'] == 0) {
                    $msg = $this->uploadImage($_FILES, $blogid);
                    if ($msg != "UF" && $msg != "IF") {
                        $set['feature_img'] = $msg;
                    }
                }
                if ($_FILES['feature_video']['error'] == 0) {
                    $msg = $this->uploadVideo($_FILES, $blogid);
                    if ($msg != "UF" && $msg != "IF") {
                        $set['feature_video'] = $msg;
                    }
                }
            }
        }
        $this->db->update('blogs', $set, array('blog_id' => $blogid));
        return "U";
    }

    function setAction($type) {
        $msg = "";
        switch ($type) {
            case "Default":
                $id = $this->input->post('default');
                if (isset($id) && $id != NULL) {
                    $this->db->update('blogs', array('default_post' => 0), array('blog_id !=' => $id));
                    $this->db->update('blogs', array('default_post' => 1), array('blog_id' => $id));
                    $msg = "SD";
                } else {
                    $msg = FALSE;
                }
                break;
            case "Delete":
                $ids = $this->input->post('blog');
                if (is_array($ids) && count($ids) > 0) {
                    foreach ($ids as $value) {
                        $this->db->delete('blogs', array('blog_id' => $value));
                    }
                    $msg = "D";
                } else {
                    $msg = FALSE;
                }
                break;
            case "Publish":
                $ids = $this->input->post('blog');
                if (is_array($ids) && count($ids) > 0) {
                    $this->db->where_in('blog_id', $ids);
                    $this->db->update('blogs', array('status' => 1));
                    $msg = "P";
                } else {
                    $msg = FALSE;
                }
                break;
            case "Draft":
                $ids = $this->input->post('blog');
                if (is_array($ids) && count($ids) > 0) {
                    $this->db->where_in('blog_id', $ids);
                    $this->db->update('blogs', array('status' => 0));
                    $msg = "DR";
                } else {
                    $msg = FALSE;
                }
                break;
        }
        return $msg;
    }

    function uploadImage($file, $blogid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['feature_img']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'blog/blog_img_' . $blogid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['feature_img']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function uploadVideo($file, $blogid) {
        $valid_formats = array("mp4", "flv");
        $ext = explode('/', $file['feature_video']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'video/video_' . $blogid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['feature_video']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function sendEmail($set) {
        $query = $this->db->get('subscriber');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $value) {
                $this->common->sendMail($value->email, "New Blog :" . $set['title'], $set['content']);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //----------------------------Blog Category-------------------------------//
    function getBlogCategoryDetail() {
        $query = $this->db->get('blog_categories');
        return $query->result();
    }

    function getBlogCategory($cid) {
        $this->db->where('category_id', $cid);
        $query = $this->db->get('blog_categories');
        return $query->row();
    }

    function createBlogCategory($set) {
        $this->db->insert('blog_categories', $set);
        return TRUE;
    }

    function updateBlogCategory($set) {
        $cid = $set['categoryid'];
        unset($set['categoryid']);
        $this->db->update('blog_categories', $set, array('category_id' => $cid));
        return TRUE;
    }

    function delete() {
        $ids = $this->input->post('category');
        foreach ($ids as $value) {
            $this->db->delete('blog_categories', array('category_id' => $value));
        }
    }

    //---------------------------------About Us-------------------------------//

    function isExistAboutus() {
        $query = $this->db->get('aboutus');
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    function getAboutusContent() {
        $query = $this->db->get('aboutus');
        return $query->row();
    }

    function addAboutus($set) {
        $this->db->insert('aboutus', $set);
        return TRUE;
    }

    function updateAboutus($set) {
        $aboutusid = $set['aboutusid'];
        unset($set['aboutusid']);
        $this->db->update('aboutus', $set, array('aboutus_id' => $aboutusid));
        return TRUE;
    }

    //--------------------Upload Video----------------------------------------//

    /* function getVideos() {
      $query = $this->db->get('video');
      return $query->result();
      }

      function deleteVideo() {

      $ids = $this->input->post('video');
      foreach ($ids as $value) {
      $this->db->delete('video', array('video_id' => $value));
      }
      }

      function upload($set) {
      if (isset($_FILES['video_url'])) {
      if ($_FILES['video_url']['error'] == 0) {
      $msg = $this->uploadVideo($_FILES, $set);
      return $msg;
      } else {
      return "UF";
      }
      } else {
      return "UF";
      }
      }

      function getShortcode() {
      $query = $this->db->get_where('video');
      return $query->result();
      } */
}
