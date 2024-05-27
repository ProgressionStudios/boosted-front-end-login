<?php
/**
 *
 * @package Boosted
 */

namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
