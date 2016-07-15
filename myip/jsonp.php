<?php
header('Cache-Control: no-cache');
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
require_once( '../geoipfix.php' );

$data['country'] = $_SERVER['GEOIP_COUNTRY_CODE'];

if( isset( $_SERVER["REAL_IP"] ) ){
	$data['ip'] = $_SERVER["HTTP_CLIENT_IP"];// For the Beijing datacenter
} elseif( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
	$data['ip'] = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // For our CDN, user can fake this header.
} else {
	$data['ip'] = $_SERVER['REMOTE_ADDR'];
}

echo $_GET['callback'],"(",json_encode($data),")";
