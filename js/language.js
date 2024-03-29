(function($) {
  'use strict';
	
	function checkLanguagesSupported(language) {
		var languagesSupported = ['br', 'pt', 'es', 'fr', 'en'];
		if (languagesSupported.indexOf(language) >= 0) {
			return true;
		}
		return false;
	}
	
	function checkExibitionLogo(language) {
		var currentSlide = $('#ensign-nivoslider').data('nivo:vars').currentSlide;
		if(currentSlide === 0 && $(language).hasClass('active-flag')) {
			$('#navbar-logo').attr('style', 'visibility: hidden');
		}
	}
	
	$('#language-brazilian-portuguese').click(function() {
		checkLanguagesSupported('br') ? $('.full-site').show() : $('.full-site').hide();
		$('html').attr('lang', 'pt');
		$('.br').show();
		$('.pt').hide();
        $('.es').hide();
		$('.fr').hide();
		$('.en').hide();
		$('#language-brazilian-portuguese').addClass('active-flag');
		$('#language-portuguese').removeClass('active-flag');
        $('#language-spanish').removeClass('active-flag');
		$('#language-french').removeClass('active-flag');
		$('#language-english').removeClass('active-flag');
		checkExibitionLogo('#language-brazilian-portuguese');
	});
	
	$('#language-portuguese').click(function() {
		checkLanguagesSupported('pt') ? $('.full-site').show() : $('.full-site').hide();
		$('html').attr('lang', 'pt');
		$('.br').hide();
		$('.pt').show();
        $('.es').hide();
		$('.fr').hide();
		$('.en').hide();
		$('#language-brazilian-portuguese').removeClass('active-flag');
		$('#language-portuguese').addClass('active-flag');
        $('#language-spanish').removeClass('active-flag');
		$('#language-french').removeClass('active-flag');
		$('#language-english').removeClass('active-flag');
		$('#navbar-logo').attr('style', 'visibility: visible');
		checkExibitionLogo('#language-portuguese');
	});
    
	$('#language-spanish').click(function() {
		checkLanguagesSupported('es') ? $('.full-site').show() : $('.full-site').hide();
		$('html').attr('lang', 'es');
		$('.br').hide();
		$('.pt').hide();
        $('.es').show();
		$('.fr').hide();
		$('.en').hide();
		$('#language-brazilian-portuguese').removeClass('active-flag');
		$('#language-portuguese').removeClass('active-flag');
        $('#language-spanish').addClass('active-flag');
		$('#language-french').removeClass('active-flag');
		$('#language-english').removeClass('active-flag');
		$('#navbar-logo').attr('style', 'visibility: visible');
		checkExibitionLogo('#language-spanish');
	});
	
	$('#language-french').click(function() {
		checkLanguagesSupported('fr') ? $('.full-site').show() : $('.full-site').hide();
		$('html').attr('lang', 'fr');
		$('.br').hide();
		$('.pt').hide();
        $('.es').hide();
		$('.fr').show();
		$('.en').hide();
		$('#language-brazilian-portuguese').removeClass('active-flag');
		$('#language-portuguese').removeClass('active-flag');
        $('#language-spanish').removeClass('active-flag');
		$('#language-french').addClass('active-flag');
		$('#language-english').removeClass('active-flag');
		$('#navbar-logo').attr('style', 'visibility: visible');
		checkExibitionLogo('#language-french');
	});
	
	$('#language-english').click(function() {
		checkLanguagesSupported('en') ? $('.full-site').show() : $('.full-site').hide();
		$('html').attr('lang', 'en');
		$('.br').hide();
		$('.pt').hide();
        $('.es').hide();
		$('.fr').hide();
		$('.en').show();
		$('#language-brazilian-portuguese').removeClass('active-flag');
		$('#language-portuguese').removeClass('active-flag');
        $('#language-spanish').removeClass('active-flag');
		$('#language-french').removeClass('active-flag');
		$('#language-english').addClass('active-flag');
		$('#navbar-logo').attr('style', 'visibility: visible');
		checkExibitionLogo('#language-english');
	});
	
	$('#language-brazilian-portuguese').click();

})(jQuery);
