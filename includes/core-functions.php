<?php // Morpho Admin - Core Functionality


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
   exit;
}


//	================================================================================================
//	Login page
//	================================================================================================


// custom login logo url
function morphoadmin_custom_login_url( $url ) {

	// $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );
    //
	// if ( isset( $options['custom_url'] ) && ! empty( $options['custom_url'] ) ) {
    //
	// 	$url = esc_url( $options['custom_url'] );
    //
	// }

	// return $url;

    return home_url();

}
add_filter( 'login_headerurl', 'morphoadmin_custom_login_url' );


// custom login logo title
function morphoadmin_custom_login_title( $title ) {

	// $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );
    //
	// if ( isset( $options['custom_title'] ) && ! empty( $options['custom_title'] ) ) {
    //
	// 	$title = esc_attr( $options['custom_title'] );
    //
	// }

	// return $title;

    return 'Sanctuaire du Sacré-Coeur de Beauvoir';

}
add_filter( 'login_headertitle', 'morphoadmin_custom_login_title' );


// custom login logo image
function morphoadmin_custom_login_image() {

?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri() . "/images/logo-du-site-de-beauvoir.png"; ?>) !important;
    		height:65px;
    		width:320px;
    		background-size: 320px 75px;
    		background-repeat: no-repeat;
            padding-bottom: 15px;
        }
    </style>
<?php

}
add_action( 'login_enqueue_scripts', 'morphoadmin_custom_login_image' );


// custom login styles
function morphoadmin_custom_login_styles() {

	// $styles = false;
    //
	// $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );
    //
	// if ( isset( $options['custom_style'] ) && ! empty( $options['custom_style'] ) ) {
    //
	// 	$styles = sanitize_text_field( $options['custom_style'] );
    //
	// }

	// if ( 'enable' === $styles ) {

		wp_enqueue_style( 'morphoadmin-login', plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/morphoadmin-login.css', array(), null, 'screen' );

		// wp_enqueue_script( 'morphoadmin-login', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/morphoadmin-login.js', array(), null, true );

	// }

}
add_action( 'login_enqueue_scripts', 'morphoadmin_custom_login_styles' );


// remove login page shake
function morphoadmin_remove_shake() {

    remove_action( 'login_head', 'wp_shake_js', 12 );

}
add_action( 'login_head', 'morphoadmin_remove_shake' );


//	================================================================================================
//	Admin toolbar
//	================================================================================================


// custom toolbar styles
function morphoadmin_custom_toolbar_styles() {

	if ( is_admin_bar_showing() ) {

        wp_enqueue_style( 'morphoadmin-toolbar', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/css/morphoadmin-toolbar.css', array(), null, 'screen' );

	}

}
add_action( 'wp_head', 'morphoadmin_custom_toolbar_styles', 99 );


// custom toolbar items
function morphoadmin_custom_admin_toolbar() {

	// $toolbar = false;
    //
	// $options = get_option( 'morphoadmin_options', morphoadmin_options_default() );
    //
	// if ( isset( $options['custom_toolbar'] ) && ! empty( $options['custom_toolbar'] ) ) {
    //
	// 	$toolbar = (bool) $options['custom_toolbar'];
    //
	// }

	// if ( $toolbar ) {

        global $wp_admin_bar;

        $wp_admin_bar->remove_menu( 'site-name' );
        $wp_admin_bar->remove_menu( 'comments' );
        $wp_admin_bar->remove_menu( 'new-project' );
        $wp_admin_bar->remove_menu( 'wp-logo' );
        $wp_admin_bar->remove_node( 'new-user' );
        $wp_admin_bar->remove_node( 'new-media' );
        $wp_admin_bar->remove_node( 'new-page' );
        $wp_admin_bar->remove_node( 'swift-performance' );
        $wp_admin_bar->remove_node( 'new-member' );
        $wp_admin_bar->remove_node( 'new-sermon' );
        $wp_admin_bar->remove_node( 'new-photo_album' );

        // add back the new Media
        $wp_admin_bar->add_menu( array(
            'parent' => 'new-content',
            'id' => 'new_media',
            'title' => __( 'Media File' ),
            'href' => admin_url( 'media-new.php' )
        ));

        // add back the new Page
        $wp_admin_bar->add_menu( array(
            'parent' => 'new-content',
            'id' => 'new-page',
            'title' => __( 'Page' ),
            'href' => admin_url( 'post-new.php?post_type=page' )
        ));

        // add back the new Sermon
        $wp_admin_bar->add_menu( array(
            'parent' => 'new-content',
            'id' => 'new-sermon',
            'title' => __( 'Sermon', 'morpho-admin' ),
            'href' => admin_url( 'post-new.php?post_type=sermon' )
        ));

	// }

}
add_action( 'wp_before_admin_bar_render', 'morphoadmin_custom_admin_toolbar', 999 );


// View Site Link
function morphoadmin_view_site_link( $wp_admin_bar ) {

    if ( ! is_admin() ) { return; }  // end function if not in admin back-end

    $args = array(
        // id of the existing child node (View Site)
        'id'     => 'view-site',
        // alter the title of existing node (optional)
        'title'  => __( 'View Site', 'morpho-admin' ),
        // set parent to false to make it a top level (parent) node
        'parent' => false
    );

    $wp_admin_bar->add_node( $args );

}
add_action( 'admin_bar_menu', 'morphoadmin_view_site_link', 999 );


// turn off Gravatars (in Dashboard)
update_option( 'show_avatars', 0 );


// Admin Link to frontend toolbar
function morphoadmin_admin_link() {

	global $wp_admin_bar;

    if ( is_admin_bar_showing() && ! is_admin() ) {  // we are in front-end

        $args = array(
            'id'     => 'morphoadmin-dashboard-link',
            'title'  => __( 'Dashboard' ),
            'href'   => '/wp-admin/',
            'group'  => false,
        );

        $wp_admin_bar->add_menu( $args );

    }

}
add_action( 'admin_bar_menu', 'morphoadmin_admin_link', 0 );


// remove Help tab
// from: https://wpartisan.me/tutorials/how-to-the-remove-screen-options-and-help-tabs-from-the-wp-admin
function morphoadmin_remove_help_tab( $old_help, $screen_id, $screen ) {

    $screen->remove_help_tabs();
    return $old_help;

}
add_filter( 'contextual_help', 'morphoadmin_remove_help_tab', 999, 3 );


//	================================================================================================
//	Admin menus
//	================================================================================================


// custom top-level menus and sub-menus
function morphoadmin_custom_admin_menus() {

    global $submenu;

    // remove Projects
    remove_menu_page(
        'edit.php?post_type=project' );

    // remove Comments
    remove_menu_page(
        'edit-comments.php' );

    // remove Post Tags
    // remove_submenu_page(
    //     'edit.php',
    //     'edit-tags.php?taxonomy=post_tag' );

    // remove Duplicator Pro Info
    remove_submenu_page(
        'duplicator',
        'duplicator-gopro' );

    // remove iThemes Security Go Pro Info
    remove_submenu_page(
        'itsec',
        'itsec-go-pro' );

    // repositionne Divi Layout Injector
    remove_submenu_page(
        'options-general.php',
        'sb_divi_fe' );
    add_submenu_page(
        'et_divi_options',
        'Divi Layout Injector',
        'Divi Layout Injector',
        'manage_options',
        'sb_divi_fe',
        'sb_divi_fe_submenu_cb' );

    // repositionne Search Layout Injector
    remove_submenu_page(
        'options-general.php',
        'sb_et_search_li' );
    add_submenu_page(
        'et_divi_options',
        'Search Layout Injector',
        'Search Layout Injector',
        'manage_options',
        'sb_et_search_li',
        'sb_et_search_li_submenu_cb' );

    // repositionne Taxonomie Layout Injector
    remove_submenu_page(
        'options-general.php',
        'sb_et_tax_li' );
    add_submenu_page(
        'et_divi_options',
        'Taxonomy Layout Injector',
        'Taxonomy Layout Injector',
        'manage_options',
        'sb_et_tax_li',
        'sb_et_tax_li_submenu_cb' );

    // repositionne Envato Market
    if ( isset( $submenu[ 'envato-market' ] ) ) {
        remove_menu_page(
            'envato-market' );
        add_submenu_page(
            'plugins.php',
            'Envato Market',
            'Envato Market',
            'manage_options',
            'envato-market' );
    }

    // repositionne Updraftplus Backups
    if ( isset( $submenu[ 'updraftplus' ] ) ) {
        remove_submenu_page(
            'options-general.php',
            'updraftplus' );
        add_submenu_page(
            'options-general.php',
            'Updraftplus Backups',
            'Updraftplus Backups',
            'manage_options',
            'updraftplus' );
    }

    // repositionne WP-Optimize
    if ( isset( $submenu[ 'WP-Optimize' ] ) ) {
        remove_menu_page(
            'WP-Optimize' );
        add_submenu_page(
            'options-general.php',
            'WP-Optimize',
            'WP-Optimize',
            'manage_options',
            'WP-Optimize' );
       }

}
add_action( 'admin_init', 'morphoadmin_custom_admin_menus' );


// re-order top-level menus
function morphoadmin_custom_top_level_menus_order() {

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'edit.php', // Posts
        'edit.php?post_type=class', // Events
        'upload.php', // Media
        'edit.php?post_type=page', // Pages
        'edit.php?post_type=sermon', // Sermons
        'edit.php?post_type=photo_album', // Albums photo
        'edit.php?post_type=member', // Team
        'separator2', // Second separator
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
        'separator-last', // Last separator
        'et_divi_options', // Divi
        'et_bloom_options', // Bloom
        'the_grid', // The Grid
        'aam', // Advanced Access Manager
        'duplicator', // Duplicator
        'mlang', // Polylang
        'lingotek-translation', // Lingotek
        'loco', // Loco Translate
        'meowapps-main-menu', // Meow Apps
        'itsec', // iThemes Security
        'seopress-option', // SEO Press

    );
}
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'morphoadmin_custom_top_level_menus_order' );


//	================================================================================================
//	Admin columns
//	================================================================================================


// custom pages columns
function morphoadmin_custom_pages_columns( $columns ) {

	unset(
		$columns['author'],
		$columns['comments']
	);

	return $columns;

}
add_filter( 'manage_pages_columns', 'morphoadmin_custom_pages_columns' );


// custom posts columns
function morphoadmin_custom_posts_columns( $columns ) {

	unset(
		$columns['tags'],
		$columns['comments']
	);

	return $columns;

}
add_filter( 'manage_posts_columns', 'morphoadmin_custom_posts_columns' );


// custom events columns
function morphoadmin_custom_classes_columns( $columns ) {

	unset(
		$columns['taxonomy-wcs-room'],
		$columns['taxonomy-wcs-instructor']
	);

	return $columns;

}
add_filter( 'manage_edit-class_columns', 'morphoadmin_custom_classes_columns' );


// custom member posts columns
// from: https://wordpress.stackexchange.com/questions/152971/replacing-the-title-in-admin-list-table --> 2. Replace the table column title
//       https://www.smashingmagazine.com/2017/12/customizing-admin-columns-wordpress/
function morphoadmin_custom_member_posts_columns( $posts_columns ) {
    $posts_columns[ 'title' ] = __( 'Name' );
    return $posts_columns;
}
add_filter( 'manage_member_posts_columns', 'morphoadmin_custom_member_posts_columns' );


//	================================================================================================
//	Admin dashboard
//	================================================================================================


// remove default welcome dashboard & try Gutenberg panels
remove_action( 'welcome_panel', 'wp_welcome_panel' );
remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );

// remove default widgets
// https://digwp.com/2014/02/disable-default-dashboard-widgets/
function morphoadmin_disable_default_dashboard_widgets() {

    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    // Swift Adds
    unset($wp_meta_boxes['dashboard']['normal']['core']['swift_dashboard_widget']);
    // Aquila
    unset($wp_meta_boxes['dashboard']['normal']['core']['welcome-to-aquila']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['aquila-plugin-support']);

}
add_action('wp_dashboard_setup', 'morphoadmin_disable_default_dashboard_widgets', 999);


/* Welcome Panel
------------------------------------------------------------------------*/


// create welcome panel
function morphoadmin_create_welcome_panel() {

	$current_user = wp_get_current_user();

	$welcome_stt = __(
		'Welcome to your dashboard',
		'morpho-admin'
	);

	$use_links_stt = __(
		'You can use the links below to quickly navigate to the most important areas of the website',
		'morpho-admin'
	);

	$need_assistance_stt = __(
		'If you need any assistance, please do not hesitate to contact me',
		'morpho-admin'
	);

	$hoping_stt = __(
		'Hoping you will enjoy your experience with Wordpress!',
		'morpho-admin'
	);

    $screen = get_current_screen();

    if ( $screen->base == 'dashboard' ) {

    ?>
        <div id="morphoadmin-welcome-message">
            <h2>
                <?php echo $welcome_stt . ", " . $current_user->user_firstname ?>
            </h2>
            <p>
                <?php echo $use_links_stt . "... " . $need_assistance_stt . "..." ?>
            </p>
            <p>
                <?php echo $hoping_stt ?>
            </p>
        </div>
    <?php

    }

}


// add welcome panel
function morphoadmin_add_welcome_panel() {

    $welcome_panel_title_stt = __(
		'Welcome',
		'morpho-admin'
	);

    wp_add_dashboard_widget(
        'morphoadmin_welcome_panel',                // Widget slug
        $welcome_panel_title_stt,                   // Title
        'morphoadmin_create_welcome_panel'          // Function
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_welcome_panel' );


/* View Site Widget
------------------------------------------------------------------------*/


$view_site_stt = __(
    'View Site',
    'morpho-admin'
);


// create View Site widget
function morphoadmin_create_view_site_widget() {

    global $view_site_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url(); ?>">
            <span class="dashicons dashicons-welcome-view-site"></span>
            <h3><?php echo __( $view_site_stt, 'morpho-admin' ); ?></h3>
        </a>
    </div>
    <?php

}


// add View Site widget
function morphoadmin_add_view_site_widget() {

    global $view_site_stt;

	add_meta_box(
        'morphoadmin_view_site_widget',             // Widget slug
        __( $view_site_stt, 'morpho-admin' ),       // Title
        'morphoadmin_create_view_site_widget',      // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_view_site_widget' );


/* Profile Widget
------------------------------------------------------------------------*/


$profile_stt = __(
    'Profile'
);


// create Profile widget
function morphoadmin_create_profile_widget() {

    global $profile_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/profile.php"; ?>">
            <span class="dashicons dashicons-id"></span>
            <h3><?php echo __( $profile_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Profile widget
function morphoadmin_add_profile_widget() {

    global $profile_stt;

	add_meta_box(
        'morphoadmin_profile_widget',               // Widget slug
        __( $profile_stt ),                         // Title
        'morphoadmin_create_profile_widget',        // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_profile_widget' );


/* Posts Widget
------------------------------------------------------------------------*/


$posts_stt = __(
    'Posts'
);


// create Posts widget
function morphoadmin_create_posts_widget() {

    global $posts_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/edit.php"; ?>">
            <span class="dashicons dashicons-edit"></span>
            <h3><?php echo __( $posts_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Posts widget
function morphoadmin_add_posts_widget() {

    global $posts_stt;

	add_meta_box(
        'morphoadmin_posts_widget',                 // Widget slug
        __( $posts_stt ),                           // Title
        'morphoadmin_create_posts_widget',          // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_posts_widget' );


/* Events Widget
------------------------------------------------------------------------*/


$events_stt = __(
    'Events',
    'morpho-admin'
);


// create Events widget
function morphoadmin_create_events_widget() {

    global $events_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/edit.php?post_type=class"; ?>">
            <span class="dashicons dashicons-calendar-alt"></span>
            <h3><?php echo __( $events_stt, 'morpho-admin' ); ?></h3>
        </a>
    </div>
    <?php

}


// add Events widget
function morphoadmin_add_events_widget() {

    global $events_stt;

	add_meta_box(
        'morphoadmin_events_widget',                // Widget slug
        __( $events_stt, 'morpho-admin' ),          // Title
        'morphoadmin_create_events_widget',         // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_events_widget' );


/* Media Widget
------------------------------------------------------------------------*/


$media_stt = __(
    'Media'
);


// create Media widget
function morphoadmin_create_media_widget() {

    global $media_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/upload.php"; ?>">
            <span class="dashicons dashicons-admin-media"></span>
            <h3><?php echo __( $media_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Media widget
function morphoadmin_add_media_widget() {

    global $media_stt;

	add_meta_box(
        'morphoadmin_media_widget',                 // Widget slug
        __( $media_stt ),                           // Title
        'morphoadmin_create_media_widget',          // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_media_widget' );


/* Pages Widget
------------------------------------------------------------------------*/


$pages_stt = __(
    'Pages'
);


// create Pages widget
function morphoadmin_create_pages_widget() {

    global $pages_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/edit.php?post_type=page"; ?>">
            <span class="dashicons dashicons-admin-page"></span>
            <h3><?php echo __( $pages_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Pages widget
function morphoadmin_add_pages_widget() {

    global $pages_stt;

	add_meta_box(
        'morphoadmin_pages_widget',                 // Widget slug
        __( $pages_stt ),                           // Title
        'morphoadmin_create_pages_widget',          // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_pages_widget' );


/* Plugins Widget
------------------------------------------------------------------------*/


$plugins_stt = __(
    'Plugins'
);


// create Plugins widget
function morphoadmin_create_plugins_widget() {

    global $plugins_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/plugins.php"; ?>">
            <span class="dashicons dashicons-admin-plugins"></span>
            <h3><?php echo __( $plugins_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Plugins widget
function morphoadmin_add_plugins_widget() {

    global $plugins_stt;

	add_meta_box(
        'morphoadmin_plugins_widget',               // Widget slug
        __( $plugins_stt ),                         // Title
        'morphoadmin_create_plugins_widget',        // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_plugins_widget' );


/* Settings Widget
------------------------------------------------------------------------*/


$settings_stt = __(
    'Settings'
);


// create Settings widget
function morphoadmin_create_settings_widget() {

    global $settings_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/options-general.php"; ?>">
            <span class="dashicons dashicons-admin-settings"></span>
            <h3><?php echo __( $settings_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Settings widget
function morphoadmin_add_settings_widget() {

    global $settings_stt;

	add_meta_box(
        'morphoadmin_settings_widget',              // Widget slug
        __( $settings_stt ),                        // Title
        'morphoadmin_create_settings_widget',       // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_settings_widget' );


/* Users Widget
------------------------------------------------------------------------*/


$users_stt = __(
    'Users'
);


// create Users widget
function morphoadmin_create_users_widget() {

    global $users_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/users.php"; ?>">
            <span class="dashicons dashicons-admin-users"></span>
            <h3><?php echo __( $users_stt ); ?></h3>
        </a>
    </div>
    <?php

}


// add Users widget
function morphoadmin_add_users_widget() {

    global $users_stt;

	add_meta_box(
        'morphoadmin_users_widget',                 // Widget slug
        __( $users_stt ),                           // Title
        'morphoadmin_create_users_widget',          // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_users_widget' );


/* Posts To Translate Widget
------------------------------------------------------------------------*/


$posts_to_translate_stt = __(
    'Posts to translate',
    'morpho-admin'
);


// create Posts To Translate widget
function morphoadmin_create_posts_to_translate_widget() {

    global $posts_to_translate_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/edit.php?post_status=draft&post_type=post"; ?>">
            <span class="dashicons dashicons-translation"></span>
            <h3><?php echo __( $posts_to_translate_stt, 'morpho-admin' ); ?></h3>
        </a>
    </div>
    <?php

}


// add Posts To Translate widget
function morphoadmin_add_posts_to_translate_widget() {

    global $posts_to_translate_stt;

	add_meta_box(
        'morphoadmin_posts_to_translate_widget',        // Widget slug
        __( $posts_to_translate_stt, 'morpho-admin' ),  // Title
        'morphoadmin_create_posts_to_translate_widget', // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_posts_to_translate_widget' );


/* Pages To Translate Widget
------------------------------------------------------------------------*/


$pages_to_translate_stt = __(
    'Pages to translate',
    'morpho-admin'
);


// create Pages To Translate widget
function morphoadmin_create_pages_to_translate_widget() {

    global $pages_to_translate_stt;

    ?>
    <div class="morphoadmin-dashboard-widget-links">
        <a href="<?php echo get_site_url() . "/wp-admin/edit.php?post_status=draft&post_type=page"; ?>">
            <span class="dashicons dashicons-translation"></span>
            <h3><?php echo __( $pages_to_translate_stt, 'morpho-admin' ); ?></h3>
        </a>
    </div>
    <?php

}


// add Pages To Translate widget
function morphoadmin_add_pages_to_translate_widget() {

    global $pages_to_translate_stt;

	add_meta_box(
        'morphoadmin_pages_to_translate_widget',        // Widget slug
        __( $pages_to_translate_stt, 'morpho-admin' ),  // Title
        'morphoadmin_create_pages_to_translate_widget', // Function
        'dashboard',
        'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_pages_to_translate_widget' );


/* Support Panel
------------------------------------------------------------------------*/


$support_panel_title_stt = __(
    'Need assistance?',
    'morpho-admin'
);


// create support panel
function morphoadmin_create_support_panel() {

    global $support_panel_title_stt;

    $support_intro_title_stt = __(
        'Contact me',
        'morpho-admin'
    );

    $support_intro_stt = __(
		'If you have any questions or need assistance, call me or send me an email. I will answer you as soon as possible.',
		'morpho-admin'
	);

    $support_phone_label_stt = __(
        'Phone:',
        'morpho-admin'
    );

    $support_email_label_stt = __(
        'Email:',
        'morpho-admin'
    );

    $screen = get_current_screen();

    if ( $screen->base == 'dashboard' ) {

    ?>
        <div id="morphoadmin-support-message">
            <h3>
                <?php echo __( $support_panel_title_stt, 'morpho-admin' ); ?>
            </h3>
            <p>
                <?php echo $support_intro_stt; ?>
            </p>
            <p>
                <?php echo $support_phone_label_stt . " 819 878-3840"; ?>
            </p>
            <p>
                <?php echo $support_email_label_stt . " "; ?><a href="mailto:phil.normandin@live.ca" target="_self">phil.normandin@live.ca</a>
            </p>
        </div>
    <?php

    }

}


// add support panel
function morphoadmin_add_support_panel() {

    global $support_panel_title_stt;

	add_meta_box(
         'morphoadmin_support_panel',                       // Widget slug
         __( $support_panel_title_stt, 'morpho-admin' ),    // Title
         'morphoadmin_create_support_panel',                // Function
         'dashboard',
         'normal'
    );

}
add_action( 'wp_dashboard_setup', 'morphoadmin_add_support_panel' );


//	================================================================================================
//	Admin labels
//	================================================================================================


// custom admin WP labels
// http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
function morphoadmin_custom_wp_admin_labels( $translated_text, $untranslated_text , $domain ) {

    global $pagenow;

    if ( ( $pagenow == 'post.php' ) || ( $pagenow == 'post-new.php' ) ) {

        switch ( $untranslated_text ) {

            case 'Move to Trash' :
            $translated_text = __( 'Trash', 'morpho-admin' );
            break;

            // case 'Save Draft' :
            // $translated_text = __( 'Save', 'morpho-admin' );
            // break;

            case 'Stick this post to the front page' :
            $translated_text = __( 'Stick this post to the Home Page', 'morpho-admin' );
            break;

            case 'Allow <a href="%s">trackbacks and pingbacks</a> on this page' :
            $translated_text = __( 'Allow <a href="%s">trackbacks and pingbacks</a>', 'morpho-admin' );
            break;

        }

        switch ( $translated_text ) {

            // case 'Preview' :
            // $translated_text = __( 'Preview', 'morpho-admin' );
            // break;

        }

    }

    return $translated_text;

}
add_filter( 'gettext', 'morphoadmin_custom_wp_admin_labels', 20, 3 );


// custom title place holder
function morphoadmin_title_place_holder( $title , $post ) {

    if ( $post->post_type == 'member' ) {
        $title = __( 'Name and Surname', 'morpho-admin' );
    }

    return $title;
}
add_filter('enter_title_here', 'morphoadmin_title_place_holder' , 20 , 2 );


// Change the meta box title to the pod name
// from: https://github.com/pods-framework/pods/issues/1057
//       https://pods.io/forums/topic/more-fields-widget-title-and-labels/
function morphoadmin_pods_meta_title( $title ) {

    if ( get_post_type( get_the_ID() ) == 'member' ) {
        $title = __( 'Personal data', 'morpho-admin' );
    }

	return $title;
}
add_filter( 'pods_meta_default_box_title', 'morphoadmin_pods_meta_title' );


//	================================================================================================
//	Image Sizes
//	================================================================================================


// remove Divi image sizes
// From : https://gist.github.com/felixhirschfeld/8843935858f1d17bb4f25e021b573b66
function morphoadmin_remove_divi_image_sizes() {

	remove_image_size('et-pb-post-main-image');
	remove_image_size('et-pb-post-main-image-fullwidth');
	remove_image_size('et-pb-portfolio-image');
	remove_image_size('et-pb-portfolio-module-image');
	remove_image_size('et-pb-portfolio-image-single');
	remove_image_size('et-pb-gallery-module-image-portrait');
	remove_image_size('et-pb-post-main-image-fullwidth-large');

}
// add_action('init', 'morphoadmin_remove_divi_image_sizes');


//	================================================================================================
//	Contact Form & Other Snippets
//	================================================================================================


// create a dashboard contact form
function morphoadmin_create_contact_form() {

    $contact_form_title_stt = __(
        'Send me a message',
        'text-domain'
    );

    $email_placeholder_stt = __(
        'Your email address',
        'text-domain'
    );

    $subject_placeholder_stt = __(
        'Subject',
        'text-domain'
    );

    $message_placeholder_stt = __(
        'Message',
        'text-domain'
    );

    $button_stt = __(
        'Send',
        'text-domain'
    );

	?>
    <div id="my-admin-contact-section">
        <h3>
            <?php echo $contact_form_title_stt ?>
        </h3>
        <form action="contact-form.php" method="post" enctype="text/plain">
            <input name="email" type="text" class="f-input" placeholder="<?php echo $email_placeholder_stt ?>" required>
            <input name="subject" type="text" class="f-input" placeholder="<?php echo $subject_placeholder_stt ?>" required>
            <textarea name="message" class="f-input" placeholder="<?php echo $message_placeholder_stt ?>" required></textarea>
            <input type="submit" value="Send"<?php echo $button_stt ?> >
        </form>
    </div>
    <?php
}
