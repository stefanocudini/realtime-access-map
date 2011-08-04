<?
header("Content-type: text/plain");
require('clients.php');

$KEY = 'ac735b1e635d4ec5b0ba271b287eb42c2161eabfbbc53894cb6ea642c210befd';

#$url = "http://api.ipinfodb.com/v2/ip_query.php?key=$KEY&output=json&timezone=&ip=";
$url = "http://67.212.77.12/v2/ip_query.php?key=$KEY&output=json&timezone=&ip=";

$hosts = array();
foreach($ips as $p)
{
	$addr = $p[0];
	$req = $p[1];
	$j = get($url.$addr);
	$J = json_decode($j,true);
	$hosts[]= array($addr,(float)$J['Longitude'], (float)$J['Latitude']);
}
echo json_encode($hosts);#, JSON_FORCE_OBJECT);

function get($url,$post=null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
#    curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
#    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
    curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE, 9578);
    curl_setopt($ch, CURLOPT_MAX_SEND_SPEED_LARGE, 9578);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: api.ipinfodb.com'));
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');#$_SERVER['HTTP_USER_AGENT']);
    /*curl_setopt($ch, CURLOPT_REFERER, 'http://www.mymovies.it/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Requested-With: XMLHttpRequest') );
    if(isset($post)) {
    $post = is_array($post) ? http_build_query($post) : $post;
    curl_setopt($ch, CURLOPT_POST      ,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }//*/
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $error = curl_error($ch);
    curl_close($ch); 

    return $data;
}

?>
