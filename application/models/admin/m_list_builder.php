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
class M_list_builder extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getGroups($type) {
        $this->db->select('C.group_id,group_name,count(contact_id) as total');
        $this->db->from('contact_groups as C');
        $this->db->join('multiple_contact_group as M', 'C.group_id = M.group_id', 'left outer');
        $this->db->group_by('C.group_id');
        $this->db->where('C.type', $type);
        $query = $this->db->get();
        return $query->result();
    }

    function getGroupContact($gid) {
        $res = array();
        $query = $this->db->get_where('contact_groups', array('group_id' => $gid));
        $res[] = $query->row();

        $this->db->select('contact_id');
        $query = $this->db->get_where('multiple_contact_group', array('group_id' => $gid));
        $contact = array();
        foreach ($query->result() as $value) {
            $contact[] = $value->contact_id;
        }
        $res[] = $contact;
        return $res;
    }

    function getGroupAffiliate($gid) {
        $res = array();
        $query = $this->db->get_where('affiliate_groups', array('group_id' => $gid));
        $res[] = $query->row();

        $this->db->select('affiliate_id');
        $query = $this->db->get_where('multiple_affiliate_group', array('group_id' => $gid));
        $affiliate = array();
        foreach ($query->result() as $value) {
            $affiliate[] = $value->affiliate_id;
        }
        $res[] = $affiliate;
        return $res;
    }

    function getGroupCustomer($gid) {
        $res = array();
        $query = $this->db->get_where('customer_groups', array('group_id' => $gid));
        $res[] = $query->row();

        $this->db->select('user_id');
        $query = $this->db->get_where('multiple_customer_group', array('group_id' => $gid));
        $customer = array();
        foreach ($query->result() as $value) {
            $customer[] = $value->user_id;
        }
        $res[] = $customer;
        return $res;
    }

    function createList($post) {
        $set = array();
        $data['group_name'] = $post['group_name'];
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

        $type = $set['updateType'];
        $gid = $set['groupid'];

        if ($type == "contact") {
            if (isset($set['contact_id'])) {
                $contact = $set['contact_id'];
                unset($set['contact_id']);
            }
        } else {
            if (isset($set['group_id'])) {
                $group = $set['group_id'];
                unset($set['group_id']);
            }
        }
        unset($set['groupid']);
        unset($set['updateType']);

        $data = array();
        if (isset($contact)) {
            foreach ($contact as $value) {
                $data[] = array(
                    'group_id' => $gid,
                    'contact_id' => $value
                );
            }
        } elseif (isset($group)) {
            foreach ($group as $value) {
                $data[] = array(
                    'group_id' => $gid,
                    'subgroup_id' => $value
                );
            }
        }

        $this->db->trans_start();

        $this->db->update('contact_groups', $set, array('group_id' => $gid));
        if ($type == "contact") {
            $this->db->delete('multiple_contact_group', array('group_id' => $gid));
            (count($data) > 0) ? $this->db->insert_batch('multiple_contact_group', $data) : '';
        } else {
            $this->db->delete('subgroup', array('group_id' => $gid));
            (count($data) > 0) ? $this->db->insert_batch('subgroup', $data) : '';
        }
        $this->db->trans_complete();
        return TRUE;
    }

    function setAction() {
        $ids = $this->input->post('group');

        if (is_array($ids)) {
            $this->db->trans_start();
            $this->db->where_in('group_id', $ids);
            $this->db->delete('contact_groups');

            $this->db->where_in('group_id', $ids);
            $this->db->delete('multiple_contact_group');

            $this->db->trans_complete();
        } else {
            return FALSE;
        }
    }

    function getListSubGroup($gid) {
        $res = array();
        $query = $this->db->get_where('contact_groups', array('group_id' => $gid));
        $res[] = $query->row();

        $this->db->select('subgroup_id');
        $query = $this->db->get_where('subgroup', array('group_id' => $gid));
        $subgroup = array();
        foreach ($query->result() as $value) {
            $subgroup[] = $value->subgroup_id;
        }
        $res[] = $subgroup;
        return $res;
    }

    function getSubGroupContact($gid) {
        $contact = array();

        $this->db->select('contact_id');
        $query = $this->db->get_where('multiple_contact_group', array('group_id' => $gid));
        foreach ($query->result() as $value) {
            $contact[] = $value->contact_id;
        }
        $this->db->select('contact_id');
        $this->db->distinct('contact_id');
        $this->db->from('multiple_contact_group as MG');
        $this->db->join('subgroup as SG', 'MG.group_id = SG.subgroup_id');
        $this->db->where("subgroup_id IN (select subgroup_id from subgroup where group_id = $gid)");
        $query = $this->db->get();

        foreach ($query->result() as $value) {
            if (!in_array($value->contact_id, $contact))
                $contact[] = $value->contact_id;
        }
        return $contact;
    }

    function getSubGroup($gid) {
        $this->db->select('C.group_id,group_name');
        $this->db->distinct('S.group_id');
        $this->db->from('contact_groups as C');
        $this->db->join('subgroup as S', 'C.group_id = S.subgroup_id');
        $this->db->where('S.group_id', $gid);
        $query = $this->db->get('subgroup');
        $res = $query->result();
        foreach ($res as $key => $value) {
            $this->db->select('count(*) as totalC');
            $query = $this->db->get_where('multiple_contact_group', array('group_id' => $value->group_id));
            $res[$key]->totalC = $query->row()->totalC;
        }
        return $res;
    }

    function delete($type, $post) {
        if ($type == "contacts") {
            $this->db->where_in('contact_id', $post['contacts']);
            $this->db->delete('multiple_contact_group', array('group_id' => $post['groupid']));
        } else if ($type == "groups") {
            $this->db->where_in('subgroup_id', $post['groups']);
            $this->db->delete('subgroup', array('group_id' => $post['groupid']));
        }
        return TRUE;
    }

}
