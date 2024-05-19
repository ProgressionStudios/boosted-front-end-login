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

if (!session_id()) {
    session_start();
}

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function custom_block_init() {
	register_block_type( __DIR__ . '/build/login' );
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

function front_end_login() {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $creds = array(
            'user_login' => $_POST['username'],
            'user_password' => $_POST['password'],
            'remember' => isset($_POST['remember']) && $_POST['remember'] === 'forever'
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            $_SESSION['login_error'] = $user->get_error_message();
            wp_redirect($_SERVER['HTTP_REFERER']);
            exit;
        } else {
            wp_redirect(home_url());
            exit;
        }
    }
    return null;
}
add_action('admin_post_nopriv_front_end_login', __NAMESPACE__ . '\\front_end_login');
add_action('admin_post_front_end_login', __NAMESPACE__ . '\\front_end_login'); 
