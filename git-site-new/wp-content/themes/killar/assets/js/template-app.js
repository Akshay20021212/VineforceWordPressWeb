(function ($) {
	"use strict";
	var kwt = kwt || {};
	window.kwt = kwt;
	function parseVal(s, d)
	{
		s = ( typeof s != "undefined" ) ? s : d;
		return ( ( /^\s*(true|1|on)\s*$/i ).test(s) ) ? true : false;
	}
	kwt.initialization = {
		init: function () {
			
			// Navigation
			! function(n, e, i, a) {
				n.navigation = function(t, s) {
					var o = {
							responsive: !0,
							mobileBreakpoint:mobileMenuBreikpoint,
							showDuration: 300,
							hideDuration: 300,
							showDelayDuration: 0,
							hideDelayDuration: 0,
							submenuTrigger: "hover",
							effect: "fade",
							submenuIndicator: !0,
							hideSubWhenGoOut: !0,
							visibleSubmenusOnMobile: !1,
							fixed: !1,
							overlay: !0,
							overlayColor: "rgba(0, 0, 0, 0.5)",
							hidden: !1,
							offCanvasSide: "left",
							onInit: function() {},
							onShowOffCanvas: function() {},
							onHideOffCanvas: function() {}
						},
						u = this,
						r = Number.MAX_VALUE,
						d = 1,
						f = "click.nav touchstart.nav",
						l = "mouseenter.nav",
						c = "mouseleave.nav";
					u.settings = {};
					var t = (n(t), t);
					n(t).find(".nav-menus-wrapper").prepend("<span class='nav-menus-wrapper-close-button'>✕</span>"), n(t).find(".nav-search").length > 0 && n(t).find(".nav-search").find("form").prepend("<span class='nav-search-close-button'>✕</span>"), u.init = function() {
						u.settings = n.extend({}, o, s), "right" == u.settings.offCanvasSide && n(t).find(".nav-menus-wrapper").addClass("nav-menus-wrapper-right"), u.settings.hidden && (n(t).addClass("navigation-hidden"), u.settings.mobileBreakpoint = 99999), v(), u.settings.fixed && n(t).addClass("navigation-fixed"), n(t).find(".nav-toggles").on("click touchstart", function(n) {
							n.stopPropagation(), n.preventDefault(), u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")
						}), n(t).find(".nav-menus-wrapper-close-button").on("click touchstart", function() {
							u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")
						}), n(t).find(".nav-search-button").on("click touchstart", function(n) {
							n.stopPropagation(), n.preventDefault(), u.toggleSearch()
						}), n(t).find(".nav-search-close-button").on("click touchstart", function() {
							u.toggleSearch()
						}), n(t).find(".megamenu-tabs").length > 0 && y(), n(e).resize(function() {
							m(), C()
						}), m(), s !== a && u.callback("onInit")
					};
					var v = function() {
						n(t).find("li").each(function() {
							n(this).children(".nav-dropdown,.megamenu-panel").length > 0 && (n(this).children(".nav-dropdown,.megamenu-panel").addClass("nav-submenu"), u.settings.submenuIndicator && n(this).children("a").append("<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"))
						})
					};
					u.showSubmenu = function(e, i) {
						g() > u.settings.mobileBreakpoint && n(t).find(".nav-search").find("form").slideUp(), "fade" == i ? n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).fadeIn(u.settings.showDuration) : n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).slideDown(u.settings.showDuration), n(e).addClass("nav-submenu-open")
					}, u.hideSubmenu = function(e, i) {
						"fade" == i ? n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).fadeOut(u.settings.hideDuration) : n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).slideUp(u.settings.hideDuration), n(e).removeClass("nav-submenu-open").find(".nav-submenu-open").removeClass("nav-submenu-open")
					};
					var h = function() {
							n("body").addClass("no-scroll"), u.settings.overlay && (n(t).append("<div class='nav-overlay-panel'></div>"), n(t).find(".nav-overlay-panel").css("background-color", u.settings.overlayColor).fadeIn(300).on("click touchstart", function(n) {
								u.hideOffcanvas()
							}))
						},
						p = function() {
							n("body").removeClass("no-scroll"), u.settings.overlay && n(t).find(".nav-overlay-panel").fadeOut(400, function() {
								n(this).remove()
							})
						};
					u.showOffcanvas = function() {
						h(), "left" == u.settings.offCanvasSide ? n(t).find(".nav-menus-wrapper").css("transition-property", "left").addClass("nav-menus-wrapper-open") : n(t).find(".nav-menus-wrapper").css("transition-property", "right").addClass("nav-menus-wrapper-open")
					}, u.hideOffcanvas = function() {
						n(t).find(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open").on("webkitTransitionEnd moztransitionend transitionend oTransitionEnd", function() {
							n(t).find(".nav-menus-wrapper").css("transition-property", "none").off()
						}), p()
					}, u.toggleOffcanvas = function() {
						g() <= u.settings.mobileBreakpoint && (n(t).find(".nav-menus-wrapper").hasClass("nav-menus-wrapper-open") ? (u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")) : (u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")))
					}, u.toggleSearch = function() {
						"none" == n(t).find(".nav-search").find("form").css("display") ? (n(t).find(".nav-search").find("form").slideDown(), n(t).find(".nav-submenu").fadeOut(200)) : n(t).find(".nav-search").find("form").slideUp()
					};
					var m = function() {
							u.settings.responsive ? (g() <= u.settings.mobileBreakpoint && r > u.settings.mobileBreakpoint && (n(t).addClass("navigation-portrait").removeClass("navigation-landscape"), D()), g() > u.settings.mobileBreakpoint && d <= u.settings.mobileBreakpoint && (n(t).addClass("navigation-landscape").removeClass("navigation-portrait"), k(), p(), u.hideOffcanvas()), r = g(), d = g()) : k()
						},
						b = function() {
							n("body").on("click.body touchstart.body", function(e) {
								0 === n(e.target).closest(".navigation").length && (n(t).find(".nav-submenu").fadeOut(), n(t).find(".nav-submenu-open").removeClass("nav-submenu-open"), n(t).find(".nav-search").find("form").slideUp())
							})
						},
						g = function() {
							return e.innerWidth || i.documentElement.clientWidth || i.body.clientWidth
						},
						w = function() {
							n(t).find(".nav-menu").find("li, a").off(f).off(l).off(c)
						},
						C = function() {
							if (g() > u.settings.mobileBreakpoint) {
								var e = n(t).outerWidth(!0);
								n(t).find(".nav-menu").children("li").children(".nav-submenu").each(function() {
									n(this).parent().position().left + n(this).outerWidth() > e ? n(this).css("right", 0) : n(this).css("right", "auto")
								})
							}
						},
						y = function() {
							function e(e) {
								var i = n(e).children(".megamenu-tabs-nav").children("li"),
									a = n(e).children(".megamenu-tabs-pane");
								n(i).on("click.tabs touchstart.tabs", function(e) {
									e.stopPropagation(), e.preventDefault(), n(i).removeClass("active"), n(this).addClass("active"), n(a).hide(0).removeClass("active"), n(a[n(this).index()]).show(0).addClass("active")
								})
							}
							if (n(t).find(".megamenu-tabs").length > 0)
								for (var i = n(t).find(".megamenu-tabs"), a = 0; a < i.length; a++) e(i[a])
						},
						k = function() {
							w(), n(t).find(".nav-submenu").hide(0), navigator.userAgent.match(/Mobi/i) || navigator.maxTouchPoints > 0 || "click" == u.settings.submenuTrigger ? n(t).find(".nav-menu, .nav-dropdown").children("li").children("a").on(f, function(i) {
								if (u.hideSubmenu(n(this).parent("li").siblings("li"), u.settings.effect), n(this).closest(".nav-menu").siblings(".nav-menu").find(".nav-submenu").fadeOut(u.settings.hideDuration), n(this).siblings(".nav-submenu").length > 0) {
									if (i.stopPropagation(), i.preventDefault(), "none" == n(this).siblings(".nav-submenu").css("display")) return u.showSubmenu(n(this).parent("li"), u.settings.effect), C(), !1;
									if (u.hideSubmenu(n(this).parent("li"), u.settings.effect), "_blank" == n(this).attr("target") || "blank" == n(this).attr("target")) e.open(n(this).attr("href"));
									else {
										if ("#" == n(this).attr("href") || "" == n(this).attr("href")) return !1;
										e.location.href = n(this).attr("href")
									}
								}
							}) : n(t).find(".nav-menu").find("li").on(l, function() {
								u.showSubmenu(this, u.settings.effect), C()
							}).on(c, function() {
								u.hideSubmenu(this, u.settings.effect)
							}), u.settings.hideSubWhenGoOut && b()
						},
						D = function() {
							w(), n(t).find(".nav-submenu").hide(0), u.settings.visibleSubmenusOnMobile ? n(t).find(".nav-submenu").show(0) : (n(t).find(".nav-submenu").hide(0), n(t).find(".submenu-indicator").removeClass("submenu-indicator-up"), u.settings.submenuIndicator ? n(t).find(".submenu-indicator").on(f, function(e) {
								return e.stopPropagation(), e.preventDefault(), u.hideSubmenu(n(this).parent("a").parent("li").siblings("li"), "slide"), u.hideSubmenu(n(this).closest(".nav-menu").siblings(".nav-menu").children("li"), "slide"), "none" == n(this).parent("a").siblings(".nav-submenu").css("display") ? (n(this).addClass("submenu-indicator-up"), n(this).parent("a").parent("li").siblings("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), n(this).closest(".nav-menu").siblings(".nav-menu").find(".submenu-indicator").removeClass("submenu-indicator-up"), u.showSubmenu(n(this).parent("a").parent("li"), "slide"), !1) : (n(this).parent("a").parent("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), void u.hideSubmenu(n(this).parent("a").parent("li"), "slide"))
							}) : k())
						};
					u.callback = function(n) {
						s[n] !== a && s[n].call(t)
					}, u.init()
				}, n.fn.navigation = function(e) {
					return this.each(function() {
						if (a === n(this).data("navigation")) {
							var i = new n.navigation(this, e);
							n(this).data("navigation", i)
						}
					})
				}
			}
			(jQuery, window, document), $(document).ready(function() {
				$("#navigation, #mobile-menu").navigation()
			});

			$("#js-contcheckbox").change(function() {
				if ( this.checked ) {
					$('.js-montlypricing').css('display', 'none');
					$('.js-yearlypricing').css('display', 'flex');
					$('.afterinput').addClass('text-success');
					$('.beforeinput').removeClass('text-success');
					} else {
					$('.js-montlypricing').css('display', 'flex');
					$('.js-yearlypricing').css('display', 'none');
					$('.afterinput').removeClass('text-success');
					$('.beforeinput').addClass('text-success');
				}
			});
			
			$('.header a[href^="#"]:not([data-bs-toggle]), .wsmenu a[href^="#"], .page a.btn[href^="#"], .page a.internal-link[href^="#"]').on('click', function (e) {
				e.preventDefault();
				var target = this.hash,
					$target = jQuery(target);
				if( $target.length > 0 ) {
					$htmlBody.stop().animate({
						'scrollTop': $target.offset().top - 60 // - 200px (nav-height)
					}, 'slow', 'easeInSine', function () {
						window.location.hash = '1' + target;
					});
				}
			});
			
			$('.video-popup, [data-fancybox]').magnificPopup({
				type: 'iframe',
				iframe: {
				  patterns: { 
					youtube: {
						index: 'youtube.com/',
						id: function(url) {
							var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
							if ( !m || !m[1] ) return null;
							return m[1];
						},
						src: '//www.youtube.com/embed/%id%?autoplay=1' 
					}, 
					vimeo: {
						index: 'vimeo.com/',
						id: function(url) {
							var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
							if ( !m || !m[5] ) return null;
							return m[5];
						},
						src: '//player.vimeo.com/video/%id%?autoplay=1' 
					}
				}
				} 
			});
			
			$body.on('click', '[data-toggle="modal"].portfolio-ajx-action', function(e) {
				e.preventDefault();
				var $this = $(this),
				datatarget = $this.attr("data-target"),
				dataurl = $this.attr("href");
				$this.addClass('wt-loading');
				$.ajax({
                    url: kWT.ajxUrl,
                    type: "post",
                    data: {
                        target: datatarget,
                        action: "killar_portfolio_popup"
                    },
                    success: function(data) {
						
						if($('#ModalPortfolio').length > 0 ){
							$('.modal-backdrop').remove();
							$('#ModalPortfolio').remove();
						}
					
						if($('#ModalPortfolio').length > 0 ){
							$("#ModalPortfolio .modal-portfolio").html(data);
							$('#ModalPortfolio').modal('open');
						} else {
							$('<div class="portfolio-modal modal fade" id="ModalPortfolio" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content "><div class="close-icon float-right pt-10 pr-10"><button type="button" class="close d-inline-block" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button></div><div class="modal-body"><div class="modal-portfolio">' + data + '</div></div></div></div></div>').modal('show');
						}
					
                    },
                    complete: function() {
                       $this.removeClass('wt-loading');
                    },
                    error: function(error) {
						console.log(error);
						$this.removeClass('wt-loading');
					},
                });
			});
			
			$body.on('click', '.close-icon', function(e) {
				e.preventDefault();
				$(".header-search-details").removeClass('open-search-info');
				$(".side-mobile-menu").removeClass('open-menubar');
				$(".body-overlay").removeClass("opened");
			});
			
			$body.on('click', '.body-overlay', function(e) {
				e.preventDefault();
				$(".side-mobile-menu").removeClass('open-menubar');
				$(".body-overlay").removeClass("opened");
			});
			
			$('.counter').counterUp({
				delay: 10,
				time: 1000
			});
			
			$("[data-background]").each(function (){
				$(this).css("background-image","url(" + $(this).attr("data-background") + ")");
			});

			$body.on( 'click', '.login-register-action', function() {
				$($(this).data('bs-target')).find('.modal-content').removeClass().addClass( 'modal-content ' + $(this).data('bs-class') );
			} );

			this.infiniteScroll();
			kwt.sections.kwtSlickCarousel();
			this.aos();
		},
		aos:function() {
			AOS.init({once: true, disable: 'mobile'});
		},
		infiniteScroll: function() {
			$window.on( 'load', function() {
				if ( $.fn.infiniteScroll !== undefined && $( 'div.infinite-scroll-nav .next-posts a' ).length ) {
					killarwtInfiniteScrollInit();
				}
				
				function killarwtInfiniteScrollInit() {
					$( '.infinite-scroll-wrap' ).each(function( e ) {
					  	var $this = $(this),
						infStyle = $this.parents('div').find('.infinite-pagination').data('style'),
						itemSelector = $this.parents('div').find('.infinite-pagination').data('item-selector'),
						isLoadMore = ( infStyle == 'load-more' ) ? false : true;
						$this.infiniteScroll( {
							path 	: '.next-posts a',
							append 	: ( itemSelector ) ? itemSelector : '.item-entry',
							status 	: '.infinite-pagination',
							button  : '.load-more-button',
							scrollThreshold : isLoadMore,
							hideNav : '.infinite-scroll-nav',
							history : false,
							checkLastPage : true,
						} );
						
						$this.on( 'load.infiniteScroll', function( event, response, path, items ) {
							var $items = $( response ).find( '.item-entry' );
							$items.imagesLoaded( function() {
								$items.animate( { opacity : 1 } );
								$items.find( 'img' ).each( function( index, img ) {
									img.outerHTML = img.outerHTML;
								} );

							} );

						} );
					});
				}
			} );
		},
		sidebarToggleDropdown: function (el) { 
			$document.on('click', '.sidebar-widget ul li.menu-item-has-children, .sidebar-widget ul li.page_item_has_children', function (e) {
				var ele = $(this);
				if (ele.hasClass('open')) {
					ele.removeClass('open').find('li').removeClass('open');
					ele.find('ul').slideUp();
				} else {
					ele.addClass('open').children('ul').slideDown();
					ele.siblings('li').children('ul').slideUp();
					ele.siblings('li').removeClass('open');
					ele.siblings('li').find('li').removeClass('open');
					ele.siblings('li').find('ul').slideUp();
				}
			});
		}
	},
	kwt.header = {
		init: function () {
			//this.megaMenu();
			this.searchToggle();
		},
		searchToggle: function () {
			$body.on('click', '.search-action', function(){
				$(this).parents('.header-search').toggleClass('search-open');
			});
		},
		megaMenu: function () {
			var MegaMenu = {
				MegaMenuData: {
					header: '.header-wrapper',
					menu: '.kwt-menu',
					submenu: '.kwt-dropdown',
					toggleMenu: '.toggleMenu',
					simpleDropdn: '.has-simple-menu',
					megaDropdn: '.has-mega-menu',
					vertical: false
				},
				init: function (options) {
					$.extend(this.MegaMenuData, options);
					if ( !isMobile && $(this.MegaMenuData.menu).length) {
						MegaMenu._handlers(this);
					}
				},
				_handlers: function (menu) {
					
					function setMaxHeight(wHeight, submenu) {
						if ($menu.hasClass('menu-vertical')) return false;
						if (submenu.length) {
							var maxH = $header.find('.header-wrapper').hasClass('sticky-menu') ? (wHeight - $header.find('.header-wrapper.sticky-menu').outerHeight()) : (wHeight - submenu.prev().offset().top - submenu.prev().outerHeight());
							submenu.css({
								'max-height': maxH + 'px'
							})
						}
					}
					
					function setMenuXPosition(wWidth, submenu) {
						if ($menu.hasClass('menu-vertical')) return false;
						if (submenu.length) {
							submenu.css("left", '');
							var menuContainer = $header.find('.menu-container');
							if(typeof submenu.offset() !== 'undefined' && menuContainer && submenu.parent('li').hasClass('has-mega-menu')){
								var oPosition = submenu.offset().left,
								oWidth = submenu.outerWidth(),
								cnWidth = menuContainer.width(),
								cnLeftOffset = menuContainer.offset().left;
								if (submenu.parent('li').hasClass('mega-menu-full-width')) {
									submenu.find('.kwt-megamenu-inside').width(cnWidth);
								}
								if ( oWidth + oPosition - cnLeftOffset >= cnWidth ) {
									var delta = parseInt( oWidth + oPosition - cnWidth - cnLeftOffset - 15);
									submenu.css({'left' : - delta});
								}
							}
						}
					}
					
					function setSubmenuPosition(wWidth, submenu) {
						if ($menu.hasClass('menu-vertical')) return false;
						if (submenu.length) {
							submenu.find('li').each(function() {
								var $this = $(this),
								menuContainer = $header.find('.menu-container'),
								$item = $($this).find('.kwt-megamenu-inside .kwt-dropdown').first();
								if ( $($item).length > 0 ) {
									if ( submenu.parent('li').hasClass('menu-item') ) {
										wWidth = (menuContainer.width())+(menuContainer.offset().left) ;
									}
									var ofRight = (wWidth - ($item.offset().left + $item.outerWidth()));
									if ( ofRight < 0 ) {
										$($item).removeClass('to-right').addClass('to-left');
									}
								}
							});
						}
					}

					function clearMaxHeight() {
						$submenu.each(function () {
							var $this = $(this);
							$this.css({
								'max-height': ''
							});
						})
					}

					var $menu = $(menu.MegaMenuData.menu),
						submenu = menu.MegaMenuData.submenu,
						$submenu = $(menu.MegaMenuData.submenu, $menu),
						$header = $(menu.MegaMenuData.header),
						$toggleMenu = $(menu.MegaMenuData.toggleMenu),
						megaDropdnClass = menu.MegaMenuData.megaDropdn,
						simpleDropdnClass = menu.MegaMenuData.simpleDropdn,
						vertical = menu.MegaMenuData.vertical;
						
					if (vertical && (window.innerWidth || $window.width()) < 1024) {
						$menu.on(".kwt-menu", ".submenu a", function (e) {
							var $this = $(this);
							if (!$this.data('firstclick')) {
								$this.data('firstclick', true);
								e.preventDefault();
							}
						});
						$menu.on(".kwt-menu", megaDropdnClass + '> a,' + simpleDropdnClass + '> a', function (e) {
							if (!$(this).parent('li').hasClass('hovered')) {
								setMaxHeight($window.height(), $(this).next());
								$submenu.scrollTop(0);
								$('li', $menu).removeClass('hovered');
								$(this).parent('li').addClass('hovered');
								e.preventDefault();
							} else {
								clearMaxHeight();
								$(this).parent('li').removeClass('hovered');
								$(submenu + 'a').removeData('firstclick');
							}
						});
						$menu.on(".kwt-menu", function (e) {
							e.stopPropagation();
						})
					} else {
						
						$menu.on('hover mouseenter', '.has-mega-menu, .has-simple-menu', function () {
							var $this = $(this),
								$submenu = $this.find(submenu).first();
							setMaxHeight($(window).height(), $submenu);
							setMenuXPosition($(window).width(), $submenu);
							setSubmenuPosition($(window).width(), $submenu);
							$submenu.scrollTop(0);
							$this.addClass('hovered');
						}).on("mouseleave", megaDropdnClass + ',' + simpleDropdnClass, function () {
							clearMaxHeight();
							var $this = $(this);
							$this.removeClass('hovered');
						});
						
					}
					
					$toggleMenu.on('click', function (e) {
						var $this = this;
						$header.toggleClass('open');
						$this.toggleClass('open');
						$menu.addClass('disable').delay(1000).queue(function () {
							$this.removeClass('disable').dequeue();
						});
						e.preventDefault();
					});
					
					if (vertical) {
						$('li.has-simple-menu', $menu).on('hover', function () {
							var $this = $(this),
								$elm = $('.sub-menu', this).length ? $('.sub-menu', this) : $('ul:first', this),
								windowH = $window.height(),
								isYvisible = (windowH + $window.scrollTop()) - ($elm.offset().top + $elm.outerHeight());
							if (isYvisible < 0 && !$this.hasClass('has-mega-menu')) {
								$elm.css({
									'margin-top': isYvisible + 'px'
								});
							}
						})
					}
				}
			};
			kwt.megamenu = Object.create(MegaMenu);
			kwt.megamenu.init();
		},
	},
	kwt.sections = {
		init: function () {
			this.kwtSlickCarousel();
			this.masonryGrid();
		},
		kwtSlickCarousel: function () {
			var slickCarousel = {
				data: {
					carousel: '.kwt-slick-slider'
				},
				init: function (options) {
					$.extend(this.data, options);
					if (w < maxSM && $(this.data.carousel).hasClass('js-product-isotope-sm')) {
						return false;
					}
					this.reinit();
				},
				reinit: function () {
					$('body').find(this.data.carousel).each(function () {
						var $this = $(this),
							arrowsplace;
						if (w < maxSM && $this.hasClass('js-product-isotope-sm')) {
							if ( $this.hasClass('slick-initialized')) {
								 $this.css({
									'height': ''
								}).slick('unslick');
							}
							return false;
						} else if ( $this.hasClass('slick-initialized')) {
							 $this.css({'height': ''}).slick('unslick');
						}
						if ($this.parent().find('.carousel-arrows').length) {
							arrowsplace = $this.parent().find('.carousel-arrows');
						} else if ($this.closest('.holder').find('.carousel-arrows').length) {
							arrowsplace = $this.closest('.holder').find('.carousel-arrows');
						}
						$this.on('beforeChange', function () {
							$this.find('.color-swatch').each(function () {
								$(this).find('.js-color-toggle').first().trigger('click');
							})
						});
						var items =  $this.data('items'),
							itemsXXL =  $this.data('items-xxl') || 4,
							itemsXL =  $this.data('items-lg') || 4,
							itemsLG =  $this.data('items-lg') || 4,
							itemsMD =  $this.data('items-md') || 3,
							itemsSM =  $this.data('items-sm') || 2,
							itemsXS =  $this.data('items-xs') || 1,
							rows =  $this.data('rows') || 1;
						var slick = $this.slick({
							rows: rows,
							slidesToShow: items,
							slidesToScroll: 1,
							arrows: parseVal( $this.data('nav'), true ),
							dots: parseVal( $this.data('dots'), true ),
							appendArrows: arrowsplace,
							adaptiveHeight: parseVal( $this.data('adaptive-height'), true ),
							infinite: parseVal( $this.data('infinite'), true ),
							autoplay: parseVal( $this.data('autoplay'), false ),
							autoplaySpeed: $this.data('autoplay-speed') || 1500,
							speed: $this.data('speed') || 500,
							centerMode: parseVal( $this.data('center-mode'), false ),
							variableWidth: parseVal( $this.data('variable-width'), false ),
							asNavFor: $this.data('as-nav-for'),
							prevArrow:'<span class="slik-prev"><span class="fas fa-long-arrow-left l-a"></span></span>',
							nextArrow:'<span class="slik-next"><span class="fas fa-long-arrow-right r-a"></span></span>',
							centerPadding: "0",
							responsive: [
							{
								breakpoint: 1770,
								settings: {
									slidesToShow: items,
								}
							},
							{
								breakpoint: 1400,
								settings: {
									slidesToShow: itemsXXL,
								}
							},
							{
								breakpoint: 1200,
								settings: {
									slidesToShow: itemsXL,
								}
							},
							{
								breakpoint: 992,
								settings: {
									slidesToShow: itemsLG,
									variableWidth: parseVal( $this.data('variable-width-tablet'), false ),
								}
							},
							{
								breakpoint: 768,
								settings: {
									slidesToShow: itemsMD,
									variableWidth: parseVal( $this.data('variable-width-mobile'), false ),
								}
							},
							{
								breakpoint: 576,
								settings: {
									slidesToShow: itemsSM,
									variableWidth: parseVal( $this.data('variable-width-mobile'), false ),
								}
							},
							{
								breakpoint: 0,
								settings: {
									slidesToShow: itemsXS,
									variableWidth: parseVal( $this.data('variable-width-mobile'), false ),
								}
							},
							{
								breakpoint: 0,
								settings: {
									slidesToShow: 1,
									variableWidth: parseVal( $this.data('variable-width-mobile'), false ),
								}
							}]
						});
					});
				}
			}
			kwt.kwtSlickCarousel = Object.create(slickCarousel);
			kwt.kwtSlickCarousel.init({});
		},
		masonryGrid: function() {
			$('.grid-loaded').imagesLoaded(function () {
				$('.masonry-filter').on('click', 'button', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({
					  filter: filterValue
					});
				});
				$('.masonry-filter button').on('click', function () {
					$('.masonry-filter button').removeClass('active');
					$(this).addClass('active');
					var selector = $(this).attr('data-filter');
					$grid.isotope({
					  filter: selector
					});
					return false;
				});
				var $grid = $('.masonry-wrap').isotope({
					itemSelector: '.masonry-item',
					percentPosition: true,
					transitionDuration: '0.7s',
					masonry: {
					  columnWidth: '.masonry-item',
					}
				});
				
			});
		},
	},
	kwt.general = {
		init: function () {

			function initnewsLetterObj($obj) {
					var pause = $obj.attr('data-pause');
					setTimeout(function() {
						$obj.modal('show');
					}, pause);
			};
		
			$('#newsletter-modal').on('click', '.checkbox-group', function() {
				$.cookie('modalnewsletter', '1', { expires: 7, path:'/' });
			});
			var modalnewsletter = $.cookie('modalnewsletter'),
					newsLetterObj = $('#newsletter-modal');

			if (modalnewsletter == 1) return;
			if(newsLetterObj.length){
					initnewsLetterObj(newsLetterObj);
					$body.addClass('modal-newsletter');
					$('#newsletter-modal').on('click', '.modal-header .close', function() {
						$body.removeClass('modal-newsletter');
					});
			};
		},
		preLoader: function () {
			var preloader = $('#loader-wrapper'),
			loader = preloader.find('.cssload-loader');
			loader.fadeOut();
			preloader.delay(200).fadeOut('slow');
		},
		scrollFromTop: function () {
			var stickyWrap = $(".wsmainfull, .wsmobileheader, .header-wrapper");
			if( !stickyWrap.hasClass( 'no-sticky' ) ) {
				if( $window.scrollTop() > 80 ){		
					stickyWrap.addClass('sticky-menu header-fixed');
				} else {
					stickyWrap.removeClass('sticky-menu header-fixed');
				}
			}
		},
		scrollUp: function ( options ) {
			var defaults = {
				scrollName: 'scrollUp', // Element ID
				topDistance: 600, // Distance from top before showing element (px)
				topSpeed: 800, // Speed back to top (ms)
				scrollText: '', // Text for element
				scrollImg: false, // Set true to use image
			};
			var o = $.extend({}, defaults, options),
				scrollId = '#' + o.scrollName;
			$('<a/>', {
				id: o.scrollName,
				href: '#top',
				title: o.scrollText,
				class: o.scrollName,
			}).appendTo('body');
			if (!o.scrollImg) {
				$(scrollId).text(o.scrollText);
			}
			$window.on('scroll', function(){	
				$( ($window.scrollTop() > o.topDistance) ? $(scrollId).addClass('show') : $(scrollId).removeClass('show') );
			});
			$(scrollId).on('click', function(event){
				$htmlBody.animate({scrollTop:0}, o.topSpeed);
				event.preventDefault();
			});
		},
	};
	kwt.documentReady = {
		init: function () {
			kwt.initialization.init();
			kwt.general.scrollUp();
			kwt.header.init();
			kwt.sections.init();
		}
	};
	kwt.documentLoad = {
		init: function () {
			kwt.general.init();
			kwt.general.preLoader();
		}
	};
	kwt.documentScroll = {
		init: function () {
			kwt.general.scrollFromTop();
		}
	};
	
	var $body = $('body'),
		$htmlBody = $('html, body'),
		$window = $(window),
		$document = $(document),
		w = $window.innerWidth() || $window.width(),
		swipemode = false,
		maxXXS = 0,
		maxXS = 576,
		maxSM = 768,
		maxMD = 992,
		maxLG = 1200,
		maxXL = 1770,
		mobileMenuBreikpoint = 992,
		isMobile = w < mobileMenuBreikpoint;
		$document.on('ready', kwt.documentReady.init);
		$window.on('load', kwt.documentLoad.init);
		$window.on('scroll', kwt.documentScroll.init);
})(jQuery, window, document);

/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD (Register as an anonymous module)
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (arguments.length > 1 && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {},
			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling $.cookie().
			cookies = document.cookie ? document.cookie.split('; ') : [],
			i = 0,
			l = cookies.length;

		for (; i < l; i++) {
			var parts = cookies[i].split('='),
				name = decode(parts.shift()),
				cookie = parts.join('=');

			if (key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));