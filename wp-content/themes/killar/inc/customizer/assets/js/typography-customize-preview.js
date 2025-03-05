( function( $ ) {
	
	var body 	= 	$( 'body' );
	wp.customize('killar_body_typography[font-family]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var idfirst = ( contVal.trim().toLowerCase().replace( " ", "-" ), "customizer-typography-body-font-family" );
				var fontSize = contVal.replace( " ", "%20" );
				fontSize = fontSize.replace( ",", "%2C" );
				fontSize = killarTypography.googleFontsUrl + "/css?family=" + contVal + ":" + killarTypography.googleFontsWeight;
				if ( $( "#" + idfirst ).length ) {
					$( "#" + idfirst ).attr( "href", fontSize );
				} else {
					$('head').append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + fontSize + '">' );
				}
				
				var custStyle = 'body{font-family: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-font-family', custStyle);
			}
		} );
	} ), wp.customize( 'killar_body_typography[font-weight]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{font-weight: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-font-weight', custStyle);
			}
		} );
	} ), wp.customize( 'killar_body_typography[font-style]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{font-style: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-font-style', custStyle);
			}
		} );
	} ), wp.customize( 'killar_body_typography[text-transform]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{text-transform: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-text-transform', custStyle);
			}
		} );
	} ), wp.customize( 'killar_body_typography[font-size]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{font-size: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-font-size', custStyle);
			}
		} );
	} ), wp.customize( 'killar_body_typography[line-height]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{line-height: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-line-height', custStyle);
			}
		} );
	} ), wp.customize( 'killar_body_typography[color]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'html, body{color: ' + contVal + ';}';
				killarwt_add_customize_css('killar_body_typography-color', custStyle);
			}
		} );
	} ),wp.customize('killar_headings_typography[font-family]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var idfirst = ( contVal.trim().toLowerCase().replace( " ", "-" ), "customizer-typography-headings-font-family" );
				var fontSize = contVal.replace( " ", "%20" );
				fontSize = fontSize.replace( ",", "%2C" );
				fontSize = killarTypography.googleFontsUrl + "/css?family=" + contVal + ":" + killarTypography.googleFontsWeight;
				if ( $( "#" + idfirst ).length ) {
					$( "#" + idfirst ).attr( "href", fontSize );
				} else {
					$('head').append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + fontSize + '">' );
				}
				
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-family: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-font-family', custStyle);
			}
		} );
	} ), wp.customize( 'killar_headings_typography[font-weight]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-weight: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-font-weight', custStyle);
			}
		} );
	} ), wp.customize( 'killar_headings_typography[font-style]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-style: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-font-style', custStyle);
			}
		} );
	} ), wp.customize( 'killar_headings_typography[text-transform]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{text-transform: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-text-transform', custStyle);
			}
		} );
	} ), wp.customize( 'killar_headings_typography[font-size]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-size: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-font-size', custStyle);
			}
		} );
	} ), wp.customize( 'killar_headings_typography[line-height]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{line-height: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-line-height', custStyle);
			}
		} );
	} ), wp.customize( 'killar_headings_typography[color]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.killarwt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{color: ' + contVal + ';}';
				killarwt_add_customize_css('killar_headings_typography-color', custStyle);
			}
		} );
	} )
   
} )( jQuery );
