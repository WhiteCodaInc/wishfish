<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cpanel_email_account
 *
 * @author Laxmisoft
 */
/*
  Online PHP Examples with Source Code
  website: http://4evertutorials.blogspot.com/
 */


class cPanelEmailManager {

    private $cpanelHost;
    private $cpanelPort;
    private $username;
    private $password;
    private $logcurl;
    private $cookiefile;
    private $curlfile;
    private $emailArray;
    private $cpsess;

    /**
     * Constructor 
     * @param string $user cPanel username 
     * @param string $pass cPanel password 
     * @param string $host cPanel domain 
     * @param int $port cPanel domain 
     */
    public function __construct($user, $pass, $host, $port = 2083) {
        $this->cpanelHost = $host;
        $this->cpanelPort = $port;
        $this->username = $user;
        $this->password = $pass;
        $this->logcurl = false;
        $this->cookiefile = FCPATH . "cpmm_cookie.txt";
        // echo $this->cookiefile;
        //die();
        $this->LogIn();
    }

    /**
     * Checks if an email address exists 
     * @param string $Needle Email address to check 
     * @param bool $FullEmailOnly If false, will return true with or without the domain attached 
     * @return bool 
     */
    public function emailExists($Needle, $FullEmailOnly = false) {
        $Haystack = empty($this->emailArray) ? $this->getEmails() : $this->emailArray;
        foreach ($Haystack as $H) {
            if ($FullEmailOnly === true && $H['email'] == $Needle) {
                return true;
            } else if ($FullEmailOnly !== true && ($H['user'] == $Needle || $H['email'] == $Needle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Creates a new email address 
     * @param string $email Complete mail address to create, ie. myemail@mydomain.com 
     * @param string $password Password for new email 
     * @param string $quota Disk Space Quota, 0 for unlimited 
     * @return bool 
     */
    public function createEmail($email, $password, $quota = 0) {
        $e = explode("@", $email);
        $params = 'user=' . $this->username . '&pass=' . $this->password;
        $url = "https://" . $this->cpanelHost . ":" . $this->cpanelPort . $this->cpsess . "/json-api/cpanel" .
                "?cpanel_jsonapi_version=2" .
                "&cpanel_jsonapi_func=addpop" .
                "&cpanel_jsonapi_module=Email&" .
                "email=" . $e[0] . "&" .
                "domain=" . $e[1] . "&" .
                "password=" . urlencode($password) . "&" .
                "quota=" . $quota;
        $answer = json_decode($this->Request($url, $params), true);
        $this->getEmails(true);
        return ($answer["cpanelresult"]["data"][0]['result'] === 1) ? true : false;
    }

    /**
     * Deletes an email address 
     * @param string $email Complete mail address to delete, ie. myemail@mydomain.com 
     * @return bool 
     */
    public function deleteEmail($email) {
//        if (!$this->emailExists($email, true)) {
//            return "Email address " . $email . " does not exist";
//        }
        $e = explode("@", $email);
        $params = 'user=' . $this->username . '&pass=' . $this->password;
        $url = "https://" . $this->cpanelHost . ":" . $this->cpanelPort . $this->cpsess . "/json-api/cpanel" .
                "?cpanel_jsonapi_version=2" .
                "&cpanel_jsonapi_func=delpop" .
                "&cpanel_jsonapi_module=Email&" .
                "email=" . $e[0] . "&" .
                "domain=" . $e[1];
        $answer = json_decode($this->Request($url, $params), true);
        $this->getEmails(true);
        return ($answer["cpanelresult"]["data"][0]['result'] === 1) ? true : false;
    }

    /**
     * Changes a password 
     * @param string $email Complete email of account, ie. myemail@mydomain.com 
     * @param string $newPW New password 
     * @return bool 
     */
    public function changePW($email, $newPW) {
//        if (!$this->emailExists($email, true)) {
//            return "Email address " . $email . " does not exist";
//        }
        $e = explode("@", $email);
        $params = 'user=' . $this->username . '&pass=' . $this->password;
        $url = "https://" . $this->cpanelHost . ":" . $this->cpanelPort . $this->cpsess . "/json-api/cpanel" .
                "?cpanel_jsonapi_version=2" .
                "&cpanel_jsonapi_func=passwdpop" .
                "&cpanel_jsonapi_module=Email&" .
                "email=" . $e[0] . "&" .
                "domain=" . $e[1] . "&" .
                "password=" . urlencode($newPW);
        $answer = json_decode($this->Request($url, $params), true);
        $this->getEmails(true);
        return ($answer["cpanelresult"]["data"][0]['result'] === 1) ? true : false;
    }

    /**
     * Lists all email accounts and their properties 
     * @param int $pageSize Number of results per page 
     * @param int $currentPage Page number to start from 
     * @param bool $paginate Return in pages 
     * @param bool $sort Sort the results 
     * @param bstring $sortby Column to sort by, ie. "email", "_diskused", "mtime", or "domain" 
     * @return array 
     */
    public function listEmails($pageSize = 10, $currentPage = 1, $paginate = true, $sort = true, $sortby = "user") {
        $params = 'user=' . $this->username . '&pass=' . $this->password;
        $url = "https://" . $this->cpanelHost . ":" . $this->cpanelPort . $this->cpsess . "/json-api/cpanel" .
                "?cpanel_jsonapi_version=2" .
                "&cpanel_jsonapi_func=listpopswithdisk" .
                "&cpanel_jsonapi_module=Email" .
                "&api2_paginate=" . ($paginate === false ? 0 : 1) .
                "&api2_paginate_size=" . $pageSize .
                "&api2_paginate_start=" . $currentPage .
                "&api2_sort=" . ($sort === false ? 0 : 1) .
                "&api2_sort_column=" . $sortby .
                "&api2_sort_method=alphabet" .
                "&api2_sort_reverse=0";
        $answer = $this->Request($url, $params);
        $emails = json_decode($answer, true);
        $this->emailArray = $emails["cpanelresult"]["data"];
        return $this->emailArray;
    }

    /**
     * Turns cURL logging on 
     * @param int $curlfile Path to curl log file 
     * @return array 
     */
    public function logCurl($curlfile = "cpmm_curl_log.txt") {
        if (!file_exists(FCPATH . $curlfile)) {
            try {
                fopen(FCPATH . $curlfile, "w");
            } catch (Exception $ex) {
                if (!file_exists(FCPATH . $curlfile)) {
                    return $ex . 'Cookie file missing.';
                }
                return true;
            }
        } else if (!is_writable(FCPATH . $curlfile)) {
            return 'Cookie file not writable.';
        }
        $this->logcurl = true;
        return true;
    }

    /**
     * Returns a complete list of emails and their properties 
     * @access private 
     */
    private function getEmails($refresh = false) {
        if (!empty($this->emailArray) && !$refresh) {
            return $this->emailArray;
        }
        $params = 'user=' . $this->username . '&pass=' . $this->password;
        $url = "https://" . $this->cpanelHost . ":" . $this->cpanelPort . $this->cpsess . "/json-api/cpanel" .
                "?cpanel_jsonapi_version=2" .
                "&cpanel_jsonapi_func=listpopswithdisk" .
                "&cpanel_jsonapi_module=Email";
        $answer = $this->Request($url, $params);
        $emails = json_decode($answer, true);
        $this->emailArray = $emails["cpanelresult"]["data"];
        return $this->emailArray;
    }

    /**
     * Starts a session on the cPanel server 
     * @access private 
     */
    private function LogIn() {
        $url = 'https://' . $this->cpanelHost . ":" . $this->cpanelPort . "/login/?login_only=1";
        $url .= "&user=" . $this->username . "&pass=" . urlencode($this->password);
        $answer = $this->Request($url);
        $answer = json_decode($answer, true);
        if (isset($answer['status']) && $answer['status'] == 1) {
            $this->cpsess = $answer['security_token'];
            $this->homepage = 'https://' . $this->cpanelHost . ":" . $this->cpanelPort . $answer['redirect'];
        }
    }

    /**
     * Makes an HTTP request 
     * @access private 
     */
    private function Request($url, $params = array()) {
        if ($this->logcurl) {
            $curl_log = fopen($this->curlfile, 'a+');
        }
        if (!file_exists($this->cookiefile)) {
            try {
                fopen($this->cookiefile, "w");
            } catch (Exception $ex) {
                if (!file_exists($this->cookiefile)) {
                    echo $ex . 'Cookie file missing.';
                    exit;
                }
            }
        } else if (!is_writable($this->cookiefile)) {
            echo 'Cookie file not writable.';
            exit;
        }
        $ch = curl_init();
        $curlOpts = array(
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_COOKIEJAR => realpath($this->cookiefile),
            CURLOPT_COOKIEFILE => realpath($this->cookiefile),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => array(
                "Host: " . $this->cpanelHost,
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language: en-US,en;q=0.5",
                "Accept-Encoding: gzip, deflate",
                "Connection: keep-alive",
                "Content-Type: application/x-www-form-urlencoded")
        );
        if (!empty($params)) {
            $curlOpts[CURLOPT_POST] = true;
            $curlOpts[CURLOPT_POSTFIELDS] = $params;
        }
        if ($this->logcurl) {
            $curlOpts[CURLOPT_STDERR] = $curl_log;
            $curlOpts[CURLOPT_FAILONERROR] = false;
            $curlOpts[CURLOPT_VERBOSE] = true;
        }
        curl_setopt_array($ch, $curlOpts);
        $answer = curl_exec($ch);
        if (curl_error($ch)) {
            echo curl_error($ch);
            exit;
        }
        curl_close($ch);
        if ($this->logcurl) {
            fclose($curl_log);
        }
        return (@gzdecode($answer)) ? gzdecode($answer) : $answer;
    }

}
