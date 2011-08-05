<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>Traccia Posizione Client HTTP</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <style type="text/css">
		@import url('clients.css');
    </style>
  </head>
  <body>
	  	<h1>Tracciamento posizione geografica dei client HTTP collegati</h1> 

	<div id="tool">
			<select id="dom">
				<option value="ryuzan.it">ryuzan.it</option>
				<option value="easyblog.it" selected="selected">easyblog.it</option>
				<option value="stefanorossini.it">stefanorossini.it</option>
			</select>
		<label><input id="loop" type="checkbox" />Refresh</label>
		<label><select id="tt">
		<? for($t=0;$t<=20;$t++): ?>
		<option value="<?=$t*1000?>"><?=$t?></option>
		<? endfor; ?>
		</select> s &nbsp;</label>
		<input id="zoomall" type="button" value="Zoom tutto" />
		<div id="loader">&nbsp;</div>	
	</div>
	<div id="map_wrap">
		<div id="map"></div>	
		<div id="coords"></div>
		<!--div id="status"></div-->
		<div id="dati"><div></div></div>
	</div>
	
	<div id="log_wrap">	
	<h4> Lista:</h4>
	<div id="log"></div>  
	</div>
	
	<div id="copy">powered by Stefano Cudini</div>

	<script src="../openlayers/OpenLayers.js"></script>
	<script src="../../jquery-1.4.2.min.js"></script>
	<script src="clients.devel.js" ></script>  	  
  </body>
</html>

