$(function() {

	var lon = 12.451196, lat = 42.374583,  //casa
		lon = 234827.002046, lat =4461518.840733,	//centro mondo
		zoom = 1,
		TT = 4000,
		loop = false,
		firstloop = true;
	var map$ = $('#map'), 
		mapOL;
	var wgs84 = new OpenLayers.Projection("EPSG:4326"),
		mercator = new OpenLayers.Projection("EPSG:900913");

	mapOL = new OpenLayers.Map({
		div: "map",
		//allOverlays: true,
		projection: mercator,
		displayProjection: wgs84
	});
	//mapOL.addControl(new OpenLayers.Control.Navigation());

	var osmLayer = new OpenLayers.Layer.OSM("OpenStreetMap");		
	mapOL.addLayers([osmLayer]);
	var markers = new OpenLayers.Layer.Markers("Clients");
    mapOL.addLayers([markers]);
	
	mapOL.setCenter( new OpenLayers.LonLat(lon, lat) ,zoom );  //centro iniziale

	for(c in mapOL.controls)
		if(mapOL.controls[c].CLASS_NAME=="OpenLayers.Control.Attribution")
			mapOL.controls[c].destroy();
			
	function addClients() {	//eseguito al click e moveend su openlayers

		if(loop || firstloop)
		$.getJSON('coords.php',function(json) {
			markers.clearMarkers();
			for(c in json)
			{
			    var ip = json[c][0];
			    var lonlat = new OpenLayers.LonLat(parseFloat(json[c][1]), parseFloat(json[c][2]));
				var size = new OpenLayers.Size(21,25);
				var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
				var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png',size,offset);
				lonlat = lonlat.transform( wgs84, mapOL.getProjectionObject());
				markers.addMarker(new OpenLayers.Marker(lonlat,icon));
				$('#log').prepend(ip+': '+',');
			}
			$('#log').prepend('<hr>');
		});
		
		setTimeout(function(){ addClients(); }, TT);  //loop ricorsivo a intervallo variabile
	}

	$.ajaxSetup({async:false});

	$('#loader')
	.ajaxStart(function() {
		$(this).html('<img src="loading.gif" /> updating...');
	})
	.ajaxStop(function() {
		$(this).html('&nbsp;');
	});
	
	$('#loop').attr('checked',loop?'checked':false)
	.change(function() {
		loop = $(this).is(':checked');
	});
	
	$('#tt').val(TT)
	.bind('change mousemove',function(e) {
		TT = parseInt($(this).val());
	});
	
	$('#zoomall').click(function(e) {
		mapOL.zoomToExtent( markers.getDataExtent() );//box.transform( wgs84, mapOL.getProjectionObject()));
	});

	addClients();
	firstloop = false;	//start update


});//////////document ready



function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

// implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};

function randcolor() {
  function c() {
    return Math.floor(Math.random()*220+36).toString(16)
  }
  return "#"+c()+c()+c();
}

function print_r(theObj) {
var out = '';
  if(theObj.constructor == Array ||
     theObj.constructor == Object){
    out +="<ul>";
    for(var p in theObj){
      if(theObj[p].constructor == Array||
         theObj[p].constructor == Object){
		out +="<li>["+p+"] => "+typeof(theObj)+"</li>";
        out +="<ul>";
        out +=print_r(theObj[p]);
        out +="</ul>";
      } else {
	out +="<li>["+p+"] => "+theObj[p]+"</li>";
      }
    }
    out +="</ul>";
  }
  return out;
}

