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

require_once('easyblog/geoip.lib.php');
//definisce la funzione geoip()

require_once('simple_html_dom.php');
//parser html

$domains = file('domains.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//domini dei virtual hosts

$defaultdom = $domains[0];
//dominio visualizzato di default

$myip = $_SERVER['SERVER_ADDR'];
//ip del server locale per escluderlo dagli accessi

$urlstatus = "http://127.0.0.1/server-status";
//indirizzo di mod_status di apache

$modes = array('_'=>'Waiting for Connection', 'S'=>'Starting up', 'R'=>'Reading Request',
			   'W'=>'Sending Reply', 'K'=>'Keepalive (read)', 'D'=>'DNS Lookup',
			   'C'=>'Closing connection', 'L'=>'Logging', 'G'=>'Gracefully finishing',
			   'I'=>'Idle cleanup of worker', '.'=>'Open slot with no current process');
				
$modes_short = array('_'=>'wait','S'=>'start','R'=>'read','W'=>'reply','K'=>'keepalive','D'=>'dns',
			         'C'=>'close','L'=>'log','G'=>'grace','I'=>'clean','.'=>'open');

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
