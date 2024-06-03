<?php
/**
 *
 * @package Boosted
 */

namespace BoostedLogin;

if (!defined('ABSPATH')) {
    exit;
}

function front_end_login() {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['form_id'])) {

        if (!isset($_POST['front_end_login_nonce']) || !wp_verify_nonce($_POST['front_end_login_nonce'], 'front_end_login_action')) {
            wp_die(esc_html__('Nonce verification failed', 'boosted-front-end-login'));
        }

        $creds = array(
            'user_login' => sanitize_text_field($_POST['username']),
            'user_password' => sanitize_text_field($_POST['password']),
            'remember' => isset($_POST['remember']) && $_POST['remember'] === 'forever'
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            set_transient('login_error_' . sanitize_text_field($_POST['form_id']), $user->get_error_message(), 60);
            wp_redirect(add_query_arg('form_id', sanitize_text_field($_POST['form_id']), esc_url_raw($_SERVER['HTTP_REFERER'])));
            exit;
        } else {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, $creds['remember']);
            do_action('wp_login', $user->user_login, $user);

            $referrer = wp_get_referer() ? wp_get_referer() : home_url();
            wp_redirect(esc_url_raw($referrer));
            exit;
        }
    } else {
        error_log('Missing username, password, or form_id in POST request.');
        wp_redirect(esc_url_raw($_SERVER['HTTP_REFERER']));
        exit;
    }
}
add_action('admin_post_nopriv_front_end_login', __NAMESPACE__ . '\\front_end_login');
add_action('admin_post_front_end_login', __NAMESPACE__ . '\\front_end_login');
