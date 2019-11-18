<?php // Morpho Admin - Register Settings


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
   exit;
}


// register plugin settings
function morphoadmin_register_settings() {

   /*

   register_setting(
       string   $option_group,
       string   $option_name,
       callable $sanitize_callback
   );

   */

   register_setting(
       'morphoadmin_options',
       'morphoadmin_options',
       'morphoadmin_callback_validate_options'
   );

   /*

   add_settings_section(
       string   $id,
       string   $title,
       callable $callback,
       string   $page
   );

   */

   add_settings_section(
       'morphoadmin_section_login',
       'Customize Login Page',
       'morphoadmin_callback_section_login',
       'morpho-admin'
   );

   add_settings_section(
       'morphoadmin_section_admin',
       'Customize Admin Area',
       'morphoadmin_callback_section_admin',
       'morpho-admin'
   );

   /*

   add_settings_field(
       string   $id,
       string   $title,
       callable $callback,
       string   $page,
       string   $section = 'default',
       array    $args = []
   );

   */

   add_settings_field(
       'custom_url',
       'Custom URL',
       'morphoadmin_callback_field_text',
       'morpho-admin',
       'morphoadmin_section_login',
       [ 'id' => 'custom_url', 'label' => 'Custom URL for the login logo link' ]
   );

   add_settings_field(
       'custom_title',
       'Custom Title',
       'morphoadmin_callback_field_text',
       'morpho-admin',
       'morphoadmin_section_login',
       [ 'id' => 'custom_title', 'label' => 'Custom title attribute for the logo link' ]
   );

   add_settings_field(
       'custom_style',
       'Custom Style',
       'morphoadmin_callback_field_radio',
       'morpho-admin',
       'morphoadmin_section_login',
       [ 'id' => 'custom_style', 'label' => 'Custom CSS for the Login screen' ]
   );

   add_settings_field(
       'custom_message',
       'Custom Message',
       'morphoadmin_callback_field_textarea',
       'morpho-admin',
       'morphoadmin_section_login',
       [ 'id' => 'custom_message', 'label' => 'Custom text and/or markup' ]
   );

   add_settings_field(
       'custom_footer',
       'Custom Footer',
       'morphoadmin_callback_field_text',
       'morpho-admin',
       'morphoadmin_section_admin',
       [ 'id' => 'custom_footer', 'label' => 'Custom footer text' ]
   );

   add_settings_field(
       'custom_toolbar',
       'Custom Toolbar',
       'morphoadmin_callback_field_checkbox',
       'morpho-admin',
       'morphoadmin_section_admin',
       [ 'id' => 'custom_toolbar', 'label' => 'Remove new post and comment links from the Toolbar' ]
   );

   add_settings_field(
       'custom_scheme',
       'Custom Scheme',
       'morphoadmin_callback_field_select',
       'morpho-admin',
       'morphoadmin_section_admin',
       [ 'id' => 'custom_scheme', 'label' => 'Default color scheme for new users' ]
   );

}
add_action( 'admin_init', 'morphoadmin_register_settings' );
