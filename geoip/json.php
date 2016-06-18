<?php
set_time_limit( 5 );
header('Content-Type: application/json');
if( !isset( $_GET['host'] ) ){
	exit('{"status":"error","description":"Undefined host name."}');
}

$error_message = '';

if( filter_var($_GET['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ){
	$fetch = apcu_fetch($_GET['host']);
	if($fetch){
		exit( json_encode( $data ) );
	}
	$type = 'ipv4';
	$asn = geoip_asnum_by_name( $_GET['host'] );
	$domain = gethostbyaddr( $_GET['host'] );
} elseif ( filter_var($_GET['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
	$fetch = apcu_fetch($_GET['host']);
	if($fetch){
		exit( json_encode( $fetch ) );
	}
	$type = 'ipv6';
	$asn = false;
	$error_message = ' Cannot use IPv6 at this time.';
	$domain = gethostbyaddr( $_GET['host'] );
} else {
	$fetch = apcu_fetch($_GET['host']);
	if($fetch){
		$fetch = apcu_fetch($fetch);
		exit( json_encode( $fetch ) );
	}
	$_GET['host'] = gethostbyname( $_GET['host'] );
	$type = 'domain';
	if( filter_var($_GET['host'], FILTER_VALIDATE_IP) ){
		$asn = geoip_asnum_by_name( $_GET['host'] );
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
		'record' => geoip_record_by_name( $_GET['host'] ),
		'domain' => $domain,
		'asn' => $asn,
		'ip' => $_GET['host'],
	];
	apcu_store($_GET['host'], $data, 3600);
	apcu_store($domain, $_GET['host'], 3600);
} else {
	$data = [
		'status' => 'error',
		'description' => 'Address cannot be found in the database.'.$error_message,
		'type' => $type,
		'domain' => $domain,
		'ip' => $_GET['host'],
	];
	header('Cache-Control: public, max-age=60');
}

echo json_encode( $data );