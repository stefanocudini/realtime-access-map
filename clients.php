<?
#$xml = simplexml_load_file("http://127.0.0.1/server-status");
#$xml = file_get_contents("http://127.0.0.1/server-status");
#var_dump($xml);
#$tables = $xml->xpath("/html/body/table/tr/td");
#print_r($tables);

require_once('config.php');

$html = file_get_html($urlstatus);
#$html = file_get_html("http://127.0.0.1/server-status.html");


$tab = $html->find('table',0);
if($tab)
{
	$trs = $tab->find('tr');
	$ips = array();
	foreach($trs as $tr)
	{
		if(!$tr->find('td')) continue;//se non ci sono td nel tr
		$ip = $tr->find('td',-3)->innertext;
		$req = $tr->find('td',-1)->innertext;
		$vhost = $tr->find('td',-2)->innertext;
		$mode = trim($tr->find('td',3)->plaintext);
		if($ip!='127.0.0.1' and $ip!=$myip and $ip!='?' and $ip!=$_SERVER['REMOTE_ADDR'])
			$ips[$vhost][]= array($ip, $req, $mode);
	}

	if( basename(__FILE__) == basename($_SERVER['PHP_SELF']) )	//utilizzo standalone di clients.php
	{
		foreach($ips as $dom=>$P)
		{
			echo $dom."<br>";
			foreach($P as $p)
				echo implode(' ',$p).'<br />';
			echo "<hr>";
		}//*/
	echo $html;
	}
}
?>
