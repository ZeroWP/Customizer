;(function ( $ ) {

	"use strict";

	$.fn.zerowpc_rangeslider = function( options ){

		this.each(function(){
			var postfix = $(this).data('postfix');
			postfix = ( postfix !== undefined ) ? ' ' + postfix : '';
			
			var _handle;
			if( jQuery().rangeslider ){

				$(this).rangeslider( {
					polyfill: false,
					onInit: function(){
						_handle = $('.rangeslider__handle', this.$range);
						$(_handle).prepend('<div class="rangeslider__value_label"><span>'+ this.value + postfix +'</span></div>');
					},
					onSlideEnd: function(position, value){
						$( this ).val( value ).change();
					}
				} ).on('input', function() {
					$( _handle ).children('.rangeslider__value_label').children().text( this.value + postfix );
				});
			}
		});

		return this;
	};

	$(document).ready(function(){
		function zerowpc_spectrum_init() {
			
			$(".zerowpc-spectrum-input").spectrum({
				preferredFormat: "rgb",
				showAlpha: true,
				showInput: true,
				showInitial: true,
				allowEmpty:true,
				showButtons: false,
				move: function(color) {
					$(this).val( color ).change();
				}
			});

		};

		if( jQuery().spectrum ){
			zerowpc_spectrum_init();
		}

		$(".zerowpc-range-slider-input").zerowpc_rangeslider();
		
	});


}( jQuery ));