<?
/*
Configurazione del modulo mod_status di apache2
/etc/apache2/mod-enabled/status.conf:

	<IfModule mod_status.c>
	ExtendedStatus On
	<Location /server-status>
		SetHandler server-status
		Order deny,allow
		Deny from all
		Allow from 127.0.0.1
	</Location>
	</IfModule>

*/

$domains = array('easyblog.it', 'stefanorossini.it', 'ryuzan.it');
$defaultdom = $domains[1];
$KEY = 'ac735b1e635d4ec5b0ba271b287eb42c2161eabfbbc53894cb6ea642c210befd';
//chiave api.ipinfodb.com 
$myip = '91.121.205.105';	//ip del server locale
$dircache = './cache/';	//directory di cache per le richieste a ipinfodb.com
$urlstatus = "http://127.0.0.1/server-status";
//indirizzo di mod_status di apache

$modes = array('_'=>'Waiting for Connection', 'S'=>'Starting up', 'R'=>'Reading Request',
				'W'=>'Sending Reply', 'K'=>'Keepalive (read)', 'D'=>'DNS Lookup',
				'C'=>'Closing connection', 'L'=>'Logging', 'G'=>'Gracefully finishing',
				'I'=>'Idle cleanup of worker', '.'=>'Open slot with no current process');
$modes_short = array('_'=>'wait','S'=>'start','R'=>'read','W'=>'reply','K'=>'keepalive','D'=>'dns',
			   'C'=>'close','L'=>'log','G'=>'grace','I'=>'clean','.'=>'open');

require_once('../../simplehtmldom/simple_html_dom.php');

function get($url,$host,$post=null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
#    curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
#    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
    curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE, 9578);
    curl_setopt($ch, CURLOPT_MAX_SEND_SPEED_LARGE, 9578);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $host"));
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

function json_indent($json) {
 
    $result    = '';
    $pos       = 0;
    $strLen    = strlen($json);
    $indentStr = '  ';
    $newLine   = "\n";
 
    for($i = 0; $i <= $strLen; $i++) {
        
        // Grab the next character in the string
        $char = substr($json, $i, 1);
        
        // If this character is the end of an element, 
        // output a new line and indent the next line
        if($char == '}' || $char == ']') {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        // Add the character to the result string
        $result .= $char;
 
        // If the last character was the beginning of an element, 
        // output a new line and indent the next line
        if ($char == ',' || $char == '{' || $char == '[') {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
    }
 
    return $result;
}

?>
