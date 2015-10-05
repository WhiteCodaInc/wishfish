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
class M_admin_contacts extends CI_Model {

    private $profileid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->profileid = $this->session->userdata('profileid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getContactDetail() {
        $this->db->order_by('fname', 'asc');
        $query = $this->db->get('contact_detail');
        $res = $query->result();
        foreach ($res as $key => $value) {
            $group_name = "";
            $this->db->select('C.group_id,C.group_name');
            $this->db->from('multiple_contact_group as M');
            $this->db->join('contact_groups as C', 'M.group_id = C.group_id');
            $this->db->where('M.contact_id', $value->contact_id);
            $query = $this->db->get();
            foreach ($query->result() as $grp) {
                $group_name .= ($grp->group_name . '<br>');
            }
            $res[$key]->group_name = $group_name;
        }
        return $res;
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
        ($from != "") ? $where['birthday >='] = date('Y-m-d', strtotime($from)) : '';
        ($to != "") ? $where['birthday <='] = date('Y-m-d', strtotime($to)) : '';
        ($zodiac != "" && $zodiac != "-1") ? $where['zodiac'] = $zodiac : '';
        ($country != "") ? $this->db->like('country', $country) : '';
        ($city != "") ? $this->db->like('city', $city) : '';
        ($address != "") ? $this->db->like('address', $address) : '';
        ($rating != "" && $rating != "-1") ? $where['rating'] = $rating : '';
        ($group != "" && $group != "-1") ? $where['group_id'] = $group : '';

        $this->db->select('*');
        $this->db->from('contact_detail as C');
        $this->db->join('multiple_contact_group as M', 'C.contact_Id = M.contact_id', 'left outer');
        $this->db->group_by('C.contact_id');
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';

        $query = $this->db->get();
        $res = $query->result();
        foreach ($res as $key => $value) {
            $group_name = "";
            $this->db->select('C.group_id,C.group_name');
            $this->db->from('multiple_contact_group as M');
            $this->db->join('contact_groups as C', 'M.group_id = C.group_id');
            $this->db->where('M.contact_id', $value->contact_id);
            $query = $this->db->get();
            foreach ($query->result() as $grp) {
                $group_name .= ($grp->group_name . '<br>');
            }
            $res[$key]->group_name = $group_name;
        }
        return $res;
    }

    function getContactInfo($cid) {
        $query = $this->db->get_where('contact_detail', array('contact_id' => $cid));
        return $query->row();
    }

    function getContact($cid, $type) {
        $res = array();
        $query = $this->db->get_where('contact_detail', array('contact_id' => $cid));
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
    }

    function createContact($set) {
        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        unset($set['code']);

        if (isset($set['group_id'])) {
            $group = $set['group_id'];
            unset($set['group_id']);
        }
        $this->db->trans_start();

        $this->db->insert('contact_detail', $set);
        $insertid = $this->db->insert_id();

        $data = array();
        if (isset($group)) {
            foreach ($group as $value) {
                $data[] = array(
                    'contact_id' => $insertid,
                    'group_id' => $value
                );
            }
        }

        //-------------------------Insert New Assign Group--------------------//
        (count($data) > 0) ? $this->db->insert_batch('multiple_contact_group', $data) : '';

        $event_data = array(
            'event' => 'Birthday : ' . $set['fname'],
            'event_type' => "notification",
            'group_type' => "individual",
            'user_id' => $insertid,
            'user' => 2,
            'color' => "#BDBDBD",
            'notification' => 0,
            'notify' => "them",
            'date' => $this->getFutureDate($set['birthday'])
        );
        $this->db->insert('schedule', $event_data);
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
                        $this->db->update('contact_detail', $set, array('contact_id' => $insertid));
                        $m = "I";
                        break;
                }
            }
        }
        $this->db->trans_complete();
        return $m;
    }

    function updateContact($set) {
        $m = "";
        $cid = $set['contactid'];
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;

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
        if ($this->isBirthdaySchedule($cid, $set)) {
            $event_data = array(
                'event' => 'Birthday : ' . $set['fname'],
                'event_type' => "notification",
                'group_type' => "individual",
                'user_id' => $cid,
                'user' => 2,
                'color' => "#BDBDBD",
                'notification' => 0,
                'notify' => "them",
                'date' => $this->getFutureDate($set['birthday'])
            );
            $this->db->insert('schedule', $event_data);
        }
        $m = "U";
        $this->db->update('contact_detail', $set, array('contact_id' => $cid));
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
            $this->db->delete('multiple_contact_group');
        }
        //-------------------------Insert New Assign Group--------------------//
        (count($data) > 0) ? $this->db->insert_batch('multiple_contact_group', $data) : '';
        $this->db->trans_complete();
        return $m;
    }

    function uploadImage($file, $cid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['contact_avatar']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/admin/contacts/contact_avatar_' . $cid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['contact_avatar']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function setAction($post) {
//        echo '<pre>';
//        print_r($post);
//        die();
        $msg = "";
        $ids = $post['contact'];
        switch ($post['actionType']) {
            case "Add":
                foreach ($ids as $value) {
                    $set = array(
                        'contact_id' => $value,
                        'group_id' => $post['groupid']
                    );
                    if (!$this->isAlreadyExists($set)) {
                        $this->db->insert('multiple_contact_group', $set);
                    }
                }
                $msg = "A";
                break;
            case "Remove":
                foreach ($ids as $value) {
                    $set = array(
                        'contact_id' => $value,
                        'group_id' => $post['groupid']
                    );
                    if ($this->isAlreadyExists($set)) {
                        $this->db->delete('multiple_contact_group', $set);
                    }
                }
                $msg = "R";
                break;
            case "Delete":
                foreach ($ids as $value) {
                    $this->db->delete('contact_detail', array('contact_id' => $value));
                    $where = array(
                        'user_id' => $value,
                        'user' => 2
                    );
                    $this->db->delete('schedule', $where);
                }
                $msg = "D";
                break;
        }
        return $msg;
    }

    function isAlreadyExists($set) {
        $query = $this->db->get_where('multiple_contact_group', $set);
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    function createList($post) {
        $set = array();
        $data['group_name'] = "Black List";
        $data['type'] = $post['type'];
        $ids = (isset($post['contact_id'])) ? $post['contact_id'] : array();

        $this->db->trans_start();
        $this->db->insert('contact_groups', $data);
        $insertid = $this->db->insert_id();

        if (count($ids) > 0) {
            foreach ($ids as $value) {
                $set[] = array(
                    'contact_id' => $value,
                    'group_id' => $insertid
                );
            }
            $this->db->insert_batch('multiple_contact_group', $set);
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
        $this->db->update('contact_groups', $set, array('group_id' => $gid));
        $this->db->delete('multiple_contact_group', array('group_id' => $gid));
        (count($data) > 0) ? $this->db->insert_batch('multiple_contact_group', $data) : '';
        $this->db->trans_complete();
        return TRUE;
    }

    function getBlockContacts() {
        $res = array();
        $query = $this->db->get_where('contact_groups', array('type' => "block"));
        if ($query->num_rows() > 0) {
            $res[] = $query->row();
            $this->db->select('contact_id');
            $query = $this->db->get_where('multiple_contact_group', array('group_id' => $res[0]->group_id));
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
        $query = $this->db->get_where('contact_detail', array('contact_id' => $cid));
        $res = $query->row();
        $where = array(
            'event' => 'Birthday : ' . $set['fname'],
            'user_id' => $cid,
            'user' => 2
        );
        $query = $this->db->get_where('schedule', $where);
        if ($query->num_rows() > 0) {
            $this->db->delete('schedule', array('event_id' => $query->row()->event_id));
        }
        return TRUE;
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

    function isExist($phone) {
        $query = $this->db->get_where('inbox', array('from' => $phone));
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    function addMsgInbox($contact, $body, $sid) {
        $set = array(
            'from' => $contact->phone,
            'sid' => $sid,
            'body' => $body,
            'date_sent' => date('D,j M Y H:i:s +0000'),
            'contact_id' => $contact->contact_id,
            'status' => 0
        );
        $this->db->insert('inbox', $set);
    }

}
