;(function ( $ ) {

	"use strict";

	$.fn.zerowpImageSelect = function( options ) {
		
		if (this.length > 1){
			this.each(function(index, elem) { 
				$(elem).qwcImageSelect(options);
			});
			return this;
		}
		
		// Defaults
		var settings = $.extend({}, options );

		// Current object
		var obj = this;

		//"Constructor"
		var init = function() {
			obj.showOnlyTheLinkedOptionsOnReady();
			obj.changeOptionOnClick();
			obj.changeOptionOnParentUpdate();
		}

		this.changeOption = function( the_selector, value ){
			var the_option = the_selector.find('.zerowp-customizer-image-select-control-element[data-value='+ value +']');
			if( ! the_option.hasClass('active') ){

				the_selector.find('.zerowp-customizer-image-select-control-element').not(the_option).removeClass('active');
				the_option.addClass('active');
				
				the_selector.find(".zerowp-customizer-image-select-control-value").val( value ).change();
			}
		},

		this.changeOptionOnClick = function(){
			obj.on('click', '.zerowp-customizer-image-select-control-element', function(){
				var elem = $(this);
				obj.changeOption( obj, elem.data('value') );
			});
		},

		this.isLinked = function(){
			return (obj.data('link-with') !== undefined);
		},

		this.getParentLink = function(){
			return obj.data('link-with') + '_image_select';
		},

		this.changeOptionOnParentUpdate = function(){
			if( obj.isLinked() ){
				$( '.' + obj.getParentLink() + ' .zerowp-customizer-image-select-control-value' ).on('change', function(){
					var the_new_val = $(this).val();
					obj.showOnlyTheLinkedOptions(the_new_val);
				});
			}
		},

		this.showOnlyTheLinkedOptionsOnReady = function(){
			if( obj.isLinked() ){
				var the_linked_parent_val = $( '.' + obj.getParentLink() + ' .zerowp-customizer-image-select-control-value' ).val()
				obj.showOnlyTheLinkedOptions(the_linked_parent_val);
			}
		},

		this.showOnlyTheLinkedOptions = function( value ){
			obj.find('.zerowp-customizer-image-select-control-element').hide().removeClass('available');
			obj.find('.zerowp-customizer-image-select-control-element[data-parent-option="'+ value +'"]').show().addClass('available');
			var first = obj.find('.zerowp-customizer-image-select-control-element.available').eq(0).data('value');
			obj.changeOption( obj, first );
		},

		this._d = function( data ){
			console.log( data );
		},

		//"Constructor" init
		init();
		return this;

	};

	$(document).ready(function(){
		$('.zerowp-customizer-image-select-control-block').zerowpImageSelect();
	});


}( jQuery ));