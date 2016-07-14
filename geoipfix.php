<?php
if($_SERVER["SERVER_ADMIN"] == 'saesupport@sina.cn'){
	$_SERVER['GEOIP_COUNTRY_CODE'] = 'CN';
	$_SERVER["REAL_IP"] = $_SERVER["HTTP_X_REAL_IP"];
}
