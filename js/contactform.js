jQuery(document).ready(function($) {
	'use strict';
	
	function getCurrentLanguage() {
		if ($('#language-brazilian-portuguese').hasClass('active-flag')) {
			return 'br';
		} else if ($('#language-portuguese').hasClass('active-flag')) {
			return 'pt';
		} else if ($('#language-spanish').hasClass('active-flag')) {
			return 'es';
		} else if ($('#language-french').hasClass('active-flag')) {
			return 'fr';
		} else if ($('#language-english').hasClass('active-flag')) {
			return 'en';
		}
		return '';
	}
	
	//Contact
	$('form.contactForm').submit(function() {
		var f = $(this).find('.form-group'),
			ferror = false,
			emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i,
			paramsEmail = {};

		f.children('input').each(function() { // run all inputs

			var i = $(this); // current input
			var rule = i.attr('data-rule');

			if (rule !== undefined && i.hasClass(getCurrentLanguage())) {
				var ierror = false; // error flag for current input
				var pos = rule.indexOf(':', 0);
				if (pos >= 0) {
					var exp = rule.substr(pos + 1, rule.length);
					rule = rule.substr(0, pos);
				} else {
					rule = rule.substr(pos + 1, rule.length);
				}

				switch (rule) {
					case 'required':
						if (i.val() === '') {
							ferror = ierror = true;
						}
						break;

					case 'minlen':
						if (i.val().length < parseInt(exp)) {
							ferror = ierror = true;
						}
						break;

					case 'email':
						if (!emailExp.test(i.val())) {
							ferror = ierror = true;
						}
						break;

					case 'checked':
						if (!i.is(':checked')) {
							ferror = ierror = true;
						}
						break;

					case 'regexp':
						exp = new RegExp(exp);
						if (!exp.test(i.val())) {
							ferror = ierror = true;
						}
						break;
				}
				paramsEmail[i.attr('name')] = i.val();
				i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
			}
		});
		f.children('textarea').each(function() { // run all inputs

			var i = $(this); // current input
			var rule = i.attr('data-rule');

			if (rule !== undefined && i.hasClass(getCurrentLanguage())) {
				var ierror = false; // error flag for current input
				var pos = rule.indexOf(':', 0);
				if (pos >= 0) {
					var exp = rule.substr(pos + 1, rule.length);
					rule = rule.substr(0, pos);
				} else {
					rule = rule.substr(pos + 1, rule.length);
				}

				switch (rule) {
					case 'required':
						if (i.val() === '') {
							ferror = ierror = true;
						}
						break;

					case 'minlen':
						if (i.val().length < parseInt(exp)) {
							ferror = ierror = true;
						}
						break;
				}
				paramsEmail[i.attr('name')] = i.val();
				i.next('.validation').html((ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
			}
		});

		if (ferror) return false;
		var action = $(this).attr('action');
		if (!action) {
			action = 'send_email/send_email.php';
		}

		$.ajax({
			type: 'POST',
			url: action,
			data: paramsEmail,
			success: function(msg) {
				if (msg == 'OK') {
					$('#sendmessage').addClass('show');
					$('#errormessage').removeClass('show');
					$('.contactForm').find('input, textarea').val('');
				} else {
					$('#sendmessage').removeClass('show');
					$('#errormessage').addClass('show');
					$('#errormessage').html(msg);
				}

			}
		});
		return false;
	});

});