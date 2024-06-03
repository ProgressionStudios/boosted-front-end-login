<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
    <?php
    $user_id = get_current_user_id();
    $lost_password_error = get_transient( 'lost_password_error_' . $user_id );
    $lost_password_message = get_transient( 'lost_password_message_' . $user_id );

    if ( $lost_password_error ) :
        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
        );
    ?>
        <div class="boosted-front-end-login-error" role="alert">
            <?php echo wp_kses( $lost_password_error, $allowed_html ); ?>
            <?php delete_transient( 'lost_password_error_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $lost_password_message ) : 
        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
        );
    ?>
        <div class="boosted-front-end-login-success" role="alert">
            <?php echo wp_kses( $lost_password_message, $allowed_html ); ?>
            <?php delete_transient( 'lost_password_message_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <form class="boosted-front-end-form boosted-front-end-lost-password" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Lost-Password-Form">
        <?php wp_nonce_field( 'front_end_lost_password_action', 'front_end_lost_password_nonce' ); ?>
        <input type="hidden" name="action" value="front_end_lost_password">
        <?php if ( ! empty( $attributes['lostDescription'] ) ) : ?>
            <p class="boosted-front-end-form-lost-description"><?php echo wp_kses_post( $attributes['lostDescription'] ); ?></p>
        <?php endif; ?>
        <p class="boosted-front-end-form-username">
            <?php if ( ! empty( $attributes['usernameLabel'] ) ) : ?><label for="user_login"><?php echo wp_kses_post( $attributes['usernameLabel'] ); ?></label><?php endif; ?>
            <input class="boosted-front-end-username" type="text" id="user_login" name="user_login" placeholder="<?php echo esc_attr( $attributes['usernamePlaceholder'] ); ?>" required>
        </p>
        <p class="boosted-front-end-form-submit">
            <input class="boosted-front-end-submit" type="submit" value="<?php echo esc_attr( $attributes['resetButtonLabel'] ); ?>" aria-label="<?php esc_html_e('Request a password reset', 'boosted-front-end-login'); ?>">
        </p>
    </form>
</div>
