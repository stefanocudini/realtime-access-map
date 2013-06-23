<?

require_once('config.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>Traccia Posizione Geografica Accessi</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <style type="text/css">
		@import url('clients.css');
    </style>
  </head>
  <body>
	  	<h1>Tracciamento posizione geografica degli accessi</h1> 

	<div id="tool">
	<?
	$DOM = (isset($_SERVER['QUERY_STRING']) and !empty($_SERVER['QUERY_STRING'])) ? trim($_SERVER['QUERY_STRING']) : false;
	if($DOM and in_array($DOM,$domains) ):
	?>
		<input id="dom" type="text" value="<?=$DOM?>" disabled="disabled" />
	<?
	else:
	?>
		<select id="dom">
 		<?php foreach($domains as $dom): ?>
			<option value="<?=$dom?>"><?=$dom?></option>
		<?php endforeach; ?>
		</select>
	<?
	endif;
	?>
		&nbsp;
		<label><input id="loop" type="checkbox" />Aggiorna ogni</label>
		<label><select id="tt">
		<?php for($t=15;$t<=60;$t+=5): ?>
		<option value="<?=$t*1000?>"><?=$t?></option>
		<?php endfor; ?>
		</select> s &nbsp;</label>
		<input id="zoomall" type="button" value="Zoom tutto" />
		<div id="loader"><img src="loading.gif" /> updating...</div>	
	</div>
	<div id="map_wrap">
		<div id="map"></div>	
		<div id="coords"></div>
		<!--div id="status"></div-->
		<div id="dati"><div></div><a href="#" class="x">&times;</a></div>
	</div>
	
	<div id="log_wrap">
	<h4> Lista:</h4>
	<div id="log"></div>
	</div>

	<a href="https://github.com/stefanocudini/realtime-access-map"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png" alt="Fork me on GitHub"></a>
	
	<div id="copy">powered by Stefano Cudini</div>

	<script src="../openlayers/OpenLayers.js"></script>
	<script src="/js/jquery-1.4.2.min.js"></script>
	<script src="clients.devel.js" ></script>  	  
	
	<script src="/labs-common.js"></script>
  
  </body>
</html>

