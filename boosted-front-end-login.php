<?php
/**
 * Plugin Name:       Boosted Front-end Login
 * Description:       Add a Front-end Login, Registration, & Password Reset
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Michael Garcia
 * Author URI:        https://progressionstudios.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       boosted-front-end-login
 *
 * @package Boosted
 */

namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function custom_block_init() {
	register_block_type( __DIR__ . '/build/login' );
    register_block_type( __DIR__ . '/build/lost-password' );
	register_block_type( __DIR__ . '/build/registration' );
}
add_action( 'init', __NAMESPACE__ . '\\custom_block_init' );

function block_categories( $block_categories, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
		array_push(
			$block_categories,
			array(
				'slug'  => 'boosted-login',
				'title' => __( 'Boosted Login', 'boosted-front-end-login' ),
				'icon'  => null,
			)
		);
	}
	return $block_categories;
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\\block_categories', 10, 2 );

require_once plugin_dir_path(__FILE__) . 'includes/page-activation.php';
register_activation_hook( __FILE__, __NAMESPACE__ . '\\create_login_pages' );
add_filter('lostpassword_url', __NAMESPACE__ . '\\lostpassword_page_link');
add_filter('register_url', __NAMESPACE__ . '\\registration_page_link');

//Form specific code
require_once plugin_dir_path(__FILE__) . 'includes/login.php';
require_once plugin_dir_path(__FILE__) . 'includes/lost-password.php';
require_once plugin_dir_path(__FILE__) . 'includes/registration.php';