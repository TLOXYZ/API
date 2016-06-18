<?php
header('Cache-Control: no-cache');
$data = '';
$data = json_decode(base64_decode($_GET['data']), true);
function redirect($url){
	if( substr( $url,0,13 ) == 'no-referer://' ){
		$url2 = substr($url,13);
		echo <<<HTML
<!DOCTYPE html>
<meta charset=utf-8>
<title>Redirecting...</title>
<h1>Redirecting...</h1>

<script>
var URL = "{$url2}";

function lose_in_webkit(url) {
	location = "data:text/html,\<script>location='" + url + "'\</scr"+"ipt>";
	return false;
}

function lose_in_ie(url) {
	window.open(url);
}

function lose_in_ff(url) {
	location = 'data:text/html,\<html>\<meta http-equiv="refresh" content="0; url='+ url + '">\</html>';
}

function post_and_lose(url) {
	location = 'data:text/html,\<html>\<meta http-equiv="refresh" content="0; url=data:text/html,\<form id=f method=post action=\''+url+'\'>\</form>\<script>document.getElementById(\'f\').submit()\</scri'+'pt>">\</html>';
}

if(navigator.userAgent.indexOf("Chrome") != -1 ) 
{
	lose_in_webkit(URL);
}

else if(navigator.userAgent.indexOf("Opera") != -1 )
{
	lose_in_webkit(URL);
}
else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
{
	lose_in_ff(URL);
}
else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
{
	lose_in_ie(URL); 
}
else 
{
	lose_in_webkit(URL);
}
</script>
HTML;
	} else {
		header('HTTP/1.1 302 Moved Temporarily');
		header('Location: '.$url);
	}
}
if( isset($data[ 'default' ]) ) {
	if( isset( $data[ $_SERVER['GEOIP_COUNTRY_CODE'] ] ) ) {
		if( isset( $data[ $_SERVER['GEOIP_COUNTRY_CODE'] ]['default'] ) && isset( $data[ $_SERVER['GEOIP_COUNTRY_CODE'] ]['mobile'] ) ) {
			if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4))){
				redirect($data[ $_SERVER['GEOIP_COUNTRY_CODE'] ]['mobile']);
			} else {
				redirect($data[ $_SERVER['GEOIP_COUNTRY_CODE'] ]['default']);
			}
		} else {
			redirect($data[ $_SERVER['GEOIP_COUNTRY_CODE'] ]);
		}
	} else {
		redirect($data[ 'default' ]);
	}
} else {
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
