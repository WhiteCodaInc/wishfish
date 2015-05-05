<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;
# Instantiate the client.
$mgClient = new Mailgun('key-acfdb718a88968c616bcea83e1020909');

# Issue the call to the client.
$result = $mgClient->post("lists", array(
    'address'     => 'mikhail@mg.mikhailkuznetsov.com',
    'description' => 'Mailgun Dev List'
));
