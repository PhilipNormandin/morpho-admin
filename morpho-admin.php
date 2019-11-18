<?php

/*
Plugin Name: Morpho Admin
Version:     1.0
Description: This plugin cleans and customizes admin area, allowing to better find yourself in all the mumbo jumbo of WordPress.
Author:      Philip Normandin
Author URI:  https://profiles.wordpress.org/philipnormandin
Text Domain: morpho-admin
Domain Path: /languages
License:     GPL2

Morpho Admin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Morpho Admin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Morpho Admin. If not, see https://www.gnu.org/licenses/gpl-2.0.txt.
*/


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// load text domain
function morphoadmin_load_textdomain() {

	load_plugin_textdomain( 'morpho-admin', false, plugin_dir_path( __FILE__ ) . 'languages/' );

}
add_action( 'plugins_loaded', 'morphoadmin_load_textdomain' );


// load Roboto Font
function morphoadmin_load_font() {
    ?>

        <link rel="preload" href="<?php echo plugin_dir_url( __FILE__ ) . 'includes/fonts/roboto-v18-latin-regular.woff2'; ?>" as="font">

        <style>
        @font-face {
            font-family: Roboto;
            font-style: normal;
            font-weight: 400;
            src: url("<?php echo plugin_dir_url( __FILE__ ) . 'includes/fonts/roboto-v18-latin-regular.woff2'; ?>") format('woff2'),
            url("<?php echo plugin_dir_url( __FILE__ ) . 'includes/fonts/roboto-v18-latin-regular.woff'; ?>") format('woff');
        }
        </style>

    <?php
}
add_action( 'admin_head', 'morphoadmin_load_font' );


// load custom Admin styles
function morphoadmin_custom_admin_styles() {

    wp_enqueue_style( 'morphoadmin-admin', plugin_dir_url( __FILE__ ) . 'admin/css/morphoadmin.css', array(), null, 'all' );

    wp_enqueue_script( 'morphoadmin-admin', plugin_dir_url( __FILE__ ) . 'admin/js/morphoadmin.js', array( 'jquery' ) );

}
add_action( 'admin_enqueue_scripts', 'morphoadmin_custom_admin_styles' );


// load custom Divi Builder styles
function morphoadmin_custom_divi_builder_styles() {

    if ( is_admin_bar_showing() ) {
        wp_enqueue_style( 'morphoadmin-divi-builder', plugin_dir_url( __FILE__ ) . 'admin/css/morphoadmin-divi-builder.css', array(), null, 'all' );
    }

}
add_action( 'wp_enqueue_scripts', 'morphoadmin_custom_divi_builder_styles' );


// load javascript for default Divi Post Settings
function morphoadmin_default_divi_post_settings() {

    $screen = get_current_screen();

    if ( $screen->post_type == 'post' ||
         $screen->post_type == 'album_photo' ) {

        wp_enqueue_script( 'morphoadmin-divi-post-settings', plugin_dir_url( __FILE__ ) . 'admin/js/morphoadmin-default-divi-post-settings.js', array( 'jquery' ) );

    }

}
add_action( 'admin_enqueue_scripts', 'morphoadmin_default_divi_post_settings' );


// load javascript which customize spinner when New Divi Builder is activated
function morphoadmin_custom_divi_spinner() {

    $screen = get_current_screen();

    if ( $screen->post_type == 'post' ) {

        wp_enqueue_script( 'morphoadmin-divi-spinner', plugin_dir_url( __FILE__ ) . 'admin/js/morphoadmin-custom-divi-spinner.js', array( 'jquery' ) );

    }

}
add_action( 'admin_enqueue_scripts', 'morphoadmin_custom_divi_spinner' );


// load javascript for Events Schedule plugin
function morphoadmin_events_schedule_script() {

    $screen = get_current_screen();

    if ( $screen->post_type == 'class' ) {

        wp_enqueue_script( 'morphoadmin-events-schedule', plugin_dir_url( __FILE__ ) . 'admin/js/morphoadmin-events-schedule.js', array( 'jquery' ) );

    }

}
add_action( 'admin_enqueue_scripts', 'morphoadmin_events_schedule_script' );


// if admin area
if ( is_admin() ) {

    // include plugin dependencies
    // require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
    // require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
    // require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
    // require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
    // require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';

}


// include plugin dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';


// default plugin options
// function morphoadmin_options_default() {
//
// 	return array(
// 		'custom_url'     => 'https://wordpress.org/',
// 		'custom_title'   => 'Powered by WordPress',
// 		'custom_style'   => 'disable',
//         'custom_toolbar' => false,
// 		'custom_...'     => '...',
// 	);
//
// }
