<?php
namespace ZeroWP\Customizer;

class Css extends lessc{

	public function addCssToFile($css, $outFname = null) {
		
		$out = $this->compile( $css );

		return file_put_contents($outFname, $out);
	}

	public function addCss( $css ){
		try {
			echo $this->compile( $css );
		} catch (Exception $e) {
			echo( $e->getMessage() );
		}
	}

	public function compileCssToFile( $css ){
		return $this->addCssToFile( $css, $this->stylesheetPath() );
	}

	public function colorIsHex( $subject ){
		$check = preg_match("/^#(?:[0-9a-fA-F]{3}){1,2}$/", $subject);
		return ( $check === 1 );
	}

	public function colorIsLight( $color = false ){
		// Get our color
		$color = str_replace('#', '', $color);
		// Calculate straight from rbg
		$r = hexdec($color[0].$color[1]);
		$g = hexdec($color[2].$color[3]);
		$b = hexdec($color[4].$color[5]);
		return (( $r*299 + $g*587 + $b*114 )/1000 > 130);
	}

	public function colorIsDark( $color = false ){
		// Get our color
		$color = str_replace('#', '', $color);
		// Calculate straight from rbg
		$r = hexdec($color[0].$color[1]);
		$g = hexdec($color[2].$color[3]);
		$b = hexdec($color[4].$color[5]);
		return (( $r*299 + $g*587 + $b*114 )/1000 <= 130);
	}

	public function getGoodTextColor( $color = false ){
		if( $this->colorIsDark($color) ){
			return '#ffffff';
		}
		else{
			return '#333333';
		}
	}
	
	public function stylesheetName(){
		$id = '0';
		$template = get_option( 'template' );
		if( empty($template) ){
			$template = 'qwc';
		}
		if( is_multisite() ){
			$id = absint( get_current_blog_id() );
		}

		return strtolower( trim( 'qwc-' . sanitize_title( $id .'-'. $template ) ) . '.css' );
	}

	public function upPath(){
		$upload_dir = wp_upload_dir();
		$up_path    = trailingslashit($upload_dir['basedir']);
		return $up_path;
	}


	public function upUrl(){
		$upload_dir = wp_upload_dir();
		$up_url = trailingslashit($upload_dir['baseurl']);
		return $up_url;
	}

	public function stylesheetPath(){
		return $this->upPath() . $this->stylesheetName();
	}
	public function stylesheetUrl(){
		return $this->upUrl() . $this->stylesheetName();
	}

}