<?php
if( ! function_exists('qwc_standard_fonts') ){
	function qwc_standard_fonts(){
		return array(
			//sans-serif
			'Arial',
			'Arial Black',
			'Arial Narrow',
			'Arial Rounded MT Bold',
			'Calibri',
			'Candara',
			'Century Gothic',
			'Helvetica',
			'Helvetica Neue',
			'Impact',
			'Lucida Grande',
			'Optima',
			'Segoe UI',
			'Tahoma',
			'Trebuchet MS',
			'Verdana',
			//serif
			'Georgia',
			'Calisto MT',
			'Cambria',
			'Garamond',
			'Lucida Bright',
			'Baskerville',
			'Palatino',
			'TimesNewRoman',
			//monospace
			'Consolas',
			'Courier New',
			'Lucida Console',
			'Lucida Sans Typewriter',
			'Monaco',
			'Andale Mono',
			//fantasy
			'Copperplate',
			'Papyrus',
			//cursive
			'Brush Script MT',
		);
	}
}

if( ! function_exists('qwc_enqueue_font') ){
	function qwc_enqueue_font( $option ){
		$font_name          = get_theme_mod( $option );
		if(empty($font_name)){
			$font_name = 'Arial';
		}

		if( ! in_array($font_name, qwc_standard_fonts() ) ){
			$font_weight        = get_theme_mod( $option . '_weight', 400 );
			$font_weight        = (! empty( $font_weight ) ? $font_weight : 400);
			$font_weight_in_url = !in_array( absint($font_weight), array(400, 700) ) ? '400,700,'. $font_weight : '400,700';
			$font_name          = trim($font_name);
			$handle             = 'google_font_' . str_ireplace(' ', '_', $font_name );

			if ( ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_register_style( $handle, "//fonts.googleapis.com/css?family=". str_ireplace(' ', '+', $font_name) .":". $font_weight_in_url);
				wp_enqueue_style( $handle );
			}
			else{
				$registered_link = wp_styles()->query( $handle )->src;

				if ( strpos($registered_link, (string) $font_weight) === false ) {
					wp_deregister_style( $handle );
					wp_register_style( $handle, $registered_link . ','. $font_weight );
					wp_enqueue_style( $handle );
				}
			}
		}
	}
}

if( ! function_exists('qwc_get_font_css') ){
	function qwc_get_font_css( $option ){
		$font_name   = get_theme_mod( $option );
		$font_weight = get_theme_mod( $option . '_weight', 400 );
		$font_weight = (! empty( $font_weight ) ? $font_weight : 400);
		$font_style  = get_theme_mod( $option . '_style', 'normal');
		$font_family = get_theme_mod( $option . '_family', 'sans-serif' );
		$font_family = (! empty( $font_family ) ? $font_family : 'sans-serif');

		if( !empty($font_name) ){
			return '
				font-family: "'. $font_name .'", '. $font_family .';
				font-weight: '. $font_weight .';
				font-style: '. $font_style .';
			';
		}
	}
}

if( ! function_exists('qwc_apply_font_css') ){
	function qwc_apply_font_css( $option, $selectors, $style_tag = false ){
		$before = ( $style_tag ) ? '<style>' : '';
		$after = ( $style_tag ) ? '</style>' : '';
		return $before . $selectors .'{
			'. qwc_get_font_css( $option ) .'
		}' . $after;
	}
}