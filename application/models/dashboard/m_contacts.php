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
class M_contacts extends CI_Model {

    private $userid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->userid = $this->session->userdata('userid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getContactDetail() {
        $this->db->order_by('fname', 'asc');
        $query = $this->db->get_where('wi_contact_detail', array('user_id' => $this->userid));
        return $query->result();
    }

    function searchResult() {
        $post = $this->input->post();
        $fname = $post['fname_search'];
        $lname = $post['lname_search'];
        $email = $post['email_search'];
        $age = $post['age_search'];
        $from = $post['from_search'];
        $to = $post['to_search'];
        $group = $post['group_search'];
        $zodiac = $post['zodiac_search'];
        $country = $post['country_search'];
        $city = $post['city_search'];
        $address = $post['address_search'];
        $rating = $post['rating_search'];

        ($fname != "") ? $this->db->like('fname', $fname) : '';
        ($lname != "") ? $this->db->like('lname', $lname) : '';
        ($email != "") ? $this->db->like('email', $email) : '';
        ($age != "") ? $where['age'] = $age : '';
        ($from != "") ?
                        $where['birthday >='] = $this->common->getMySqlDate($from, $this->session->userdata('date_format')) :
                        '';
        ($to != "") ?
                        $where['birthday <='] = $this->common->getMySqlDate($to, $this->session->userdata('date_format')) :
                        '';
        ($zodiac != "" && $zodiac != "-1") ? $where['zodiac'] = $zodiac : '';
        ($country != "") ? $this->db->like('country', $country) : '';
        ($city != "") ? $this->db->like('city', $city) : '';
        ($address != "") ? $this->db->like('address', $address) : '';
        ($rating != "" && $rating != "-1") ? $where['rating'] = $rating : '';
        ($group != "" && $group != "-1") ? $where['group_id'] = $group : '';

        $this->db->where('user_id', $this->userid);

        $this->db->select('*');
        $this->db->from('contact_detail as C');
        $this->db->join('multiple_contact_group as M', 'C.contact_Id = M.contact_id', 'left outer');
        $this->db->group_by('C.contact_id');
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';

        $query = $this->db->get();
        return $query->result();
    }

    function getContactInfo($cid) {
        $where = array(
            'contact_id' => $cid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('wi_contact_detail', $where);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    function getContact($cid, $type) {
        $res = array();
        $where = array(
            'contact_id' => $cid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('wi_contact_detail', $where);
        if ($query->num_rows() > 0) {
            $res[] = $query->row();
            $this->db->select('C.group_id');
            $this->db->from('contact_groups as C');
            $this->db->join('multiple_contact_group as MC', 'C.group_id = MC.group_id');
            $this->db->where('contact_id', $cid);
            $this->db->where('type', $type);
            $query = $this->db->get();
            $cgroup = array();
            foreach ($query->result() as $value) {
                $cgroup[] = $value->group_id;
            }
            $res[] = $cgroup;
            return $res;
        } else {
            return FALSE;
        }
    }

    function createContact($set) {
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->common->getMySqlDate($set['birthday'], $this->session->userdata('date_format')) :
                NULL;
        $set['user_id'] = $this->userid;
        unset($set['code']);
        $this->db->insert('wi_contact_detail', $set);
        $insertid = $this->db->insert_id();

        $event_data = array(
            'user_id' => $this->userid,
            'is_birthday' => 1,
            'event' => 'Birthday : ' . $set['fname'],
            'event_type' => "notification",
            'group_type' => "individual",
            'contact_id' => $insertid,
            'color' => "#BDBDBD",
            'notification' => "0",
            'notify' => "them",
            'date' => $this->getFutureDate($set['birthday'])
        );
        $this->db->insert('wi_schedule', $event_data);
        $m = "I";
        if (isset($_FILES['contact_avatar'])) {
            if ($_FILES['contact_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $insertid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['contact_avatar'] = $msg;
                        $this->db->update('wi_contact_detail', $set, array('contact_id' => $insertid));
                        $m = "I";
                        break;
                }
            }
        }
        return $m;
    }

    function updateContact($set) {
        $m = "";
        $cid = $set['contactid'];
//        $set['phone'] = str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']);
//        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;

        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->common->getMySqlDate($set['birthday'], $this->session->userdata('date_format')) :
                NULL;

        if (isset($set['group_id'])) {
            $group = $set['group_id'];
            unset($set['group_id']);
        }
        unset($set['contactid']);
        unset($set['code']);

        $data = array();
        if (isset($group)) {
            foreach ($group as $value) {
                $data[] = array(
                    'contact_id' => $cid,
                    'group_id' => $value
                );
            }
        }
        if (isset($_FILES['contact_avatar'])) {
            if ($_FILES['contact_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $cid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['contact_avatar'] = $msg;
                        $m = "U";
                        break;
                }
            }
        }

        $this->db->trans_start();
        if (!$this->isBirthdaySchedule($cid, $set)) {
            $event_data = array(
                'user_id' => $this->userid,
                'is_birthday' => 1,
                'event' => 'Birthday : ' . $set['fname'],
                'event_type' => "notification",
                'group_type' => "individual",
                'contact_id' => $cid,
                'color' => "#BDBDBD",
                'notification' => "0",
                'notify' => "them",
                'date' => $this->getFutureDate($set['birthday'])
            );
            $this->db->insert('wi_schedule', $event_data);
        }
        $m = "U";
        $this->db->update('wi_contact_detail', $set, array('contact_id' => $cid));
        //--------------Delete Existing Group---------------------------------//
        $this->db->select('M.id');
        $this->db->from('multiple_contact_group as M');
        $this->db->join('contact_groups as CG', 'M.group_id = CG.group_id');
        $this->db->join('contact_detail as C', 'M.contact_id = C.contact_id');
        $this->db->where('CG.type', "simple");
        $this->db->where('M.contact_id', $cid);
        $query = $this->db->get();
        $res = $query->result();
        $ids = array();
        foreach ($res as $value) {
            $ids[] = $value->id;
        }
        if (count($ids) > 0) {
            $this->db->where_in('id', $ids, TRUE);
            $this->db->delete('wi_multiple_contact_group');
        }
        //-------------------------Insert New Assign Group--------------------//
        (count($data) > 0) ? $this->db->insert_batch('wi_multiple_contact_group', $data) : '';
        $this->db->trans_complete();
        return $m;
    }

    function uploadImage($file, $cid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['contact_avatar']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/contacts/contact_avatar_' . $cid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['contact_avatar']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function setAction() {

        $ids = $this->input->post('contact');
        foreach ($ids as $value) {
            $this->db->delete('wi_contact_detail', array('contact_id' => $value));
        }
    }

    function createList($post) {
        $set = array();
        $data['group_name'] = $post['group_name'];
        $data['type'] = $post['type'];
        $data['user_id'] = $this->userid;
        $ids = (isset($post['contact_id'])) ? $post['contact_id'] : array();

        $this->db->trans_start();
        $this->db->insert('wi_contact_groups', $data);
        $insertid = $this->db->insert_id();

        if (count($ids) > 0) {
            foreach ($ids as $value) {
                $set[] = array(
                    'contact_id' => $value,
                    'group_id' => $insertid
                );
            }
            $this->db->insert_batch('wi_multiple_contact_group', $set);
        }
        $this->db->trans_complete();
        return TRUE;
    }

    function updateList($set) {

        $gid = $set['groupid'];
        unset($set['groupid']);
        $data = array();
        if (isset($set['contact_id'])) {
            foreach ($set['contact_id'] as $value) {
                $data[] = array(
                    'group_id' => $gid,
                    'contact_id' => $value
                );
            }
            unset($set['contact_id']);
        }
        $this->db->trans_start();
        $this->db->update('wi_contact_groups', $set, array('group_id' => $gid));
        $this->db->delete('wi_multiple_contact_group', array('group_id' => $gid));
        (count($data) > 0) ? $this->db->insert_batch('wi_multiple_contact_group', $data) : '';
        $this->db->trans_complete();
        return TRUE;
    }

    function getBlockContacts() {
        $res = array();
        $query = $this->db->get_where('wi_contact_groups', array('type' => "block"));
        if ($query->num_rows() > 0) {
            $res[] = $query->row();
            $this->db->select('contact_id');
            $query = $this->db->get_where('wi_multiple_contact_group', array('group_id' => $res[0]->group_id));
            $contact = array();
            foreach ($query->result() as $value) {
                $contact[] = $value->contact_id;
            }
            $res[] = $contact;
            return $res;
        } else {
            return FALSE;
        }
    }

    function getBlackList() {
        $this->db->select('MG.contact_id');
        $this->db->from('multiple_contact_group as MG');
        $this->db->join('contact_groups as C', 'MG.group_id = C.group_id');
        $this->db->where('type', 'block');
        $query = $this->db->get();
        $contacts = array();
        foreach ($query->result() as $value) {
            $contacts[] = $value->contact_id;
        }
        return $contacts;
    }

    function isBirthdaySchedule($cid, $set) {
        $query = $this->db->get_where('wi_contact_detail', array('contact_id' => $cid));
        $res = $query->row();
        $where = array(
            'event' => 'Birthday : ' . $set['fname'],
            'contact_id' => $cid
        );
        $query = $this->db->get_where('wi_schedule', $where);
        if ($query->num_rows() > 0) {
            $this->db->delete('wi_schedule', array('event_id' => $query->row()->event_id));
        }
        return FALSE;
    }

    function getFutureDate($bdt) {
        $curr = date('Y');
        $bdate = date('Y', strtotime($bdt));
        $diff = $curr - $bdate;
        $date = new DateTime($bdt);
        if (date('m-d', strtotime($bdt)) >= date('m-d')) {
            date_add($date, date_interval_create_from_date_string("{$diff} years"));
        } else {
            $diff++;
            date_add($date, date_interval_create_from_date_string("{$diff} years"));
        }
        return date_format($date, 'Y-m-d');
    }

    function checkTotalContact() {
        $planInfo = $this->common->getLatestPlan();
        $tcontacts = $this->common->getTotal($this->userid, 'wi_contact_detail');
        if ($planInfo->contacts == -1 || $tcontacts < $planInfo->contacts) {
            return true;
        } else {
            return false;
        }
    }

}
