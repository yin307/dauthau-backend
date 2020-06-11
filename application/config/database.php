<?php
        defined('BASEPATH') OR exit('No direct script access allowed');
        
        $active_group = 'default';
        $query_builder = TRUE;
        // $tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 118.68.169.0)(PORT = 1521))
        // (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = xe)))';118.68.169.0:1521:xe; Acc: msc_dump/112233
        
        //$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 118.68.169.0)(PORT = 1521))
          //          (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = xe)))';
        // $tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 118.68.169.0)(PORT = 1521))
        //             (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = xe)))';
        $tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 14.248.82.173)(PORT = 1521))
                    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = orcl)))';

        $db['default'] = array(
            'dsn'   => '',
            'hostname' => $tnsname,
            'username' => 'MSC_ITO',
            'password' => 'MSC_ITO',
            // 'username' => 'msc_dump',
            // 'password' => '112233',
            'database' => '',
            'dbdriver' => 'oci8',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
    /*
    'hostname' => 'localhost',
    'username' => 'dauthau1',
    'password' => '123PO!@_45678sef34@$!!@!PJG',
    'database' => 'dauthau_pro',
     'dbdriver' => 'mysqli',
     
     
     git.alphawaytech.com
     port : 1521
     username: MSC_ITO
     password : MSC_ITO
     sdi: orcl
    */
