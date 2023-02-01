var zIndexCount=2000;

function CustomMarker(latlng, map, args, field) {
	this.latlng = latlng;	
	this.args = args;	
	this.setMap(map);
	this.field = field;
}

function infoMaker (field) {	
		var type;
		switch (field.type) {
			case "apartment":
				type = "آپارتمان";
				break;
				
			case "villa":
				type = "ویلا";
				break;
				
			case "room":
				type = "سوئیت";
				break;
		}
		
		var roomCount = field.rooms;
		if(field.rooms == 0)
			roomCount = "بدون";
		
		var txt = '<div id="map-location-info" class="google-map-marker">';
		txt += '<a href="/houses/show/'+field.id+'" target="_blank" style="text-decoration: none">';
		txt += '<div class="map-location-info-img-container">';
		txt += '<img src="/'+field.image+'">';
		txt += '</div>';
		txt += '<div class="map-location-info-text-container">';
		txt += '<div>'+field.title+'</div>';
		txt += '<div>';
		txt += '<span> '+field.province+' </span>';
		txt += '&minus;';
		txt += '<span> '+field.city+' </span>';
		txt += '</div>';
		txt += '<div>';
		txt += '<span>';
		txt += '<span> '+type+' </span>';
		txt += '<span style="opacity: 0.6"> | </span>';
		txt += digitsToHindi(roomCount);
		txt += '<span>  اتاق </span>';
		txt += '<span style="opacity: 0.5"> | </span>';
		txt += 'تا';
		txt += digitsToHindi(field.max_accommodates);
		txt += '<span>  نفر </span>';
		txt += '</span>';	
		txt += '<span style="float: left">';
		// txt += '<span> ۲۴ </span><span> رزرو </span>';
		txt += '&nbsp;&nbsp;';
		txt += '<span style="color: #008489">';
		txt += '<i class="fa fa-star"></i>';
		txt += '<i class="fa fa-star"></i>';
		txt += '<i class="fa fa-star"></i>';
		txt += '<i class="fa fa-star star-0"></i>';
		txt += '<i class="fa fa-star star-0"></i>';
		txt += '</span>';
		txt += '</span>';
		txt += '</div>';
		txt += '<div>';
		txt += '</a>';
		txt += '<div>';
		
		return txt;
}
CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function() {
	
	var self = this;
	var div = this.div;
	//var zIndexItem = this.style.zIndex;
	if (!div) {
	
		div = this.div = document.createElement('div');
		
		div.className = 'map-tooltip';
		div.id = this.field.id+"Marker";
		div.style.zIndex = this.field.id;
		var zIndexItem = div.style.zIndex;
		div.innerHTML = 'از '+ digitsToHindi(this.field.min_price) + 'ه.ت' + infoMaker(this.field);
		
		if (typeof(self.args.marker_id) !== 'undefined') {
			div.dataset.marker_id = self.args.marker_id;
		}
		
		google.maps.event.addDomListener(window, "click", function(event) {
			$(".map-tooltip").css("visibility" , "visible");
			$(".google-map-marker").css("visibility" , "hidden");
			div.style.zIndex = zIndexItem;
		});
		
		google.maps.event.addDomListener(div, "click", function(event) {
			event.stopPropagation();
			console.log(div.style.zIndex);
			$(".map-tooltip").css("visibility" , "visible");
			$(".google-map-marker").css("visibility" , "hidden");
			
			div.style.visibility = 'hidden';
			div.style.color = "rgba(85,85,85,0.5)";
			div.childNodes[1].style.visibility = "visible";
			$(".map-tooltip").css("z-index" , "300 !important");
			this.style.zIndex = zIndexCount++;
			
			google.maps.event.trigger(self, "click");
		});
		
		
		
		var panes = this.getPanes();
		console.log('Adding marker to map');
		panes.overlayImage.appendChild(div);
	}
	else {
		console.log('Adding marker to map failed.');
	}
	
	var point = this.getProjection().fromLatLngToDivPixel(this.latlng);

	
	if (point) {
		div.style.left = (point.x - 33) + 'px';
		div.style.top = (point.y - 36) + 'px';
	}
};

CustomMarker.prototype.remove = function() {
	if (this.div) {
		this.div.parentNode.removeChild(this.div);
		this.div = null;
	}	
};

CustomMarker.prototype.getPosition = function() {
	return this.latlng;	
};