<?
#$xml = simplexml_load_file("http://127.0.0.1/server-status");
#$xml = file_get_contents("http://127.0.0.1/server-status");
#var_dump($xml);
#$tables = $xml->xpath("/html/body/table/tr/td");
#print_r($tables);

include('../../simplehtmldom/simple_html_dom.php');
$html = file_get_html("http://127.0.0.1/server-status");
#$html = file_get_html("http://127.0.0.1/server-status.html");
$modes = array('_'=>'wait','S'=>'start','R'=>'read','W'=>'reply','K'=>'keepalive','D'=>'dns',
			   'C'=>'close','L'=>'log','G'=>'grace','I'=>'clean','.'=>'open');
/* Modes
"_" Waiting for Connection, "S" Starting up, "R" Reading Request,
"W" Sending Reply, "K" Keepalive (read), "D" DNS Lookup,
"C" Closing connection, "L" Logging, "G" Gracefully finishing,
"I" Idle cleanup of worker, "." Open slot with no current process */

$tab = $html->find('table',0);
$trs = $tab->find('tr');
$ips=array();
foreach($trs as $tr)
{
	if(!$tr->find('td')) continue;//se non ci sono td nel tr
	$ip = $tr->find('td',-3)->innertext;
	$req = $tr->find('td',-1)->innertext;
	$vhost = $tr->find('td',-2)->innertext;
	$mode = $tr->find('td',3)->innertext;
	if($ip!='127.0.0.1' and $ip!='?' and $ip!=$_SERVER['REMOTE_ADDR'])
		$ips[$vhost][]= array($ip,$req);
}
if( basename(__FILE__)==basename($_SERVER['PHP_SELF']) )
{
	foreach($ips as $dom=>$P)
	{
		echo $dom."<br>";
		foreach($P as $p)
			echo implode(' ',$p).'<br />';
		echo "<hr>";
	}
}
?>
