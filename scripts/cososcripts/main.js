/*
Theme Name: Adsbounty Coso
Description: Adsbounty Coming Soon Temp
Author: Gokuzimaki
Theme URI: http://adsbounty.com/
Version: 1.3.1
*/
result="";
(function($) {
	"use strict";

	/* BOOTSTRAP FIX FOR WINPHONE 8 AND IE10 */
	if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
		var msViewportStyle = document.createElement("style");
		msViewportStyle.appendChild(
			document.createTextNode(
				"@-ms-viewport{width:auto!important}"
			)
		);
		document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
	}

	function detectIE() {
		if ($.browser.msie && $.browser.version == 9) {
			return true;
		}
		if ($.browser.msie && $.browser.version == 8) {
			return true;
		}
		return false;
	}

	function getWindowWidth() {
		return Math.max( $(window).width(), window.innerWidth);
	}

	function getWindowHeight() {
		return Math.max( $(window).height(), window.innerHeight);
	}


	// BEGIN WINDOW.LOAD FUNCTION
	$(window).load(function() {

		/* ------------------------------------------------------------------------ */
		/*	PRELOADER
		/* ------------------------------------------------------------------------ */
		var preloaderDelay = 350,
			preloaderFadeOutTime = 800;

		function hidePreloader() {
			var loadingAnimation = $('#loading-animation'),
				preloader = $('#preloader');

			loadingAnimation.fadeOut();
			preloader.delay(preloaderDelay).fadeOut(preloaderFadeOutTime);
		}

		hidePreloader();

	});

	//BEGIN DOCUMENT.READY FUNCTION
	jQuery(document).ready(function($) {

		$.browser.chrome = $.browser.webkit && !!window.chrome;
		$.browser.safari = $.browser.webkit && !window.chrome;

		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$('body').addClass('mobile');
		}

		if ($.browser.chrome) {
			$('body').addClass('chrome');
		}

		if ($.browser.safari) {
			$('body').addClass('safari');
		}


		/* REFRESH WAYPOINTS */
		function refreshWaypoints() {
			setTimeout(function() {
				$.waypoints('refresh');
			}, 1000);   
		}


		/* ANIMATED ELEMENTS */	
		if( !$('body').hasClass('mobile') ) {

			$('.animated').appear();

			if( detectIE() ) {
				$('.animated').css({
					'display':'block',
					'visibility': 'visible'
				});
			} else {
				$('.animated').on('appear', function() {
					var elem = $(this);
					var animation = elem.data('animation');
					if ( !elem.hasClass('visible') ) {
						var animationDelay = elem.data('animation-delay');
						if ( animationDelay ) {
							setTimeout(function(){
								elem.addClass( animation + " visible" );
							}, animationDelay);
						} else {
							elem.addClass( animation + " visible" );
						}
					}
				});
				
				/* Starting Animation on Load */
				$(window).load(function() {
					$('.onstart').each( function() {
						var elem = $(this);
						if ( !elem.hasClass('visible') ) {
							var animationDelay = elem.data('animation-delay');
							var animation = elem.data('animation');
							if ( animationDelay ) {
								setTimeout(function(){
									elem.addClass( animation + " visible" );
								}, animationDelay);
							} else {
								elem.addClass( animation + " visible" );
							}
						}
					});
				});	
				
			}

		}


		/* FULLPAGE */	
		$('#fullpage').fullpage({
			anchors: ['homePage', 'registrationPage', 'contactPage', 'fifthPage', 'lastPage'],
			menu: '#menu',
			scrollingSpeed: 800,
			autoScrolling: true,
			scrollBar: true,
			easing: 'easeInQuart',
			resize : false,
			paddingTop: '80px',
			paddingBottom: '80px',
			responsive: 1000,
		});

		$('a.go-slide').on( 'click', function() {
			var elem = $(this),
				slideID = elem.data('slide');
				
			$.fn.fullpage.moveTo(slideID);
		});
		
		if( $('body').hasClass('mobile') ) {
			$('#main-nav a').on( 'click', function() {
				$('.navbar-toggle').trigger('click');
			});
		};


		/* BACKGROUNDS */	
		function initPageBackground() {
			if($('body').hasClass('image-background')) { // IMAGE BACKGROUND

				$("body").backstretch(""+host_addr+"demo/background/image-1.jpg");

			} else if( $('body').hasClass('slideshow-background') ) { // SLIDESHOW BACKGROUND

				$("body").backstretch([
					""+host_addr+"demo/background/image-1.jpg",
					""+host_addr+"demo/background/image-2.jpg",
					""+host_addr+"demo/background/image-3.jpg"
				], {duration: 3000, fade: 1200});

			} else if($('body').hasClass('youtube-background')) { // YOUTUBE VIDEO BACKGROUND
				if($('body').hasClass('mobile')) {

					// Default background on mobile devices
					$("body").backstretch(""+host_addr+"demo/viideo/video.jpg");

				} else {
					$(".player").each(function() {
						$(".player").mb_YTPlayer();
					});
				}
			} else if($('body').hasClass('youtube-list-background')) { // YOUTUBE LIST VIDEOS BACKGROUND
				if($('body').hasClass('mobile')) {

					// Default background on mobile devices
					$("body").backstretch(""+host_addr+"demo/viideo/video.jpg");

				} else {

					var videos = [
						{videoURL: "0pXYp72dwl0",containment:'body',autoPlay:true, mute:true, startAt:0,opacity:1, loop:false, ratio:"4/3", addRaster:true},
						{videoURL: "9d8wWcJLnFI",containment:'body',autoPlay:true, mute:true, startAt:0,opacity:1, loop:false, ratio:"4/3", addRaster:false},
						{videoURL: "nam90gorcPs",containment:'body',autoPlay:true, mute:true, startAt:0,opacity:1, loop:false, ratio:"4/3", addRaster:true}
					];

					$(".player").YTPlaylist(videos, true);

				}
			} else if($('body').hasClass('mobile')) { // MOBILE BACKGROUND - Image background instead of video on mobile devices
				if($('body').hasClass('video-background')) {

					// Default background on mobile devices
					$("body").backstretch(""+host_addr+"demo/viideo/video.jpg");

				}	
			}
		}

		initPageBackground();


		/* RESPONSIVE VIDEO - FITVIDS */
		$(".video-container").fitVids();


		/* FLEXSLIDER */
		$('.flexslider').flexslider({
			animation: "fade",
			animationLoop: true,
			slideshowSpeed: 12000,
			animationSpeed: 600,
			controlNav: false,
			directionNav: false,
			keyboard: false,
			start: function(slider){
				$('body').removeClass('loading');
			}
		});


		/* COUNTDOWN */
		$('#clock').countdown('2015/10/1 12:00:00').on('update.countdown', function(event) {
			var $this = $(this).html(event.strftime('<div class="counter-container"><div class="counter-box first"><div class="number">%-D</div><span>Day%!d</span></div><div class="counter-box"><div class="number">%H</div><span>Hours</span></div><div class="counter-box"><div class="number">%M</div><span>Minutes</span></div><div class="counter-box last"><div class="number">%S</div><span>Seconds</span></div></div>'
			));
		});


		function mailchimpCallback(resp) {
			 if (resp.result === 'success') {
				$('.success-message').html(resp.msg).fadeIn(1000);
				$('.error-message').fadeOut(500);

			} else if(resp.result === 'error') {
				$('.error-message').html(resp.msg).fadeIn(1000);
			}  
		}


		/* Start Javascript for Subscription Form */
		$('.subscription-form').submit(function(event) {
			var email = $('#email').val();
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

			$.ajax({
				url:'subscribe.php',
				type :'POST',
				dataType:'json',
				data: {'email': email
			},

				success: function(data){
					if(data.error){
						$('.error-message').fadeIn();
					}else{
						$('.success-message').fadeIn();
						$(".error-message").hide();
					}
				}
			});
			return false;
		});

		$('#email').focus(function(){
			$('.error-message').fadeOut();
			$('.success-message').fadeOut();
		});

		$('#email').keydown(function(){
			$('.error-message').fadeOut();
			$('.success-message').fadeOut();
		});

		$("#email").on( 'click', function() {
			$("#email").val('');
		});


		/* PLACEHOLDER */
		$('input, textarea').placeholder();

		/*USER REGISTRATION FORM*/
		function handleUserRegForm() {
			// console.log(formstatus," formstatus");
			if(typeof $.fn.validate !== 'undefined'){
					
				$('#registeruser-form').validate({
					errorClass: 'validation-error', // so that it doesn't conflict with the error class of alert boxes
					rules: {
						firstname: {
							required: true
						},
						/*middlename: {
							required: true,
						},*/
						lastname: {
							required: true
						},
						gender: {
							required: true
						},
						maritalstatus: {
							required: true
						},
						state: {
							required: true
						},
						LocalGovt: {
							required: true
						},
						dobday: {
							required: true
						},
						dobmonth: {
							required: true
						},
						dobyear: {
							required: true
						},
						useremail: {
							required: true,
							email: true
						},
						upassword: {
							required: true,
							minlength: 6
						},
						upasswordconfirm: {
							required: true,
							equalTo: "#upassword"
						},
						phoneone: {
							required: true
						}
					},
					messages: {
						firstname: {
							required: "Your Firstname Please!!"
						},
						/*middlename: {
							required: "Middlename missing",
						},*/
						lastname: {
							required: "Lets have Your Lastname"
						},
						gender: {
							required: "Are you male or female, this is important"
						},
						maritalstatus: {
							required: "Are you single or married"
						},
						state: {
							required: "Pick the state You are in"
						},
						LocalGovt: {
							required: "Select Your Local Govt."
						},
						dobday: {
							required: "Select you birth Day"
						},
						dobmonth: {
							required: "Select you birth Month"
						},
						dobyear: {
							required: "Select you birth Year"
						},
						useremail: {
							required: "Provide your email address",
							email: "Oops, seems your email ain't valid"
						},
						upassword: {
							required: "Provide your password"
						},
						upasswordconfirm: {
							required: "Confirm your password"
						}, 
						phoneone: {
							required: "Main phone number needed"
						}
					},
					submitHandler: function(form) {
						$('.loadermini').show(500);
						var email=$('input[name=useremail]').val();
						// check if email is existing else do nothing
						if(email!==""&&typeof(email)!=="undefined"){
							$.ajax({
									type: "GET",
									data:{	
										displaytype: "verifyemail",
										email:""+email+"",
										extraval:""
									},
									url: ""+host_addr+"snippets/display.php",
									success: function(msg) {
										console.log(msg);
										result="";
										if (msg == 'OK') {
											result='<div class="alert alert-error"><i class="close fa fa-times-circle"></i>Form ' + msg + ', Submitting...</div>';
											$("#formstatus-3").html(result)
											// $(document).scrollTop(100);
											console.log(form.action,form.method,$(form).serialize());
											$.ajax({
												url: form.action,
												type: form.method,
												data: $(form).serialize(),
												success: function(response) {
													window.alert("Thank you for registering, an email has been sent to your mail box, you should use the activation link provided there to get started");
													$(form).find("input[type=text], input[type=password], textarea, select").val("");
													$("#formstatus-3").hide();
													console.log(response);
													$('.loadermini').hide();
													if(response=="ok"){
														if($('input[name=prereg]')){
															$("#formstatus-3").html("Thank you for registering...").show(500);
														}else{
															window.location.href=host_addr+"userdashboard.php";

														}

													}else{
														$("#formstatus-3").html(response).show(500);

													}
												},
												error: function(){
													alert("Sorry but there was an error submitting your form, it is probably a network issue  ")
												}

											});
										} else {
											result = '<div class="alert error"><i class="close fa fa-times-circle"></i>' + msg + '</div>';
											$('.loadermini').hide();
											$("#formstatus-3").html(result);
											// $(document).scrollTop(100);
										}
											
										    // console.log(inputname1.val(),inputname2.val(),inputname3.val(),inputname3.val().length);
					
									},
									error: function() {
					
										result = '<div class="alert error"><i class="fa fa-times-circle"></i>There was an error sending the message!</div>';
										$("#formstatus-3").html(result);
					
									}
							});	
						}	
						// $(form).submit();
					}
				});
				
			}
			
		}
		/*END*/
		/* CONTACT FORM */
		function initContactForm() {

			var scrollElement = $('html,body'),
				contactForm = $('form[name=contactform].contact-form'),
				form_msg_timeout;

			contactForm.on( 'submit', function() {

				var requiredFields = $(this).find('.required'),
					formFields = $(this).find('input, textarea'),
					formData = contactForm.serialize(),
					formAction = $(this).attr('action'),
					formSubmitMessage = $('.response-message');

				requiredFields.each(function() {

					if( $(this).val() === "" ) {

						$(this).addClass('input-error');

					} else {

						$(this).removeClass('input-error');
					}

				});

				function validateEmail(email) { 
					var exp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					return exp.test(email);
				}

				var emailField = $('.contact-form-email');

				if( !validateEmail(emailField.val()) ) {

					emailField.addClass("input-error");

				}

				if ($(".contact-form :input").hasClass("input-error")) {
					return false;
				} else {

					clearTimeout(form_msg_timeout);

					$.post(formAction, formData, function(data) {
						formSubmitMessage.text(data);

						formFields.val('');

						form_msg_timeout = setTimeout(function() {
							formSubmitMessage.slideUp();
						}, 5000);
					});

				}

				return false;

			});

		}
		initContactForm();
		handleUserRegForm();
	});
	//END DOCUMENT.READY FUNCTION

})(jQuery);

$(document).ready(function(){
	$(document).on('click','.alert .close, div[id*=formstatus] .close', function () {
		event.preventDefault();

		$(this).parent().remove();
	});
})