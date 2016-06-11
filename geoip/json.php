<?php
set_time_limit( 5 );
header('Content-Type: application/json');
if( !isset( $_GET['host'] ) ){
	$_GET['host'] = $_SERVER['REMOTE_ADDR'];
}

$error_message = '';

if( filter_var($_GET['host'], FILTER_VALIDATE_IP) ){
	$type = 'ip';
	$asn = geoip_asnum_by_name_v6( $_GET['host'] );
	$domain = geoip_domain_by_name( $_GET['host'] );
} else {
	$_GET['host'] = gethostbyname( $_GET['host'] );
	$type = 'domain';
	if( filter_var($_GET['host'], FILTER_VALIDATE_IP) ){
		$asn = geoip_asnum_by_name_v6( $_GET['host'] );
		$domain = geoip_domain_by_name( $_GET['host'] );
	} else {
		$asn = false;
		$error_message = ' Cannot resolve host name.';
		$domain = '';
		$_GET['host'] = '';
	}
}
if( $asn ) {
	$data = [
		'status' => 'success',
		'description' => 'Address successfully found.',
		'type' => $type,
		'record' => geoip_record_by_name_v6( $_GET['host'] ),
		'domain' => $domain,
		'asn' => $asn,
		'ip' => $_GET['host'],
	];
} else {
	$data = [
		'status' => 'error',
		'description' => 'Address cannot be found in the database.'.$error_message,
		'type' => $type,
		'domain' => $domain,
		'ip' => $_GET['host'],
	];
}

echo json_encode( $data );