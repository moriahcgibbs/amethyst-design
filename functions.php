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

//* Add Home Image Size
add_image_size( 'home', 300, 175, true );

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

//* Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( ' ' );
}

//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'sp_search_button_text' );
function sp_search_button_text( $text ) {
	return esc_attr( ' ' );
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
if ( !is_page() ) {
	$post_meta = 'Published On: [post_date format="m/d/y"]';
	return $post_meta;
}}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_categories before="" ]';
	return $post_info;
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return ' . . . <a class="more-link" href="' . get_permalink() . '">read more</a>';
}

//Adds visibility settings for labels to gravity forms
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; Designed and Developed by <a href="http://mydomain.com">Amethyst Design</a> &middot; Built on the <a href="http://www.studiopress.com/themes/genesis" title="Genesis Framework">Genesis Framework</a>';
  echo '<br>';
  echo 'Want us to build your website? <a href="#">Click Here</a> to find out more.';
	echo '</p></div>';
}
/**
 * Add a CSS ID to main element
 **/
add_filter( 'genesis_attr_content', 'lc_custom_attributes_content' );
function lc_custom_attributes_content( $attributes ) {
  $attributes['id'] = 'main-content';
  return $attributes;

}

/**
 * Add support for JetPack infinite scroll
 **/
function lc_infinite_scroll_init() {
 add_theme_support( 'infinite-scroll', array(
 'footer_widgets' => true,
 'container' => 'main-content',
 'footer' => false,
 'render' => 'genesis_loop',
 ) );
}
add_action( 'after_setup_theme', 'lc_infinite_scroll_init' );

/*
 * Change the posts_per_page Infinite Scroll setting from 10 to 20
 */
function my_theme_infinite_scroll_settings( $args ) {
    if ( is_array( $args ) )
        $args['posts_per_page'] = 6;
    return $args;
}
add_filter( 'infinite_scroll_settings', 'my_theme_infinite_scroll_settings' );

//* Add Featured Image In the Entry Header
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

//* Move Post Info above entry_title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action('genesis_entry_header', 'genesis_post_info', 9 );
