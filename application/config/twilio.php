<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Twilio
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Location:
 *
 * Created:  03.29.2011
 *
 * Description:  Twilio configuration settings.
 *
 *
 */
/**
 * Mode ("sandbox" or "prod")
 * */
$config['mode'] = 'prod';

/**
 * Account SID
 * */
$config['account_sid'] = 'AC26e396626147ca331c571d41f9e126e3';

/**
 * Auth Token
 * */
$config['auth_token'] = '7987438208fc3181db00382db4b3b756';

/**
 * API Version
 * */
$config['api_version'] = '2010-04-01';

/**
 * Twilio Phone Number
 * */
$config['number'] = '';


/* End of file twilio.php */