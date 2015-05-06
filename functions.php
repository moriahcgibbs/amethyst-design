<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );


define( 'CHILD_THEME_NAME', 'WP Temple Sandbox Theme' );
define( 'CHILD_THEME_URL', 'https://www.wptemple.com/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

add_action( 'wp_enqueue_scripts', 'genesis_sandbox_enqueue_scripts' );
    function genesis_sandbox_enqueue_scripts() {
        wp_enqueue_script( 'responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
        wp_enqueue_style( 'dashicons' );

    }

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister Layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Move Primary Nav Above Header
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

add_theme_support( 'custom-header', array(
    'width'             => 700,
    'height'            => 100,
    'header-selector'   => '.site-title a',
    'header-text'       => FALSE,
) );

//* Reposition the primary navigation menu
remove_action( 'genesis_before_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'genesis_do_nav' );

add_filter( 'wp_nav_menu_items', 'theme_menu_extras', 10, 2 );
/**
 * Filter menu items, appending either a search form or today's date.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function theme_menu_extras( $menu, $args ) {

	//* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
	if ( 'primary' !== $args->theme_location )
		return $menu;

	//* Uncomment this block to add a search form to the navigation menu

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu  .= '<li class="nav-search">' . $search . '</li>';


	//* Uncomment this block to add the date to the navigation menu
	/*
	$menu .= '<li class="right date">' . date_i18n( get_option( 'date_format' ) ) . '</li>';
	*/

	return $menu;

}
