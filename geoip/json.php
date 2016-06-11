<?php
set_time_limit( 5 );
if( !isset( $_GET['host'] ) ){
	$_GET['host'] = $_SERVER['REMOTE_ADDR'];
}
$geoip_data = geoip_record_by_name( $_GET['host'] );
$geoip_data['org'] = geoip_org_by_name( $_GET['host'] );
echo json_encode( $geoip_data );