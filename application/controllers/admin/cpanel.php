<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpanel extends CI_Controller {

    private $stream, $inbox_user, $inbox_passwd;
    private $ip, $uname, $passwd, $domain, $quota;
    private $cpmm;
    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        require_once APPPATH . 'third_party/cpanel_email_account.php';
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->ip = "50.28.18.90";
            $this->uname = "wishfish";
            $this->passwd = "vishal789";
            $this->domain = "@wish-fish.com";
            $this->quota = "100";

            $this->cpmm = new cPanelEmailManager($this->uname, $this->passwd, $this->ip);

            $this->inbox_user = $this->session->userdata('inbox_user');
            $this->inbox_passwd = $this->session->userdata('inbox_password');

            $this->load->model('admin/m_cpanel', 'objcpanel');
        }
    }

    function index() {
        if ($this->p->emailai || $this->p->emailau || $this->p->emailad) {
            $account = $this->objcpanel->getAccounts();
            //echo "<pre>";
            // print_r($account);
            foreach ($account as $key => $value) {
                if ($this->openInbox($value->email, $value->password)) {
                    $account[$key]->unread = $this->getUnread();
                    $account[$key]->total = $this->getTotal();
                    imap_close($this->stream);
                } else {
                    $account[$key]->unread = 0;
                    $account[$key]->total = 0;
                }
            }
            // print_r($account);
            // die();
            $data['account'] = $account;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/cpanel-email-account', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addAccount() {
        if ($this->p->emailai) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-cpanel-email-account');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createAccount() {
        if ($this->p->emailai) {
            $post = $this->input->post();
            $post['email'] = $post['email'] . $this->domain;
            if ($this->cpmm->emailExists($post['email'], true)) {
                $msg = "E";
            } else {
                $result = $this->cpmm->createEmail($post['email'], $post['password'], $this->quota);
                if ($result) {
                    $this->objcpanel->createAccount($post);
                    $msg = "I";
                } else {
                    $msg = "F";
                }
            }
            $this->session->set_flashdata('msg', $msg);
            header('location:' . site_url() . 'admin/cpanel');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editAccount($accountid) {
        if ($this->p->emailau) {
            $data['account'] = $this->objcpanel->getAccount($accountid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-cpanel-email-account', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateAccount($accountid) {
        if ($this->p->emailau) {
            $post = $this->input->post();
            $accountInfo = $this->objcpanel->getAccount($accountid);
            $result = $this->cpmm->changePW($accountInfo->email, $post['password']);
            if ($result) {
                $this->objcpanel->updateAccount($accountid, $post);
            }
            $this->session->set_flashdata('msg', "U");
            header('location:' . site_url() . 'admin/cpanel');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->emailau || $this->p->emailad) {
            $msg = "";
            $post = $this->input->post();
            $type = $post['actionType'];
            if ($type == "Delete") {
                foreach ($post['account'] as $value) {
                    $accountInfo = $this->objcpanel->getAccount($value);
                    $result = $this->cpmm->deleteEmail($accountInfo->email);
                    if ($result) {
                        $this->objcpanel->setAction($type, $value);
                    }
                    $msg = "D";
                }
            } else if ($type == "Add" || $type == "Remove") {
                $this->objcpanel->setAction($type, $post['account']);
                $msg = ($type == "Add") ? "A" : "R";
            } else {
                $msg = "";
            }
            if ($msg != "") {
                $this->session->set_flashdata('msg', $msg);
                header('location:' . site_url() . 'admin/cpanel');
            } else {
                header('location:' . site_url() . 'admin/cpanel');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getUnread() {
        $res = imap_search($this->stream, 'UNSEEN');
        return ($res) ? count($res) : 0;
    }

    function getTotal() {
        $res = imap_search($this->stream, 'ALL');
        return ($res) ? count($res) : 0;
    }

    function openInbox($uname, $passwd) {
        $this->stream = @imap_open('{mail.mikhailkuznetsov.com:143/notls}INBOX', $uname, $passwd);
        imap_errors();
        $imap_obj = ($this->stream) ? imap_check($this->stream) : FALSE;
        return ($imap_obj) ? TRUE : FALSE;
    }

    function getEmailList() {
        // List email accounts 
//        echo '<pre>';
//        $pageSize = 15;
//        $pageNo = 1;
//        $result = $cpmm->listEmails($pageSize, $pageNo);
//        print_r($result);
    }

    function getTotalUnreadEmail() {
        $account = $this->objcpanel->getNotificationAccount();
        $data = array();
        $mailbox = array();
        $totalUnread = 0;
        $cnt = 0;
        foreach ($account as $value) {
            if ($this->openInbox($value->email, $value->password)) {
                $emails = imap_search($this->stream, 'UNSEEN');
                if (is_array($emails)) {
                    $totalUnread += count($emails);
                    rsort($emails);
                    foreach ($emails as $email_id) {
                        $overview = imap_fetch_overview($this->stream, $email_id, 0);
                        $mailbox[$cnt]['id'] = $value->account_id;
                        $mailbox[$cnt]['subject'] = $overview[0]->subject;
                        $mailbox[$cnt]['from'] = $overview[0]->from;
                        $mailbox[$cnt]['date'] = date('m-d-Y H:i', strtotime($overview[0]->date));
                        $cnt++;
                    }
                }
                imap_close($this->stream);
            }
        }
        $data['emails'] = $mailbox;
//        print_r($data);
//        die();
        $this->load->view('admin/email-notify', $data);
    }

}
