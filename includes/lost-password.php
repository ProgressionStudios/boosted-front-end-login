<?php
/**
 *
 * @package Boosted
 */

namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function create_lost_password_page() {

    $query = new \WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'title'          => 'Lost Password?',
        'posts_per_page' => 1,
    ) );

    if ( ! $query->have_posts() ) {
        $lost_password_page = array(
            'post_title'    => 'Lost Password?',
            'post_content'  => '<!-- wp:boosted/boosted-lost-password /-->',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        wp_insert_post( $lost_password_page );

        if ($post_id) {
            update_option( 'boosted_lost_password_page_id', $post_id );
        }
	} else {
        $page = $query->posts[0];
        update_option( 'boosted_lost_password_page_id', $page->ID );
    }
}

function lostpassword_page_link($lostpassword_url) {
    $page_id = get_option( 'boosted_lost_password_page_id' );

    if ( $page_id ) {
        return get_permalink( $page_id );
    }

    return $lostpassword_url;
}


function front_end_lost_password() {
    if (isset($_POST['user_login'])) {
        $user_login = sanitize_text_field($_POST['user_login']);
        $user = get_user_by('login', $user_login);
        if (!$user && strpos($user_login, '@')) {
            $user = get_user_by('email', $user_login);
        }

        if ($user) {
            $reset_key = get_password_reset_key($user);
            if (!is_wp_error($reset_key)) {
                $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');
                $message = __('Someone has requested a password reset for the following account:', 'boosted-front-end-login') . "\r\n\r\n";
                $message .= network_home_url('/') . "\r\n\r\n";
                // Translators: %s is the username.
                $message .= sprintf(__('Username: %s', 'boosted-front-end-login'), $user->user_login) . "\r\n\r\n";
                $message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'boosted-front-end-login') . "\r\n\r\n";
                $message .= __('To reset your password, visit the following address:', 'boosted-front-end-login') . "\r\n\r\n";
                $message .= '<' . $reset_url . ">\r\n";

                if (wp_mail($user->user_email, __('Password Reset Request', 'boosted-front-end-login'), $message)) {
                    $_SESSION['lost_password_message'] = __('Password reset email has been sent.', 'boosted-front-end-login');
                } else {
                    $_SESSION['lost_password_error'] = __('Failed to send password reset email.', 'boosted-front-end-login');
                }
            } else {
                $_SESSION['lost_password_error'] = $reset_key->get_error_message();
            }
        } else {
            $_SESSION['lost_password_error'] = __('Invalid username or email.', 'boosted-front-end-login');
        }
    }
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit;
}
add_action('admin_post_nopriv_front_end_lost_password', __NAMESPACE__ . '\\front_end_lost_password');
add_action('admin_post_front_end_lost_password', __NAMESPACE__ . '\\front_end_lost_password');