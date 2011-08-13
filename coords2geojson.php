<?
header("Content-type: text/plain");

require('clients.php');
//inizializza $ips

$dominio = isset($_GET['d']) ? trim($_GET['d']) : 'easyblog.it';

#$url = "http://api.ipinfodb.com/v2/ip_query.php?key=$KEY&output=json&timezone=&ip=";
//se si fanno troppe richieste errate con questo url api.ipinfodb.com il dns diventa irragiungibile, ma l'ip e' sempre valido!

$hostinfo = 'api.ipinfodb.com';
$urlinfo = "http://67.212.77.12/v2/ip_query.php?key=$KEY&output=json&timezone=&ip=";

#echo "point	title	description	iconSize	iconOffset	icon\r\n";
$hosts = array();
$hosts['type']= "FeatureCollection";
foreach($ips[$dominio] as $p)
{
	$ip = $p[0];
	$r = explode(' ', $p[1]);
	$u = parse_url($r[1]);
	$url = stripslashes($u['path']);
	$J = json_decode( get($urlinfo.$ip,$hostinfo), true);
	$city = $J['City'];
	$lonlat = array( (float)$J['Longitude'], (float)$J['Latitude'] );
	#$mode = $p[3];
/*	$F['type']= "Feature";
	$F['geometry']= array('type'=>'Point', 'coordinates'=>array((float)$J['Longitude'], (float)$J['Latitude']));
	$F['properties']= array('ip'=>$ip, 'city'=>$J['City'], 'url'=>$url);
	$hosts['features'][]= $F;
	//ogni url una feature!!
}//*/
	$IPS[$ip]['type']= 'Feature';
	$IPS[$ip]['geometry']= array('type'=>'Point',
						  'coordinates'=>$lonlat);
	$IPS[$ip]['properties']['ip']= $ip;
	$IPS[$ip]['properties']['city']= $city;
	$IPS[$ip]['properties']['url'][]= $url;
#	$IPS[$ip]=$F;
}
foreach($IPS as $IP)
	$hosts['features'][]= $IP;//*/
	
echo json_indent( stripslashes(json_encode($hosts)) );
#echo stripslashes(json_encode($hosts));#, JSON_FORCE_OBJECT);

?>