(function($) {
	'use strict';
	
	/*--------------------------
	preloader
	---------------------------- */
	$(window).on('load', function() {
		var pre_loader = $('#preloader');
		pre_loader.fadeOut('slow', function() {
			$(this).remove();
		});
	});

	/*---------------------
	 TOP Menu Stick
	--------------------- */
	var s = $('#sticker');
	var pos = s.position();
	if (($(window).scrollTop() > 300) > pos.top) {
		s.addClass('stick');
		$('#navbar-logo').attr('style', 'visibility: visibility');
	}
	else {
		$('#navbar-logo').attr('style', 'visibility: hidden');
	}
	$(window).on('scroll', function() {
		var windowpos = $(window).scrollTop() > 300;
		if (windowpos > pos.top) {
			s.addClass('stick');
		$('#navbar-logo').attr('style', 'visibility: visibility');
		} else {
			s.removeClass('stick');
			var currentSlide = $('#ensign-nivoslider').data('nivo:vars').currentSlide;
			if(currentSlide === 0 && ($('#language-brazilian-portuguese').hasClass('active-flag') || $('#language-portuguese').hasClass('active-flag') || $('#language-spanish').hasClass('active-flag') || $('#language-french').hasClass('active-flag') || $('#language-english').hasClass('active-flag'))) {
				$('#navbar-logo').attr('style', 'visibility: hidden');
			}
		}
	});

	/*----------------------------
	 Navbar nav
	------------------------------ */
	var main_menu = $('.main-menu ul.navbar-nav li ');
	main_menu.on('click', function() {
		main_menu.removeClass('active');
		$(this).addClass('active');
	});

	/*----------------------------
	 wow js active
	------------------------------ */
	new WOW().init();

	$('.navbar-collapse a:not(.dropdown-toggle)').on('click', function() {
		$('.navbar-collapse.collapse').removeClass('in');
	});

	//---------------------------------------------
	//Nivo slider
	//---------------------------------------------
	$('#ensign-nivoslider').nivoSlider({
		effect: 'fold',
		animSpeed: 500,
		pauseTime: 5000,
		startSlide: 0,
		directionNav: true,
		controlNavThumbs: false,
		pauseOnHover: true,
		manualAdvance: false,
		beforeChange: function() {
		var currentSlide = $('#ensign-nivoslider').data('nivo:vars').currentSlide;
		var totalSlides = $('#ensign-nivoslider').data('nivo:vars').totalSlides;
			if(($(window).scrollTop() > 300) <= pos.top && (currentSlide + 1 === 0 || currentSlide + 1 === totalSlides)) {
				if ($('#language-brazilian-portuguese').hasClass('active-flag') || $('#language-portuguese').hasClass('active-flag') || $('#language-spanish').hasClass('active-flag') || $('#language-french').hasClass('active-flag') || $('#language-english').hasClass('active-flag')) {
					$('#navbar-logo').attr('style', 'visibility: hidden');
				}
			} else {
				$('#navbar-logo').attr('style', 'visibility: visible');
			}
		}
	});

	/*----------------------------
	 Scrollspy js
	------------------------------ */
	var Body = $('body');
	Body.scrollspy({
		target: '.navbar-collapse',
		offset: 80
	});

	/*---------------------
		Venobox
	--------------------- */
	var veno_box = $('.venobox');
	veno_box.venobox();

	/*----------------------------
	Page Scroll
	------------------------------ */
	var page_scroll = $('a.page-scroll');
	page_scroll.on('click', function(event) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')) && $($anchor.attr('href')).offset() ? $($anchor.attr('href')).offset().top - 55 : null
		}, 1500, 'easeInOutExpo');
		event.preventDefault();
	});

	/*--------------------------
		Back to top button
	---------------------------- */
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$('.back-to-top').fadeIn('slow');
		} else {
			$('.back-to-top').fadeOut('slow');
		}
	});

	$('.back-to-top').click(function(){
		$('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
		return false;
	});

	/*----------------------------
	 Parallax
	------------------------------ */
	var well_lax = $('.wellcome-area');
	well_lax.parallax('50%', 0.4);
	var well_text = $('.wellcome-text');
	well_text.parallax('50%', 0.6);

	/*--------------------------
	 collapse
	---------------------------- */
	var panel_test = $('.panel-heading a');
	panel_test.on('click', function() {
		panel_test.removeClass('active');
		$(this).addClass('active');
	});

	/*---------------------
	 Circular Bars - Knob
	--------------------- */
	if (typeof($.fn.knob) != 'undefined') {
		var knob_tex = $('.knob');
		knob_tex.each(function() {
			var $this = $(this),
				knobVal = $this.attr('data-rel');

			$this.knob({
				'draw': function() {
					$(this.i).val(this.cv + '%')
				}
			});
			$this.appear(function() {
				$({
					value: 0
				}).animate({
					value: knobVal
				}, {
					duration: 2000,
					easing: 'swing',
					step: function() {
						$this.val(Math.ceil(this.value)).trigger('change');
					}
				});
			}, {
				accX: 0,
				accY: -150
			});
		});
	}

})(jQuery);
