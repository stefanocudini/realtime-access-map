<?
header("Content-type: text/plain");

require('clients.php');
//inizializza $ips
$dominio = isset($_GET['d']) ? trim($_GET['d']) : $defaultdom;

#echo "point	title	description	iconSize	iconOffset	icon\r\n";
$hosts = array();
$hosts['type']= "FeatureCollection";
$IPS = array();
if($ips[$dominio]):
	foreach($ips[$dominio] as $p)
	{
		$ip = $p[0];
		$r = explode(' ', $p[1]);
		$u = parse_url($r[1]);
		$url = stripslashes($u['path']);

		$J = geoip($ip, true);
		$city = $J['City'];
		$lonlat = array( (float)$J['Longitude'], (float)$J['Latitude'] );
		$mode = $p[2];
		$IPS[$ip]['type']= 'Feature';
		$IPS[$ip]['geometry']= array('type'=>'Point',
							  		 'coordinates'=>$lonlat);
		$IPS[$ip]['properties']['ip']= $ip;
		$IPS[$ip]['properties']['city']= $city;
		$IPS[$ip]['properties']['url'][]= $url.' ('.$modes_short[$mode].')';
	#	$IPS[$ip]=$F;
	}
endif;

$hosts['features']=array();
foreach($IPS as $IP)
	$hosts['features'][]= $IP;//*/
	
#echo json_indent( stripslashes(json_encode($hosts)) );
echo stripslashes(json_encode($hosts));#, JSON_FORCE_OBJECT);

?>
