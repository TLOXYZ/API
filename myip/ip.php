<?php
header('Cache-Control: no-cache');
header('Content-type: text/plain');
require_once( '../geoipfix.php' );

if( isset( $_SERVER["REAL_IP"] ) ){
	$data['ip'] = $_SERVER["REAL_IP"];// For the Beijing datacenter
} elseif( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
	$data['ip'] = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // For our CDN, user can fake this header.
} else {
	$data['ip'] = $_SERVER['REMOTE_ADDR'];
}

echo $data['ip'];
