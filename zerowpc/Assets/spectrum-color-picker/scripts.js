;(function ( $ ) {

	"use strict";

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
		zerowpc_spectrum_init();
	});


}( jQuery ));