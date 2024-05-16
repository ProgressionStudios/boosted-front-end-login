<?php
/**
 * Plugin Name:       Boosted Front-end Login
 * Description:       Add a Front-end Login, Registration, & Password Reset
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Michael Garcia
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       boosted-front-end-login
 *
 * @package Boosted
 */

 namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


function custom_block_init() {
	register_block_type( __DIR__ . '/build/login' );
}
add_action( 'init', 'BoostedLogin\custom_block_init' );


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
add_filter( 'block_categories_all', 'BoostedLogin\block_categories', 10, 2 );
