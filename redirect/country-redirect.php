<?php
header('Cache-Control: no-cache');
require_once( '../geoipfix.php' );

if( isset( $_GET['default'] ) ) {
	header('HTTP/1.1 302 Moved Temporarily');
	if( isset( $_GET[ $_SERVER['GEOIP_COUNTRY_CODE'] ] ) ) {
		header('Location: '.$_GET[ $_SERVER['GEOIP_COUNTRY_CODE'] ]);
	}
	else {
		header('Location: '.$_GET['default']);
	}
}
else {
	header('HTTP/1.1 400 Bad Request');
	echo <<<HTML
<html>
<head><title>400 Bad Request</title></head>
<body bgcolor="white">
<center><h1>400 Bad Request</h1></center>
<hr><center>apiTLO</center>
</body>
</html>
HTML;
}

