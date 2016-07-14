<?php
header('Cache-Control: no-cache');
header("Content-type: application/json");
require_once( '../geoipfix.php' );

$data['country'] = $_SERVER['GEOIP_COUNTRY_CODE'];

if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
	$data['ip'] = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // For our CDN, user can fake this header.
} else {
	$data['ip'] = $_SERVER['REMOTE_ADDR'];
}

echo json_encode($data);
