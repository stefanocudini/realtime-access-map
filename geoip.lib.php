<?php

function geoip($ip, $array=false)
{
	$dircache = './geoipcache/';
	//directory di cache per le richieste a ipinfodb.com

	$KEY = trim(file_get_contents('api.ipinfodb.com.key'));
	//file con dentro la chiave api.ipinfodb.com

	if(empty($ip)) return '';

	$hostinfo = 'api.ipinfodb.com';
	$urlinfo = 'http://67.212.77.12/v2/ip_query.php?key='.$KEY.'&output=json&timezone=&ip='.trim($ip);

	if(file_exists($dircache.$ip))
		$info = file_get_contents($dircache.$ip);
	else{
		$info = geoip_get($urlinfo, $hostinfo);
		file_put_contents($dircache.$ip, $info);
		chmod($dircache.$ip, 0775);
	}

	return $array ? json_decode(trim($info),true) : $info;
}

function geoip_get($url, $host, $post=null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $host"));
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');#$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $error = curl_error($ch);
    curl_close($ch);
    return $data;
}

?>
