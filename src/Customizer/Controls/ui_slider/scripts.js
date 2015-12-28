;(function ( $ ) {

	"use strict";

	$(document).ready(function(){
		 function qwc_ui_slider_init() {
			jQuery('.qwc-ui-slider-block .qwc-ui-slider').each(function(index, elem) {
				
				var obj   = jQuery(this),
				    val   = parseInt(obj.data('val'), 10),
				    min   = parseInt(obj.data('min'), 10),
				    max   = parseInt(obj.data('max'), 10),
				    step  = parseInt(obj.data('step'), 10);
				
				//slider init
				obj.slider({
					value: val,
					min: min,
					max: max,
					step: step,
					range: "min",
					slide: function( event, ui ) {
						obj.prev('input').val( ui.value );
					},
					stop: function( event, ui ) {
						obj.prev('input').val( ui.value ).change();
					}
				});

				$(elem).find('.ui-slider-range').addClass('wp-ui-highlight');
				$(elem).find('.ui-slider-handle').addClass('wp-ui-primary');
				
			});
			$('.qwc-ui-slider-input').on('keyup change', function(){
				$(this).next('.qwc-ui-slider').slider('value', $(this).val() );
			});

			// $('.qwc-ui-slider-input').on('change', function(){
			// 	var min_allowed = parseInt( $(this).attr('min'), 10);
			// 	var max_allowed = parseInt( $(this).attr('max'), 10);
			// 	var value = parseInt( $(this).val(), 10);
			// 	var final_val = value;

			// 	if( value > max_allowed ){
			// 		final_val = max_allowed;
			// 	}
			// 	else if( value < min_allowed ){
			// 		final_val = min_allowed;
			// 	}

			// 	$(this).val( final_val ).change();
			// });

		};
		qwc_ui_slider_init();
	});


}( jQuery ));