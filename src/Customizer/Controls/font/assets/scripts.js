;(function( $ ) {
	"use strict";
$(document).ready(function(){

	function zerowp_customizer_add_selected_font( selected_elem_from_list, parent_block ){
		var font_class = selected_elem_from_list.attr('class');
		var font_title = selected_elem_from_list.attr('title');
		var font_html = selected_elem_from_list.html();
		parent_block.find('.zerowp-customizer-show-selected-font .zerowp-customizer-font-item').attr('class', font_class).attr('title', font_title).html( font_html );
		parent_block.find('.zerowp-customizer-show-selected-font .zerowp-customizer-font-item span.selected-font').remove();

		//Show only available weights for this font
		var the_weights_of_this_font = selected_elem_from_list.attr('data-w');
		var the_input = parent_block.find('input.zerowp-customizer-fonts-value');
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
	}

	/* Show fonts list
	------------------------------------------------*/
	function zerowp_customizer_show_fonts_list(){
		$('.zerowp-customizer-show-selected-font').on('click', function(){
			var _this = $(this);

			$('.zerowp-customizer-show-selected-font').removeClass('active');
			$('.zerowp-customizer-fonts').hide();

			_this.toggleClass('active');
			_this.parents('.zerowp-customizer-fonts-block').find('.zerowp-customizer-fonts').toggle();

			//scroll to selected
			var the_parent = _this.parents('.zerowp-customizer-fonts-block').find('.zerowp-customizer-fonts ul');
			var target     = _this.find('.zerowp-customizer-font-item').attr('title');
			var element    = _this.parents('.zerowp-customizer-fonts-block').find('.zerowp-customizer-fonts ul li[title="' + target + '"]');

			the_parent.scrollTop( the_parent.scrollTop()+element.position().top-20 );
		});

		//Cache the container
		var container = $('.zerowp-customizer-show-selected-font');
		
		//Hide/Show when we leave the area
		$(document).mouseup(function ( event ){
			if (!container.is(event.target) // if the target of the click isn't the container...
			&& ! $('.zerowp-customizer-fonts').is(event.target) // if the target of the click isn't the a font from list...
			&& $('.zerowp-customizer-fonts').has(event.target).length === 0 // ... nor a descendant of the fonts list
			&& container.has(event.target).length === 0){// ... nor a descendant of the container
				container.removeClass('active');
				container.parents('.zerowp-customizer-fonts-block').find('.zerowp-customizer-fonts').hide();
			}
		});

	}
	zerowp_customizer_show_fonts_list();

	/* On ready active
	------------------------------------------------*/
	$('.zerowp-customizer-fonts-block').each(function(){
		var font_val = $(this).find('.zerowp-customizer-fonts-value').val();
		if( '' !== font_val && undefined !== font_val ){
			var selected = $(this).find('.zerowp-customizer-fonts li.zerowp-customizer-font-item[title="'+ font_val +'"]');
		}
		else{
			var selected = $(this).find('.zerowp-customizer-fonts li.zerowp-customizer-font-item').eq(150);
		}
		selected.addClass('active').append('<span class="selected-font wp-ui-highlight"></span>');

		// Add class to the "selected font" block
		zerowp_customizer_add_selected_font( selected, $(this) );
	});

	/* Activate selected
	------------------------------------------------*/
	$('.zerowp-customizer-fonts li').not('.zerowp-customizer-font-heading-title').on('click', function(){
		var parent = $(this).parents('.zerowp-customizer-fonts');
		var the_input = parent.find('input.zerowp-customizer-fonts-value');
		var main_control_id = the_input.data('customize-setting-link');
		var font_name = this.title;
		var items = parent.find('li.zerowp-customizer-font-item');

		the_input.val(font_name).change();

		items.removeClass('active');
		items.find('.selected-font').remove();
		$(this).addClass('active').append('<span class="selected-font wp-ui-highlight"></span>');

		// Add class to the "selected font" block
		zerowp_customizer_add_selected_font( $(this), $(this).parents('.zerowp-customizer-fonts-block') );

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

	/* Search font
	------------------------------------------------*/
	function zerowp_customizer_search_fonts() {
		$('.zerowp-customizer-fonts-block .zerowp-customizer-fonts-search-field').on( 'keyup', function(){
			var value    = $(this).val().toLowerCase(),
				parent = $(this).parents('.zerowp-customizer-fonts'),
			    headings = parent.find('li.zerowp-customizer-font-heading-title').not('.zerowp-customizer-main-headings'),
			    standard_fonts_heading = parent.find('li.zerowp-customizer-font-heading-title').eq(0),
			    google_fonts_heading = parent.find('li.zerowp-customizer-font-heading-title').eq(1);

			// Hide or show headings
			value.length > 0 ? headings.hide() : headings.show();

			parent.find('li.zerowp-customizer-font-item').each(function() {
				$(this).attr('title').toLowerCase().search(value) > -1 ? $(this).show() : $(this).hide();
			});

			if( parent.find('li.zerowp-customizer-font-item.font-standard:visible').length < 1 ){
				standard_fonts_heading.hide();
			}
			else{
				standard_fonts_heading.show();
			}
			if( parent.find('li.zerowp-customizer-font-item:visible').not('.font-standard').length < 1 ){
				google_fonts_heading.hide();
			}
			else{
				google_fonts_heading.show();
			}
		});
	}
	zerowp_customizer_search_fonts();

});
})(jQuery);