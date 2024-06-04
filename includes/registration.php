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
        $user_pass = $_POST['user_pass'];
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
            'role'       => 'pending',
        );

        $user_id = wp_insert_user( $userdata );

        if ( is_wp_error( $user_id ) ) {
            set_transient( 'registration_error_' . get_current_user_id(), $user_id->get_error_message(), 60 );
            wp_redirect( esc_url_raw( $_SERVER['HTTP_REFERER'] ) );
            exit;
        } else {
            $verification_key = wp_generate_password( 20, false );
            update_user_meta( $user_id, 'email_verification_key', $verification_key );

            $verification_url = add_query_arg(
                array(
                    'action' => 'verify_email',
                    'key'    => $verification_key,
                    'user'   => $user_id,
                    '_wpnonce' => wp_create_nonce('verify_email_' . $user_id),
                ),
                home_url()
            );

            // Translators: %s is the verification URL that the user needs to click to verify their email.
            $message = sprintf( __( 'Please verify your email by clicking the following link: %s', 'boosted-front-end-login' ), $verification_url );
            wp_mail( $user_email, __( 'Email Verification', 'boosted-front-end-login' ), $message );

            set_transient( 'registration_message_' . get_current_user_id(), __('Registration complete. Please check your email to verify your account.', 'boosted-front-end-login'), 60 );
            wp_redirect( esc_url_raw( $_SERVER['HTTP_REFERER'] ) );
            exit;
        }
    }
}
add_action('admin_post_nopriv_front_end_register', __NAMESPACE__ . '\\front_end_register');
add_action('admin_post_front_end_register', __NAMESPACE__ . '\\front_end_register');

function verify_email() {
    if ( isset( $_GET['key'] ) && isset( $_GET['user'] ) && isset( $_GET['_wpnonce'] ) ) {
        if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'verify_email_' . intval( $_GET['user'] ) ) ) {
            wp_die( esc_html__( 'Nonce verification failed', 'boosted-front-end-login' ) );
        }

        $verification_key = sanitize_text_field( $_GET['key'] );
        $user_id = intval( $_GET['user'] );

        $stored_key = get_user_meta( $user_id, 'email_verification_key', true );

        if ( $stored_key === $verification_key ) {
            delete_user_meta( $user_id, 'email_verification_key' );
            wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );

            set_transient( 'verification_message_' . $user_id, __( 'Your email has been verified. You can now log in.', 'boosted-front-end-login' ), 60 );
            wp_redirect( home_url() );
            exit;
        } else {
            set_transient( 'verification_error_' . $user_id, __( 'Invalid verification key.', 'boosted-front-end-login' ), 60 );
            wp_redirect( home_url() );
            exit;
        }
    }
}
add_action( 'init', __NAMESPACE__ . '\\verify_email' );
