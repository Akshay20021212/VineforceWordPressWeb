var kwtdemos = kwtdemos || {};
(function ($) {
	kwtdemos.initialization = {
		importData: {},
		init: function () {
			var that = this;
			$('.demo-items .demo-item').click( function (e) {
				e.preventDefault();
				var cur_wrap = $(this),
					demo_name = cur_wrap.data('demo-id');
					cur_wrap.addClass('kwt-loader');
					that.getDemoData( cur_wrap, demo_name );
			});
			
			$( document ).on( 'click' 						, '.install-now', this.installNow );
			$( document ).on( 'click' 						, '.activate-now', this.activatePlugins );
			$( document ).on( 'wp-plugin-install-success'	, this.installSuccess );
			$( document ).on( 'wp-plugin-installing' 		, this.pluginInstalling );
			$( document ).on( 'wp-plugin-install-error'		, this.installError );
			
		},
		getDemoData : function ( cur_wrap, demo_name ) {
			var that = this;
			$.ajax({
				url: kWTDemos.ajaxUrl,
				data: {
					'action' : 'killarwt_get_import_data',
					'demo_name'	: demo_name,
					'data_nonce' : kWTDemos.kwt_import_data_nonce,
				},
				method: 'post',
				complete: function ( data ) {
					cur_wrap.removeClass('kwt-loader');
					that.importData = $.parseJSON( data.responseText );
				},
				error: function () {
					alert('Something went wrong, please try again latter.');
				}
			});
			$.ajax({
				url: kWTDemos.ajaxUrl,
				data: {
					'action' : 'killarwt_get_demo_data',
					'demo_name'	: demo_name,
					'data_nonce' : kWTDemos.kwt_demo_data_nonce,
				},
				method: 'post',
				complete: function ( data ) {
					cur_wrap.removeClass('kwt-loader');
					that.popup( data );
				},
				error: function () {
					alert('Something went wrong, please try again latter.');
				}
			});
			
		},
		popup : function ( data ) {
			var that = this;
			if ( data.responseText ) {
				var popup_content = $( '#kwt-demo-popup-content' );
				popup_content.html( data.responseText );
				$.magnificPopup.open({
					items: {
						src: '.kwt-demo-popup-wrap',
					},
					enableEscapeKey: !0,
					callbacks: {
						beforeOpen: function() {
							this.st.mainClass = "kwt-demo-popup"
						},
						close: function() {
							popup_content.html('');
						}
					}
				});
			  
				$('body').on( 'click', '.kwt-plugins-next', function(e){
					  e.preventDefault();
					  $('#kwt-demo-plugins').hide();
					  $('#kwt-demo-import').show();
				});
			  
				$('.import-item-checkbox').change(function(){
					if ( $('.import-item-checkbox:checked').length > 0 ) {
					   $('.kwt-import').prop( "disabled", false );
					} else {
						$('.kwt-import').prop( "disabled", true );
					}
				});
				
				$('#kwt-demo-import-form').submit( function( e ) {
					e.preventDefault();
					
					var $this = $( this ),
						demo = $this.find( '[name="kwt_import_demo"]' ).val(),
						nonce = $this.find( '[name="kwt_import_demo_data_nonce"]' ).val(),
						contentToImport = [];
						
					$this.find( 'input[type="checkbox"]' ).each( function() {
						if ( $( this ).is( ':checked' ) === true ) {
							contentToImport.push( $( this ).attr( 'name' ) );
						}
					} );
					
					$('#kwt-demo-import').hide();
					$('#kwt-demo-import-process').show();
					
					that.importContent( {
						demo: demo,
						nonce: nonce,
						contentToImport: contentToImport,
						isContents: $( '#kwt_import_contents' ).is( ':checked' )
					} );
				});
			}
		},
		importContent: function( importData ) {
			var that = this,
			currentContent,
			importingLimit,
			timerStart = Date.now(),
			ajaxData = {
				kwt_import_demo: importData.demo,
				kwt_import_demo_data_nonce: importData.nonce
			};
			
			// When all the selected content has been imported
			if ( importData.contentToImport.length === 0 ) {
				
				// Show the imported screen after 1 second
				setTimeout( function() {
					$( '#kwt-demo-import-success' ).show();
				}, 1000 );

				// Notify the server that the importing process is complete
				$.ajax( {
					url: kWTDemos.ajaxUrl,
					type: 'post',
					data: {
						action: 'kwt_after_import',
						kwt_import_demo: importData.demo,
						kwt_import_demo_data_nonce: importData.nonce,
						kwt_import_is_contents: importData.isContents
					},
					complete: function( data ) {}
				} );

				this.allowPopupClosing = true;
				$( '.mfp-close' ).fadeIn();

				return;
			}
			
			for ( var key in this.importData ) {

				var contentIndex = $.inArray( this.importData[ key ][ 'id' ], importData.contentToImport );
				if ( contentIndex !== -1 ) {
					currentContent = key;
					importData.contentToImport.splice( contentIndex, 1 );
					ajaxData.action = this.importData[ key ]['action'];
					break;
				}
			}
			
			$( '.kwt-import-status' ).append( '<p class="kwt-importing">' + this.importData[ currentContent ]['loader'] + '</p>' );
			
			var ajaxRequest = $.ajax( {
				url: kWTDemos.ajaxUrl,
				data: ajaxData,
				method: 'post',
				complete: function( data ) {

					var continueProcess = true;
					if ( data.status === 500 || data.status === 502 || data.status === 503 ) {
						$( '.kwt-importing' )
							.addClass( 'kwt-importing-failed' )
							.removeClass( 'kwt-importing' )
							.text( kWTDemos.content_importing_error + ' '+ data.status );
					} else if ( data.responseText.indexOf( 'successful import' ) !== -1 ) {
						$( '.kwt-importing' ).addClass( 'kwt-imported' ).removeClass( 'kwt-importing' );
					} else {
						var errors = $.parseJSON( data.responseText ),
							errorMessage = '';

						// Iterate through the list of errors
						for ( var error in errors ) {
							errorMessage += errors[ error ];

							// If there was an error with the importing of the XML file, stop the process
							if ( error === 'kwt_import_error' ) {
								continueProcess = false;
							}
						}

						// Display the error message
						$( '.kwt-importing' )
							.addClass( 'kwt-importing-failed' )
							.removeClass( 'kwt-importing' )
							.text( errorMessage );

						that.allowPopupClosing = true;
						$( '.mfp-close' ).fadeIn();
					}

					if ( continueProcess === true ) {
						that.importContent( importData );
					}

				}
			} );
			
			// Set a time limit of 15 minutes for the importing process.
			importingLimit = setTimeout( function() {

				// Abort the AJAX request
				ajaxRequest.abort();

				// Allow the popup to be closed
				that.allowPopupClosing = true;
				$( '.mfp-close' ).fadeIn();

				$( '.kwt-importing' )
					.addClass( 'kwt-importing-failed' )
					.removeClass( 'kwt-importing' )
					.text( kWTDemos.content_importing_error );
			}, 15 * 60 * 1000 );

		},
		installNow: function( e ) {
			e.preventDefault();

			// Vars
			var $button 	= $( e.target ),
				$document   = $( document );

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( e );

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.install-now.updating-message' );

					$message
						.removeClass( 'updating-message' )
						.text( wp.updates.l10n.installNow );

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
				} );
			}

			wp.updates.installPlugin( {
				slug: $button.data( 'slug' )
			} );
		},
		activatePlugins: function( e ) {
			e.preventDefault();

			// Vars
			var $button = $( e.target ),
				$init 	= $button.data( 'init' ),
				$slug 	= $button.data( 'slug' );

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			$button.addClass( 'updating-message button-primary' ).html( kWTDemos.button_activating );

			$.ajax( {
				url: kWTDemos.ajaxUrl,
				type: 'POST',
				data: {
					action : 'kwt_ajax_required_plugins_activate',
					init   : $init,
				},
			} ).done( function( result ) {

				if ( result.success ) {

					$button.removeClass( 'button-primary install-now activate-now updating-message' )
						.attr( 'disabled', 'disabled' )
						.addClass( 'disabled' )
						.text( kWTDemos.button_active );

				}

			} );
		},
		installSuccess: function( e, response ) {
			e.preventDefault();

			var $message = $( '.kwt-plugin-' + response.slug ).find( '.button' );

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $message.data('init');

			$message.removeClass( 'install-now installed button-disabled updated-message' )
				.addClass( 'updating-message' )
				.html( kWTDemos.button_activating );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax( {
					url: kWTDemos.ajaxUrl,
					type: 'POST',
					data: {
						action : 'kwt_ajax_required_plugins_activate',
						init   : $init,
					},
				} ).done( function( result ) {

					if ( result.success ) {

						$message.removeClass( 'button-primary install-now activate-now updating-message' )
							.attr( 'disabled', 'disabled' )
							.addClass( 'disabled' )
							.text( kWTDemos.button_active );

					} else {
						$message.removeClass( 'updating-message' );
					}

				} );

			}, 1200 );
		},
		pluginInstalling: function( e, args ) {
			e.preventDefault();

			var $card = $( '.kwt-plugin-' + args.slug ),
				$button = $card.find( '.button' );

			$button.addClass( 'updating-message' );
		},
		installError: function( e, response ) {
			e.preventDefault();

			var $card = $( '.kwt-plugin-' + response.slug );

			$card.removeClass( 'button-primary' ).addClass( 'disabled' ).html( wp.updates.l10n.installFailedShort );
		}
		
	};
	kwtdemos.documentReady = {
		init: function () {
			kwtdemos.initialization.init();
		}
	};
	kwtdemos.documentLoad = {
		init: function () {
			w = window.innerWidth || $window.width();
		}
	};
	
	var $body = $('body'),
		$window = $(window),
		$document = $(document),
		w = window.innerWidth || $window.width(),
		maxXXS = 0,
		maxXS = 576,
		maxSM = 768,
		maxMD = 992,
		maxLG = 1200,
		maxXL = 1770,
		mobileMenuBreikpoint = 992,
		isMobile = w < mobileMenuBreikpoint;
		$document.on('ready', kwtdemos.documentReady.init);
		$window.on('load', kwtdemos.documentLoad.init);
		//$window.on('resize', kwtdemos.documentResize.init);
			
})(jQuery);