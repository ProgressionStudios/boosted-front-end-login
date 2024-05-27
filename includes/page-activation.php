<?php
/**
 *
 * @package Boosted
 */

namespace BoostedLogin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function create_login_pages() {
    $login_query = new \WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'title'          => 'Login',
        'posts_per_page' => 1,
    ) );

    if ( ! $login_query->have_posts() ) {
        $login_page = array(
            'post_title'    => 'Login',
            'post_content'  => '<!-- wp:boosted/boosted-front-end-login /-->',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        $login_post_id = wp_insert_post( $login_page );

        if ($login_post_id) {
            update_option( 'boosted_login_page_id', $login_post_id );
        }
    } else {
        $login_page = $login_query->posts[0];
        update_option( 'boosted_login_page_id', $login_page->ID );
    }

    $lost_password_query = new \WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'title'          => 'Lost Password?',
        'posts_per_page' => 1,
    ) );

    if ( ! $lost_password_query->have_posts() ) {
        $lost_password_page = array(
            'post_title'    => 'Lost Password?',
            'post_content'  => '<!-- wp:boosted/boosted-lost-password /-->',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        $lost_password_post_id = wp_insert_post( $lost_password_page );

        if ($lost_password_post_id) {
            update_option( 'boosted_lost_password_page_id', $lost_password_post_id );
        }
    } else {
        $lost_password_page = $lost_password_query->posts[0];
        update_option( 'boosted_lost_password_page_id', $lost_password_page->ID );
    }

    $registration_query = new \WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'title'          => 'Register',
        'posts_per_page' => 1,
    ) );

    if ( ! $registration_query->have_posts() ) {
        $registration_page = array(
            'post_title'    => 'Register',
            'post_content'  => '<!-- wp:boosted/boosted-registration /-->',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        $registration_post_id = wp_insert_post( $registration_page );

        if ($registration_post_id) {
            update_option( 'boosted_registration_page_id', $registration_post_id );
        }
    } else {
        $registration_page = $registration_query->posts[0];
        update_option( 'boosted_registration_page_id', $registration_page->ID );
    }
    
}

function lostpassword_page_link($lostpassword_url) {
    $lost_page_id = get_option( 'boosted_lost_password_page_id' );

    if ( $lost_page_id ) {
        return get_permalink( $lost_page_id );
    }

    return $lostpassword_url;
}

function registration_page_link($register_url) {
    $registration_page_id = get_option( 'boosted_registration_page_id' );

    if ( $registration_page_id ) {
        return get_permalink( $registration_page_id );
    }

    return $register_url;
}
