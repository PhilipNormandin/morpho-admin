<?php // Morpho Admin - Settings Callbacks


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
   exit;
}


// callback: login section
function morphoadmin_callback_section_login() {

   echo '<p>These settings enable you to customize the WP Login screen.</p>';

}


// callback: admin section
function morphoadmin_callback_section_admin() {

   echo '<p>These settings enable you to customize the WP Admin Area.</p>';

}


// callback: text field
function morphoadmin_callback_field_text( $args ) {

    $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	echo '<input id="morphoadmin_options_'. $id .'" name="morphoadmin_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="morphoadmin_options_'. $id .'">'. $label .'</label>';

}


// callback: radio field
function morphoadmin_callback_field_radio( $args ) {

    $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$radio_options = array(

		'enable'  => 'Enable custom styles',
		'disable' => 'Disable custom styles'

	);

	foreach ( $radio_options as $value => $label ) {

		$checked = checked( $selected_option === $value, true, false );

		echo '<label><input name="morphoadmin_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

	}

}


// callback: textarea field
function morphoadmin_callback_field_textarea( $args ) {

    $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$allowed_tags = wp_kses_allowed_html( 'post' );

	$value = isset( $options[$id] ) ? wp_kses( stripslashes_deep( $options[$id] ), $allowed_tags ) : '';

	echo '<textarea id="morphoadmin_options_'. $id .'" name="morphoadmin_options['. $id .']" rows="5" cols="50">'. $value .'</textarea><br />';
	echo '<label for="morphoadmin_options_'. $id .'">'. $label .'</label>';

}


// callback: checkbox field
function morphoadmin_callback_field_checkbox( $args ) {

    $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';

	echo '<input id="morphoadmin_options_'. $id .'" name="morphoadmin_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="morphoadmin_options_'. $id .'">'. $label .'</label>';

}


// callback: select field
function morphoadmin_callback_field_select( $args ) {

    $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$select_options = array(

		'default'   => 'Default',
		'light'     => 'Light',
		'blue'      => 'Blue',
		'coffee'    => 'Coffee',
		'ectoplasm' => 'Ectoplasm',
		'midnight'  => 'Midnight',
		'ocean'     => 'Ocean',
		'sunrise'   => 'Sunrise',

	);

	echo '<select id="morphoadmin_options_'. $id .'" name="morphoadmin_options['. $id .']">';

	foreach ( $select_options as $value => $option ) {

		$selected = selected( $selected_option === $value, true, false );

		echo '<option value="'. $value .'"'. $selected .'>'. $option .'</option>';

	}

	echo '</select> <label for="morphoadmin_options_'. $id .'">'. $label .'</label>';

}
