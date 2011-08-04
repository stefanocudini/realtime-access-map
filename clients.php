<?
#$xml = simplexml_load_file("http://127.0.0.1/server-status");
#$xml = file_get_contents("http://127.0.0.1/server-status");
#var_dump($xml);
#$tables = $xml->xpath("/html/body/table/tr/td");
#print_r($tables);

include('../../simplehtmldom/simple_html_dom.php');
$html = file_get_html("http://127.0.0.1/server-status");
#$html = file_get_html("http://127.0.0.1/server-status.html");

$tab = $html->find('table',0);
$trs = $tab->find('tr');
$ips=array();
foreach($trs as $tr)
{
	if(!$tr->find('td')) continue;//se non ci sono td nel tr
	$ip = $tr->find('td',-3)->innertext;
	$req = $tr->find('td',-1)->innertext;
	if($ip!='127.0.0.1' and $ip!=$_SERVER['REMOTE_ADDR'] and $ip!='?') $ips[]= array($ip,$req);
}

if( basename(__FILE__)==basename($_SERVER['PHP_SELF'])) print_r($ips);

?>
