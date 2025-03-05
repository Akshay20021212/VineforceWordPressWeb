(function ($) {
	"use strict";
	var kwwt = kwwt || {};
	window.kwwt = kwwt;
	kwwt.initialization = {
		init: function () {
			this.addToWishlist();
			this.addToCompare();
			this.productQuickview();
			this.changeInput();
			this.singleAjaxAddtoCart();
			this.afterAddtoCart();
			this.autoCartUpdate();
		},
		addToWishlist: function() {
			$body.on("click", ".add_to_wishlist", function() {
				$(this).addClass("wt-icoldr");
			})
		},
		addToCompare: function() {
			$body.on("click", "a.compare", function() {
				$(this).addClass("wt-icoldr");
			});
			$body.on("yith_woocompare_open_popup", function() {
				$("a.compare").removeClass("wt-icoldr");
				$body.addClass("compare-opened")
			});
			$body.on('click', '#cboxClose, #cboxOverlay', function() {
				$body.removeClass("compare-opened")
			})
		},
		productQuickview: function() {
			$body.on('click', '.quickview-action', function(e) {
				e.preventDefault();
				var $this = $(this),
					pid = $this.data('product_id');
				$this.addClass('wt-icoldr');
				$.ajax({
                    url: ewWT.ajxUrl,
                    type: "post",
                    data: {
                        product_id: pid,
                        action: "killar_product_quickview"
                    },
                    success: function(response) {
                       $.magnificPopup.open({
                            items: {
                                src: '<div class="wt-quickview-popup zoom-anim-dialog">' + response + "</div>",
                                type: "inline"
                            },
                            removalDelay: 500,
                            enableEscapeKey: !0,
                            callbacks: {
                                beforeOpen: function() {
                                    this.st.mainClass = "mfp-move-horizontal my-mfp-zoom-in quick-view-wrapper"
                                },
                                open: function() {
									kwt.sections.kwtSlickCarousel();
									var $prod = $('.wt-quickview'),
									$gallery = $prod.find('.woocommerce-product-gallery__wrapper'),
									$variation = $('.variations_form'),
									$buttons = $prod.find('form.cart .actions-button'),
									$buy_now = $buttons.find('.buy_now_button');
									$gallery.find('.woocommerce-product-gallery__image > a').on('click', function (e) {
										e.preventDefault();
									});
									$variation.each(function() {
										$(this).wc_variation_form().find(".variations select:eq(0)").change()
									});
									$variation.trigger("wc_variation_form");
                                    
									
                                }
                            }
					  });
                    },
                    complete: function() {
                       $this.removeClass('wt-icoldr');
                    },
                    error: function(error) {
						console.log(error);
						$this.removeClass('wt-icoldr');
					},
                });
			});
		},
		changeInput: function () {
			$body.on('click', '.decrease, .increase', function (e) {
				var $this = $(this),
					input = $this.parents('.quantity').find('input[name="quantity"], input.qty'),
					step = parseFloat(input.attr('step')),
					step = step ? step : 1,
					v = $this.hasClass('decrease') ? input.val() - step : input.val() * 1 + step,
					min = input.attr('min') ? input.attr('min') : 1,
					max = input.attr('max') ? input.attr('max') : false;
				if (v >= min) {
					if (!max == false && v > max) {
						return false
					} else input.val(v).trigger('change');
				}
				e.preventDefault();
			});
		},
		singleAjaxAddtoCart : function () {
			if ( ! ewWT.ajax_add_to_cart ) { return; }
			
			$body.on('submit', 'form.cart', function (e) {
				
				var $productWrapper = $(this).parents('.single-product-page');
				if ($productWrapper.hasClass('product-type-external')) return;
					
				var $form = $(this),
					$singleBtn = $form.find('.single_add_to_cart_button'),
					product_id = $form.find('input[name=add-to-cart]').val() || $singleBtn.val();
					
				if ( $form.length > 0 ) {
					e.preventDefault();
				} else {
					return;
				}
				
				let data=$form.serialize();
				data += '&action=killar_ajax_add_to_cart&add-to-cart='+product_id;
				
				$singleBtn.removeClass('added not-added');
				$singleBtn.addClass('loading');

				// Trigger event
				$body.trigger('adding_to_cart', [$singleBtn, data]);

				$.ajax({
					url: ewWT.ajxUrl,
					data: data,
					method: 'POST',
					success: function (response) {
						if (!response) {
							return;
						}

						var this_page = window.location.toString();
						this_page = this_page.replace('add-to-cart', 'added-to-cart');
						if (response.error && response.product_url) {
							window.location = response.product_url;
							return;
						} else {
							$singleBtn.removeClass('loading');
							
							if (typeof wc_add_to_cart_params !== 'undefined') {
								if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
									window.location = wc_add_to_cart_params.cart_url;
									return;
								}	
							}

							var fragments = response.fragments;
							if (fragments) {
								$.each(fragments, function (key, value) {
									$(key).addClass('updating');
									$(key).replaceWith(value);
								});
							}
							
							// Show notices
							if (response.notices.indexOf('error') > 0) {
								$('.woocommerce-notices-wrapper').empty().append(response.notices);
								$singleBtn.addClass('not-added');
							} else {
								$singleBtn.addClass('added');
								$body.trigger('added_to_cart', [fragments, response.cart_hash, $singleBtn]);
							}
						}
					},
					error: function () {
						console.log('Ajax adding to cart error');
					}
				});
			});
		},
		afterAddtoCart: function() {
			$body.on('added_to_cart', function(e, obj) {
				if ($('.minicart-action').length > 0) {
					$($('.minicart-action').attr('href')).offcanvas('show');
				}
				var minicartDrpdwn = $('.woo-minicart-dropdown');
				if (minicartDrpdwn.length > 0) {
					minicartDrpdwn.toggleClass('hovered');
					setTimeout(function(){
						minicartDrpdwn.toggleClass('hovered');
					}, 5000);
				}
			});
		},
		autoCartUpdate: function() {
			if( $('.woocommerce-cart-form').length >= 0 ) {
				$body.on('change', '.woocommerce-cart-form .product-quantity',function(e) {
					$("[name='update_cart']").removeAttr('disabled');
					$("[name='update_cart']").trigger("click"); 
				} );
			}
		}
	},
	kwwt.catalog = {
		init: function () {
			this.mobileFilter('.fixed-col');
			this.sidebarProdutsCattegories();
			this.viewMode('.view-mode'); // product view mode toggle
		},
		mobileFilter: function (el) {
			var $mobileFilter = $(el),
				toggleFilter = '.fixed-col-toggle, .filter-close';
			$document.on('click', toggleFilter, function (e) {
				$mobileFilter.toggleClass('active');
				$('body').toggleClass('is-fixed');
				e.preventDefault();
			});
			$document.on('touchstart click', '.fixed-col', function (e) {
				if ($(e.target).hasClass('active')) {
					$mobileFilter.removeClass('active');
					$('body').removeClass('is-fixed');
					e.preventDefault();
				}
			});
		},
		sidebarProdutsCattegories: function (el) {
			$document.on('click', '.product-categories li.cat-parent', function (e) {
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
				//e.preventDefault();
			});
		},
		viewMode: function (viewmode) {
			var $grid = $('.grid-view', $(viewmode)),
				$list = $('.list-view', $(viewmode)),
				$products = $('.products-wrap');
		
			$grid.on("click", function (e) {
				var $this = $(this);
				if (!$this.is('.active')) {
					$list.removeClass('active');
					$this.addClass('active');
					$products.removeClass('listing-view');
				}
				e.preventDefault();
			});
			$list.on("click", function (e) {
				var $this = $(this);
				if (!$this.is('.active')) {
					$grid.removeClass('active');
					$('[data-view]').removeClass('active');
					$this.addClass('active');
					$products.addClass('listing-view');
				}
				e.preventDefault();
			});
		},
	},
	kwwt.addtocart = {
		init: function () {
			
		},
		singleAjaxAddtoCart : function () {
			
			$('body').on('submit', 'form.cart', function (e) {
				
				var $productWrapper = $(this).parents('.single-product-page');
				if ($productWrapper.hasClass('product-type-external')) return;

				e.preventDefault();

				var $form = $(this),
					$singleBtn = $form.find('.single_add_to_cart_button'),
					data = $form.serialize();

				data += '&action=killar_ajax_add_to_cart';

				if ($singleBtn.val()) {
					data += '&add-to-cart=' + $singleBtn.val();
				}

				$singleBtn.removeClass('added not-added');
				$singleBtn.addClass('loading');

				// Trigger event
				$(document.body).trigger('adding_to_cart', [$singleBtn, data]);

				$.ajax({
					url: ewWT.ajxUrl,
					data: data,
					method: 'POST',
					success: function (response) {
						if (!response) {
							return;
						}

						var this_page = window.location.toString();

						this_page = this_page.replace('add-to-cart', 'added-to-cart');

						if (response.error && response.product_url) {
							window.location = response.product_url;
							return;
						}

						// Redirect to cart option
						if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {

							window.location = wc_add_to_cart_params.cart_url;
							return;

						} else {

							$singleBtn.removeClass('loading');

							var fragments = response.fragments;
							var cart_hash = response.cart_hash;


							// Block fragments class
							if (fragments) {
								$.each(fragments, function (key) {
									$(key).addClass('updating');
								});
							}

							// Replace fragments
							if (fragments) {
								$.each(fragments, function (key, value) {
									$(key).replaceWith(value);
								});
							}

							// Show notices
							if (response.notices.indexOf('error') > 0) {
								$('body').append(response.notices);
								$singleBtn.addClass('not-added');
							} else {
								// Changes button classes
								$singleBtn.addClass('added');
								// Trigger event so themes can refresh other areas
								$(document.body).trigger('added_to_cart', [fragments, cart_hash, $singleBtn]);
							}

						}
					},
					error: function () {
						console.log('ajax adding to cart error');
					},
					complete: function () { },
				});

			});
		},
		AddtoCart : function(e, products_id, action, qty, d, t){
			var action = action || 'add';
			var qty = qty || '1';

			setPzenAjxloaderClass(e, 'add', t);
			
			if((typeof d!="undefined") && d!=''){
				d = d;
			}else{
				d = new FormData; 
				d.append('pzen_action', action); 
				d.append('products_id', products_id); 
				d.append('qty', qty);
			}
			
			try {
				jQuery.ajax({
					type : 'post',
					url  : ewWT.ajxUrl,
					dataType : 'json',
					contentType: false, // The content type used when sending data to the server.
					cache: false,  // To unable request pages to be cached
					processData:false,  
					data : d,
					success :function(data){
						setPzenAjxData(e, data, action);
						setPzenAjxloaderClass(e, 'remove', t);
					},
					error: function(xhr, textStatus, errorThrown) {
						var err = eval("(" + xhr.responseText + ")");
						setPzenAjxQck(e, "Error: " + xhr.status + ": " + xhr.statusText);
						setPzenAjxloaderClass(e, 'remove', t);
					}
				});
			} catch (e) {
			}
			return false;
		}
			
	},
	kwwt.product = {
		init: function () {
			this.productGalleryImage('.product-gallery-image:not(.no-zoom)');
			this.productGalleryThumbnails('.product-gallery-thumbnails');
			this.productTabsToggle();
		},
		productGalleryImage: function (gallery) {
			if ( ! ewWT.productGalleryZoom ) { return; }
			var galleryImg = $(gallery).find( '.woocommerce-product-gallery__image' );
			if ( galleryImg.length > 0 ) {
				galleryImg.trigger('zoom.destroy');
				galleryImg.zoom({
					touch: false
				});
			}
		},
		productGalleryThumbnails: function (thumbnails) {
			var thumbnails = $(thumbnails);
			if ( thumbnails.length > 0 ) {
				$('.product-gallery-slider').on('afterChange', function(event, slick, currentSlide, nextSlide){
					thumbnails.find('.slick-slide').removeClass('slick-current');
					thumbnails.find('.slick-slide:not(.slick-cloned)').eq(currentSlide).addClass('slick-current');  
				});
			}
			
		},
		productTabsToggle: function () {
			
			$('.woocommerce-tabs').each(function () {
				var wrapper = jQuery(this);

				var hasTabs = wrapper.hasClass('tabs-layout');
				var hasAccordion = wrapper.hasClass('accordion');
				var startOpen = wrapper.hasClass('open');

				var dl = wrapper.children('dl:first');
				var dts = dl.children('dt');
				var panes = dl.children('dd');
				var groups = new Array(dts, panes);

				//Create a ul for tabs if necessary.
				if (hasTabs) {
					var lis = jQuery('.wc-tabs').children();
					groups.push(lis);
				}

				//Add "last" classes.
				var i;
				for (i = 0; i < groups.length; i++) {
					groups[i].filter(':last').addClass('last');
				}

				function toggleClasses(clickedItem, group) {
					var index = group.index(clickedItem);
					var i;
					for (i = 0; i < groups.length; i++) {
						groups[i].removeClass('active');
						groups[i].find('a').removeClass('active');
						groups[i].eq(index).addClass('active');
						groups[i].eq(index).find('a').addClass('active');
					}
				}

				//Toggle on tab (dt) click.
				dts.on('click', function (e) {
					e.preventDefault();
					//They clicked the active dt to close it. Restore the wrapper to unclicked state.
					/*if (jQuery(this).hasClass('active') && wrapper.hasClass('accordion-open')) {
						wrapper.removeClass('accordion-open');
					} else {
						//They're clicking something new. Reflect the explicit user interaction.
						wrapper.addClass('accordion-open');
					}*/
					//toggleClasses(jQuery(this), dts);
					lis.eq(dts.index(jQuery(this))).find('a').trigger('click');
				});

				//Toggle on tab (li) click.
				if (hasTabs) {
					lis.on('click', function (e) {
						toggleClasses(jQuery(this), lis);
					});
					//Open the first tab.
					lis.eq(0).find('a').trigger('click');
				}

				//Open the first accordion if desired.
				if (startOpen) {
					dts.eq(0).find('a').trigger('click');
				}

			});
		}
	};
	kwwt.documentReady = {
		init: function () {
			kwwt.initialization.init();
			kwwt.catalog.init();
			kwwt.addtocart.init();
			kwwt.product.init();
		}
	};
	kwwt.documentLoad = {
		init: function () {
			//kwwt.general.preLoader();
		}
	};
	kwwt.documentScroll = {
		init: function () {
			//kwwt.general.scrollFromTop();
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
		$document.on('ready', kwwt.documentReady.init);
		$window.on('load', kwwt.documentLoad.init);
		$window.on('scroll', kwwt.documentScroll.init);
})(jQuery, window, document);