<?php
if($_SERVER["SERVER_ADMIN"] == 'saesupport@sina.cn'){
	$_SERVER['GEOIP_COUNTRY_CODE'] = 'CN';
	$_SERVER["REAL_IP"] = $_SERVER["HTTP_X_REAL_IP"];
	header('X-Tlo-Hostname: bj-server.tlo.xyz');
} elseif( isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
	$_SERVER["REAL_IP"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
	$_SERVER['GEOIP_COUNTRY_CODE'] = $_SERVER['HTTP_CF_IPCOUNTRY'];
}
