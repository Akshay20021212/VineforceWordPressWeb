
function killarwt_add_customize_css( control, style ) {
	jQuery( 'style#' + control ).remove();
	jQuery( 'head' ).append(
		'<style id="' + control + '">' + style + '</style>'
	);
}

function killarwt_wpcustomize( cust_array ) {
	if ( cust_array ) {
		var custmizeHtml = '';
		jQuery.each(cust_array, function (index, value) {
			if ( value.action != '' && value.style != '' ) {
				custmizeHtml += "wp.customize('" + value.action + "', function( control ) { control.bind(function( contVal ) { if( contVal != '' ) { killarwt_add_customize_css('" + value.action + "', '" + value.style.replace('%contVal%', "' + contVal + '") + "'); } }); }); ";
			}
		});
		return custmizeHtml;
	}
	
}

( function( $ ) {
	
	var body 	= 	$( 'body' );
	wp.customize('killar_header_height', function( control ) {
      control.bind(function( contVal ) {
			if( contVal != '' ) {
				custStyle = '.header-mid-area {line-height : '+ contVal +'px;}';
				killarwt_add_customize_css('killar_header_height', custStyle);
			}
		});
    }),
	wp.customize('killar_topbar_bg_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-topbar {background-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_topbar_bg_color', custStyle);
			}
		});
	}),
	wp.customize('killar_topbar_text_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-topbar {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_topbar_text_color', custStyle);
			}
		});
	}),
	wp.customize('killar_topbar_links_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-topbar a {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_topbar_links_color', custStyle);
			}
		});
	}),
	wp.customize('killar_topbar_links_hover_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-topbar a:hover{color : '+ contVal +';}';
				killarwt_add_customize_css('killar_topbar_links_hover_color', custStyle);
			}
		});
	}),
	wp.customize('killar_topbar_border_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-topbar, .header-topbar ul {border-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_topbar_border_color', custStyle);
			}
		});
	}),
	wp.customize('killar_header_bg_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-wrapper {background-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_header_bg_color', custStyle);
			}
		});
	}),
	wp.customize('killar_header_text_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.header-wrapper {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_header_text_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_font_size', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu > li {font-size : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_font_size', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_font_weight', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu > li {font-weight : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_font_weight', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_text_transform', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu>li>a {text-transform : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_text_transform', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_bg_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu>li {background-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_bg_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_text_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu>li>a, .header.header-transparent.dark .nav-menu>li>a {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_text_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_hover_bg_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu>li:hover {background-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_hover_bg_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_menu_text_hover_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu>li>a:hover, .header.header-transparent.dark .nav-menu>li>a:hover {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_menu_text_hover_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_megamenu_bg_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu li .kwt-megamenu {background-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_megamenu_bg_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_megamenu_text_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu li .kwt-megamenu {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_megamenu_text_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_megamenu_border_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-menu li a {border-color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_megamenu_border_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_megamenu_cols_heading_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-megamenu.lvl-1>li>a {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_megamenu_cols_heading_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_megamenu_link_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-megamenu li a {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_megamenu_link_color', custStyle);
			}
		});
	}),
	wp.customize('killar_nav_megamenu_link_hover_color', function( control ) {
		control.bind(function( contVal ) {
			if( contVal != '' ) {
				var custStyle = '.kwt-megamenu li a:hover {color : '+ contVal +';}';
				killarwt_add_customize_css('killar_nav_megamenu_link_hover_color', custStyle);
			}
		});
	}),
	
	eval(killarwt_wpcustomize([
	{action: 'killar_page_title_desktop_top_padding', style: '.page-header { padding-top: %contVal%px;}'},
	{action: 'killar_page_title_desktop_right_padding', style: '.page-header { padding-right: %contVal%px;}'},
	{action: 'killar_page_title_desktop_bottom_padding', style: '.page-header { padding-bottom: %contVal%px;}'},
	{action: 'killar_page_title_desktop_left_padding', style: '.page-header { padding-left: %contVal%px;}'},
	{action: 'killar_page_title_tablet_top_padding', style: '@media (max-width: 768px){ .page-header { padding-top: %contVal%px;} }'},
	{action: 'killar_page_title_tablet_right_padding', style: '@media (max-width: 768px){ .page-header { padding-right: %contVal%px;} }'},
	{action: 'killar_page_title_tablet_bottom_padding', style: '@media (max-width: 768px){ .page-header { padding-bottom: %contVal%px;} }'},
	{action: 'killar_page_title_tablet_left_padding', style: '@media (max-width: 768px){ .page-header { padding-left: %contVal%px;} }'},
	{action: 'killar_page_title_mobile_top_padding', style: '@media (max-width: 480px){ .page-header { padding-top: %contVal%px;} }'},
	{action: 'killar_page_title_mobile_right_padding', style: '@media (max-width: 480px){ .page-header { padding-right: %contVal%px;} }'},
	{action: 'killar_page_title_mobile_bottom_padding', style: '@media (max-width: 480px){ .page-header { padding-bottom: %contVal%px;} }'},
	{action: 'killar_page_title_mobile_left_padding', style: '@media (max-width: 480px){ .page-header { padding-left: %contVal%px;} }'},
	{action: 'killar_page_title_font_size', style: '.page-header-title { font-size: %contVal%;}'},
	{action: 'killar_page_title_bg_color', style: '.page-header { background-color: %contVal%;}'},
	{action: 'killar_page_title_text_color', style: '.page-header { color: %contVal%;}'},
	{action: 'killar_page_title_separator_color', style: '.breadcrumb-sep { color: %contVal%;}'},
	{action: 'killar_page_title_link_color', style: '.page-header a { color: %contVal%;}'},
	{action: 'killar_page_title_link_hover_color', style: '.page-header a:hover { color: %contVal%;}'},
	{action: 'killar_page_title_bg_image', style: '.bgimg-page-header { background-image: url(%contVal%);}'},
	{action: 'killar_page_title_bg_position', style: '.bgimg-page-header { background-position: %contVal%;}'},
	{action: 'killar_page_title_bg_attachment', style: '.bgimg-page-header { background-attachment: %contVal%;}'},
	{action: 'killar_page_title_bg_repeat', style: '.bgimg-page-header { background-repeat: %contVal%;}'},
	{action: 'killar_page_title_bg_size', style: '.bgimg-page-header { background-size: %contVal%;}'},
	{action: 'killar_page_title_height', style: '.page-title-wrap { height: %contVal%px;}'},
	{action: 'killar_page_title_overlay_bg_color', style: '.page-header-bgimg-overlay { background-color: %contVal%;}'},
	{action: 'killar_page_title_bg_overlay_opacity', style: '.page-header-bgimg-overlay { opacity: %contVal%;}'},
	{action: 'killar_mob_header_bg_color', style: '.header-mobile { background-color: %contVal%;}'},
	{action: 'killar_mob_header_text_color', style: '.header-mobile { color: %contVal%;}'},
	{action: 'killar_mob_header_link_color', style: '.header-mobile a:not(:hover) { color: %contVal%;}'},
	{action: 'killar_mob_header_link_hover_color', style: '.header-mobile a:hover, .header-mobile a:active { color: %contVal%;}'},
	]));
   
} )( jQuery );
