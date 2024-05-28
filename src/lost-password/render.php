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

    <form class="boosted-front-end-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Lost-Password-Form">
        <?php wp_nonce_field( 'front_end_lost_password_action', 'front_end_lost_password_nonce' ); ?>
        <input type="hidden" name="action" value="front_end_lost_password">
        <p><?php esc_html_e('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'boosted-front-end-login'); ?></p>
        <p>
            <label for="user_login"><?php esc_html_e('Username or Email', 'boosted-front-end-login'); ?></label>
            <input class="boosted-front-end-username" type="text" id="user_login" name="user_login" required>
        </p>
        <p>
            <input class="boosted-front-end-submit" type="submit" value="<?php esc_html_e('Reset Password', 'boosted-front-end-login'); ?>" aria-label="<?php esc_html_e('Request a password reset', 'boosted-front-end-login'); ?>">
        </p>
    </form>
</div>
