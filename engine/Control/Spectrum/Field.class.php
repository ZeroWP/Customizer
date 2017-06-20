<?php
namespace ZeroWPCustomizer\Control\Spectrum;

use ZeroWPCustomizer\ControlBase;

class Field extends ControlBase {

	public function enqueue() {
		wp_enqueue_style('zwpc-spectrum');
		wp_enqueue_script('zwpc-randomcolor');
		wp_enqueue_script('zwpc-spectrum');

		parent::enqueue();
	}

	public function defaultArgs(){
		return $this->spectrumArgs();
	}

	public function spectrumArgs(){
		return array(
			// 'color'                 => tinycolor,
			'allow-empty'              => true,
			'cancel-text'              => __('Cancel', 'zerowp-customizer'),
			'choose-text'              => __('Choose', 'zerowp-customizer'),
			'clickout-fires-change'    => true,
			'container-class-name'     => '',
			'disabled'                 => false,
			'flat'                     => false,
			'local-storage-key'        => false,
			'max-selection-size'       => 7,
			'palette'                  => false,
			'preferred-format'         => 'rgb',
			'replacer-class-name'      => '',
			'random-color-palette'     => false,
			'selection-palette'        => '',
			'show-alpha'               => false,
			'show-buttons'             => false,
			'show-initial'             => true,
			'show-input'               => true,
			'show-palette'             => false,
			'show-palette-only'        => false,
			'show-selection-palette'   => false,
			'toggle-palette-only'      => false,
			'toggle-palette-more-text' => __('More', 'zerowp-customizer'),
			'toggle-palette-less-text' => __('Less', 'zerowp-customizer'),
		);
	}

	public function spectrumDataAttrs(){
		$args = array_intersect_key( $this->args, $this->spectrumArgs() );
		$joined = '';

		if( !empty( $args[ 'palette' ] ) ){
			$args[ 'palette' ] = $this->colorsColection( $args[ 'palette' ] );
		}

		// The pallete is empty
		if( empty( $args[ 'palette' ] ) ){
			$args[ 'show-palette' ] = false;
			$args[ 'show-palette-only' ] = false;
		}
		else{
			$args[ 'show-palette' ] = true;
		}

		foreach ($args as $attr => $val) {
			if( is_array($val) ){
				$val = json_encode( $val );
			}
			elseif( is_bool( $val ) ){
				$val = $val ? 'true' : 'false';
			}
			elseif( empty( $val ) ){
				continue;
			}
			$joined .= ' data-'. $attr .'="'. esc_attr( $val ) .'"';
		}

		return $joined;
	}

	public function render_content() {
		?>
			<div class="<?php echo sanitize_html_class( $this->id ); ?>_spectrum">
				<label>
					<?php 
						$output = '';
						$output .= '<div class="zerowpc-spectrum-block">';
							$output .= '<div class="zerowpc-spectrum-title">'. esc_html( $this->label ) .'</div>';
							$output .= '<input type="text" '. $this->get_link() .' value="'. $this->value() .'" class="zerowpc-spectrum-input" '. $this->spectrumDataAttrs() .' />';
						$output .= '</div>';

						echo $output;
					?>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo $this->description ; ?></span>
					<?php endif; ?>
					
				</label>
			</div>
		<?php
	}

	public function colorsColection( $colections ){
		$r = array();

		foreach ($colections as $colection) {
			if( is_array( $colection ) ){
				$r[] = $colection;
			}
			elseif( is_string( $colection ) ){
				if( false !== ( $c = $this->getColection( $colection ) ) ){
					$r[] = $c;
				}
			}
		
		}

		return $r;
	}

	public function getColection( $colection ){
		$c = array(
			'flat' => array( 
				'#1abc9c','#16a085','#2ecc71','#27ae60','#3498db','#2980b9','#34495e',
				'#2c3e50','#ea4c88','#ca2c68','#9b59b6','#8e44ad','#f1c40f','#f39c12',
				'#e74c3c','#c0392b','#ecf0f1','#bdc3c7','#95a5a6','#7f8c8d','#000',
			),
			'red' => array(
				'#FFCCBC','#FFAC9C','#FF8C7C','#FF7C6C','#FF6C5C','#F75C4C',
				'#E74C3C','#D73C2C','#C72C1C','#B71C0C','#A70C00',				
			),
			'pink' => array(
				'#ffbcd8','#ff8cc8','#ff7cb8','#ff6ca8','#fa5c98','#ea4c88',
				'#da3c78','#ca2c68','#ba1c58','#aa0c48','#9a0038',				
			),
			'purple' => array( 
				'#DCC6E0','#cea0e4','#BE90D4','#ab69c6','#9b59b6','#8E44AD',
				'#7e349d','#6e248d','#5e147d','#4e046d','#3e005d',
			),
			'blue' => array( 
				'#39d5ff','#29c5ff','#19B5FE','#22A7F0','#1297e0','#0287d0',
				'#0077c0','#0067b0','#0057a0','#004790','#003780',
			),
			'teal' => array( 
				'#5efaf7','#51f5ea','#47ebe0','#37dbd0','#27cbc0','#17bbb0',
				'#07aba0','#009b90','#008b80','#007b70','#106b60',
			),
			'green' => array( 
				'#8effc1','#5efca1','#4eec91','#3edc81','#2ecc71','#1ebc61',
				'#0eac51','#009c41','#008c31','#007c21','#006c11',
			),
			'orange' => array( 
				'#FDE3A7','#ffcf4b','#F9BF3B','#f9b32f','#F5AB35','#F39C12',
				'#f1892d','#e67e22','#d87400','#c86400','#b85400',
			),
			'darkorange' => array( 
				'#ffdcb5','#ffc29b','#ffb28b','#ffa27b','#ff926b','#f3825b',
				'#e3724b','#d3623b','#c3522b','#b3421b','#a3320b',
			),
			'brown' => array( 
				'#f6c4a3','#eab897','#dfad8c','#d4a281','#ce9c7b','#be8c6b',
				'#ae7c5b','#9e6c4b','#8e5c3b','#7e4c2b','#6e3c1b',
			),
			'slategray' => array( 
				'#c5d3e2','#bccad9','#acbac9','#9caab9','#8c9aa9','#7c8a99',
				'#6C7A89','#5c6a79','#4c5a69','#3c4a59','#2c3a49',
			),
			'gray' => array( 
				'#d5e5e6','#c5d5d6','#b5c5c6','#a5b5b6','#95a5a6','#859596',
				'#758586','#657576','#556566','#455556','#354546',
			),
			'black' => array( 
				'#e0e0e0','#d0d0d0','#c0c0c0','#a0a0a0','#909090','#808080',
				'#707070','#606060','#505050','#404040','#303030',
			),
			'dark' => array( 
				'#870000','#8a0028','#1e003d','#102770','#005b50','#005c01',
				'#a84410','#932210','#5e2c0b','#1c2a39','#253536',			
			),
		);

		if( array_key_exists( $colection, $c ) ){
			return $c[ $colection ];
		}
		else{
			return false;
		}
	}

}