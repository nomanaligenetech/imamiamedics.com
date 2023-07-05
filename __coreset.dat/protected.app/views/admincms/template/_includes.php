<!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url("assets/admincms/css/bootstrap.min.css");?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url("assets/admincms/css/font-awesome.min.css");?>" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url("assets/admincms/css/jQueryUI/jquery-ui-1.10.3.custom.css");?>" rel="stylesheet" type="text/css" />
        
        <!-- Ionicons -->
        <link href="<?php echo base_url("assets/admincms/css/ionicons.min.css");?>" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo base_url("assets/admincms/css/morris/morris.css");?>" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo base_url("assets/admincms/css/jvectormap/jquery-jvectormap-1.2.2.css");?>" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo base_url("assets/admincms/css/datepicker/datepicker3.css");?>" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo base_url("assets/admincms/css/daterangepicker/daterangepicker-bs3.css");?>" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url("assets/admincms/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css");?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url("assets/admincms/css/AdminLTE.css");?>" rel="stylesheet" type="text/css" />
        
        
        <link href="<?php echo base_url("assets/admincms/css/iCheck/all.css");?>" rel="stylesheet" type="text/css" />
         
        <link href="<?php echo base_url("assets/admincms/css/bootstrap-timepicker.css");?>" rel="stylesheet" type="text/css" />
        
        <!-- DATA TABLES -->
        <link href="<?php echo base_url("assets/admincms/css/datatables/dataTables.bootstrap.css");?>" rel="stylesheet" type="text/css" />
        
        
        <link href="<?php echo base_url("assets/admincms/css/colorpicker/bootstrap-colorpicker.min.css");?>" rel="stylesheet"/>
        
        <link rel="stylesheet" href="<?php echo base_url("assets/widgets/colorbox/example1/colorbox.css");?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
        
        
        <link href="<?php echo base_url("assets/admincms/css/custom_icheck.css");?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url("assets/admincms/css/style.css");?>" rel="stylesheet" type="text/css" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <style type="text/css">
        	.parameter label{
        		margin-left: -154px;
        	}
        	.values label{
        		margin-left: -10px;
        	}
        	.invalid-feedback{
        		color: red;
			    position: absolute;
			    margin-left: -155px;
        	}
        	.invalid-feedback1{
        		color: red;
			    position: absolute;
			    margin-left: -12px;
        	}
        </style>
        
        
    
        
        <script>
		var site_url				= "<?php echo base_url();?>";
		var controller				= "<?php echo $_directory;?>";
		
		var base_url 				= "<?php echo base_url();?>";
		var lang_folder 			= "<?php echo SessionHelper::_get_session('SITE_LANGUAGE_FOLDER', 'site_settings');?>";
		var is_post 				= "<?php echo $this->validations->is_post();?>";
		var operations				= '<?php echo $notallowed_operations; ?>';
		</script>
        
        
        <script src="<?php echo base_url("assets/widgets/jquery-ui-1.11.1.custom/external/jquery/jquery.js");?>" type="text/javascript"></script>
        <script src="<?php echo base_url("assets/widgets/jquery-ui-1.11.1.custom/jquery-ui.js");?>" type="text/javascript"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        
        <!-- Bootstrap -->
        <script src="<?php echo base_url("assets/admincms/js/bootstrap.min.js");?>" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php echo base_url("assets/admincms/js/plugins/morris/morris.min.js");?>" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?php echo base_url("assets/admincms/js/plugins/sparkline/jquery.sparkline.min.js");?>" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php echo base_url("assets/admincms/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js");?>" type="text/javascript"></script>
        <script src="<?php echo base_url("assets/admincms/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js");?>" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo base_url("assets/admincms/js/plugins/jqueryKnob/jquery.knob.js");?>" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php echo base_url("assets/admincms/js/plugins/daterangepicker/daterangepicker.js");?>" type="text/javascript"></script>
       
        <!-- iCheck -->
        <script src="<?php echo base_url("assets/admincms/js/plugins/iCheck/icheck.min.js");?>" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url("assets/admincms/js/AdminLTE/app.js");?>" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo base_url("assets/admincms/js/AdminLTE/dashboard.js");?>" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url("assets/admincms/js/AdminLTE/demo.js");?>" type="text/javascript"></script>
        
        <script src="<?php echo base_url("assets/admincms/js/bootstrap-timepicker.js");?>" type="text/javascript"></script>
        
        
        
         <!-- CK Editor -->
        <script src="<?php echo base_url("assets/admincms/js/ckeditor/ckeditor.js");?>" type="text/javascript"></script>
        
        <script src="<?php echo base_url("assets/admincms/js/plugins/colorpicker/bootstrap-colorpicker.min.js");?>" type="text/javascript"></script>
        
        
        
		<script src="<?php echo base_url("assets/widgets/colorbox/jquery.colorbox.js");?>"></script>
        
        <script src="<?php echo base_url("assets/widgets/jquery_blockUI/jquery.blockUI.js");?>"></script>
        
        
        
        
        <link rel="stylesheet" href="<?php echo base_url( FOLDER_WIDGETS . "selectize.js-master/dist/css/selectize.default.css");?>">
		<script src="<?php echo base_url( FOLDER_WIDGETS . "selectize.js-master/dist/js/standalone/selectize.js");?>"></script>
        <script src="<?php echo base_url( FOLDER_WIDGETS . "selectize.js-master/examples/js/index.js");?>"></script>
        
        
        
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

        <script src="<?php echo base_url("assets/admincms/js/site.js");?>" type="text/javascript"></script>