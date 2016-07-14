<?php
header('Cache-Control: no-cache');
header('Content-type: text/plain');
require_once( '../geoipfix.php' );

echo $_SERVER['GEOIP_COUNTRY_CODE'];
