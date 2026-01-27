(function($) { 
	"use strict";  

	/*Preloader js */
		$('.preloader_wrap').delay(400).fadeOut('slow');
		$('.preloader_wrap').delay(350).fadeOut('slow'); 
	
	// Active Slick Nav 
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 100) {
			$('#header-area').addClass('sticky');
		} else {
			$('#header-area').removeClass('sticky');
		}
	});
		
		
	jQuery(document).ready(function($) {
					
		/*Mobile Menu Js Start*/
		$(".main-menu").meanmenu({
			meanMenuContainer: ".mobile-menu",
			meanScreenWidth: "1199",
			meanExpand: ['<i class="far fa-plus"></i>'],
		});

		// Sidebar Toggle Js Start //
		$(".offcanvas__close,.offcanvas__overlay").on("click", function () {
			$(".offcanvas__info").removeClass("info-open");
			$(".offcanvas__overlay").removeClass("overlay-open");
		});
		$(".sidebar__toggle").on("click", function () {
			$(".offcanvas__info").addClass("info-open");
			$(".offcanvas__overlay").addClass("overlay-open");
		});

		/*Counter */
		$('.counter_up').on('inview', function(event, visible, visiblePartX, visiblePartY) {
			if (visible) {
				$(this).find('span.count').each(function () {
					var $this = $(this);
					$({ Counter: 0 }).animate({ Counter: $this.text() }, {
						duration: 2000,
						easing: 'swing',
						step: function () {
							$this.text(Math.ceil(this.Counter));
						}
					});
				});
				$(this).unbind('inview');
			}
		});				
	});		

	// TR Slider
	const tr_slider = new Swiper('.tr_slider', {
		// Optional parameters
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		// Navigation arrows
		navigation: {
			nextEl: '.hs_next_arrow',
			prevEl: '.hs_prev_arrow',		
		},
		pagination: {
			el: ".hero_pagination",
			clickable: true,
		},
		effect: "fade",
		breakpoints: {
			1299: {
				slidesPerView: 1,
			},
			1199: {
				slidesPerView: 1,
			},					
			1024: {
				slidesPerView: 1,
			},
			991: {
				slidesPerView: 1,
			},			

			767: {
				slidesPerView: 1,
			},
			575: {
				slidesPerView: 1,
			},
			0: {
				slidesPerView: 1,
			},
		},
	});
	

	//Gallery Slider

	var vgthumb = new Swiper(".vgallery_thumb", {
      loop: true,
      spaceBetween: 20,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
		// Responsive breakpoints
		breakpoints: {
			0: {
				slidesPerView: 2,
			},			
			640: {
				slidesPerView: 2,
			},
			768: {
				slidesPerView: 3,
			},
			1024: {
				slidesPerView: 4,
			},
		},	  
	  
    });

    var vgslider = new Swiper(".vgallery_slider", {
      loop: true,
      spaceBetween: 10,
	  initialSlide: 2,
	  effect: 'fade',
      navigation: {
        nextEl: ".vgarrow_next",
		prevEl: ".vgarrow_prev",
      },
      thumbs: {
        swiper: vgthumb,
      },
    });

	// Tour Swipper Slider
	const package_slider = new Swiper(".packages_slider", {
		slidesPerView: 1,
		spaceBetween: 20,
		loop: true,
		pagination: {
			el: ".tslider-pagination",
			type: "progressbar",
		},
		navigation: {
			nextEl: ".tslider-arrow-next",
			prevEl: ".tslider-arrow-prev",
		},

		// Responsive breakpoints
		breakpoints: {
			640: {
				slidesPerView: 1,
			},
			768: {
				slidesPerView: 1,
			},
			1024: {
				slidesPerView: 2,
			},
			1299: {
				slidesPerView: 3,
			},
			1199: {
				slidesPerView: 3,
			},
		},
	});
	
	// Testimonials
	var testthumb = new Swiper(".test_thumb", {
		loop: true,
		spaceBetween: 0,
		slidesPerView: 1,
		effect: 'fade',
		freeMode: true,
		watchSlidesProgress: true,
		loop: true,
	});

	var test_slider = new Swiper('.test_slider', {
		// Optional parameters
		slidesPerView: 1,
		spaceBetween: 30,
		effect: 'slide',
		loop: true,
		// Navigation arrows
		navigation: {
			nextEl: '.tarrow_right',
			prevEl: '.tarrow_left',		
		},

		breakpoints: {
			1299: {
				slidesPerView: 1,
			},
			1199: {
				slidesPerView: 1,
			},					
			1024: {
				slidesPerView: 1,
			},
			991: {
				slidesPerView: 1,
			},			

			767: {
				slidesPerView: 1,
			},
			575: {
				slidesPerView: 1,
			},
			0: {
				slidesPerView: 1,
			},
		},

		thumbs: {
			swiper: testthumb,
		},
	});

	
	//  Image Gallery Slider
	const tourgallery = new Swiper(".img_gallery_slider", {
		slidesPerView: 5,
		spaceBetween: 20,
		loop: true,
	
		// Responsive breakpoints
		breakpoints: {
			1299: {
				slidesPerView: 5,
			},
			1199: {
				slidesPerView: 5,
			},					
			1024: {
				slidesPerView: 4,
			},
			991: {
				slidesPerView: 3,
			},			

			767: {
				slidesPerView: 3,
			},
			575: {
				slidesPerView: 2,
			},
			0: {
				slidesPerView: 1,
			},
		},
	});

	//  Tour Detials Page  Gallery Slider
	const tdgalleryslider = new Swiper(".td_gallery_slider", {
		slidesPerView: 4,
		spaceBetween: 20,
		loop: true,
		// Navigation arrows
		navigation: {
			nextEl: '.sdt_arrow_next',
			prevEl: '.sdt_arrow_prev',		
		},
		// Responsive breakpoints
		breakpoints: {
		640: {
			slidesPerView: 2,
		},
		768: {
			slidesPerView: 4,
		},
		1024: {
			slidesPerView: 4,
		},
		},
	});

	//  Related Tour Slider
	const relatedtourslider = new Swiper(".related_tour_slider", {
		slidesPerView: 3,
		spaceBetween: 20,
		loop: true,
		// Responsive breakpoints
		breakpoints: {
			1299: {
				slidesPerView: 3,
			},
			1199: {
				slidesPerView: 3,
			},					
			1024: {
				slidesPerView: 2,
			},
			991: {
				slidesPerView: 2,
			},			

			767: {
				slidesPerView: 1,
			},
			575: {
				slidesPerView: 1,
			},
			0: {
				slidesPerView: 1,
			},
		},
	});	
	
	// Activity Slider
	const activity_slider = new Swiper(".activity_slider", {
		slidesPerView: 4,
		spaceBetween: 20,
		loop: true,
		// Responsive breakpoints
		breakpoints: {
			1299: {
				slidesPerView: 4,
			},
			1199: {
				slidesPerView: 3,
			},					
			1024: {
				slidesPerView: 3,
			},
			991: {
				slidesPerView: 2,
			},			

			767: {
				slidesPerView: 2,
			},
			480: {
				slidesPerView: 2,
			},		
			0: {
				slidesPerView: 1,
			},
		},
	});

	// Guide Slider
	const guide_slider = new Swiper(".guide_slider", {
		slidesPerView: 4,
		spaceBetween: 25,
		loop: true,
		// Navigation arrows
		navigation: {
			nextEl: '.guarrow_right',
			prevEl: '.guarrow_left',		
		},
		breakpoints: {
			1299: {
				slidesPerView: 4,
			},
			1199: {
				slidesPerView: 3,
			},					
			1024: {
				slidesPerView: 3,
			},
			991: {
				slidesPerView: 2,
			},			

			767: {
				slidesPerView: 2,
			},
			0: {
				slidesPerView: 1,
			},
		},
	});

	//Clients
	$('.clients_slider').owlCarousel({
		loop: true,
		item:6,
		margin: 25,
		navText: ["<i class='ph ph-arrow-up-left'></i>" ,"<i class='ph ph-arrow-up-right'></i>"],
		nav: false,
		dots: false,
		responsive: {
			0: {
				items: 1
			},			
			440: {
				items: 2
			},
			768: {
				items: 4
			},
			992: {
				items: 5
			},			
			1199: {
				items: 6
			}
		}
	});

	$('.clients_slider2').owlCarousel({
		loop: true,
		item:6,
		margin: 60,
		navText: ["<i class='ph ph-arrow-up-left'></i>" ,"<i class='ph ph-arrow-up-right'></i>"],
		nav: false,
		dots: false,
		responsive: {
			0: {
				items: 1
			},			
			440: {
				items: 2
			},
			768: {
				items: 4
			},
			992: {
				items: 5
			},			
			1199: {
				items: 6
			}
		}
	});

		//------------- DETAIL ADD - MINUS COUNT ORDER -------------//
		$(".btn-number").on("click", function () {

			var $button = $(this);
			var oldValue = $button.closest('.quantity_option').find("input.quntity-input").val();

			if ($button.text() == "+") {
				var newVal = parseFloat(oldValue) + 1;
			} else {
				// Don't allow decrementing below zero
				if (oldValue > 0) {
					var newVal = parseFloat(oldValue) - 1;
				} else {
					newVal = 0;
				}
			}

			$button.closest('.quantity_option').find("input.quntity-input").val(newVal);

		});
		
		/* Nice Select */
		jQuery('select').niceSelect();

	/* WOW */
	new WOW().init();
	
}(jQuery));


