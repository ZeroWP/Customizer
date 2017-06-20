;(function( $ ) {

	"use strict";

	$.fn.zerowpc_font = function( options ) {

		if ( this.length > 1 ){
			this.each( function() {
				$(this).zerowpc_font( options );
			});
			return this;
		}

		// Defaults
		var settings = $.extend( {}, options );

		// Cache current instance
		var plugin = this;

		//Plugin go!
		var init = function() {
			plugin.build();
		}

		// Build plugin
		this.build = function() {
			
			var self = false;

			var _base = {

				/*
				-------------------------------------------------------------------------------
				Font
				-------------------------------------------------------------------------------
				*/
				prepareFontsList: function(){
					var _width = $('#customize-controls').outerWidth();
					console.log( _width );
					$('.zerowpc-fonts').css({
						'left': _width
					});
				},

				addSelectedFont: function( selected_elem_from_list, parent_block ){
					var font_class = selected_elem_from_list.attr('class');
					var font_title = selected_elem_from_list.attr('title');
					var font_html = selected_elem_from_list.html();
					parent_block.find('.zerowpc-show-selected-font .zerowpc-font-item').attr('class', font_class).attr('title', font_title).html( font_html );
					parent_block.find('.zerowpc-show-selected-font .zerowpc-font-item span.selected-font').remove();

					//Show only available weights for this font
					var the_weights_of_this_font = selected_elem_from_list.attr('data-w');
					var the_input = parent_block.find('input.zerowpc-fonts-value');
					var main_control_id = the_input.data('customize-setting-link');
					var weight_input = $('[data-customize-setting-link="'+ main_control_id +'_weight"]');
					var weight_input_options = weight_input.find('option');

					weight_input_options.each(function(index, elem){
						if( the_weights_of_this_font.indexOf( $(elem).attr('value') ) == -1 ){
							$(elem).css({ 'display': 'none' });
						}
						else{
							$(elem).css({ 'display': '' });
						}
					});
				},

				/* Show fonts list
				------------------------------------------------*/
				showFontsList: function(){
					$('.zerowpc-show-selected-font').on('click', function(){
						var _this = $(this);

						$('.zerowpc-show-selected-font').removeClass('active');
						$('.zerowpc-fonts').hide();

						_this.toggleClass('active');
						$('.zerowpc-fonts').toggle();

						//scroll to selected
						var the_parent = $('.zerowpc-fonts ul');
						var target     = the_parent.find('.zerowpc-font-item').attr('title');
						var element    = $('.zerowpc-fonts ul li[title="' + target + '"]');

						the_parent.scrollTop( the_parent.scrollTop()+element.position().top-60 );
					});

					//Cache the container
					var container = $('.zerowpc-show-selected-font');
					
					//Hide/Show when we leave the area
					$(document).mouseup(function ( event ){
						if (!container.is(event.target) // if the target of the click isn't the container...
						&& ! $('.zerowpc-fonts').is(event.target) // if the target of the click isn't the a font from list...
						&& $('.zerowpc-fonts').has(event.target).length === 0 // ... nor a descendant of the fonts list
						&& container.has(event.target).length === 0){// ... nor a descendant of the container
							container.removeClass('active');
							$('.zerowpc-fonts').hide();
						}
					});

				},

				buildFonts: function(){
					/* On ready active
					------------------------------------------------*/
					$('.zerowpc-fonts-block').each(function(){
						var font_val = $(this).find('.zerowpc-fonts-value').val();
						if( '' !== font_val && undefined !== font_val ){
							var selected = $(this).find('.zerowpc-fonts li.zerowpc-font-item[title="'+ font_val +'"]');
						}
						else{
							var selected = $(this).find('.zerowpc-fonts li.zerowpc-font-item').eq(150);
						}
						selected.addClass('active').append('<span class="selected-font wp-ui-highlight"></span>');

						// Add class to the "selected font" block
						self.addSelectedFont( selected, $(this) );
					});

					/* Activate selected
					------------------------------------------------*/
					$('.zerowpc-fonts li').not('.zerowpc-font-heading-title').on('click', function(){
						var parent = $(this).parents('.zerowpc-fonts');
						var the_input = parent.find('input.zerowpc-fonts-value');
						var main_control_id = the_input.data('customize-setting-link');
						var font_name = this.title;
						var items = parent.find('li.zerowpc-font-item');

						the_input.val(font_name).change();

						items.removeClass('active');
						items.find('.selected-font').remove();
						$(this).addClass('active').append('<span class="selected-font wp-ui-highlight"></span>');

						// Add class to the "selected font" block
						self.addSelectedFont( $(this), $(this).parents('.zerowpc-fonts-block') );

						//Update font-family option
						var the_family_of_this_font = $(this).data('c');
						$('[data-customize-setting-link="'+ main_control_id +'_family"]').val( the_family_of_this_font ).change();

						//Change font-size if the currently selected is not available for this font.
						var the_weights_of_this_font = $(this).attr('data-w');
						
						var weight_input = $('[data-customize-setting-link="'+ main_control_id +'_weight"]');
						var current_weight_value = weight_input.val();

						//Return to regular if the already selected weight is not supported by this font
						if( the_weights_of_this_font.indexOf( current_weight_value ) == -1 ){
							weight_input.val( 400 ).change();
						}

					});
				},

				/* Search font
				------------------------------------------------*/
				searchFonts: function() {
					$('.zerowpc-fonts-block .zerowpc-fonts-search-field').on( 'keyup', function(){
						var value    = $(this).val().toLowerCase(),
							parent = $(this).parents('.zerowpc-fonts'),
						    headings = parent.find('li.zerowpc-font-heading-title').not('.zerowpc-main-headings'),
						    standard_fonts_heading = parent.find('li.zerowpc-font-heading-title').eq(0),
						    google_fonts_heading = parent.find('li.zerowpc-font-heading-title').eq(1);

						// Hide or show headings
						value.length > 0 ? headings.hide() : headings.show();

						parent.find('li.zerowpc-font-item').each(function() {
							$(this).attr('title').toLowerCase().search(value) > -1 ? $(this).show() : $(this).hide();
						});

						if( parent.find('li.zerowpc-font-item.font-standard:visible').length < 1 ){
							standard_fonts_heading.hide();
						}
						else{
							standard_fonts_heading.show();
						}
						if( parent.find('li.zerowpc-font-item:visible').not('.font-standard').length < 1 ){
							google_fonts_heading.hide();
						}
						else{
							google_fonts_heading.show();
						}
					});
				},

				__construct: function(){
					self = this;

					self.prepareFontsList();
					self.showFontsList();
					self.buildFonts();
					self.searchFonts();

					return this;
				}

			};

			/*
			-------------------------------------------------------------------------------
			Rock it!
			-------------------------------------------------------------------------------
			*/
			_base.__construct();

		}

		//Plugin go!
		init();
		return this;

	};

})(jQuery);