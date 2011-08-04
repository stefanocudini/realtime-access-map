<?

require('clients.php');

$hosts = array();
foreach($ips as $p)
{
	$addr = $p[0];
	$req = $p[1];
	$o=null;	//exec aggiunge ad $o
	exec("geoip $addr",$o);
	$loc = explode(' ',implode('',$o));
	$hosts[]= array($addr,(float)$loc[1],(float)$loc[0]);
}
echo json_encode($hosts);#, JSON_FORCE_OBJECT);

?>
