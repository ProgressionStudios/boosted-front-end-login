<?php
/**
 *
 * @package Boosted
 */

namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function show_login_error() {
    if ( $error = get_transient( 'login_error_' . get_current_user_id() ) ) {
        echo '<div class="login-error">' . esc_html( $error ) . '</div>';
        delete_transient( 'login_error_' . get_current_user_id() );
    }
}
add_action( 'login_form', __NAMESPACE__ . '\\show_login_error' );

function front_end_login() {
    if (isset($_POST['username']) && isset($_POST['password'])) {

        if ( ! isset( $_POST['front_end_login_nonce'] ) || ! wp_verify_nonce( $_POST['front_end_login_nonce'], 'front_end_login_action' ) ) {
            wp_die( esc_html__( 'Nonce verification failed', 'boosted-front-end-login' ) );
        }

        $creds = array(
            'user_login'    => sanitize_text_field( $_POST['username'] ),
            'user_password' => sanitize_text_field( $_POST['password'] ),
            'remember'      => isset( $_POST['remember'] ) && $_POST['remember'] === 'forever'
        );

        $user = wp_signon( $creds, false );

        if ( is_wp_error( $user ) ) {
            set_transient( 'login_error_' . get_current_user_id(), $user->get_error_message(), 60 );
            wp_redirect( esc_url_raw( $_SERVER['HTTP_REFERER'] ) );
            exit;
        } else {
            wp_set_current_user( $user->ID );
            wp_set_auth_cookie( $user->ID, $creds['remember'] );
            do_action( 'wp_login', $user->user_login, $user );

            $referrer = wp_get_referer() ? wp_get_referer() : home_url();
            wp_redirect( esc_url_raw( $referrer ) );
            exit;
        }
    }
    return null;
}
add_action('admin_post_nopriv_front_end_login', __NAMESPACE__ . '\\front_end_login');
add_action('admin_post_front_end_login', __NAMESPACE__ . '\\front_end_login');
