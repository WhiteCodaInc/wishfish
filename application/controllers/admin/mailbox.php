<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mailbox extends CI_Controller {

    private $stream, $inbox_user, $inbox_passwd;
    private $ip, $uname, $passwd, $domain, $quota;
    private $cpmm;

    function __construct() {
        parent::__construct();
        require_once APPPATH . 'third_party/cpanel_email_account.php';
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->email) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->ip = "50.28.18.90";
            $this->uname = "wishfish";
            $this->passwd = "vishal789";
            $this->domain = "@wish-fish.com";
            $this->quota = "100";

            $this->cpmm = new cPanelEmailManager($this->uname, $this->passwd, $this->ip);

            $this->inbox_user = $this->session->userdata('inbox_user');
            $this->inbox_passwd = $this->session->userdata('inbox_password');
            if ($this->is_login())
                $this->stream = imap_open('{mail.mikhailkuznetsov.com:143/notls}', $this->inbox_user, $this->inbox_passwd);
            $this->load->model('admin/m_cpanel', 'objcpanel');
            $this->load->model('admin/m_admin_profile', 'objprofile');
            $this->load->model('admin/m_admin_contacts', 'objcon');
            $this->load->model('admin/m_affiliates', 'objaffiliate');
            $this->load->model('admin/m_customers', 'objcustomer');
            $this->load->model('admin/m_list_builder', 'objbuilder');
        }
    }

    function index() {
        if ($this->is_login())
            header('location:' . site_url() . 'admin/mailbox/inbox');

        $data['accounts'] = $this->objcpanel->getProfileAccount();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/mailbox-login', $data);
        $this->load->view('admin/admin_footer');
    }

    public function inbox($folder = "INBOX") {
        if (!$this->is_login())
            header('location:' . site_url() . 'admin/mailbox');

        $url = ($folder != "INBOX") ?
                "{mail.mikhailkuznetsov.com:143/notls}INBOX.{$folder}" :
                "{mail.mikhailkuznetsov.com:143/notls}INBOX";
//        echo $url . '<br>';
        $imap_obj = imap_check($this->stream);
//        echo '<pre>';
        if (!$imap_obj) {
            $mailbox = array();
        } else if (!$imap_obj->Nmsgs) {
            $mailbox = array();
        } else {
            imap_reopen($this->stream, $url);
            $emails = imap_search($this->stream, 'ALL');
//            print_r($emails);
            if (is_array($emails)) {
                rsort($emails);
                $data = array();
                foreach ($emails as $key => $email_id) {
                    $overview = imap_fetch_overview($this->stream, $email_id, 0);
                    $mailbox[$key]['id'] = $overview[0]->uid;
                    $mailbox[$key]['subject'] = $this->decode_imap_text($overview[0]->subject);
                    $mailbox[$key]['from'] = $this->decode_imap_text($overview[0]->from);
                    $mailbox[$key]['to'] = $this->decode_imap_text($overview[0]->to);
                    $mailbox[$key]['date'] = date('m-d-Y H:i', strtotime($overview[0]->date));
                    $mailbox[$key]['status'] = ($overview[0]->seen) ? 1 : 0;
                    $mailbox[$key]['body'] = imap_fetchbody($this->stream, $email_id, 1);
                }
            } else {
                $mailbox = array();
            }
        }
        $data['folder'] = $this->getInboxFolder();
        $data['threads'] = $this->makeThreads($mailbox);
//        echo '<pre>';
//        print_r($data);
//        die();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/mailbox', $data);
        $this->load->view('admin/admin_footer');
    }

    function getConversation() {
        if (!$this->is_login())
            header('location:' . site_url() . 'admin/mailbox');
        $post = $this->input->post();

        if ($post['subject'] != "") {
            $subject = str_replace('-', ' ', $post['subject']);
            $url = ($post['type'] != "Inbox") ?
                    "{mail.mikhailkuznetsov.com:143/notls}INBOX.{$post['type']}" :
                    "{mail.mikhailkuznetsov.com:143/notls}INBOX";
            $imap_obj = imap_check($this->stream);
            if (!$imap_obj) {
                $mailbox = array();
            } else if (!$imap_obj->Nmsgs) {
                $mailbox = array();
            } else {
                $display = ($post['type'] == "Inbox") ? 2 : 1;
                imap_reopen($this->stream, $url);
                $emails = imap_search($this->stream, 'ALL');
                if (is_array($emails)) {
                    rsort($emails);
                    foreach ($emails as $key => $email_id) {
                        $overview = imap_fetch_overview($this->stream, $email_id, 0);
                        $mailbox[$key]['id'] = $overview[0]->uid;
                        $mailbox[$key]['subject'] = $this->decode_imap_text($overview[0]->subject);
                        $mailbox[$key]['from'] = $this->decode_imap_text($overview[0]->from);
                        $mailbox[$key]['to'] = $this->decode_imap_text($overview[0]->to);
                        $mailbox[$key]['date'] = date('m-d-Y H:i', strtotime($overview[0]->date));
                        $mailbox[$key]['status'] = ($overview[0]->seen) ? 1 : 0;
                        $mailbox[$key]['body'] = imap_fetchbody($this->stream, $email_id, 3);
                    }
                }
            }
            $threads = $this->makeThreads($mailbox);
            echo json_encode(array_reverse($threads[$subject]));
        } else {
            header('location:' . site_url() . 'admin/mailbox/inbox');
        }
    }

    function makeThreads($mailbox) {
        $threads = array();
        foreach ($mailbox as $value) {
            $flag = TRUE;
            foreach ($mailbox as $val) {
                if ($val['subject'] == "Re: " . $value['subject']) {
                    $flag = FALSE;
                    break;
                }
            }
            if ($flag) {
                $threads[$value['subject']][] = $value;
            }
        }
        return $threads;
    }

    function decode_imap_text($str) {
        $result = '';
        $decode_header = imap_mime_header_decode($str);
        foreach ($decode_header AS $obj) {
            $result .= htmlspecialchars(rtrim($obj->text, "\t"));
        }
        return $result;
    }

    function send() {

        $to = "";
        $emails = "";

        if (!$this->inbox_user)
            header('location:' . site_url() . 'admin/mailbox');

        $post = $this->input->post();
        $type = $post['submit'];

        $folder = ($type == "Send") ?
                "{mail.mikhailkuznetsov.com:143/notls}INBOX.Sent" :
                "{mail.mikhailkuznetsov.com:143/notls}INBOX.Drafts";
        $headers = "From: {$this->inbox_user}\r\n" .
                "Reply-To: {$this->inbox_user}\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if ($post['option'] == "new" && $post['submit'] == "Send") {
            $response = $this->sendToNewContact($post, $headers, $folder);
        } else if ($post['option'] == "exist" && $post['submit'] == "Send") {
            $response = $this->sendToExistContact($post, $headers, $folder);
        } else if ($post['submit'] == "Draft") {
            imap_append(
                    $this->stream, $folder, $headers .
                    "Subject: " . $post['email_subject'] . "\r\n" .
                    "To: " . $post['email_to'] . "\r\n" .
                    "Date: " . date('Y-m-d H:i:s') . "\r\n" .
                    "\r\n" .
                    $post['message'] .
                    "\r\n"
            );
            $response = TRUE;
        } else {
            $response = FALSE;
        }
        $msg = ($response) ? "send" : "fail";
        $this->session->set_flashdata('msg', $msg);
        header('location:' . site_url() . 'admin/mailbox/inbox');
    }

    function sendToNewContact($post, $headers, $folder) {
        imap_append(
                $this->stream, $folder, $headers .
                "Subject: " . $post['email_subject'] . "\r\n" .
                "To: " . $post['email_to'] . "\r\n" .
                "Date: " . date('Y-m-d H:i:s') . "\r\n" .
                "\r\n" .
                $post['message'] .
                "\r\n"
        );
        return imap_mail($post['email_to'], $post['email_subject'], $post['message'], $headers);
    }

    function sendToExistContact($post, $headers, $folder) {
        $blackList = $this->objcon->getBlackList();
        $flag = FALSE;
        switch ($post['assign']) {
            case 'all_c':
                switch ($post['user']) {
                    case 1:
                        $user = $this->objprofile->getProfile($post['user_id']);
                        break;
                    case 2:
                        if (!in_array($post['user_id'], $blackList)) {
                            $user = $this->objcon->getContactInfo($post['user_id']);
                        } else {
                            $user = array();
                        }
                        break;
                    case 3:
                        $user = $this->objaffiliate->getAffiliateInfo($post['user_id']);
                        break;
                    case 4:
                        $user = $this->objcustomer->getCustomerInfo($post['user_id']);
                        break;
                }
                if (count($user) > 0 && $user->email != "") {
                    $flag = imap_mail($user->email, $post['email_subject'], $post['message'], $headers);
                    imap_append(
                            $this->stream, $folder, $headers .
                            "Subject: " . $post['email_subject'] . "\r\n" .
                            "To: " . $user->email . '\r\n' .
                            "Date: " . date('Y-m-d H:i:s') . "\r\n" .
                            "\r\n" .
                            $post['message'] .
                            "\r\n"
                    );
                }
                break;
            case 'all_gc':
            case 'all_l':
                switch ($post['user']) {
                    case 2:
                        if ($post['assign'] == "all_gc") {
                            $res = $this->objbuilder->getGroupContact($post['group_id']);
                            $ids = $res[1];
                        } else {
                            $ids = $this->objbuilder->getSubGroupContact($post['group_id']);
                        }
                        $f = TRUE;
                        break;
                    case 3:
                        $res = $this->objbuilder->getGroupAffiliate($post['group_id']);
                        $ids = $res[1];
                        $f = FALSE;
                        break;
                    case 4:
                        $res = $this->objbuilder->getGroupCustomer($post['group_id']);
                        $ids = $res[1];
                        $f = FALSE;
                        break;
                }
                foreach ($ids as $value) {
                    if ($f && !in_array($value, $blackList)) {
                        $user = $this->objcon->getContactInfo($value);
                    } else if ($post['user'] == 3 && !$f) {
                        $user = $this->objaffiliate->getAffiliateInfo($value);
                    } else if ($post['user'] == 4 && !$f) {
                        $user = $this->objcustomer->getCustomerInfo($value);
                    } else {
                        $user = array();
                    }
                    if (count($user) > 0 && $user->email != "") {
                        $flag = imap_mail($user->email, $post['email_subject'], $post['message'], $headers);
                        imap_append(
                                $this->stream, $folder, $headers .
                                "Subject: " . $post['email_subject'] . "\r\n" .
                                "To: " . $user->email . '\r\n' .
                                "Date: " . date('Y-m-d H:i:s') . "\r\n" .
                                "\r\n" .
                                $post['message'] .
                                "\r\n"
                        );
                    }
                }
                break;
            default:
                break;
        }
        return $flag;
    }

    function action() {
        if (!$this->inbox_user)
            header('location:' . site_url() . 'admin/mailbox');
        $post = $this->input->post();
        if (!$this->stream) {
            echo imap_last_error();
        } else if (isset($post['email_id']) && count($post['email_id'])) {
            $url = ($post['type'] != "Inbox") ?
                    "{mail.mikhailkuznetsov.com:143/notls}INBOX.{$post['type']}" :
                    "{mail.mikhailkuznetsov.com:143/notls}INBOX";
            imap_reopen($this->stream, $url);

            switch ($post['submit']) {
//                case "unread":
//                    foreach ($post['email_id'] as $email_id) {
//                        imap_setflag_full($this->stream, $email_id, "\\Unseen", ST_UID);
//                    }
//                    break;
//                case "read":
//                    foreach ($post['email_id'] as $email_id) {
//                        imap_setflag_full($this->stream, $email_id, "\\Seen", ST_UID);
//                    }
//                    break;
                case "delete":
                    foreach ($post['email_id'] as $email_id) {
                        $ids = explode('-', $email_id);
                        foreach ($ids as $value) {
                            ($post['type'] == "Trash") ?
                                            imap_delete($this->stream, $value, FT_UID) :
                                            imap_mail_move($this->stream, $value, 'INBOX.Trash', CP_UID);
                        }
                    }
                    break;
                case "spam":
                    foreach ($post['email_id'] as $email_id) {
                        imap_mail_move($this->stream, $email_id, 'INBOX.Junk', CP_UID);
                    }
                    break;
                case "archive":
                    foreach ($post['email_id'] as $email_id) {
                        imap_mail_move($this->stream, $email_id, 'INBOX.Archive', CP_UID);
                    }
                    break;
            }
        }
        imap_close($this->stream, CL_EXPUNGE);
        header('location:' . site_url() . 'admin/mailbox');
    }

    function login($accid = NULL) {
        $post = $this->input->post();
        if ($accid != NULL || is_array($post) && count($post) > 0) {
            $aid = ($accid != NULL) ? $accid : $post['account_id'];
            $accountInfo = $this->objcpanel->getAccount($aid);
            $this->stream = @imap_open('{mail.mikhailkuznetsov.com:143/notls}INBOX', $accountInfo->email, $accountInfo->password);
            imap_errors();
            if (!$this->stream) {
                $this->session->set_flashdata('error', "Invalid username or password..!");
                header('location:' . site_url() . 'admin/mailbox');
            } else {
                imap_close($this->stream);
                $this->session->set_userdata('inbox_user', $accountInfo->email);
                $this->session->set_userdata('inbox_password', $accountInfo->password);
                header('location:' . site_url() . 'admin/mailbox/inbox');
            }
        } else {
            header('location:' . site_url() . 'admin/mailbox');
        }
    }

    function createAccount() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/mailbox-account');
        $this->load->view('admin/admin_footer');
    }

    function create() {
        $post = $this->input->post();
        if (is_array($post) && count($post)) {
            $this->cpmm->set_output('json');
            $this->cpmm->set_debug(1);

            $json = $this->cpmm->api1_query(
                    $this->uname, "Email", "addpop", array(trim($post['uname']), $post['passwd'], $this->quota, $this->domain)
            );
            $result = json_decode($json);
            if (isset($result->error)) {
                $this->session->set_flashdata('error', $result->error);
                header('location:' . site_url() . 'admin/mailbox/createAccount');
            } else {
                header('location:' . site_url() . 'admin/mailbox');
            }
        }
    }

    function logout() {
        imap_close($this->stream);
        $this->session->unset_userdata('inbox_user');
        $this->session->unset_userdata('inbox_password');
        header('location:' . site_url() . 'admin/mailbox');
    }

    function is_login() {
        return ($this->inbox_user) ? TRUE : FALSE;
    }

    function getInboxFolder() {
        $srv = '{mail.mikhailkuznetsov.com:143/notls}';
        $boxes = imap_list($this->stream, $srv, '*');
        foreach ($boxes as $box) {
            imap_reopen($this->stream, $box);
            $emails = imap_search($this->stream, "ALL");
            $mailbox = array();
            if (is_array($emails)) {
                foreach ($emails as $key => $email_id) {
                    $overview = imap_fetch_overview($this->stream, $email_id, 0);
                    $mailbox[$key]['subject'] = $this->decode_imap_text($overview[0]->subject);
                }
                $folder[] = count($this->makeThreads($mailbox, "NORMAL"));
            } else {
                $folder[] = 0;
            }
        }
//        imap_close($this->stream);
        return $folder;
    }

}
