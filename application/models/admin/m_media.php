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
class M_media extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->profileid = $this->session->userdata('profileid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getMediaDetail() {
        $query = $this->db->get('media_library');
        return $query->result();
    }

    function getMedia($mid) {
        $this->db->where('media_id', $mid);
        $query = $this->db->get('media_library');
        return $query->row();
    }

    function createMedia($set) {
        $this->db->insert('media_library', $set);
        $insertid = $this->db->insert_id();
        if (!empty($_FILES) && $_FILES['upload']['error'] == 0) {
            $msg = $this->uploadMedia($_FILES, $set, $insertid);
            if ($msg) {
                $data['path'] = $msg;
                $this->db->update('media_library', $data, array('media_id' => $insertid));
            }
        }
        return true;
    }

    function updateMedia($set) {
        $mediaid = $set['mediaid'];
        unset($set['mediaid']);

        if (!empty($_FILES) && $_FILES['upload']['error'] == 0) {
            $msg = $this->uploadMedia($_FILES, $set, $mediaid);
            if ($msg) {
                $set['path'] = $msg;
            }
        }
        $this->db->update('media_library', $set, array('media_id' => $mediaid));
        return "U";
    }

    function setAction($type) {
        switch ($type) {
            case "Delete":
                $ids = $this->input->post('media');
                if (is_array($ids) && count($ids) > 0) {
                    foreach ($ids as $value) {
                        $this->db->delete('media_library', array('media_id' => $value));
                    }
                    $msg = "D";
                } else {
                    $msg = FALSE;
                }
                break;
        }
        return $msg;
    }

    function uploadImage($file, $set, $mediaid) {

        $flag = TRUE;

        $valid_image = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $valid_video = array("3gp", "ivf", "swf", "mkv", "avi", "3gp2", "mpeg", "vob", "wmv", "mp4", "mpg", "flv", "mpeg4");
        $valid_audio = array("mp3");

        $ext = explode('/', $file['upload']['type']);

        switch ($set['type']) {
            case "audio":
                $flag = (in_array($ext[1], $valid_audio)) ? TRUE : FALSE;
                $fname = 'wish-fish/media/audio/audio_' . $mediaid . '.' . $ext[1];
                break;
            case "picture":
                $flag = (in_array($ext[1], $valid_image)) ? TRUE : FALSE;
                $fname = 'wish-fish/media/picture/image_' . $mediaid . '.' . $ext[1];
                break;
            case "video":
                $flag = (in_array($ext[1], $valid_video)) ? TRUE : FALSE;
                $fname = 'wish-fish/media/video/video_' . $mediaid . '.' . $ext[1];
                break;
        }

        if ($flag) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            if ($this->s3->putObjectFile($file['upload']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

}
