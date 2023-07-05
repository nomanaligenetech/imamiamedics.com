<script>
var site_url							= "<?php echo base_url();?>";
var base_url							= "<?php echo base_url();?>";
var controller							= "<?php echo $_directory;?>";
var _pagepath 							= "<?php echo $_pagepath;?>";
var is_post 							= "<?php echo $this->validations->is_post();?>";
var _js_timeline_history_count			= "<?php echo $_js_timeline_history_count;?>";
</script>

        
<!-- this, preferably, goes inside head element: -->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo FRONTEND_FOLDER_JS.'flashcanvas.js';?>"></script>
<![endif]--> 

<style>
.input-error-class{   background-color: #ffeeee !important;    border: 1px solid #ff0000 !important;}
</style>
<?php
$this->carabiner->css(  FRONTEND_FOLDER_CSS . 'fancybox/jquery.fancybox.min.css' );
$this->carabiner->css(  FRONTEND_FOLDER_CSS . 'style.css' );
$this->carabiner->css(  FRONTEND_FOLDER_CSS . 'responsive.css' );
$this->carabiner->css(  FRONTEND_FOLDER_CSS . 'messages_style.css' );
$this->carabiner->css(  base_url("assets/widgets/colorbox/example1/colorbox.css") );


$this->carabiner->css(  base_url("assets/widgets/owl.carousel/owl-carousel/owl.carousel.css") );
$this->carabiner->css(  "assets/admincms/css/jQueryUI/jquery-ui-1.10.3.custom.css" );
$this->carabiner->css(  base_url("assets/widgets/pace/pace.css" ));
$this->carabiner->css(  base_url("assets/widgets/timepicker/src/jquery-ui-timepicker-addon.css" ));
$this->carabiner->css(  base_url("assets/widgets/selectize.js-master/dist/css/selectize.default.css" ));
$this->carabiner->css(  base_url("assets/widgets/colorbox/example1/colorbox.css" ));
$this->carabiner->css(  "assets/admincms/css/iCheck/all.css" );
$this->carabiner->css(  "assets/admincms/css/custom_icheck.css" );
$this->carabiner->css(  FRONTEND_FOLDER_CSS . 'bootstrap_model.css' );
$this->carabiner->display('css');



$this->carabiner->js(  base_url("assets/frontend/js/jquery.js") );
$this->carabiner->js(  base_url("assets/frontend/js/fancybox/jquery.fancybox.min.js") );
$this->carabiner->js(  base_url("assets/frontend/js/sweetalert.min.js") );
$this->carabiner->js(  base_url("assets/frontend/js/cleave.min.js") );
$this->carabiner->js(  base_url("assets/widgets/colorbox/jquery.colorbox.js" ));
$this->carabiner->js(  base_url("assets/widgets/owl.carousel/owl-carousel/owl.carousel.min.js" ));
$this->carabiner->js(  base_url("assets/widgets/doubletaptogo.js" ));
$this->carabiner->js(  base_url("assets/widgets/jQuery.dotdotdot-master/src/js/jquery.dotdotdot.min.js" ));
$this->carabiner->js(  base_url("assets/widgets/jquery-ui-1.11.1.custom/jquery-ui.js") );
$this->carabiner->js(  base_url("assets/widgets/pace/pace.js" ));
$this->carabiner->js(  base_url("assets/widgets/timepicker/src/jquery-ui-timepicker-addon.js" ));
$this->carabiner->js(  base_url("assets/widgets/selectize.js-master/dist/js/standalone/selectize.js" ));
$this->carabiner->js(  base_url("assets/widgets/selectize.js-master/examples/js/index.js" ));

$this->carabiner->js(  "assets/widgets/jquery.travelmap/jquery.travelmap.js" );
$this->carabiner->js(  base_url("assets/widgets/selectize.js-master/examples/js/index.js") );
$this->carabiner->js(  'assets/admincms/js/plugins/iCheck/icheck.min.js' );

$this->carabiner->js(   base_url("assets/frontend/js/script.js" ) );
$this->carabiner->js(  base_url("assets/frontend/js/responsive.js") );
$this->carabiner->js(  base_url("assets/frontend/js/bootstrap_model.js") );
$this->carabiner->js(  base_url("assets/frontend/js/jSignature.min.js") );

if($_pagepath == 'shortconference/registration/screen_one' || $_pagepath == 'shortconference/registration/screen_two' || $_pagepath == 'shortconference/registration/screen_five'){
	$this->carabiner->js(  base_url("assets/frontend/js/conferencecalculations.js") );
}else if($_pagepath == 'shortconference/registration/form'){
	$this->carabiner->js(  base_url("assets/frontend/js/shortconferenceonepagecalc.js") );
}
        
$this->carabiner->display('js');
?>


<link href="<?php echo base_url("assets/admincms/css/datatables/dataTables.bootstrap.css");?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url("assets/admincms/js/plugins/datatables/jquery.dataTables2.js");?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/admincms/js/plugins/datatables/dataTables.bootstrap.js");?>" type="text/javascript"></script>
                
<script type="text/javascript" language="javascript" class="init">

		
		//
		// Pipelining function for DataTables. To be used to the `ajax` option of DataTables
		//
		$.fn.dataTable.pipeline = function ( opts ) {
			// Configuration options
			var conf = $.extend( {
				pages: 5,     // number of pages to cache
				url: '',      // script url
				data: null,   // function or object with parameters to send to the server
							  // matching how `ajax.data` works in DataTables
				method: 'POST' // Ajax HTTP method
			}, opts );
		
			// Private variables for storing the cache
			var cacheLower = -1;
			var cacheUpper = null;
			var cacheLastRequest = null;
			var cacheLastJson = null;
		
			return function ( request, drawCallback, settings ) {
				var ajax          = false;
				var requestStart  = request.start;
				var drawStart     = request.start;
				var requestLength = request.length;
				var requestEnd    = requestStart + requestLength;
				
				if ( settings.clearCache ) {
					// API requested that the cache be cleared
					ajax = true;
					settings.clearCache = false;
				}
				else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
					// outside cached data - need to make a request
					ajax = true;
				}
				else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
						  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
						  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
				) {
					// properties changed (ordering, columns, searching)
					ajax = true;
				}
				
				// Store the request for checking next time around
				cacheLastRequest = $.extend( true, {}, request );
		
				if ( ajax ) {
					// Need data from the server
					if ( requestStart < cacheLower ) {
						requestStart = requestStart - (requestLength*(conf.pages-1));
		
						if ( requestStart < 0 ) {
							requestStart = 0;
						}
					}
					
					cacheLower = requestStart;
					cacheUpper = requestStart + (requestLength * conf.pages);
		
					request.start = requestStart;
					request.length = requestLength*conf.pages;
		
					// Provide the same `data` options as DataTables.
					if ( $.isFunction ( conf.data ) ) {
						// As a function it is executed with the data object as an arg
						// for manipulation. If an object is returned, it is used as the
						// data object to submit
						var d = conf.data( request );
						if ( d ) {
							$.extend( request, d );
						}
					}
					else if ( $.isPlainObject( conf.data ) ) {
						// As an object, the data given extends the default
						$.extend( request, conf.data );
					}
		
					settings.jqXHR = $.ajax( {
						"type":     conf.method,
						"url":      conf.url,
						"data":     request,
						"dataType": "json",
						"cache":    false,
						"success":  function ( json ) {
							cacheLastJson = $.extend(true, {}, json);
		
							if ( cacheLower != drawStart ) {
								json.data.splice( 0, drawStart-cacheLower );
							}
							json.data.splice( requestLength, json.data.length );
							
							drawCallback( json );
							
							
						}
					} );
				}
				else {
					json = $.extend( true, {}, cacheLastJson );
					json.draw = request.draw; // Update the echo for each response
					json.data.splice( 0, requestStart-cacheLower );
					json.data.splice( requestLength, json.data.length );
		
					drawCallback(json);
				}
			}
		};
		
		// Register an API method that will empty the pipelined data, forcing an Ajax
		// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
		$.fn.dataTable.Api.register( 'clearPipeline()', function () {
			return this.iterator( 'table', function ( settings ) {
				settings.clearCache = true;
			} );
		} );
		
		
		
		</script>
        

<script src="<?php echo base_url("assets/widgets/jquery_blockUI/jquery.blockUI.js");?>"></script>
<script src="<?php echo base_url("assets/admincms/js/site.js");?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/admincms/js/ckeditor/ckeditor.js");?>" type="text/javascript"></script>
<style>

.blockUI.blockMsg.blockPage > h1 {
    font-family: "Source Sans Pro",sans-serif;
    font-size: 24px;
}
</style>       





<!--
<script>
/*  @preserve
jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
http://dojofoundation.org/license for more information.
*/
(function($) {
	var topics = {};
	$.publish = function(topic, args) {
	    if (topics[topic]) {
	        var currentTopic = topics[topic],
	        args = args || {};
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            currentTopic[i].call($, args);
	        }
	    }
	};
	$.subscribe = function(topic, callback) {
	    if (!topics[topic]) {
	        topics[topic] = [];
	    }
	    topics[topic].push(callback);
	    return {
	        "topic": topic,
	        "callback": callback
	    };
	};
	$.unsubscribe = function(handle) {
	    var topic = handle.topic;
	    if (topics[topic]) {
	        var currentTopic = topics[topic];
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            if (currentTopic[i] === handle.callback) {
	                currentTopic.splice(i, 1);
	            }
	        }
	    }
	};
})(jQuery);

</script>
<script src="<?php echo base_url( "assets/widgets/jSignature-master/src/jSignature.js" );?>"></script>
<script src="<?php echo base_url( "assets/widgets/jSignature-master/src/plugins/jSignature.CompressorBase30.js" );?>"></script>
<script src="<?php echo base_url( "assets/widgets/jSignature-master/src/plugins/jSignature.CompressorSVG.js" );?>"></script>
<script src="<?php echo base_url( "assets/widgets/jSignature-master/src/plugins/jSignature.UndoButton.js" );?>"></script> 
<script src="<?php echo base_url( "assets/widgets/jSignature-master/src/plugins/signhere/jSignature.SignHere.js" );?>"></script> 
<script>
$(document).ready(function() {
	
	// This is the part where jSignature is initialized.
	var $sigdiv = $("#signature").jSignature({'UndoButton':true})
	
	// All the code below is just code driving the demo. 
	, $tools = $('#tools')
	, $extraarea = $('#displayarea')
	, pubsubprefix = 'jSignature.demo.'
	
	var export_plugins = $sigdiv.jSignature('listPlugins','export')
	, chops = ['<span><b>Extract signature data as: </b></span><select>','<option value="">(select export format)</option>']
	, name
	for(var i in export_plugins){
		if (export_plugins.hasOwnProperty(i)){
			name = export_plugins[i]
			chops.push('<option value="' + name + '">' + name + '</option>')
		}
	}
	chops.push('</select><span><b> or: </b></span>')
	
	$(chops.join('')).bind('change', function(e){
		if (e.target.value !== ''){
			var data = $sigdiv.jSignature('getData', e.target.value)
			$.publish(pubsubprefix + 'formatchanged')
			if (typeof data === 'string'){
				$('textarea', $tools).val(data)
			} else if($.isArray(data) && data.length === 2){
				$('textarea', $tools).val(data.join(','))
				$.publish(pubsubprefix + data[0], data);
			} else {
				try {
					$('textarea', $tools).val(JSON.stringify(data))
				} catch (ex) {
					$('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
				}
			}
		}
	}).appendTo($tools)

	
	$('<input type="button" value="Reset">').bind('click', function(e){
		$sigdiv.jSignature('reset')
	}).appendTo($tools)
	
	$('<div><textarea style="width:100%;height:7em;"></textarea></div>').appendTo($tools)
	
	$.subscribe(pubsubprefix + 'formatchanged', function(){
		$extraarea.html('')
	})

	$.subscribe(pubsubprefix + 'image/svg+xml', function(data) {

		try{
			var i = new Image()
			i.src = 'data:' + data[0] + ';base64,' + btoa( data[1] )
			$(i).appendTo($extraarea)
		} catch (ex) {

		}
		
		var message = [
			"If you don't see an image immediately above, it means your browser is unable to display in-line (data-url-formatted) SVG."
			, "This is NOT an issue with jSignature, as we can export proper SVG document regardless of browser's ability to display it."
			, "Try this page in a modern browser to see the SVG on the page, or export data as plain SVG, save to disk as text file and view in any SVG-capabale viewer."
           ]
		$( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
	});

	$.subscribe(pubsubprefix + 'image/svg+xml;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		$(i).appendTo($extraarea)
		
		var message = [
			"If you don't see an image immediately above, it means your browser is unable to display in-line (data-url-formatted) SVG."
			, "This is NOT an issue with jSignature, as we can export proper SVG document regardless of browser's ability to display it."
			, "Try this page in a modern browser to see the SVG on the page, or export data as plain SVG, save to disk as text file and view in any SVG-capabale viewer."
           ]
		$( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
	});
	
	$.subscribe(pubsubprefix + 'image/png;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		$('<span><b>As you can see, one of the problems of "image" extraction (besides not working on some old Androids, elsewhere) is that it extracts A LOT OF DATA and includes all the decoration that is not part of the signature.</b></span>').appendTo($extraarea)
		$(i).appendTo($extraarea)
	});
	
	$.subscribe(pubsubprefix + 'image/jsignature;base30', function(data) {
		$('<span><b>This is a vector format not natively render-able by browsers. Format is a compressed "movement coordinates arrays" structure tuned for use server-side. The bonus of this format is its tiny storage footprint and ease of deriving rendering instructions in programmatic, iterative manner.</b></span>').appendTo($extraarea)
	});

	if (Modernizr.touch){
		$('#scrollgrabber').height($('#content').height())		
	}
	
})
</script>

<style type="text/css">

	div {
		margin-top:1em;
		margin-bottom:1em;
	}
	input {
		padding: .5em;
		margin: .5em;
	}
	select {
		padding: .5em;
		margin: .5em;
	}
	
	#signatureparent {
		color:darkblue;
		background-color:darkgrey;
		/*max-width:600px;*/
		padding:20px;
	}
	
	/*This is the div within which the signature canvas is fitted*/
	#signature {
		border: 2px dotted black;
		background-color:lightgrey;
	}

	/* Drawing the 'gripper' for touch-enabled devices */ 
	html.touch #content {
		float:left;
		width:92%;
	}
	html.touch #scrollgrabber {
		float:right;
		width:4%;
		margin-right:2%;
		background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
	}
	html.borderradius #scrollgrabber {
		border-radius: 1em;
	}
	 
</style> -->