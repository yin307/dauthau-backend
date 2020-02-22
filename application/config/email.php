<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
                'mailInfo'=>array(
                    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 587,
                    'smtp_user' => 'mail.muasamcong@gmail.com',
                    'smtp_pass' => 'hchdexogutacmzms',
                    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
                    'mailtype' => 'text', //plaintext 'text' mails or 'html'
                    'smtp_timeout' => '4', //in seconds
                    'charset' => "UTF-8",
                    'wordwrap' => TRUE
                      )
                );
