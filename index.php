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
  <div style="text-align:center">
  <h1>Sistema di tracciamento posizione geografica dei client HTTP collegati</h1> 
  </div>

		<label>Refresh
		<select id="tt">
		<? for($t=2;$t<=10;$t++): ?>
		<option value="<?=$t?>"><?=$t?></option>
		<? endfor; ?>
		</select> s </label>&nbsp;
		
	  <div id="map_wrap">
    	<div id="loader">&nbsp;</div>
      	<div id="map"></div>
	  	<div id="coords"></div>
	  	<div id="status"></div>
	  </div>
	  <div id="log_wrap">
	  	<h4> Dati dell'ultimo punto selezionato: </h4>
	  	<div id="dati"></div>	
      	<h4> Debug:</h4>
	  	<div id="log"></div>  
	  </div>
	  <div style="clear:both"></div>
	  </div>
  	  <div style="clear:both">&nbsp;</div>
  	  <div style="font-size:small;text-align:center">powered by Stefano Cudini<br /><br /></div>

		<script src="../openlayers/OpenLayers.js"></script>
		<script src="../../jquery-1.4.2.min.js"></script>
		<script src="clients.devel.js" ></script>  	  
  </body>
</html>

