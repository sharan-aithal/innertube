<?php

function getcurl($device){
$headers = array();

$ch = curl_init();

if($device=='mobile'){
	$headers[] ='User-Agent: Mozilla/5.0 (Linux; U; Android 8.1.0; en-gb; Redmi Y2 Build/OPM1.171019.011) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.128 Mobile Safari/537.36 XiaoMi/MiuiBrowser/10.4.3-g';
	$url =  'https://m.youtube.com/';
	$pattern = '/\"LINK_API_KEY\"\:\"(.*?)\"/';
	}
else	{
	$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/75.0.3770.90 Chrome/75.0.3770.90 Safari/537.36';
	$url = 'https://www.youtube.com/';
	$pattern = '/window.ytcfg.set\(\'LINK_API_KEY\'\, \"(.*?)\"\)\;/';
}

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers[] = 'Dnt: 1';
//$headers[] = 'User-Agent: Mozilla/5.0 (Linux; U; Android 8.1.0; en-gb; Redmi Y2 Build/OPM1.171019.011) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.128 Mobile Safari/537.36 XiaoMi/MiuiBrowser/10.4.3-g';
//$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/75.0.3770.90 Chrome/75.0.3770.90 Safari/537.36';
$headers[] = 'X-Spf-Referer: https://www.youtube.com/';
$headers[] = 'X-Youtube-Client-Name: 1';
$headers[] = 'X-Spf-Previous: https://www.youtube.com/';
$headers[] = 'Referer: https://m.youtube.com/';
$headers[] = 'X-Youtube-Client-Version: 2.20190823.03.00';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

//return $result;
//print_r($result);


$input = $result;

preg_match($pattern,$input,$output);

print_r($output[1]);

}

 getcurl('mobile');
//$pattern = '/window.ytcfg.set\(\'LINK_API_KEY\'\, \"(.*?)\"\)\;/';
//$patt = '/\"LINK_API_KEY\"\:\"(.*?)\"/';	// phone
//preg_match($patt,$input,$output);

/*
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Content-type: application/json");
header("X-Content-type: application/json");
header("X-Youtube-Client-Version: ");

//print_r($output[1]);
//print_r($input);
*/

?>
