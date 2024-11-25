<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( ! class_exists( 'acf_field_starbelly_font_awesome_font' ) ) :

class acf_field_starbelly_font_awesome_font extends acf_field {

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct() {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'font_awesome_font';
		$json = file_get_contents( plugin_dir_path( __FILE__ ) . 'fontawesome.json' );

		$UM_FAFONTS = json_decode( $json, true );

		$none_font = array(
			"type" => "",
			"name" => "",
			"unicode" => ""
		);

		array_unshift( $UM_FAFONTS, $none_font );

		//var_dump( $UM_FAFONTS );

		$this->font = $UM_FAFONTS;
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __( 'Font Awesome Font', 'starbelly-plugin' );

		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'basic';

		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/

		$this->defaults = array(
			'font_size'	=> 14,
		);

		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*/

		$this->l10n = array(
			'error'	=> __( 'Error! Please enter a higher value', 'starbelly-plugin' ),
		);

		// do not delete!
		parent::__construct();

	}

	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*/

	function render_field_settings( $field ) {

		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/

	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*/

	function render_field( $field ) {
		?>
		<select name="<?php echo esc_attr( $field['name'] ); ?>" class="acf-select-fa-fonts">
			<?php foreach ( $this->font as $key => $font ) : $value = ''; if ( $font['name'] != '' ) : $value = $font['type'] . ' fa-' . $font['name']; endif; ?>
			<option <?php if ( $field['value'] == $value ) : ?>selected="selected"<?php endif; ?> value="<?php echo esc_attr( $value ); ?>">
				<?php
				if ( $font["name"] ) :
					echo esc_html( $font["name"] );
				else :
					echo esc_html__( '- None -', 'starbelly-plugin' );
				endif;
				?>
			</option>
			<?php endforeach; ?>
		</select>
		<script>
			jQuery(document).ready(function($) {
				var $select = $('.acf-select-fa-fonts');

				$select.select2({
					width: '100%',
					templateResult: function (state) {
						if (!state.id) { return state.text; }
					  return '<i class="'+state.id.toLowerCase()+'"></i> '+state.text;
			    },
					templateSelection: function (state) {
						if (!state.id) { return state.text; }
					  return '<i class="'+state.id.toLowerCase()+'"></i> '+state.text;
			    },
					escapeMarkup: function(markup) {
				    return markup;
				  },
				});
			});
		</script>
		<?php
	}

	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*/

	function format_value( $value, $post_id, $field ) {

		return '<i class="' . $value . '"></i>';
	}

}

// initialize
new acf_field_starbelly_font_awesome_font();

// class_exists check
endif;

?>
