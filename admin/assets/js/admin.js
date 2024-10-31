(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
$(document).ready(function() {

	// tooltip, display dialog box on mouse over
	// source: http://www.codechewing.com/library/create-simple-tooltip-jquery/
	$(".cwp2s-tooltip").hover(function(e) {
		
		var titleText = $(this).attr('title');
		//alert(titleText);
		
		$(this)
		  .data('tiptext', titleText)
		  .removeAttr('title');
		
		$('<p class="cwp2s-tooltip-display"></p>')
		.text(titleText)
		.appendTo('body')
		.css('top', (e.pageY - 10) + 'px')
		.css('left', (e.pageX + 20) + 'px')
		.fadeIn('slow');
		
		}, function(){ // Hover off event
		
		$(this).attr('title', $(this).data('tiptext'));
		$('.cwp2s-tooltip-display').remove();
		
		}).mousemove(function(e){ // Mouse move event
		
		$('.cwp2s-tooltip-display')
		  .css('top', (e.pageY - 10) + 'px')
		  .css('left', (e.pageX + 20) + 'px');
	
	});
	
	// admin twitter tweet post
	$('#cwp2s-general-settings-form').submit(generalSettingsSubmit);
	
	function generalSettingsSubmit(){
	
	// empty div before process
    $('.general-settings-response').empty();
	
	  var formData = $(this).serialize();
	
	  $.ajax({
		type:"POST",
		url: ajaxurl, // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		data: {action: 'admin_general_settings', formData:formData},
			success:function(data){
				
				$('.general-settings-response').show().prepend( data );
				// fade out
				$('.general-settings-response').delay(12000).fadeOut(800);
			
			}
	  });
	
	return false;
	}
	
	// admin twitter tweet post
	$('#cwp2s-twitter-tweet-box-form').submit(twitterTweetSubmit);
	
	function twitterTweetSubmit(){
	
	// empty div before process
    $('.twitter-tweet-response').empty();
	
	  var formData = $(this).serialize();
	
	  $.ajax({
		type:"POST",
		url: ajaxurl, // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		data: {action: 'admin_post_tweet', formData:formData},
			success:function(data){
				
				$('.twitter-tweet-response').show().prepend( data );
				// fade out
				$('.twitter-tweet-response').delay(12000).fadeOut(800);
			
			}
	  });
	
	return false;
	}
	
	// admin twitter API settings
	$('#cwp2s-twitter-auto-post-form').submit(twitterAutoPostSubmit);
	
	function twitterAutoPostSubmit(){
	
	// empty div before process
    $('.show-return-data').empty();
	
	  var formData = $(this).serialize();
	
	  $.ajax({
		type:"POST",
		url: ajaxurl, // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		data: {action: 'twitter_auto_post', formData:formData},
			success:function(data){
				
				$('.show-return-data').show().prepend( data );
				// fade out
				$('.show-return-data').delay(12000).fadeOut(800);
			
			}
	  });
	
	return false;
	}
	
	// admin twitter cards settings
	$('#cwp2s-twitter-cards-form').submit(twitterCardsSettingsSubmit);
	
	function twitterCardsSettingsSubmit(){
	
	// empty div before process
    $('.show-return-data').empty();
	
	  var formData = $(this).serialize();
	
	  $.ajax({
		type:"POST",
		url: ajaxurl, // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		data: {action: 'admin_twitter_cards_settings', formData:formData},
			success:function(data){
				
				$('.show-return-data').show().prepend( data );
				// fade out
				$('.show-return-data').delay(12000).fadeOut(800);
			
			}
	  });
	
	return false;
	}
	
	// Radio default_image_type on change
	$('.twitter-cards-image input[type=radio][name=default_image_type]').on('change', function() {
			
		var default_image_type = this.value;	
		//alert(default_image_type);	
		if (default_image_type == 'custom_field') {
			$( ".image-custom-field-name" ).show();
		} else {
			$( ".image-custom-field-name" ).hide();
		}
			
	});
	
	// char counter tweet box
	$('#twitter_tweet_message').keyup(function () {
	  var max = 115;
	  var len = $(this).val().length;
	  if (len >= max) {
		$('#twitter_char_count').text(' 0 ');
	  } else {
		var char = max - len;
		$('#twitter_char_count').text(char + ''); // characters left
	  }
	});
						   
});

})( jQuery );

// source: http://stackoverflow.com/questions/17668899/how-to-add-the-media-uploader-in-wordpress-plugin
jQuery(document).ready(function($){
								
    var custom_uploader;
    $('#upload_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            console.log(custom_uploader.state().get('selection').toJSON());
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });
	
});

// source: http://stackoverflow.com/questions/17668899/how-to-add-the-media-uploader-in-wordpress-plugin
jQuery(document).ready(function($){
								
    var custom_uploader;
    $('#upload_default_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            console.log(custom_uploader.state().get('selection').toJSON());
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_default_image').val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });
	
});