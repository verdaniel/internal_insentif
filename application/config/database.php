<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => 'localhost',
// 	'username' => 'root',
// 	'password' => '',
// 	'database' => 'tes',
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '10.20.20.72',
	'username' => 'kioson_cview',
	'password' => 'kioson@123',
	'database' => 'ipay',
	'dbdriver' => 'mysqli',
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

$db['login'] = array(
	'dsn'	=> '',
	'hostname' => '10.20.20.70',
	'username' => 'internal_insentif',
	'password' => 'Z1uH5VqyWXk2yfg6',
	'database' => 'internal_insentif',
	'dbdriver' => 'mysqli',
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