<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of my_Router
 *
 * @author Laxmisoft
 */
class My_router extends CI_Router {

    //put your code here
    /**
     * Set the route mapping
     *
     * This function supports a directory in the controller_trigger string
     *
     * @access    private
     * @return    void
     */
    function _set_routing() {
        // Are query strings enabled in the config file?
        // If so, we're done since segment based URIs are not used with query strings.
        if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')])) {
            $controller = explode('/', $_GET[$this->config->item('controller_trigger')]);
            if (count($controller) == 1) {
                $this->set_class(trim($this->uri->_filter_uri($controller[0])));
            } else {
                $this->set_directory(trim($this->uri->_filter_uri($controller[0])));
                $this->set_class(trim($this->uri->_filter_uri($controller[1])));
            }

            if (isset($_GET[$this->config->item('function_trigger')])) {
                $this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
            }

            return;
        } else {
            return parent::_set_routing();
        }
    }

    /* End of file MY_Router.php */
    /* Location: ./application/libraries/MY_Router.php */
}
