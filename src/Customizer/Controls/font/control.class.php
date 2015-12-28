<?php
namespace ZeroWP\Customizer;

zerowp_customizer_register_control( 'font', __NAMESPACE__ . '\\ControlFont' );
add_action( 'customize_register', __NAMESPACE__ . '\\zerowp_customizer_register_control_font' );

function zerowp_customizer_register_control_font( $wp_customize ){

	class ControlFont extends \WP_Customize_Control {
		public $type = 'font';
		public $args = array();
		public $field_id;

		public function __construct( $manager, $id, $args = array() ) {
			$this->args = $args;
			$this->field_id = $id;
			parent::__construct( $manager, $id, $args);
		}

		public function enqueue() {
			wp_register_style( 'qwc-font-styles', ZEROWP_CUSTOMIZER_URI .'controls/font/style.css');
			wp_enqueue_style('qwc-font-styles');

			wp_register_script( 'qwc-font-scripts', ZEROWP_CUSTOMIZER_URI .'controls/font/scripts.js', 'jquery', false, true);
			wp_enqueue_script('qwc-font-scripts');

			parent::enqueue();
		}

		public function render_content() {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo $this->description ; ?></span>
					<?php endif; ?>
				</label>
					
			<?php 
			echo '<div class="qwc-fonts-block">';
				echo '<div class="show-selected-font"><div class="qwc-font-item"></div></div>
				<div class="qwc-fonts">
					<input type="text" class="qwc-fonts-search-field" placeholder="'. __('Search font', 'qwc_local') .'" />
					<input type="hidden" class="qwc-fonts-value" '. $this->get_link() .' '. $this->value() .' />'
					. $this->fontsList() .
				'</div>
			</div>';
		}

		public function child_fields( $ctz ){
			$setting_args = $this->args;
			$setting_args['type'] = $this->args['transport_type'];

			// Font weight
			$setting_args['default'] = !empty($this->args['font_weight']) ? $this->args['font_weight'] : '400';
			$ctz->add_setting( $this->field_id .'_weight', $setting_args );

			$weight_args = $this->args;
			$weight_args['label'] = _x('Weight', 'The font weight', 'qwc_local');
			$weight_args['type'] = 'select';
			$weight_args['choices'] = array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => _x('Normal - 400', 'Font weight', 'qwc_local'),
				'500' => '500',
				'600' => '600',
				'700' => _x('Bold - 700', 'Font weight', 'qwc_local'),
				'800' => '800',
				'900' => '900',
			);
			$ctz->add_control( $this->field_id .'_weight', $weight_args );

			// Font style
			$setting_args['default'] = !empty($this->args['font_style']) && in_array( $this->args['font_style'], array('normal', 'italic') ) ? $this->args['font_style'] : 'normal';
			$ctz->add_setting( $this->field_id .'_style', $setting_args );

			$style_args = $this->args;
			$style_args['label'] = _x('Style', 'The font style',  'qwc_local');
			$style_args['type'] = 'radio';
			$style_args['choices'] = array(
				'normal' => _x('normal', 'font style normal', 'qwc_local'),
				'italic' => _x('italic', 'font style italic', 'qwc_local'),
			);
			$ctz->add_control( $this->field_id .'_style', $style_args );

			// Font family
			$setting_args['default'] = !empty($this->args['font_family']) ? $this->args['font_family'] : 'sans-serif';
			$ctz->add_setting( $this->field_id .'_family', $setting_args );

			$family_args = $this->args;
			$family_args['label'] = _x('Family', 'The font family', 'qwc_local');
			$family_args['type'] = 'select';
			$family_args['choices'] = array(
				'sans-serif' => _x('sans-serif', 'Font family', 'qwc_local'),
				'serif' => _x('serif', 'Font family', 'qwc_local'),
				'monospace' => _x('monospace', 'Font family', 'qwc_local'),
				'fantasy' => _x('fantasy', 'Font family', 'qwc_local'),
				'cursive' => _x('cursive', 'Font family', 'qwc_local'),
			);
			$ctz->add_control( $this->field_id .'_family', $family_args );

		}

		public function fontsList(){
			return '
<ul>
<li class="qwc-font-heading-title wp-ui-primary qwc-main-headings">'. __('Standard fonts', 'qwc_local') .'</li>
<li title="Arial" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Arial</li>
<li title="Arial Black" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Arial Black</li>
<li title="Arial Narrow" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Arial Narrow</li>
<li title="Arial Rounded MT Bold" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Arial Rounded MT Bold</li>
<li title="Calibri" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Calibri</li>
<li title="Candara" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Candara</li>
<li title="Century Gothic" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Century Gothic</li>
<li title="Helvetica" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Helvetica</li>
<li title="Helvetica Neue" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Helvetica Neue</li>
<li title="Impact" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Impact</li>
<li title="Lucida Grande" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Lucida Grande</li>
<li title="Optima" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Optima</li>
<li title="Segoe UI" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Segoe UI</li>
<li title="Tahoma" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Tahoma</li>
<li title="Trebuchet MS" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Trebuchet MS</li>
<li title="Verdana" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-standard">Verdana</li>
<li title="Georgia" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Georgia</li>
<li title="Calisto MT" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Calisto MT</li>
<li title="Cambria" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Cambria</li>
<li title="Garamond" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Garamond</li>
<li title="Lucida Bright" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Lucida Bright</li>
<li title="Baskerville" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Baskerville</li>
<li title="Palatino" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">Palatino</li>
<li title="TimesNewRoman" data-c="serif" data-w="400,700" class="qwc-font-item font-standard">TimesNewRoman</li>
<li title="Consolas" data-c="monospace" data-w="400,700" class="qwc-font-item font-standard">Consolas</li>
<li title="Courier New" data-c="monospace" data-w="400,700" class="qwc-font-item font-standard">Courier New</li>
<li title="Lucida Console" data-c="monospace" data-w="400,700" class="qwc-font-item font-standard">Lucida Console</li>
<li title="Lucida Sans Typewriter" data-c="monospace" data-w="400,700" class="qwc-font-item font-standard">Lucida Sans Typewriter</li>
<li title="Monaco" data-c="monospace" data-w="400,700" class="qwc-font-item font-standard">Monaco</li>
<li title="Andale Mono" data-c="monospace" data-w="400,700" class="qwc-font-item font-standard">Andale Mono</li>
<li title="Copperplate" data-c="fantasy" data-w="400,700" class="qwc-font-item font-standard">Copperplate</li>
<li title="Papyrus" data-c="fantasy" data-w="400,700" class="qwc-font-item font-standard">Papyrus</li>
<li title="Brush Script MT" data-c="cursive" data-w="400,700" class="qwc-font-item font-standard">Brush Script MT</li>

<li class="qwc-font-heading-title wp-ui-primary qwc-main-headings">'. __('Google fonts', 'qwc_local') .'</li>
<li title="ABeeZee" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-0"></li>
<li title="Abel" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-1"></li>
<li title="Abril Fatface" data-c="fantasy" data-w="400" class="qwc-font-item font-id-2"></li>
<li title="Aclonica" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-3"></li>
<li title="Acme" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-4"></li>
<li title="Actor" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-5"></li>
<li title="Adamina" data-c="serif" data-w="400" class="qwc-font-item font-id-6"></li>
<li title="Advent Pro" data-c="sans-serif" data-w="100,200,300,400,500,600,700" class="qwc-font-item font-id-7"></li>
<li title="Aguafina Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-8"></li>
<li title="Akronim" data-c="fantasy" data-w="400" class="qwc-font-item font-id-9"></li>
<li title="Aladin" data-c="cursive" data-w="400" class="qwc-font-item font-id-10"></li>
<li title="Aldrich" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-11"></li>
<li title="Alef" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-12"></li>
<li title="Alegreya" data-c="serif" data-w="400,700,900," class="qwc-font-item font-id-13"></li>
<li title="Alegreya SC" data-c="serif" data-w="400,700,900," class="qwc-font-item font-id-14"></li>
<li title="Alegreya Sans" data-c="sans-serif" data-w="100,300,400,500,700,800,900," class="qwc-font-item font-id-15"></li>
<li title="Alegreya Sans SC" data-c="sans-serif" data-w="100,300,400,500,700,800,900," class="qwc-font-item font-id-16"></li>
<li title="Alex Brush" data-c="cursive" data-w="400" class="qwc-font-item font-id-17"></li>
<li title="Alfa Slab One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-18"></li>
<li title="Alice" data-c="serif" data-w="400" class="qwc-font-item font-id-19"></li>
<li title="Alike" data-c="serif" data-w="400" class="qwc-font-item font-id-20"></li>
<li title="Alike Angular" data-c="serif" data-w="400" class="qwc-font-item font-id-21"></li>
<li title="Allan" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-22"></li>
<li title="Allerta" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-23"></li>
<li title="Allerta Stencil" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-24"></li>
<li title="Allura" data-c="cursive" data-w="400" class="qwc-font-item font-id-25"></li>
<li title="Almendra" data-c="serif" data-w="400,700," class="qwc-font-item font-id-26"></li>
<li title="Almendra Display" data-c="fantasy" data-w="400" class="qwc-font-item font-id-27"></li>
<li title="Almendra SC" data-c="serif" data-w="400" class="qwc-font-item font-id-28"></li>
<li title="Amarante" data-c="fantasy" data-w="400" class="qwc-font-item font-id-29"></li>
<li title="Amaranth" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-30"></li>
<li title="Amatic SC" data-c="cursive" data-w="400,700" class="qwc-font-item font-id-31"></li>
<li title="Amethysta" data-c="serif" data-w="400" class="qwc-font-item font-id-32"></li>
<li title="Amiri" data-c="serif" data-w="400,700," class="qwc-font-item font-id-33"></li>
<li title="Amita" data-c="monospace" data-w="400,700" class="qwc-font-item font-id-34"></li>
<li title="Anaheim" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-35"></li>
<li title="Andada" data-c="serif" data-w="400" class="qwc-font-item font-id-36"></li>
<li title="Andika" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-37"></li>
<li title="Angkor" data-c="fantasy" data-w="400" class="qwc-font-item font-id-38"></li>
<li title="Annie Use Your Telescope" data-c="cursive" data-w="400" class="qwc-font-item font-id-39"></li>
<li title="Anonymous Pro" data-c="monospace" data-w="400,700," class="qwc-font-item font-id-40"></li>
<li title="Antic" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-41"></li>
<li title="Antic Didone" data-c="serif" data-w="400" class="qwc-font-item font-id-42"></li>
<li title="Antic Slab" data-c="serif" data-w="400" class="qwc-font-item font-id-43"></li>
<li title="Anton" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-44"></li>
<li title="Arapey" data-c="serif" data-w="400" class="qwc-font-item font-id-45"></li>
<li title="Arbutus" data-c="fantasy" data-w="400" class="qwc-font-item font-id-46"></li>
<li title="Arbutus Slab" data-c="serif" data-w="400" class="qwc-font-item font-id-47"></li>
<li title="Architects Daughter" data-c="cursive" data-w="400" class="qwc-font-item font-id-48"></li>
<li title="Archivo Black" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-49"></li>
<li title="Archivo Narrow" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-50"></li>
<li title="Arimo" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-51"></li>
<li title="Arizonia" data-c="cursive" data-w="400" class="qwc-font-item font-id-52"></li>
<li title="Armata" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-53"></li>
<li title="Artifika" data-c="serif" data-w="400" class="qwc-font-item font-id-54"></li>
<li title="Arvo" data-c="serif" data-w="400,700," class="qwc-font-item font-id-55"></li>
<li title="Arya" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-56"></li>
<li title="Asap" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-57"></li>
<li title="Asset" data-c="fantasy" data-w="400" class="qwc-font-item font-id-58"></li>
<li title="Astloch" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-59"></li>
<li title="Asul" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-60"></li>
<li title="Atomic Age" data-c="fantasy" data-w="400" class="qwc-font-item font-id-61"></li>
<li title="Aubrey" data-c="fantasy" data-w="400" class="qwc-font-item font-id-62"></li>
<li title="Audiowide" data-c="fantasy" data-w="400" class="qwc-font-item font-id-63"></li>
<li title="Autour One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-64"></li>
<li title="Average" data-c="serif" data-w="400" class="qwc-font-item font-id-65"></li>
<li title="Average Sans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-66"></li>
<li title="Averia Gruesa Libre" data-c="fantasy" data-w="400" class="qwc-font-item font-id-67"></li>
<li title="Averia Libre" data-c="fantasy" data-w="300,400,700," class="qwc-font-item font-id-68"></li>
<li title="Averia Sans Libre" data-c="fantasy" data-w="300,400,700," class="qwc-font-item font-id-69"></li>
<li title="Averia Serif Libre" data-c="fantasy" data-w="300,400,700," class="qwc-font-item font-id-70"></li>
<li class="qwc-font-heading-title wp-ui-primary">B</li>
<li title="Bad Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-71"></li>
<li title="Balthazar" data-c="serif" data-w="400" class="qwc-font-item font-id-72"></li>
<li title="Bangers" data-c="fantasy" data-w="400" class="qwc-font-item font-id-73"></li>
<li title="Basic" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-74"></li>
<li title="Battambang" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-75"></li>
<li title="Baumans" data-c="fantasy" data-w="400" class="qwc-font-item font-id-76"></li>
<li title="Bayon" data-c="fantasy" data-w="400" class="qwc-font-item font-id-77"></li>
<li title="Belgrano" data-c="serif" data-w="400" class="qwc-font-item font-id-78"></li>
<li title="Belleza" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-79"></li>
<li title="BenchNine" data-c="sans-serif" data-w="300,400,700" class="qwc-font-item font-id-80"></li>
<li title="Bentham" data-c="serif" data-w="400" class="qwc-font-item font-id-81"></li>
<li title="Berkshire Swash" data-c="cursive" data-w="400" class="qwc-font-item font-id-82"></li>
<li title="Bevan" data-c="fantasy" data-w="400" class="qwc-font-item font-id-83"></li>
<li title="Bigelow Rules" data-c="fantasy" data-w="400" class="qwc-font-item font-id-84"></li>
<li title="Bigshot One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-85"></li>
<li title="Bilbo" data-c="cursive" data-w="400" class="qwc-font-item font-id-86"></li>
<li title="Bilbo Swash Caps" data-c="cursive" data-w="400" class="qwc-font-item font-id-87"></li>
<li title="Biryani" data-c="sans-serif" data-w="200,300,400,600,700,800,900" class="qwc-font-item font-id-88"></li>
<li title="Bitter" data-c="serif" data-w="400,700" class="qwc-font-item font-id-89"></li>
<li title="Black Ops One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-90"></li>
<li title="Bokor" data-c="fantasy" data-w="400" class="qwc-font-item font-id-91"></li>
<li title="Bonbon" data-c="cursive" data-w="400" class="qwc-font-item font-id-92"></li>
<li title="Boogaloo" data-c="fantasy" data-w="400" class="qwc-font-item font-id-93"></li>
<li title="Bowlby One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-94"></li>
<li title="Bowlby One SC" data-c="fantasy" data-w="400" class="qwc-font-item font-id-95"></li>
<li title="Brawler" data-c="serif" data-w="400" class="qwc-font-item font-id-96"></li>
<li title="Bree Serif" data-c="serif" data-w="400" class="qwc-font-item font-id-97"></li>
<li title="Bubblegum Sans" data-c="fantasy" data-w="400" class="qwc-font-item font-id-98"></li>
<li title="Bubbler One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-99"></li>
<li title="Buda" data-c="serif" data-w="400" class="qwc-font-item font-id-100"></li>
<li title="Buenard" data-c="serif" data-w="400,700" class="qwc-font-item font-id-101"></li>
<li title="Butcherman" data-c="fantasy" data-w="400" class="qwc-font-item font-id-102"></li>
<li title="Butterfly Kids" data-c="cursive" data-w="400" class="qwc-font-item font-id-103"></li>
<li class="qwc-font-heading-title wp-ui-primary">C</li>
<li title="Cabin" data-c="sans-serif" data-w="400,500,600,700," class="qwc-font-item font-id-104"></li>
<li title="Cabin Condensed" data-c="sans-serif" data-w="400,500,600,700" class="qwc-font-item font-id-105"></li>
<li title="Cabin Sketch" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-106"></li>
<li title="Caesar Dressing" data-c="fantasy" data-w="400" class="qwc-font-item font-id-107"></li>
<li title="Cagliostro" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-108"></li>
<li title="Calligraffitti" data-c="cursive" data-w="400" class="qwc-font-item font-id-109"></li>
<li title="Cambay" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-110"></li>
<li title="Cambo" data-c="serif" data-w="400" class="qwc-font-item font-id-111"></li>
<li title="Candal" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-112"></li>
<li title="Cantarell" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-113"></li>
<li title="Cantata One" data-c="serif" data-w="400" class="qwc-font-item font-id-114"></li>
<li title="Cantora One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-115"></li>
<li title="Capriola" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-116"></li>
<li title="Cardo" data-c="serif" data-w="400,700" class="qwc-font-item font-id-117"></li>
<li title="Carme" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-118"></li>
<li title="Carrois Gothic" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-119"></li>
<li title="Carrois Gothic SC" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-120"></li>
<li title="Carter One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-121"></li>
<li title="Caudex" data-c="serif" data-w="400,700," class="qwc-font-item font-id-122"></li>
<li title="Cedarville Cursive" data-c="cursive" data-w="400" class="qwc-font-item font-id-123"></li>
<li title="Ceviche One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-124"></li>
<li title="Changa One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-125"></li>
<li title="Chango" data-c="fantasy" data-w="400" class="qwc-font-item font-id-126"></li>
<li title="Chau Philomene One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-127"></li>
<li title="Chela One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-128"></li>
<li title="Chelsea Market" data-c="fantasy" data-w="400" class="qwc-font-item font-id-129"></li>
<li title="Chenla" data-c="fantasy" data-w="400" class="qwc-font-item font-id-130"></li>
<li title="Cherry Cream Soda" data-c="fantasy" data-w="400" class="qwc-font-item font-id-131"></li>
<li title="Cherry Swash" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-132"></li>
<li title="Chewy" data-c="fantasy" data-w="400" class="qwc-font-item font-id-133"></li>
<li title="Chicle" data-c="fantasy" data-w="400" class="qwc-font-item font-id-134"></li>
<li title="Chivo" data-c="sans-serif" data-w="400,900," class="qwc-font-item font-id-135"></li>
<li title="Cinzel" data-c="serif" data-w="400,700,900" class="qwc-font-item font-id-136"></li>
<li title="Cinzel Decorative" data-c="fantasy" data-w="400,700,900" class="qwc-font-item font-id-137"></li>
<li title="Clicker Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-138"></li>
<li title="Coda" data-c="fantasy" data-w="400,800" class="qwc-font-item font-id-139"></li>
<li title="Coda Caption" data-c="sans-serif" data-w="800" class="qwc-font-item font-id-140"></li>
<li title="Codystar" data-c="fantasy" data-w="300,400" class="qwc-font-item font-id-141"></li>
<li title="Combo" data-c="fantasy" data-w="400" class="qwc-font-item font-id-142"></li>
<li title="Comfortaa" data-c="fantasy" data-w="300,400,700" class="qwc-font-item font-id-143"></li>
<li title="Coming Soon" data-c="cursive" data-w="400" class="qwc-font-item font-id-144"></li>
<li title="Concert One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-145"></li>
<li title="Condiment" data-c="cursive" data-w="400" class="qwc-font-item font-id-146"></li>
<li title="Content" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-147"></li>
<li title="Contrail One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-148"></li>
<li title="Convergence" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-149"></li>
<li title="Cookie" data-c="cursive" data-w="400" class="qwc-font-item font-id-150"></li>
<li title="Copse" data-c="serif" data-w="400" class="qwc-font-item font-id-151"></li>
<li title="Corben" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-152"></li>
<li title="Courgette" data-c="cursive" data-w="400" class="qwc-font-item font-id-153"></li>
<li title="Cousine" data-c="monospace" data-w="400,700," class="qwc-font-item font-id-154"></li>
<li title="Coustard" data-c="serif" data-w="400,900" class="qwc-font-item font-id-155"></li>
<li title="Covered By Your Grace" data-c="cursive" data-w="400" class="qwc-font-item font-id-156"></li>
<li title="Crafty Girls" data-c="cursive" data-w="400" class="qwc-font-item font-id-157"></li>
<li title="Creepster" data-c="fantasy" data-w="400" class="qwc-font-item font-id-158"></li>
<li title="Crete Round" data-c="serif" data-w="400" class="qwc-font-item font-id-159"></li>
<li title="Crimson Text" data-c="serif" data-w="400,600,700," class="qwc-font-item font-id-160"></li>
<li title="Croissant One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-161"></li>
<li title="Crushed" data-c="fantasy" data-w="400" class="qwc-font-item font-id-162"></li>
<li title="Cuprum" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-163"></li>
<li title="Cutive" data-c="serif" data-w="400" class="qwc-font-item font-id-164"></li>
<li title="Cutive Mono" data-c="monospace" data-w="400" class="qwc-font-item font-id-165"></li>
<li class="qwc-font-heading-title wp-ui-primary">D</li>
<li title="Damion" data-c="cursive" data-w="400" class="qwc-font-item font-id-166"></li>
<li title="Dancing Script" data-c="cursive" data-w="400,700" class="qwc-font-item font-id-167"></li>
<li title="Dangrek" data-c="fantasy" data-w="400" class="qwc-font-item font-id-168"></li>
<li title="Dawning of a New Day" data-c="cursive" data-w="400" class="qwc-font-item font-id-169"></li>
<li title="Days One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-170"></li>
<li title="Dekko" data-c="cursive" data-w="400" class="qwc-font-item font-id-171"></li>
<li title="Delius" data-c="cursive" data-w="400" class="qwc-font-item font-id-172"></li>
<li title="Delius Swash Caps" data-c="cursive" data-w="400" class="qwc-font-item font-id-173"></li>
<li title="Delius Unicase" data-c="cursive" data-w="400,700" class="qwc-font-item font-id-174"></li>
<li title="Della Respira" data-c="serif" data-w="400" class="qwc-font-item font-id-175"></li>
<li title="Denk One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-176"></li>
<li title="Devonshire" data-c="cursive" data-w="400" class="qwc-font-item font-id-177"></li>
<li title="Dhurjati" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-178"></li>
<li title="Didact Gothic" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-179"></li>
<li title="Diplomata" data-c="fantasy" data-w="400" class="qwc-font-item font-id-180"></li>
<li title="Diplomata SC" data-c="fantasy" data-w="400" class="qwc-font-item font-id-181"></li>
<li title="Domine" data-c="serif" data-w="400,700" class="qwc-font-item font-id-182"></li>
<li title="Donegal One" data-c="serif" data-w="400" class="qwc-font-item font-id-183"></li>
<li title="Doppio One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-184"></li>
<li title="Dorsa" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-185"></li>
<li title="Dosis" data-c="sans-serif" data-w="200,300,400,500,600,700,800" class="qwc-font-item font-id-186"></li>
<li title="Dr Sugiyama" data-c="cursive" data-w="400" class="qwc-font-item font-id-187"></li>
<li title="Droid Sans" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-188"></li>
<li title="Droid Sans Mono" data-c="monospace" data-w="400" class="qwc-font-item font-id-189"></li>
<li title="Droid Serif" data-c="serif" data-w="400,700," class="qwc-font-item font-id-190"></li>
<li title="Duru Sans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-191"></li>
<li title="Dynalight" data-c="fantasy" data-w="400" class="qwc-font-item font-id-192"></li>
<li class="qwc-font-heading-title wp-ui-primary">E</li>
<li title="EB Garamond" data-c="serif" data-w="400" class="qwc-font-item font-id-193"></li>
<li title="Eagle Lake" data-c="cursive" data-w="400" class="qwc-font-item font-id-194"></li>
<li title="Eater" data-c="fantasy" data-w="400" class="qwc-font-item font-id-195"></li>
<li title="Economica" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-196"></li>
<li title="Ek Mukta" data-c="sans-serif" data-w="200,300,400,500,600,700,800" class="qwc-font-item font-id-197"></li>
<li title="Electrolize" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-198"></li>
<li title="Elsie" data-c="fantasy" data-w="400,900" class="qwc-font-item font-id-199"></li>
<li title="Elsie Swash Caps" data-c="fantasy" data-w="400,900" class="qwc-font-item font-id-200"></li>
<li title="Emblema One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-201"></li>
<li title="Emilys Candy" data-c="fantasy" data-w="400" class="qwc-font-item font-id-202"></li>
<li title="Engagement" data-c="cursive" data-w="400" class="qwc-font-item font-id-203"></li>
<li title="Englebert" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-204"></li>
<li title="Enriqueta" data-c="serif" data-w="400,700" class="qwc-font-item font-id-205"></li>
<li title="Erica One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-206"></li>
<li title="Esteban" data-c="serif" data-w="400" class="qwc-font-item font-id-207"></li>
<li title="Euphoria Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-208"></li>
<li title="Ewert" data-c="fantasy" data-w="400" class="qwc-font-item font-id-209"></li>
<li title="Exo" data-c="sans-serif" data-w="100,200,300,400,500,600,700,800,900," class="qwc-font-item font-id-210"></li>
<li title="Exo 2" data-c="sans-serif" data-w="100,200,300,400,500,600,700,800,900," class="qwc-font-item font-id-211"></li>
<li title="Expletus Sans" data-c="fantasy" data-w="400,500,600,700," class="qwc-font-item font-id-212"></li>
<li class="qwc-font-heading-title wp-ui-primary">F</li>
<li title="Fanwood Text" data-c="serif" data-w="400" class="qwc-font-item font-id-213"></li>
<li title="Fascinate" data-c="fantasy" data-w="400" class="qwc-font-item font-id-214"></li>
<li title="Fascinate Inline" data-c="fantasy" data-w="400" class="qwc-font-item font-id-215"></li>
<li title="Faster One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-216"></li>
<li title="Fasthand" data-c="serif" data-w="400" class="qwc-font-item font-id-217"></li>
<li title="Fauna One" data-c="serif" data-w="400" class="qwc-font-item font-id-218"></li>
<li title="Federant" data-c="fantasy" data-w="400" class="qwc-font-item font-id-219"></li>
<li title="Federo" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-220"></li>
<li title="Felipa" data-c="cursive" data-w="400" class="qwc-font-item font-id-221"></li>
<li title="Fenix" data-c="serif" data-w="400" class="qwc-font-item font-id-222"></li>
<li title="Finger Paint" data-c="fantasy" data-w="400" class="qwc-font-item font-id-223"></li>
<li title="Fira Mono" data-c="monospace" data-w="400,700" class="qwc-font-item font-id-224"></li>
<li title="Fira Sans" data-c="sans-serif" data-w="300,400,500,700," class="qwc-font-item font-id-225"></li>
<li title="Fjalla One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-226"></li>
<li title="Fjord One" data-c="serif" data-w="400" class="qwc-font-item font-id-227"></li>
<li title="Flamenco" data-c="fantasy" data-w="300,400" class="qwc-font-item font-id-228"></li>
<li title="Flavors" data-c="fantasy" data-w="400" class="qwc-font-item font-id-229"></li>
<li title="Fondamento" data-c="cursive" data-w="400" class="qwc-font-item font-id-230"></li>
<li title="Fontdiner Swanky" data-c="fantasy" data-w="400" class="qwc-font-item font-id-231"></li>
<li title="Forum" data-c="fantasy" data-w="400" class="qwc-font-item font-id-232"></li>
<li title="Francois One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-233"></li>
<li title="Freckle Face" data-c="fantasy" data-w="400" class="qwc-font-item font-id-234"></li>
<li title="Fredericka the Great" data-c="fantasy" data-w="400" class="qwc-font-item font-id-235"></li>
<li title="Fredoka One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-236"></li>
<li title="Freehand" data-c="fantasy" data-w="400" class="qwc-font-item font-id-237"></li>
<li title="Fresca" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-238"></li>
<li title="Frijole" data-c="fantasy" data-w="400" class="qwc-font-item font-id-239"></li>
<li title="Fruktur" data-c="fantasy" data-w="400" class="qwc-font-item font-id-240"></li>
<li title="Fugaz One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-241"></li>
<li class="qwc-font-heading-title wp-ui-primary">G</li>
<li title="GFS Didot" data-c="serif" data-w="400" class="qwc-font-item font-id-242"></li>
<li title="GFS Neohellenic" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-243"></li>
<li title="Gabriela" data-c="serif" data-w="400" class="qwc-font-item font-id-244"></li>
<li title="Gafata" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-245"></li>
<li title="Galdeano" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-246"></li>
<li title="Galindo" data-c="fantasy" data-w="400" class="qwc-font-item font-id-247"></li>
<li title="Gentium Basic" data-c="serif" data-w="400,700," class="qwc-font-item font-id-248"></li>
<li title="Gentium Book Basic" data-c="serif" data-w="400,700," class="qwc-font-item font-id-249"></li>
<li title="Geo" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-250"></li>
<li title="Geostar" data-c="fantasy" data-w="400" class="qwc-font-item font-id-251"></li>
<li title="Geostar Fill" data-c="fantasy" data-w="400" class="qwc-font-item font-id-252"></li>
<li title="Germania One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-253"></li>
<li title="Gidugu" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-254"></li>
<li title="Gilda Display" data-c="serif" data-w="400" class="qwc-font-item font-id-255"></li>
<li title="Give You Glory" data-c="cursive" data-w="400" class="qwc-font-item font-id-256"></li>
<li title="Glass Antiqua" data-c="fantasy" data-w="400" class="qwc-font-item font-id-257"></li>
<li title="Glegoo" data-c="serif" data-w="400,700" class="qwc-font-item font-id-258"></li>
<li title="Gloria Hallelujah" data-c="cursive" data-w="400" class="qwc-font-item font-id-259"></li>
<li title="Goblin One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-260"></li>
<li title="Gochi Hand" data-c="cursive" data-w="400" class="qwc-font-item font-id-261"></li>
<li title="Gorditas" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-262"></li>
<li title="Goudy Bookletter 1911" data-c="serif" data-w="400" class="qwc-font-item font-id-263"></li>
<li title="Graduate" data-c="fantasy" data-w="400" class="qwc-font-item font-id-264"></li>
<li title="Grand Hotel" data-c="cursive" data-w="400" class="qwc-font-item font-id-265"></li>
<li title="Gravitas One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-266"></li>
<li title="Great Vibes" data-c="cursive" data-w="400" class="qwc-font-item font-id-267"></li>
<li title="Griffy" data-c="fantasy" data-w="400" class="qwc-font-item font-id-268"></li>
<li title="Gruppo" data-c="fantasy" data-w="400" class="qwc-font-item font-id-269"></li>
<li title="Gudea" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-270"></li>
<li title="Gurajada" data-c="serif" data-w="400" class="qwc-font-item font-id-271"></li>
<li class="qwc-font-heading-title wp-ui-primary">H</li>
<li title="Habibi" data-c="serif" data-w="400" class="qwc-font-item font-id-272"></li>
<li title="Halant" data-c="serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-273"></li>
<li title="Hammersmith One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-274"></li>
<li title="Hanalei" data-c="fantasy" data-w="400" class="qwc-font-item font-id-275"></li>
<li title="Hanalei Fill" data-c="fantasy" data-w="400" class="qwc-font-item font-id-276"></li>
<li title="Handlee" data-c="cursive" data-w="400" class="qwc-font-item font-id-277"></li>
<li title="Hanuman" data-c="serif" data-w="400,700" class="qwc-font-item font-id-278"></li>
<li title="Happy Monkey" data-c="fantasy" data-w="400" class="qwc-font-item font-id-279"></li>
<li title="Headland One" data-c="serif" data-w="400" class="qwc-font-item font-id-280"></li>
<li title="Henny Penny" data-c="fantasy" data-w="400" class="qwc-font-item font-id-281"></li>
<li title="Herr Von Muellerhoff" data-c="cursive" data-w="400" class="qwc-font-item font-id-282"></li>
<li title="Hind" data-c="sans-serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-283"></li>
<li title="Holtwood One SC" data-c="serif" data-w="400" class="qwc-font-item font-id-284"></li>
<li title="Homemade Apple" data-c="cursive" data-w="400" class="qwc-font-item font-id-285"></li>
<li title="Homenaje" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-286"></li>
<li class="qwc-font-heading-title wp-ui-primary">I</li>
<li title="IM Fell DW Pica" data-c="serif" data-w="400" class="qwc-font-item font-id-287"></li>
<li title="IM Fell DW Pica SC" data-c="serif" data-w="400" class="qwc-font-item font-id-288"></li>
<li title="IM Fell Double Pica" data-c="serif" data-w="400" class="qwc-font-item font-id-289"></li>
<li title="IM Fell Double Pica SC" data-c="serif" data-w="400" class="qwc-font-item font-id-290"></li>
<li title="IM Fell English" data-c="serif" data-w="400" class="qwc-font-item font-id-291"></li>
<li title="IM Fell English SC" data-c="serif" data-w="400" class="qwc-font-item font-id-292"></li>
<li title="IM Fell French Canon" data-c="serif" data-w="400" class="qwc-font-item font-id-293"></li>
<li title="IM Fell French Canon SC" data-c="serif" data-w="400" class="qwc-font-item font-id-294"></li>
<li title="IM Fell Great Primer" data-c="serif" data-w="400" class="qwc-font-item font-id-295"></li>
<li title="IM Fell Great Primer SC" data-c="serif" data-w="400" class="qwc-font-item font-id-296"></li>
<li title="Iceberg" data-c="fantasy" data-w="400" class="qwc-font-item font-id-297"></li>
<li title="Iceland" data-c="fantasy" data-w="400" class="qwc-font-item font-id-298"></li>
<li title="Imprima" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-299"></li>
<li title="Inconsolata" data-c="monospace" data-w="400,700" class="qwc-font-item font-id-300"></li>
<li title="Inder" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-301"></li>
<li title="Indie Flower" data-c="cursive" data-w="400" class="qwc-font-item font-id-302"></li>
<li title="Inika" data-c="serif" data-w="400,700" class="qwc-font-item font-id-303"></li>
<li title="Irish Grover" data-c="fantasy" data-w="400" class="qwc-font-item font-id-304"></li>
<li title="Istok Web" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-305"></li>
<li title="Italiana" data-c="serif" data-w="400" class="qwc-font-item font-id-306"></li>
<li title="Italianno" data-c="cursive" data-w="400" class="qwc-font-item font-id-307"></li>
<li class="qwc-font-heading-title wp-ui-primary">J</li>
<li title="Jacques Francois" data-c="serif" data-w="400" class="qwc-font-item font-id-308"></li>
<li title="Jacques Francois Shadow" data-c="fantasy" data-w="400" class="qwc-font-item font-id-309"></li>
<li title="Jaldi" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-310"></li>
<li title="Jim Nightshade" data-c="cursive" data-w="400" class="qwc-font-item font-id-311"></li>
<li title="Jockey One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-312"></li>
<li title="Jolly Lodger" data-c="fantasy" data-w="400" class="qwc-font-item font-id-313"></li>
<li title="Josefin Sans" data-c="sans-serif" data-w="100,300,400,600,700," class="qwc-font-item font-id-314"></li>
<li title="Josefin Slab" data-c="serif" data-w="100,300,400,600,700," class="qwc-font-item font-id-315"></li>
<li title="Joti One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-316"></li>
<li title="Judson" data-c="serif" data-w="400,700" class="qwc-font-item font-id-317"></li>
<li title="Julee" data-c="cursive" data-w="400" class="qwc-font-item font-id-318"></li>
<li title="Julius Sans One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-319"></li>
<li title="Junge" data-c="serif" data-w="400" class="qwc-font-item font-id-320"></li>
<li title="Jura" data-c="sans-serif" data-w="300,400,500,600" class="qwc-font-item font-id-321"></li>
<li title="Just Another Hand" data-c="cursive" data-w="400" class="qwc-font-item font-id-322"></li>
<li title="Just Me Again Down Here" data-c="cursive" data-w="400" class="qwc-font-item font-id-323"></li>
<li class="qwc-font-heading-title wp-ui-primary">K</li>
<li title="Kalam" data-c="cursive" data-w="300,400,700" class="qwc-font-item font-id-324"></li>
<li title="Kameron" data-c="serif" data-w="400,700" class="qwc-font-item font-id-325"></li>
<li title="Kantumruy" data-c="sans-serif" data-w="300,400,700" class="qwc-font-item font-id-326"></li>
<li title="Karla" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-327"></li>
<li title="Karma" data-c="serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-328"></li>
<li title="Kaushan Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-329"></li>
<li title="Kavoon" data-c="fantasy" data-w="400" class="qwc-font-item font-id-330"></li>
<li title="Kdam Thmor" data-c="fantasy" data-w="400" class="qwc-font-item font-id-331"></li>
<li title="Keania One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-332"></li>
<li title="Kelly Slab" data-c="fantasy" data-w="400" class="qwc-font-item font-id-333"></li>
<li title="Kenia" data-c="fantasy" data-w="400" class="qwc-font-item font-id-334"></li>
<li title="Khand" data-c="sans-serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-335"></li>
<li title="Khmer" data-c="fantasy" data-w="400" class="qwc-font-item font-id-336"></li>
<li title="Khula" data-c="sans-serif" data-w="300,400,600,700,800" class="qwc-font-item font-id-337"></li>
<li title="Kite One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-338"></li>
<li title="Knewave" data-c="fantasy" data-w="400" class="qwc-font-item font-id-339"></li>
<li title="Kotta One" data-c="serif" data-w="400" class="qwc-font-item font-id-340"></li>
<li title="Koulen" data-c="fantasy" data-w="400" class="qwc-font-item font-id-341"></li>
<li title="Kranky" data-c="fantasy" data-w="400" class="qwc-font-item font-id-342"></li>
<li title="Kreon" data-c="serif" data-w="300,400,700" class="qwc-font-item font-id-343"></li>
<li title="Kristi" data-c="cursive" data-w="400" class="qwc-font-item font-id-344"></li>
<li title="Krona One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-345"></li>
<li title="Kurale" data-c="serif" data-w="400" class="qwc-font-item font-id-346"></li>
<li class="qwc-font-heading-title wp-ui-primary">L</li>
<li title="La Belle Aurore" data-c="cursive" data-w="400" class="qwc-font-item font-id-347"></li>
<li title="Laila" data-c="serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-348"></li>
<li title="Lakki Reddy" data-c="cursive" data-w="400" class="qwc-font-item font-id-349"></li>
<li title="Lancelot" data-c="fantasy" data-w="400" class="qwc-font-item font-id-350"></li>
<li title="Lateef" data-c="cursive" data-w="400" class="qwc-font-item font-id-351"></li>
<li title="Lato" data-c="sans-serif" data-w="100,300,400,700,900," class="qwc-font-item font-id-352"></li>
<li title="League Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-353"></li>
<li title="Leckerli One" data-c="cursive" data-w="400" class="qwc-font-item font-id-354"></li>
<li title="Ledger" data-c="serif" data-w="400" class="qwc-font-item font-id-355"></li>
<li title="Lekton" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-356"></li>
<li title="Lemon" data-c="fantasy" data-w="400" class="qwc-font-item font-id-357"></li>
<li title="Libre Baskerville" data-c="serif" data-w="400,700" class="qwc-font-item font-id-358"></li>
<li title="Life Savers" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-359"></li>
<li title="Lilita One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-360"></li>
<li title="Lily Script One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-361"></li>
<li title="Limelight" data-c="fantasy" data-w="400" class="qwc-font-item font-id-362"></li>
<li title="Linden Hill" data-c="serif" data-w="400" class="qwc-font-item font-id-363"></li>
<li title="Lobster" data-c="fantasy" data-w="400" class="qwc-font-item font-id-364"></li>
<li title="Lobster Two" data-c="fantasy" data-w="400,700," class="qwc-font-item font-id-365"></li>
<li title="Londrina Outline" data-c="fantasy" data-w="400" class="qwc-font-item font-id-366"></li>
<li title="Londrina Shadow" data-c="fantasy" data-w="400" class="qwc-font-item font-id-367"></li>
<li title="Londrina Sketch" data-c="fantasy" data-w="400" class="qwc-font-item font-id-368"></li>
<li title="Londrina Solid" data-c="fantasy" data-w="400" class="qwc-font-item font-id-369"></li>
<li title="Lora" data-c="serif" data-w="400,700," class="qwc-font-item font-id-370"></li>
<li title="Love Ya Like A Sister" data-c="fantasy" data-w="400" class="qwc-font-item font-id-371"></li>
<li title="Loved by the King" data-c="cursive" data-w="400" class="qwc-font-item font-id-372"></li>
<li title="Lovers Quarrel" data-c="cursive" data-w="400" class="qwc-font-item font-id-373"></li>
<li title="Luckiest Guy" data-c="fantasy" data-w="400" class="qwc-font-item font-id-374"></li>
<li title="Lusitana" data-c="serif" data-w="400,700" class="qwc-font-item font-id-375"></li>
<li title="Lustria" data-c="serif" data-w="400" class="qwc-font-item font-id-376"></li>
<li class="qwc-font-heading-title wp-ui-primary">M</li>
<li title="Macondo" data-c="fantasy" data-w="400" class="qwc-font-item font-id-377"></li>
<li title="Macondo Swash Caps" data-c="fantasy" data-w="400" class="qwc-font-item font-id-378"></li>
<li title="Magra" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-379"></li>
<li title="Maiden Orange" data-c="fantasy" data-w="400" class="qwc-font-item font-id-380"></li>
<li title="Mako" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-381"></li>
<li title="Mallanna" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-382"></li>
<li title="Mandali" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-383"></li>
<li title="Marcellus" data-c="serif" data-w="400" class="qwc-font-item font-id-384"></li>
<li title="Marcellus SC" data-c="serif" data-w="400" class="qwc-font-item font-id-385"></li>
<li title="Marck Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-386"></li>
<li title="Margarine" data-c="fantasy" data-w="400" class="qwc-font-item font-id-387"></li>
<li title="Marko One" data-c="serif" data-w="400" class="qwc-font-item font-id-388"></li>
<li title="Marmelad" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-389"></li>
<li title="Martel" data-c="serif" data-w="200,300,400,600,700,800,900" class="qwc-font-item font-id-390"></li>
<li title="Martel Sans" data-c="sans-serif" data-w="200,300,400,600,700,800,900" class="qwc-font-item font-id-391"></li>
<li title="Marvel" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-392"></li>
<li title="Mate" data-c="serif" data-w="400" class="qwc-font-item font-id-393"></li>
<li title="Mate SC" data-c="serif" data-w="400" class="qwc-font-item font-id-394"></li>
<li title="Maven Pro" data-c="sans-serif" data-w="400,500,700,900" class="qwc-font-item font-id-395"></li>
<li title="McLaren" data-c="fantasy" data-w="400" class="qwc-font-item font-id-396"></li>
<li title="Meddon" data-c="cursive" data-w="400" class="qwc-font-item font-id-397"></li>
<li title="MedievalSharp" data-c="fantasy" data-w="400" class="qwc-font-item font-id-398"></li>
<li title="Medula One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-399"></li>
<li title="Megrim" data-c="fantasy" data-w="400" class="qwc-font-item font-id-400"></li>
<li title="Meie Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-401"></li>
<li title="Merienda" data-c="cursive" data-w="400,700" class="qwc-font-item font-id-402"></li>
<li title="Merienda One" data-c="cursive" data-w="400" class="qwc-font-item font-id-403"></li>
<li title="Merriweather" data-c="serif" data-w="300,400,700,900," class="qwc-font-item font-id-404"></li>
<li title="Merriweather Sans" data-c="sans-serif" data-w="300,400,700,800," class="qwc-font-item font-id-405"></li>
<li title="Metal" data-c="fantasy" data-w="400" class="qwc-font-item font-id-406"></li>
<li title="Metal Mania" data-c="fantasy" data-w="400" class="qwc-font-item font-id-407"></li>
<li title="Metamorphous" data-c="fantasy" data-w="400" class="qwc-font-item font-id-408"></li>
<li title="Metrophobic" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-409"></li>
<li title="Michroma" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-410"></li>
<li title="Milonga" data-c="fantasy" data-w="400" class="qwc-font-item font-id-411"></li>
<li title="Miltonian" data-c="fantasy" data-w="400" class="qwc-font-item font-id-412"></li>
<li title="Miltonian Tattoo" data-c="fantasy" data-w="400" class="qwc-font-item font-id-413"></li>
<li title="Miniver" data-c="fantasy" data-w="400" class="qwc-font-item font-id-414"></li>
<li title="Miss Fajardose" data-c="cursive" data-w="400" class="qwc-font-item font-id-415"></li>
<li title="Modak" data-c="fantasy" data-w="400" class="qwc-font-item font-id-416"></li>
<li title="Modern Antiqua" data-c="fantasy" data-w="400" class="qwc-font-item font-id-417"></li>
<li title="Molengo" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-418"></li>
<li title="Molle" data-c="cursive" data-w="italic" class="qwc-font-item font-id-419"></li>
<li title="Monda" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-420"></li>
<li title="Monofett" data-c="fantasy" data-w="400" class="qwc-font-item font-id-421"></li>
<li title="Monoton" data-c="fantasy" data-w="400" class="qwc-font-item font-id-422"></li>
<li title="Monsieur La Doulaise" data-c="cursive" data-w="400" class="qwc-font-item font-id-423"></li>
<li title="Montaga" data-c="serif" data-w="400" class="qwc-font-item font-id-424"></li>
<li title="Montez" data-c="cursive" data-w="400" class="qwc-font-item font-id-425"></li>
<li title="Montserrat" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-426"></li>
<li title="Montserrat Alternates" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-427"></li>
<li title="Montserrat Subrayada" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-428"></li>
<li title="Moul" data-c="fantasy" data-w="400" class="qwc-font-item font-id-429"></li>
<li title="Moulpali" data-c="fantasy" data-w="400" class="qwc-font-item font-id-430"></li>
<li title="Mountains of Christmas" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-431"></li>
<li title="Mouse Memoirs" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-432"></li>
<li title="Mr Bedfort" data-c="cursive" data-w="400" class="qwc-font-item font-id-433"></li>
<li title="Mr Dafoe" data-c="cursive" data-w="400" class="qwc-font-item font-id-434"></li>
<li title="Mr De Haviland" data-c="cursive" data-w="400" class="qwc-font-item font-id-435"></li>
<li title="Mrs Saint Delafield" data-c="cursive" data-w="400" class="qwc-font-item font-id-436"></li>
<li title="Mrs Sheppards" data-c="cursive" data-w="400" class="qwc-font-item font-id-437"></li>
<li title="Muli" data-c="sans-serif" data-w="300,400" class="qwc-font-item font-id-438"></li>
<li title="Mystery Quest" data-c="fantasy" data-w="400" class="qwc-font-item font-id-439"></li>
<li class="qwc-font-heading-title wp-ui-primary">N</li>
<li title="NTR" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-440"></li>
<li title="Neucha" data-c="cursive" data-w="400" class="qwc-font-item font-id-441"></li>
<li title="Neuton" data-c="serif" data-w="200,300,400,700,800" class="qwc-font-item font-id-442"></li>
<li title="New Rocker" data-c="fantasy" data-w="400" class="qwc-font-item font-id-443"></li>
<li title="News Cycle" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-444"></li>
<li title="Niconne" data-c="cursive" data-w="400" class="qwc-font-item font-id-445"></li>
<li title="Nixie One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-446"></li>
<li title="Nobile" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-447"></li>
<li title="Nokora" data-c="serif" data-w="400,700" class="qwc-font-item font-id-448"></li>
<li title="Norican" data-c="cursive" data-w="400" class="qwc-font-item font-id-449"></li>
<li title="Nosifer" data-c="fantasy" data-w="400" class="qwc-font-item font-id-450"></li>
<li title="Nothing You Could Do" data-c="cursive" data-w="400" class="qwc-font-item font-id-451"></li>
<li title="Noticia Text" data-c="serif" data-w="400,700," class="qwc-font-item font-id-452"></li>
<li title="Noto Sans" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-453"></li>
<li title="Noto Serif" data-c="serif" data-w="400,700," class="qwc-font-item font-id-454"></li>
<li title="Nova Cut" data-c="fantasy" data-w="400" class="qwc-font-item font-id-455"></li>
<li title="Nova Flat" data-c="fantasy" data-w="400" class="qwc-font-item font-id-456"></li>
<li title="Nova Mono" data-c="monospace" data-w="400" class="qwc-font-item font-id-457"></li>
<li title="Nova Oval" data-c="fantasy" data-w="400" class="qwc-font-item font-id-458"></li>
<li title="Nova Round" data-c="fantasy" data-w="400" class="qwc-font-item font-id-459"></li>
<li title="Nova Script" data-c="fantasy" data-w="400" class="qwc-font-item font-id-460"></li>
<li title="Nova Slim" data-c="fantasy" data-w="400" class="qwc-font-item font-id-461"></li>
<li title="Nova Square" data-c="fantasy" data-w="400" class="qwc-font-item font-id-462"></li>
<li title="Numans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-463"></li>
<li title="Nunito" data-c="sans-serif" data-w="300,400,700" class="qwc-font-item font-id-464"></li>
<li class="qwc-font-heading-title wp-ui-primary">O</li>
<li title="Odor Mean Chey" data-c="fantasy" data-w="400" class="qwc-font-item font-id-465"></li>
<li title="Offside" data-c="fantasy" data-w="400" class="qwc-font-item font-id-466"></li>
<li title="Old Standard TT" data-c="serif" data-w="400,700" class="qwc-font-item font-id-467"></li>
<li title="Oldenburg" data-c="fantasy" data-w="400" class="qwc-font-item font-id-468"></li>
<li title="Oleo Script" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-469"></li>
<li title="Oleo Script Swash Caps" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-470"></li>
<li title="Open Sans" data-c="sans-serif" data-w="300,400,600,700,800," class="qwc-font-item font-id-471"></li>
<li title="Open Sans Condensed" data-c="sans-serif" data-w="300,700" class="qwc-font-item font-id-472"></li>
<li title="Oranienbaum" data-c="serif" data-w="400" class="qwc-font-item font-id-473"></li>
<li title="Orbitron" data-c="sans-serif" data-w="400,500,700,900" class="qwc-font-item font-id-474"></li>
<li title="Oregano" data-c="fantasy" data-w="400" class="qwc-font-item font-id-475"></li>
<li title="Orienta" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-476"></li>
<li title="Original Surfer" data-c="fantasy" data-w="400" class="qwc-font-item font-id-477"></li>
<li title="Oswald" data-c="sans-serif" data-w="300,400,700" class="qwc-font-item font-id-478"></li>
<li title="Over the Rainbow" data-c="cursive" data-w="400" class="qwc-font-item font-id-479"></li>
<li title="Overlock" data-c="fantasy" data-w="400,700,900," class="qwc-font-item font-id-480"></li>
<li title="Overlock SC" data-c="fantasy" data-w="400" class="qwc-font-item font-id-481"></li>
<li title="Ovo" data-c="serif" data-w="400" class="qwc-font-item font-id-482"></li>
<li title="Oxygen" data-c="sans-serif" data-w="300,400,700" class="qwc-font-item font-id-483"></li>
<li title="Oxygen Mono" data-c="monospace" data-w="400" class="qwc-font-item font-id-484"></li>
<li class="qwc-font-heading-title wp-ui-primary">P</li>
<li title="PT Mono" data-c="monospace" data-w="400" class="qwc-font-item font-id-485"></li>
<li title="PT Sans" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-486"></li>
<li title="PT Sans Caption" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-487"></li>
<li title="PT Sans Narrow" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-488"></li>
<li title="PT Serif" data-c="serif" data-w="400,700," class="qwc-font-item font-id-489"></li>
<li title="PT Serif Caption" data-c="serif" data-w="400" class="qwc-font-item font-id-490"></li>
<li title="Pacifico" data-c="cursive" data-w="400" class="qwc-font-item font-id-491"></li>
<li title="Palanquin" data-c="sans-serif" data-w="100,200,300,400,500,600,700" class="qwc-font-item font-id-492"></li>
<li title="Palanquin Dark" data-c="sans-serif" data-w="400,500,600,700" class="qwc-font-item font-id-493"></li>
<li title="Paprika" data-c="fantasy" data-w="400" class="qwc-font-item font-id-494"></li>
<li title="Parisienne" data-c="cursive" data-w="400" class="qwc-font-item font-id-495"></li>
<li title="Passero One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-496"></li>
<li title="Passion One" data-c="fantasy" data-w="400,700,900" class="qwc-font-item font-id-497"></li>
<li title="Pathway Gothic One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-498"></li>
<li title="Patrick Hand" data-c="cursive" data-w="400" class="qwc-font-item font-id-499"></li>
<li title="Patrick Hand SC" data-c="cursive" data-w="400" class="qwc-font-item font-id-500"></li>
<li title="Patua One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-501"></li>
<li title="Paytone One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-502"></li>
<li title="Peddana" data-c="serif" data-w="400" class="qwc-font-item font-id-503"></li>
<li title="Peralta" data-c="fantasy" data-w="400" class="qwc-font-item font-id-504"></li>
<li title="Permanent Marker" data-c="cursive" data-w="400" class="qwc-font-item font-id-505"></li>
<li title="Petit Formal Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-506"></li>
<li title="Petrona" data-c="serif" data-w="400" class="qwc-font-item font-id-507"></li>
<li title="Philosopher" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-508"></li>
<li title="Piedra" data-c="fantasy" data-w="400" class="qwc-font-item font-id-509"></li>
<li title="Pinyon Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-510"></li>
<li title="Pirata One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-511"></li>
<li title="Plaster" data-c="fantasy" data-w="400" class="qwc-font-item font-id-512"></li>
<li title="Play" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-513"></li>
<li title="Playball" data-c="fantasy" data-w="400" class="qwc-font-item font-id-514"></li>
<li title="Playfair Display" data-c="serif" data-w="400,700,900," class="qwc-font-item font-id-515"></li>
<li title="Playfair Display SC" data-c="serif" data-w="400,700,900," class="qwc-font-item font-id-516"></li>
<li title="Podkova" data-c="serif" data-w="400,700" class="qwc-font-item font-id-517"></li>
<li title="Poiret One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-518"></li>
<li title="Poller One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-519"></li>
<li title="Poly" data-c="serif" data-w="400" class="qwc-font-item font-id-520"></li>
<li title="Pompiere" data-c="fantasy" data-w="400" class="qwc-font-item font-id-521"></li>
<li title="Pontano Sans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-522"></li>
<li title="Port Lligat Sans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-523"></li>
<li title="Port Lligat Slab" data-c="serif" data-w="400" class="qwc-font-item font-id-524"></li>
<li title="Pragati Narrow" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-525"></li>
<li title="Prata" data-c="serif" data-w="400" class="qwc-font-item font-id-526"></li>
<li title="Preahvihear" data-c="fantasy" data-w="400" class="qwc-font-item font-id-527"></li>
<li title="Press Start 2P" data-c="fantasy" data-w="400" class="qwc-font-item font-id-528"></li>
<li title="Princess Sofia" data-c="cursive" data-w="400" class="qwc-font-item font-id-529"></li>
<li title="Prociono" data-c="serif" data-w="400" class="qwc-font-item font-id-530"></li>
<li title="Prosto One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-531"></li>
<li title="Puritan" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-532"></li>
<li title="Purple Purse" data-c="fantasy" data-w="400" class="qwc-font-item font-id-533"></li>
<li class="qwc-font-heading-title wp-ui-primary">Q</li>
<li title="Quando" data-c="serif" data-w="400" class="qwc-font-item font-id-534"></li>
<li title="Quantico" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-535"></li>
<li title="Quattrocento" data-c="serif" data-w="400,700" class="qwc-font-item font-id-536"></li>
<li title="Quattrocento Sans" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-537"></li>
<li title="Questrial" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-538"></li>
<li title="Quicksand" data-c="sans-serif" data-w="300,400,700" class="qwc-font-item font-id-539"></li>
<li title="Quintessential" data-c="cursive" data-w="400" class="qwc-font-item font-id-540"></li>
<li title="Qwigley" data-c="cursive" data-w="400" class="qwc-font-item font-id-541"></li>
<li class="qwc-font-heading-title wp-ui-primary">R</li>
<li title="Racing Sans One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-542"></li>
<li title="Radley" data-c="serif" data-w="400" class="qwc-font-item font-id-543"></li>
<li title="Rajdhani" data-c="sans-serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-544"></li>
<li title="Raleway" data-c="sans-serif" data-w="100,200,300,400,500,600,700,800,900" class="qwc-font-item font-id-545"></li>
<li title="Raleway Dots" data-c="fantasy" data-w="400" class="qwc-font-item font-id-546"></li>
<li title="Ramabhadra" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-547"></li>
<li title="Ramaraja" data-c="serif" data-w="400" class="qwc-font-item font-id-548"></li>
<li title="Rambla" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-549"></li>
<li title="Rammetto One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-550"></li>
<li title="Ranchers" data-c="fantasy" data-w="400" class="qwc-font-item font-id-551"></li>
<li title="Rancho" data-c="cursive" data-w="400" class="qwc-font-item font-id-552"></li>
<li title="Ranga" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-553"></li>
<li title="Rationale" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-554"></li>
<li title="Ravi Prakash" data-c="fantasy" data-w="400" class="qwc-font-item font-id-555"></li>
<li title="Redressed" data-c="cursive" data-w="400" class="qwc-font-item font-id-556"></li>
<li title="Reenie Beanie" data-c="cursive" data-w="400" class="qwc-font-item font-id-557"></li>
<li title="Revalia" data-c="fantasy" data-w="400" class="qwc-font-item font-id-558"></li>
<li title="Ribeye" data-c="fantasy" data-w="400" class="qwc-font-item font-id-559"></li>
<li title="Ribeye Marrow" data-c="fantasy" data-w="400" class="qwc-font-item font-id-560"></li>
<li title="Righteous" data-c="fantasy" data-w="400" class="qwc-font-item font-id-561"></li>
<li title="Risque" data-c="fantasy" data-w="400" class="qwc-font-item font-id-562"></li>
<li title="Roboto" data-c="sans-serif" data-w="100,300,400,500,700,900," class="qwc-font-item font-id-563"></li>
<li title="Roboto Condensed" data-c="sans-serif" data-w="300,400,700," class="qwc-font-item font-id-564"></li>
<li title="Roboto Mono" data-c="monospace" data-w="100,300,400,500,700," class="qwc-font-item font-id-565"></li>
<li title="Roboto Slab" data-c="serif" data-w="100,300,400,700" class="qwc-font-item font-id-566"></li>
<li title="Rochester" data-c="cursive" data-w="400" class="qwc-font-item font-id-567"></li>
<li title="Rock Salt" data-c="cursive" data-w="400" class="qwc-font-item font-id-568"></li>
<li title="Rokkitt" data-c="serif" data-w="400,700" class="qwc-font-item font-id-569"></li>
<li title="Romanesco" data-c="cursive" data-w="400" class="qwc-font-item font-id-570"></li>
<li title="Ropa Sans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-571"></li>
<li title="Rosario" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-572"></li>
<li title="Rosarivo" data-c="serif" data-w="400" class="qwc-font-item font-id-573"></li>
<li title="Rouge Script" data-c="cursive" data-w="400" class="qwc-font-item font-id-574"></li>
<li title="Rozha One" data-c="serif" data-w="400" class="qwc-font-item font-id-575"></li>
<li title="Rubik Mono One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-576"></li>
<li title="Rubik One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-577"></li>
<li title="Ruda" data-c="sans-serif" data-w="400,700,900" class="qwc-font-item font-id-578"></li>
<li title="Rufina" data-c="serif" data-w="400,700" class="qwc-font-item font-id-579"></li>
<li title="Ruge Boogie" data-c="cursive" data-w="400" class="qwc-font-item font-id-580"></li>
<li title="Ruluko" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-581"></li>
<li title="Rum Raisin" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-582"></li>
<li title="Ruslan Display" data-c="fantasy" data-w="400" class="qwc-font-item font-id-583"></li>
<li title="Russo One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-584"></li>
<li title="Ruthie" data-c="cursive" data-w="400" class="qwc-font-item font-id-585"></li>
<li title="Rye" data-c="fantasy" data-w="400" class="qwc-font-item font-id-586"></li>
<li class="qwc-font-heading-title wp-ui-primary">S</li>
<li title="Sacramento" data-c="cursive" data-w="400" class="qwc-font-item font-id-587"></li>
<li title="Sail" data-c="fantasy" data-w="400" class="qwc-font-item font-id-588"></li>
<li title="Salsa" data-c="fantasy" data-w="400" class="qwc-font-item font-id-589"></li>
<li title="Sanchez" data-c="serif" data-w="400" class="qwc-font-item font-id-590"></li>
<li title="Sancreek" data-c="fantasy" data-w="400" class="qwc-font-item font-id-591"></li>
<li title="Sansita One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-592"></li>
<li title="Sarina" data-c="fantasy" data-w="400" class="qwc-font-item font-id-593"></li>
<li title="Sarpanch" data-c="sans-serif" data-w="400,500,600,700,800,900" class="qwc-font-item font-id-594"></li>
<li title="Satisfy" data-c="cursive" data-w="400" class="qwc-font-item font-id-595"></li>
<li title="Scada" data-c="sans-serif" data-w="400,700," class="qwc-font-item font-id-596"></li>
<li title="Scheherazade" data-c="serif" data-w="400" class="qwc-font-item font-id-597"></li>
<li title="Schoolbell" data-c="cursive" data-w="400" class="qwc-font-item font-id-598"></li>
<li title="Seaweed Script" data-c="fantasy" data-w="400" class="qwc-font-item font-id-599"></li>
<li title="Sevillana" data-c="fantasy" data-w="400" class="qwc-font-item font-id-600"></li>
<li title="Seymour One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-601"></li>
<li title="Shadows Into Light" data-c="cursive" data-w="400" class="qwc-font-item font-id-602"></li>
<li title="Shadows Into Light Two" data-c="cursive" data-w="400" class="qwc-font-item font-id-603"></li>
<li title="Shanti" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-604"></li>
<li title="Share" data-c="fantasy" data-w="400,700," class="qwc-font-item font-id-605"></li>
<li title="Share Tech" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-606"></li>
<li title="Share Tech Mono" data-c="monospace" data-w="400" class="qwc-font-item font-id-607"></li>
<li title="Shojumaru" data-c="fantasy" data-w="400" class="qwc-font-item font-id-608"></li>
<li title="Short Stack" data-c="cursive" data-w="400" class="qwc-font-item font-id-609"></li>
<li title="Siemreap" data-c="fantasy" data-w="400" class="qwc-font-item font-id-610"></li>
<li title="Sigmar One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-611"></li>
<li title="Signika" data-c="sans-serif" data-w="300,400,600,700" class="qwc-font-item font-id-612"></li>
<li title="Signika Negative" data-c="sans-serif" data-w="300,400,600,700" class="qwc-font-item font-id-613"></li>
<li title="Simonetta" data-c="fantasy" data-w="400,900," class="qwc-font-item font-id-614"></li>
<li title="Sintony" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-615"></li>
<li title="Sirin Stencil" data-c="fantasy" data-w="400" class="qwc-font-item font-id-616"></li>
<li title="Six Caps" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-617"></li>
<li title="Skranji" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-618"></li>
<li title="Slabo 13px" data-c="serif" data-w="400" class="qwc-font-item font-id-619"></li>
<li title="Slabo 27px" data-c="serif" data-w="400" class="qwc-font-item font-id-620"></li>
<li title="Slackey" data-c="fantasy" data-w="400" class="qwc-font-item font-id-621"></li>
<li title="Smokum" data-c="fantasy" data-w="400" class="qwc-font-item font-id-622"></li>
<li title="Smythe" data-c="fantasy" data-w="400" class="qwc-font-item font-id-623"></li>
<li title="Sniglet" data-c="fantasy" data-w="400,800" class="qwc-font-item font-id-624"></li>
<li title="Snippet" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-625"></li>
<li title="Snowburst One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-626"></li>
<li title="Sofadi One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-627"></li>
<li title="Sofia" data-c="cursive" data-w="400" class="qwc-font-item font-id-628"></li>
<li title="Sonsie One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-629"></li>
<li title="Sorts Mill Goudy" data-c="serif" data-w="400" class="qwc-font-item font-id-630"></li>
<li title="Source Code Pro" data-c="monospace" data-w="200,300,400,500,600,700,900" class="qwc-font-item font-id-631"></li>
<li title="Source Sans Pro" data-c="sans-serif" data-w="200,300,400,600,700,900," class="qwc-font-item font-id-632"></li>
<li title="Source Serif Pro" data-c="serif" data-w="400,600,700" class="qwc-font-item font-id-633"></li>
<li title="Special Elite" data-c="fantasy" data-w="400" class="qwc-font-item font-id-634"></li>
<li title="Spicy Rice" data-c="fantasy" data-w="400" class="qwc-font-item font-id-635"></li>
<li title="Spinnaker" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-636"></li>
<li title="Spirax" data-c="fantasy" data-w="400" class="qwc-font-item font-id-637"></li>
<li title="Squada One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-638"></li>
<li title="Sree Krushnadevaraya" data-c="serif" data-w="400" class="qwc-font-item font-id-639"></li>
<li title="Stalemate" data-c="cursive" data-w="400" class="qwc-font-item font-id-640"></li>
<li title="Stalinist One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-641"></li>
<li title="Stardos Stencil" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-642"></li>
<li title="Stint Ultra Condensed" data-c="fantasy" data-w="400" class="qwc-font-item font-id-643"></li>
<li title="Stint Ultra Expanded" data-c="fantasy" data-w="400" class="qwc-font-item font-id-644"></li>
<li title="Stoke" data-c="serif" data-w="300,400" class="qwc-font-item font-id-645"></li>
<li title="Strait" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-646"></li>
<li title="Sue Ellen Francisco" data-c="cursive" data-w="400" class="qwc-font-item font-id-647"></li>
<li title="Sumana" data-c="serif" data-w="400,700" class="qwc-font-item font-id-648"></li>
<li title="Sunshiney" data-c="cursive" data-w="400" class="qwc-font-item font-id-649"></li>
<li title="Supermercado One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-650"></li>
<li title="Suranna" data-c="serif" data-w="400" class="qwc-font-item font-id-651"></li>
<li title="Suravaram" data-c="serif" data-w="400" class="qwc-font-item font-id-652"></li>
<li title="Suwannaphum" data-c="fantasy" data-w="400" class="qwc-font-item font-id-653"></li>
<li title="Swanky and Moo Moo" data-c="cursive" data-w="400" class="qwc-font-item font-id-654"></li>
<li title="Syncopate" data-c="sans-serif" data-w="400,700" class="qwc-font-item font-id-655"></li>
<li class="qwc-font-heading-title wp-ui-primary">T</li>
<li title="Tangerine" data-c="cursive" data-w="400,700" class="qwc-font-item font-id-656"></li>
<li title="Taprom" data-c="fantasy" data-w="400" class="qwc-font-item font-id-657"></li>
<li title="Tauri" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-658"></li>
<li title="Teko" data-c="sans-serif" data-w="300,400,500,600,700" class="qwc-font-item font-id-659"></li>
<li title="Telex" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-660"></li>
<li title="Tenali Ramakrishna" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-661"></li>
<li title="Tenor Sans" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-662"></li>
<li title="Text Me One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-663"></li>
<li title="The Girl Next Door" data-c="cursive" data-w="400" class="qwc-font-item font-id-664"></li>
<li title="Tienne" data-c="serif" data-w="400,700,900" class="qwc-font-item font-id-665"></li>
<li title="Timmana" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-666"></li>
<li title="Tinos" data-c="serif" data-w="400,700," class="qwc-font-item font-id-667"></li>
<li title="Titan One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-668"></li>
<li title="Titillium Web" data-c="sans-serif" data-w="200,300,400,600,700,900" class="qwc-font-item font-id-669"></li>
<li title="Trade Winds" data-c="fantasy" data-w="400" class="qwc-font-item font-id-670"></li>
<li title="Trocchi" data-c="serif" data-w="400" class="qwc-font-item font-id-671"></li>
<li title="Trochut" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-672"></li>
<li title="Trykker" data-c="serif" data-w="400" class="qwc-font-item font-id-673"></li>
<li title="Tulpen One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-674"></li>
<li class="qwc-font-heading-title wp-ui-primary">U</li>
<li title="Ubuntu" data-c="sans-serif" data-w="300,400,500,700," class="qwc-font-item font-id-675"></li>
<li title="Ubuntu Condensed" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-676"></li>
<li title="Ubuntu Mono" data-c="monospace" data-w="400,700," class="qwc-font-item font-id-677"></li>
<li title="Ultra" data-c="serif" data-w="400" class="qwc-font-item font-id-678"></li>
<li title="Uncial Antiqua" data-c="fantasy" data-w="400" class="qwc-font-item font-id-679"></li>
<li title="Underdog" data-c="fantasy" data-w="400" class="qwc-font-item font-id-680"></li>
<li title="Unica One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-681"></li>
<li title="UnifrakturCook" data-c="fantasy" data-w="700" class="qwc-font-item font-id-682"></li>
<li title="UnifrakturMaguntia" data-c="fantasy" data-w="400" class="qwc-font-item font-id-683"></li>
<li title="Unkempt" data-c="fantasy" data-w="400,700" class="qwc-font-item font-id-684"></li>
<li title="Unlock" data-c="fantasy" data-w="400" class="qwc-font-item font-id-685"></li>
<li title="Unna" data-c="serif" data-w="400" class="qwc-font-item font-id-686"></li>
<li class="qwc-font-heading-title wp-ui-primary">V</li>
<li title="VT323" data-c="monospace" data-w="400" class="qwc-font-item font-id-687"></li>
<li title="Vampiro One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-688"></li>
<li title="Varela" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-689"></li>
<li title="Varela Round" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-690"></li>
<li title="Vast Shadow" data-c="fantasy" data-w="400" class="qwc-font-item font-id-691"></li>
<li title="Vesper Libre" data-c="serif" data-w="400,500,700,900" class="qwc-font-item font-id-692"></li>
<li title="Vibur" data-c="cursive" data-w="400" class="qwc-font-item font-id-693"></li>
<li title="Vidaloka" data-c="serif" data-w="400" class="qwc-font-item font-id-694"></li>
<li title="Viga" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-695"></li>
<li title="Voces" data-c="fantasy" data-w="400" class="qwc-font-item font-id-696"></li>
<li title="Volkhov" data-c="serif" data-w="400,700," class="qwc-font-item font-id-697"></li>
<li title="Vollkorn" data-c="serif" data-w="400,700," class="qwc-font-item font-id-698"></li>
<li title="Voltaire" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-699"></li>
<li class="qwc-font-heading-title wp-ui-primary">W</li>
<li title="Waiting for the Sunrise" data-c="cursive" data-w="400" class="qwc-font-item font-id-700"></li>
<li title="Wallpoet" data-c="fantasy" data-w="400" class="qwc-font-item font-id-701"></li>
<li title="Walter Turncoat" data-c="cursive" data-w="400" class="qwc-font-item font-id-702"></li>
<li title="Warnes" data-c="fantasy" data-w="400" class="qwc-font-item font-id-703"></li>
<li title="Wellfleet" data-c="fantasy" data-w="400" class="qwc-font-item font-id-704"></li>
<li title="Wendy One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-705"></li>
<li title="Wire One" data-c="sans-serif" data-w="400" class="qwc-font-item font-id-706"></li>
<li class="qwc-font-heading-title wp-ui-primary">Y</li>
<li title="Yanone Kaffeesatz" data-c="sans-serif" data-w="200,300,400,700" class="qwc-font-item font-id-707"></li>
<li title="Yellowtail" data-c="cursive" data-w="400" class="qwc-font-item font-id-708"></li>
<li title="Yeseva One" data-c="fantasy" data-w="400" class="qwc-font-item font-id-709"></li>
<li title="Yesteryear" data-c="cursive" data-w="400" class="qwc-font-item font-id-710"></li>
<li class="qwc-font-heading-title wp-ui-primary">Z</li>
<li title="Zeyada" data-c="cursive" data-w="400" class="qwc-font-item font-id-711"></li>
</ul>';
		}
	}
}