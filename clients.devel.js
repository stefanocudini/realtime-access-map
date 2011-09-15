$(function() {

	var lon = 234827.002046, lat =4461518.840733,	//centro del mondo
		zoom = 1,
		TT = 10000,
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

	mapOL.setCenter( new OpenLayers.LonLat(lon, lat) ,zoom );  //centro iniziale

	for(c in mapOL.controls)
		if(mapOL.controls[c].CLASS_NAME=="OpenLayers.Control.Attribution")
			mapOL.controls[c].destroy();
/////uso di strategies
	var style = new OpenLayers.Style({
		pointRadius: "${radius}",
		fillColor: "#ffcc66",
        label: "${count}",
        labelAlign: "${right}",
        labelXOffset: "15",
        labelYOffset: "15",
		fillOpacity: 0.8,
		strokeColor: "#cc6633",
		strokeWidth: 2,
		strokeOpacity: 0.8
	}, {
		context: {
		    radius: function(feature) {
		        return Math.min(feature.attributes.count, 7) + 5;
		    }
		}
	});
	
	var clientsLayer = new OpenLayers.Layer.Vector("Clients", {
		strategies: [
		    new OpenLayers.Strategy.Fixed(),
		    new OpenLayers.Strategy.Cluster()
		],
		protocol: new OpenLayers.Protocol.HTTP({
		    url: "coords2geojson.php",
		    params: {d: $('#dom').val()},
		    format: new OpenLayers.Format.GeoJSON({internalProjection: mercator, externalProjection: wgs84})
		}),
		styleMap: new OpenLayers.StyleMap({
		    "default": style,
		    "select": {
		        fillColor: "#ff0000",
		        strokeColor: "#aa0000"
		    }
		})
	});
	clientsLayer.events.on({
		refresh: function() {
			$('#loader').show();
		},
		featuresadded: function() {
			$('#loader').hide();
		}
	});//*/
	
	mapOL.addLayers([clientsLayer]);

	function onPointSelect(feature)  //evento onselect feature, del layer di selezione
	{
		var content=[];
		
		for(c in feature.cluster)
		{		
			var cont, attrs = feature.cluster[c].attributes;
			cont =  '<b>Ip:</b>'+ attrs.ip +', <b>City:</b> '+ attrs.city +'<br>'+
					'<b>Pagine:</b><br>'+ attrs.url.join('<br>');
			
			content.push(cont);
		}	
		$('#dati').show().children('div').html(content.join('<hr>'));
	}
	/*function onPointUnSelect(feature) {  //evento onselect feature, del layer di selezione
		setTimeout(function(){ $('#dati').fadeOut(); },3000);
	}//*/
	var pointSelect = new OpenLayers.Control.SelectFeature([clientsLayer], {hover:true, onSelect: onPointSelect });//, onUnselect:onPointUnSelect });
	mapOL.addControl(pointSelect);
	pointSelect.activate();

	function getClients() {
		$('#dati').hide();
		clientsLayer.removeAllFeatures();
	    clientsLayer.protocol.abort();
	    clientsLayer.protocol.params.d= $('#dom').val();
		clientsLayer.refresh();
	}
	
	function loopClients() {	//eseguito al click e moveend su openlayers

		if(loop)
			getClients();

		setTimeout(function(){ loopClients(); }, TT);  //loop ricorsivo a intervallo variabile
	}
	
	$('#dom').change(function() {
		getClients();
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
		mapOL.zoomToExtent( clientsLayer.getDataExtent() );
	});
	
	$('#dati .x').click(function(e) {
		$(this).parent().fadeOut();
		return false;
	});
	

	loopClients();
	
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

