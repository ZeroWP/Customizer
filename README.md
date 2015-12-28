# Customizer
Create customizer controls quick and easy with as minimum code as possible.

##This project is currently in `alpha` stage. The current code is fully functional, but may expect radical changes in the future!

###License: GPL
The license allows the usage in any projects(personal or commercial). An attribution link is not required, but very appreciated.

##Requirements:

 * PHP 5.3+
 
##Short tutorial:
###1. Include the files
```php
require_once dirname(__FILE__) . "/src/Customizer/mod.php";
```

###2.Create fields:

#####Step 1. Hook a function on to `customize_register` action:
```php
add_action( 'customize_register', 'myprefix_customizer_fields' );
function myprefix_customizer_fields( $wp_customize ) {
	//Your customizer fields will be created here.
}
```

#####Step 2. Instantiate the 'Create' class:

Inside of the previously defined function instantiate the `Create` class. It is recommended to check first if it exists.
```php
if( ! class_exists('ZeroWP\Customizer\Create') ) 
	return; //if class not found, stop!
	
//This is our new customizer object
$ctz = new ZeroWP\Customizer\Create( $wp_customize );
```

#####Step 3. Create a section and the first field:

All fields must have a parent section. In default WordPress customizer you define the section by adding this option(`'section' => 'your_section_id'`) to control settings. This framework does not need this anymore. Here you can create a section and all fields after it will be assigned automatically. Here is how it works:

```php
// Create a section
$ctz->addSection( 'myprefix_section_1', __('Section name', 'text-domain') );

// Add the field with ID 'myprefix_color_field' to a section with ID 'myprefix_section_1'
$ctz->addField( 'myprefix_color_field', 'color', array(
	'label' => __('Color field test', 'text-domain'),
));

// Add the field with ID 'myprefix_upload_field' to a section with ID 'myprefix_section_1'
$ctz->addField( 'myprefix_upload_field', 'upload', array(
	'label' => __('Upload field test', 'text-domain'),
));
```

#####Step 4. Reveal your new fields.

####Here is the full code that we wrote in the previous tutorial:
```php
add_action( 'customize_register', 'myprefix_customizer_fields' );
function myprefix_customizer_fields( $wp_customize ) {
	if( ! class_exists('ZeroWP\Customizer\Create') ) 
		return; //if class not found, stop!
		
	//This is our new customizer object
	$ctz = new ZeroWP\Customizer\Create( $wp_customize );

	// Create a section
	$ctz->addSection( 'myprefix_section_1', __('Section name', 'text-domain') );

	// Add the field with ID 'myprefix_color_field' to a section with ID 'myprefix_section_1'
	$ctz->addField( 'myprefix_color_field', 'color', array(
		'label' => __('Color field test', 'text-domain'),
	));
	
	// Add the field with ID 'myprefix_upload_field' to a section with ID 'myprefix_section_1'
	$ctz->addField( 'myprefix_upload_field', 'upload', array(
		'label' => __('Upload field test', 'text-domain'),
	));
}
```



