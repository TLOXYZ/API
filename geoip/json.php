<?php
set_time_limit( 5 );
header('Content-Type: application/json');
if( !isset( $_GET['host'] ) ){
	$_GET['host'] = $_SERVER['REMOTE_ADDR'];
}
if( !filter_var($_GET['host'], FILTER_VALIDATE_IP) ){
	$_GET['host'] = gethostbyname( $_GET['host'] );
	$type = 'domain';
} else {
	$type = 'IP';
}
$asn = geoip_org_by_name( $_GET['host'] ); // I had rename `GeoLiteASNum.dat` to `GeoIPOrg.dat`, so `geoip_org_by_name` is used to get ASN.
if( $geoip_data === false ) {
	$data = [
		'status' => 'error',
		'description' => 'Address cannot be found in the database.',
		'type' => $type,
		'ip' => $_GET['host'],
	];
} else {
	$data = [
		'status' => 'success',
		'description' => 'Address successfully found.',
		'record' => geoip_record_by_name( $_GET['host'] ),
		'domain' => geoip_domain_by_name( $_GET['host'] ),
		'ip' => $_GET['host'],
	];
}

echo json_encode( $data );