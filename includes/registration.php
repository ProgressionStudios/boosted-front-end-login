<?php
/**
 *
 * @package Boosted
 */

namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function front_end_register() {
    if (isset($_POST['user_login']) && isset($_POST['user_email']) && isset($_POST['user_pass']) && isset($_POST['user_pass_confirm'])) {

        if ( ! isset( $_POST['front_end_register_nonce'] ) || ! wp_verify_nonce( $_POST['front_end_register_nonce'], 'front_end_register_action' ) ) {
            wp_die( esc_html__( 'Nonce verification failed', 'boosted-front-end-login' ) );
        }

        $user_login = sanitize_text_field( $_POST['user_login'] );
        $user_email = sanitize_email( $_POST['user_email'] );
        $user_pass = $_POST['user_pass']; // Passwords should not be sanitized
        $user_pass_confirm = $_POST['user_pass_confirm'];

        if ( $user_pass !== $user_pass_confirm ) {
            set_transient( 'registration_error_' . get_current_user_id(), __('Passwords do not match.', 'boosted-front-end-login'), 60 );
            wp_redirect( esc_url_raw( $_SERVER['HTTP_REFERER'] ) );
            exit;
        }

        $userdata = array(
            'user_login' => $user_login,
            'user_email' => $user_email,
            'user_pass'  => $user_pass,
        );

        $user_id = wp_insert_user( $userdata );

        if ( is_wp_error( $user_id ) ) {
            set_transient( 'registration_error_' . get_current_user_id(), $user_id->get_error_message(), 60 );
            wp_redirect( esc_url_raw( $_SERVER['HTTP_REFERER'] ) );
            exit;
        } else {
            set_transient( 'registration_message_' . get_current_user_id(), __('Registration complete. You can now log in.', 'boosted-front-end-login'), 60 );
            wp_redirect( esc_url_raw( $_SERVER['HTTP_REFERER'] ) );
            exit;
        }
    }
}
add_action('admin_post_nopriv_front_end_register', __NAMESPACE__ . '\\front_end_register');
add_action('admin_post_front_end_register', __NAMESPACE__ . '\\front_end_register');