/**
 * Travelmap - jQuery Plugin
 * Pin anything on Google map with jQuery
 *
 * Examples and documentation at: https://github.com/microtroll/jquery-travel
 *
 * Copyright (c) 2014 microtroll
 *
 * Version: 1.9.7
 * Requires: jQuery v2+
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */

(function($) {
  'use strict';

  $.fn.travelmap = function(settings) {
	
	console.log(this.attr("data-width"));
	//console.log(settings);
    var o = {
      data: './assets/widgets/jquery.travelmap/cities.json',
      center: [0, 0], // lat, lng
      width: this.attr("data-width"),
      height: 500,
      zoom: 1,
      markImage: 'data:image/png;base64,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',
      markShadow: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAQEAYAAABVX8OsAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAACc0lEQVRIx+2WO2hTYRiG/1yanrYxibaREluLlrZWUQriBXGRugkOXasg9bYUQYp4mUTqooKg4KCok4u6KCg4COJSOlQ3J6W1tMa0Nk2apKkJSTq8zxGMBJPSbPmWh5Pzn+9/3+/7LzGmFrWoRS2qGK51yuOADbATDvPaJzrvM60H3hDdbp63Me4UHCdPn1B4wfNHGIeFahXICVvgVQy9R/h50foi+reKwSVxy1GxPQHfiqFBsfmZ2DhFAT4xzxvoLypwSYGVhp0wCBHiWsBQjxh4Lrb2YaBb3P5S7Poq9pwTuzeKnTkKwPgA33sOMX2yaP6S4V6jwSZIx1x0oHGPuGmX2HwSgV18doYCsLQ8D6kzRvIYWbnN71ExeYTnOeY9Dq8XFfyfpVrpHrQ7voO8CLToRHBIbLslhh5gGGFelqZFgeqekics5g5g8K4YaxOjdC7VyzjmMfMwVUpwpR20C7IPv7MI3iwGpsQWKu6bwAh7y3EBgT/EzAcxjdDEtLjIHp6jI0uWmL0iFt6hg71d+pBZq8F2BEdI80Ss92JojOH7xfwIAjn90nQuwWER+4wxxsevicmQ+PsxeSiUeQWz5Qr+X9hLsx4e5mf2nkXH/MfEDRgyO4XUZTHKNRD5JobZm5E63t9jPAayFzE2QL6bsOzrodxT1N7ECDEZ8p8VcyzRFa6L+AzCGTdNpSdPiN8RGkbgInswfRBj/RjbzXx3YKxcY3ZU2kHbYCu+O3hNZx0ISF8SF16L83mMLIsprpMM10huFN0sVfMIzvxd0OqF3UH+gfw5Rffi+7TY9FP0Mb7hF+8pjJPDwnAPGr433qJCrlusAobpnIN3kn13AAAAAElFTkSuQmCC',
      markAnimation: null,
      mapTypeId: 'ROADMAP',
      mapTypeControl: false,
      mapTypeControlOptions: 'DEFAULT',
      zoomControl: false,
      zoomControlOptions: 'DEFAULT',
      panControl: false,
	  disableDoubleClickZoom: false,
      scaleControl: false,
      overviewMapControl: false,
      streetViewControl: false,
      geoLocCheck: false,
      geoLocMessage: 'You are here',
      scrollwheel: true,
      draggable: true,
      theme: null
    };
    settings = $.extend(o, settings);

	
    // map types
    var mapTypeId = google.maps.MapTypeId.ROADMAP;
    if (o.mapTypeId === 'HYBRID') {
      mapTypeId = google.maps.MapTypeId.HYBRID;
    } else if (o.mapTypeId === 'SATELLITE') {
      mapType = google.maps.MapTypeId.SATELLITE;
    } else if (o.mapTypeId === 'TERRAIN') {
      mapTypeId = google.maps.MapTypeId.TERRAIN;
    }  

    // map controls
    var mapTypeControlOptions = google.maps.MapTypeControlStyle.DEFAULT;
    if (o.mapTypeControlOptions === 'DROPDOWN_MENU') {
      mapTypeControlOptions = google.maps.MapTypeControlStyle.DROPDOWN_MENU;
    } else if (o.mapTypeControlOptions === 'HORIZONTAL_BAR') {
      mapTypeControlOptions = google.maps.MapTypeControlStyle.HORIZONTAL_BAR;
    }

    // map zoom
    var zoomControlOptions = google.maps.ZoomControlStyle.DEFAULT;
    if (o.zoomControlOptions === 'LARGE') {
      zoomControlOptions = google.maps.ZoomControlStyle.LARGE;
    } else if (o.zoomControlOptions === 'SMALL') {
      zoomControlOptions = google.maps.ZoomControlStyle.SMALL;
    }

    // marker animation
    var markAnimation;
    if (o.markAnimation === 'DROP') {
      markAnimation = google.maps.Animation.DROP;
    } else if (o.markAnimation === 'BOUNCE') {
      markAnimation = google.maps.Animation.BOUNCE;
    }

    // set center to users location if enabled
    var pos = new google.maps.LatLng(o.center[0], o.center[1]);
	//console.log(settings);
	
    if (navigator.geolocation && o.geoLocCheck === true) { 
      navigator.geolocation.getCurrentPosition(function(position) {
        var geocoder = new google.maps.Geocoder();
        pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        if (geocoder) {
          geocoder.geocode({
            'latLng': pos
          }, function(resp, status) {
            if (status === google.maps.GeocoderStatus.OK) {
              var infowindow = new google.maps.InfoWindow({
                map: map,
                position: resp[0].geometry.location,
                content: o.geoLocMessage
              });
              map.setCenter(resp[0].geometry.location);
            } else {
              throw new Error("Geocoding failed: " + status);
            }
          });
        }
      });
    }

    // themes
    var theme;
    // themes from http://snazzymaps.com/
    if (o.theme === 'neutral-blue') {
      theme = [{
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [{
          "color": "#193341"
        }]
      }, {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
          "color": "#2c5a71"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{
          "color": "#29768a"
        }, {
          "lightness": -37
        }]
      }, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "color": "#406d80"
        }]
      }, {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [{
          "color": "#406d80"
        }]
      }, {
        "elementType": "labels.text.stroke",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#3e606f"
        }, {
          "weight": 2
        }, {
          "gamma": 0.84
        }]
      }, {
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry",
        "stylers": [{
          "weight": 0.6
        }, {
          "color": "#1a3541"
        }]
      }, {
        "elementType": "labels.icon",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [{
          "color": "#2c5a71"
        }]
      }];
    } 
	else if (o.theme === 'custom-blue') {
      theme = [{
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [{
          "color": "#F7F7F7"
        }]
      }, {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
          "color": "#4B4B4B"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{
          "color": "#29768a"
        }, {
          "lightness": -37
        }]
      }, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "color": "#406d80"
        }]
      }, {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [{
          "color": "#406d80"
        }]
      }, {
        "elementType": "labels.text.stroke",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#3e606f"
        }, {
          "weight": 2
        }, {
          "gamma": 0.84
        }]
      }, {
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#ffffff"
        }]
      },{
        "featureType": "all",
        "elementType": "labels.text",
        "stylers": [{
          visibility: "off"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry",
        "stylers": [{
          "weight": 0.6
        }, {
          "color": "#727272"
        }]
      }, {
        "elementType": "labels.icon",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [{
          "color": "#4B4B4B",
		   visibility: "off"
        }]
      }];
    } 
	else if (o.theme === 'midnight-commander') {
      theme = [{
        "featureType": "water",
        "stylers": [{
          "color": "#021019"
        }]
      }, {
        "featureType": "landscape",
        "stylers": [{
          "color": "#08304b"
        }]
      }, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "color": "#0c4152"
        }, {
          "lightness": 5
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#000000"
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#0b434f"
        }, {
          "lightness": 25
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#000000"
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#0b3d51"
        }, {
          "lightness": 16
        }]
      }, {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }]
      }, {
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 13
        }]
      }, {
        "featureType": "transit",
        "stylers": [{
          "color": "#146474"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#000000"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#144b53"
        }, {
          "lightness": 14
        }, {
          "weight": 1.4
        }]
      }];
    } 
	else if (o.theme === 'gowalla') {
      theme = [{
        "featureType": "road",
        "elementType": "labels",
        "stylers": [{
          "visibility": "simplified"
        }, {
          "lightness": 20
        }]
      }, {
        "featureType": "administrative.land_parcel",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "road.local",
        "elementType": "labels",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "labels",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "water",
        "elementType": "all",
        "stylers": [{
          "hue": "#a1cdfc"
        }, {
          "saturation": 30
        }, {
          "lightness": 49
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [{
          "hue": "#f49935"
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [{
          "hue": "#fad959"
        }]
      }];
    } 
	else if (o.theme === 'bright-and-bubbly') {
      theme = [{
        "featureType": "water",
        "stylers": [{
          "color": "#19a0d8"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#ffffff"
        }, {
          "weight": 6
        }]
      }, {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#e85113"
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#efe9e4"
        }, {
          "lightness": -40
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#efe9e4"
        }, {
          "lightness": -20
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "lightness": 100
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{
          "lightness": -100
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "labels.icon"
      }, {
        "featureType": "landscape",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape",
        "stylers": [{
          "lightness": 20
        }, {
          "color": "#efe9e4"
        }]
      }, {
        "featureType": "landscape.man_made",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "water",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "lightness": 100
        }]
      }, {
        "featureType": "water",
        "elementType": "labels.text.fill",
        "stylers": [{
          "lightness": -100
        }]
      }, {
        "featureType": "poi",
        "elementType": "labels.text.fill",
        "stylers": [{
          "hue": "#11ff00"
        }]
      }, {
        "featureType": "poi",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "lightness": 100
        }]
      }, {
        "featureType": "poi",
        "elementType": "labels.icon",
        "stylers": [{
          "hue": "#4cff00"
        }, {
          "saturation": 58
        }]
      }, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#f0e4d3"
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#efe9e4"
        }, {
          "lightness": -25
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#efe9e4"
        }, {
          "lightness": -10
        }]
      }, {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [{
          "visibility": "simplified"
        }]
      }];
    } 
	else if (o.theme === 'greyscale') {
      theme = [{
        "featureType": "all",
        "stylers": [{
          "saturation": -100
        }, {
          "gamma": 0.5
        }]
      }];
    } 
	else if (o.theme === 'red-alert') {
      theme = [{
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [{
          "color": "#ffdfa6"
        }]
      }, {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
          "color": "#b52127"
        }]
      }, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "color": "#c5531b"
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#74001b"
        }, {
          "lightness": -10
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#da3c3c"
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#74001b"
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#da3c3c"
        }]
      }, {
        "featureType": "road.local",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#990c19"
        }]
      }, {
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#74001b"
        }, {
          "lightness": -8
        }]
      }, {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [{
          "color": "#6a0d10"
        }, {
          "visibility": "on"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry",
        "stylers": [{
          "color": "#ffdfa6"
        }, {
          "weight": 0.4
        }]
      }, {
        "featureType": "road.local",
        "elementType": "geometry.stroke",
        "stylers": [{
          "visibility": "off"
        }]
      }];
    } 
	else if (o.theme !== null) {
      // user defined
      theme = o.theme;
    } else {
      theme = null;
    }

    // basic options
    var mapOptions = {
        zoom: o.zoom,
        center: pos,
        useCurrentLocation: true,
		disableDoubleClickZoom: o.disableDoubleClickZoom,
        mapTypeId: mapTypeId,
        mapTypeControl: o.mapTypeControl,
        mapTypeControlOptions: {
          style: mapTypeControlOptions
        },
        zoomControl: o.zoomControl,
        zoomControlOptions: {
          style: zoomControlOptions
        },
        panControl: o.panControl,
        scaleControl: o.scaleControl,
        overviewMapControl: o.overviewMapControl,
        streetViewControl: o.streetViewControl,
        scrollwheel: o.scrollwheel,
        draggable: o.draggable,
        styles: theme
      },
      map = new google.maps.Map(document.getElementById(this.get(0).getAttribute('id')), mapOptions);

    // global variables
    var locations = [],
      markers = [],
      boxes = [];

    // data file parser
    $.ajax({
      url: o.data,
      dataType: 'json',
      success: function(data) {

        data.places.forEach(function(p, i) {
          locations[i] = new google.maps.LatLng(p.lat, p.lng);

          // markers options
          var shape = {
            coord: [10, 0, 11, 1, 12, 2, 12, 3, 12, 4, 12, 5, 12, 6, 12, 7, 12, 8, 11, 9, 10, 10, 10, 11, 9, 12, 9, 13, 8, 14, 8, 15, 7, 15, 7, 14, 6, 13, 6, 12, 5, 11, 5, 10, 4, 9, 3, 8, 3, 7, 3, 6, 3, 5, 3, 4, 3, 3, 3, 2, 4, 1, 5, 0, 10, 0],
            type: 'poly'
          };
          var image = new google.maps.MarkerImage(
            o.markImage,
            new google.maps.Size(32, 32),
            new google.maps.Point(0, 0),
            new google.maps.Point(32, 32));
          var shadow = new google.maps.MarkerImage(
            o.markShadow,
            new google.maps.Size(28, 16),
            new google.maps.Point(0, 0),
            new google.maps.Point(8, 16)
          );

          // infoboxes options
          var content = '<div class="content_' + p.id + '">';
          content += '<div id="siteNotice"></div>';
          content += '<h2 id="firstHeading" class="firstHeading">';
          console.log(p.chapter_link);
          if (p.chapter_link != "") {
            content += '<a href="' + p.chapter_link + '" target="_blank">';
          }
          content += p.name + ', ' + p.country;
          if (p.chapter_link != "") {
            content += '</a>';
          }
          content += '</h2>';
          content += '<div id="bodyContent"><p>' + p.info + '</p></div>';
          content += '</div>';
          boxes[i] = new google.maps.InfoWindow({
            content: content
          });

          markers[i] = new google.maps.Marker({
            animation: markAnimation,
            title: p.name + ', ' + p.country,
            
            map: map,
			
			// shape: shape,
    		//animation: google.maps.Animation.DROP,

            position: locations[i]
          });


          markers[i]._index = i;
          google.maps.event.addListener(markers[i], 'click', function() {
            	
				
				for( var mm = 0; mm < boxes.length; mm++ )
				{
					boxes[mm].close();
				}
				boxes[this._index].open(map, markers[this._index]);
				
			
			
				//rao - animate the marker and close when .
				/*if (this.getAnimation() != null) {
				this.setAnimation(null);
				} else {
				this.setAnimation(google.maps.Animation.BOUNCE);
				}*/
				//rao
		  
		  
          });
		  

      var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < markers.length; i++) {
         bounds.extend(markers[i].getPosition());
        }

        map.fitBounds(bounds);
		  
		/*var center;
		google.maps.event.addDomListener(map, 'idle', function() {
		  center = map.getCenter();
		});
		   
		   
		  google.maps.event.addDomListener(window, 'resize', function() {
			 map.setCenter(center);

          });
		*/
	
	


        });
      },
      error: function() {
        throw new Error('Error while loading JSON object!');
      }
    });

    $(this).css({
      width: o.width,
      height: o.height
    });

  };

})(jQuery);
