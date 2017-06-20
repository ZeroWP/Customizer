;(function( $ ) {

	"use strict";

	$.fn.ZWPC_Plugin_Admin = function( options ) {

		if ( this.length > 1 ){
			this.each( function() {
				$(this).ZWPC_Plugin_Admin( options );
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

				__construct: function(){
					self = this;

					//

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



$(document).on( 'load ready', function(){
	
	/*
	-------------------------------------------------------------------------------
	Font field plugin call
	-------------------------------------------------------------------------------
	*/
	if( jQuery().zerowpc_font ){
		$('body').zerowpc_font();
	}

	/*
	-------------------------------------------------------------------------------
	Spectrum color picker call
	-------------------------------------------------------------------------------
	*/
	if( jQuery().spectrum ){

		if( $.type( randomColor ) === "function" ){
			$(".zerowpc-spectrum-input").each( function(){
				var _this = $(this),
				_rand = _this.data( 'random-color-palette' );

				if( _rand ){
					var _palette = [];
					$.each(_rand, function(index, val) {
						_palette[ index ] = randomColor( val );
					});
					_this.data( 'palette', _palette );
					_this.data( 'show-palette', 'true' );
				}
			});
		}

		$(".zerowpc-spectrum-input").spectrum();

		$(".zerowpc-spectrum-input").on("dragstop.spectrum", function(e, color) {
			$(this).val( color ).change();
		});

		$(".zerowpc-spectrum-title").click(function() {
			$(this).next('.zerowpc-spectrum-input').spectrum("toggle");
			return false;
		});

	}
	
	/*
	-------------------------------------------------------------------------------
	Range slider call
	-------------------------------------------------------------------------------
	*/
	if( jQuery().rangeslider ){

		$(".zerowpc-range-slider-input").each(function(){
			var postfix = $(this).data('postfix');
			postfix = ( postfix !== undefined ) ? ' ' + postfix : '';
			
			var _handle;

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
		});
		
	}

	/*
	-------------------------------------------------------------------------------
	ZeroWPC plugin
	-------------------------------------------------------------------------------
	*/
	$('body').ZWPC_Plugin_Admin();

});

})(jQuery);