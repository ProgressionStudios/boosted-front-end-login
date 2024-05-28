<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
<?php if (is_user_logged_in()): ?>
	<p class="boosted-front-end-already-logged-in">
		<?php 
		$current_user = wp_get_current_user();
        $username = $current_user->user_login;
        $logout_url = wp_logout_url( home_url() );
		printf(
			wp_kses_post(
				/* translators: 1: username, 2: username, 3: logout URL */
				__('Hello <span>%1$s</span> (not <span>%2$s</span>? <a href="%3$s">Log out</a>)', 'boosted-front-end-login')
			),
			esc_html( $username ),
			esc_html( $username ),
			esc_url( $logout_url )
		);
	?>
	</p>
<?php else: ?>
    <?php
    $user_id = get_current_user_id();
    $registration_error = get_transient( 'registration_error_' . $user_id );
    $registration_message = get_transient( 'registration_message_' . $user_id );

    if ( $registration_error ) :
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
        <div class="boosted-front-end-registration-error" role="alert">
            <?php echo wp_kses( $registration_error, $allowed_html ); ?>
            <?php delete_transient( 'registration_error_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $registration_message ) : 
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
        <div class="boosted-front-end-registration-success" role="alert">
            <?php echo wp_kses( $registration_message, $allowed_html ); ?>
            <?php delete_transient( 'registration_message_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <form class="boosted-front-end-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Registration-Form">
        <?php wp_nonce_field( 'front_end_register_action', 'front_end_register_nonce' ); ?>
        <input type="hidden" name="action" value="front_end_register">
        <p class="boosted-front-end-username">
            <label for="user_login"><?php esc_html_e( 'Username', 'boosted-front-end-login' ); ?></label>
            <input class="boosted-front-end-username" type="text" id="user_login" name="user_login" required>
        </p>
        <p class="boosted-front-end-email">
            <label for="user_email"><?php esc_html_e( 'Email', 'boosted-front-end-login' ); ?></label>
            <input class="boosted-front-end-email" type="email" id="user_email" name="user_email" required>
        </p>
        <p class="boosted-front-end-password">
            <label for="user_pass"><?php esc_html_e( 'Password', 'boosted-front-end-login' ); ?></label>
            <input class="boosted-front-end-password" type="password" id="user_pass" name="user_pass" required>
        </p>
        <p class="boosted-front-end-password-confirm">
            <label for="user_pass_confirm"><?php esc_html_e( 'Confirm Password', 'boosted-front-end-login' ); ?></label>
            <input class="boosted-front-end-password-confirm" type="password" id="user_pass_confirm" name="user_pass_confirm" required>
        </p>
        <p class="boosted-front-end-submit">
            <input class="boosted-front-end-submit" type="submit" value="<?php esc_html_e( 'Register', 'boosted-front-end-login' ); ?>" aria-label="<?php esc_html_e( 'Register a new account', 'boosted-front-end-login' ); ?>">
        </p>
    </form>
<?php endif; ?>
</div>
