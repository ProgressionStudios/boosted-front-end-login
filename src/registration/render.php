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
    $verification_message = get_transient( 'verification_message_' . $user_id );
    $verification_error = get_transient( 'verification_error_' . $user_id );

    $allowed_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    );

    if ( $registration_error ) : ?>
        <div class="boosted-front-end-registration-error" role="alert">
            <?php echo wp_kses( $registration_error, $allowed_html ); ?>
            <?php delete_transient( 'registration_error_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $registration_message ) : ?>
        <div class="boosted-front-end-registration-success" role="alert">
            <?php echo wp_kses( $registration_message, $allowed_html ); ?>
            <?php delete_transient( 'registration_message_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $verification_message ) : ?>
        <div class="boosted-front-end-verification-success" role="alert">
            <?php echo wp_kses( $verification_message, $allowed_html ); ?>
            <?php delete_transient( 'verification_message_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $verification_error ) : ?>
        <div class="boosted-front-end-verification-error" role="alert">
            <?php echo wp_kses( $verification_error, $allowed_html ); ?>
            <?php delete_transient( 'verification_error_' . $user_id ); ?>
        </div>
    <?php endif; ?>

    <form class="boosted-front-end boosted-front-end-registration" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Registration-Form">
        <?php wp_nonce_field( 'front_end_register_action', 'front_end_register_nonce' ); ?>
        <input type="hidden" name="action" value="front_end_register">
        <p class="boosted-front-end-username">
            <?php if ( ! empty( $attributes['usernameLabel'] ) ) : ?><label for="user_login"><?php echo wp_kses_post( $attributes['usernameLabel'] ); ?></label><?php endif; ?>
            <input class="boosted-front-end-username-field" type="text" id="user_login" name="user_login" required placeholder="<?php echo esc_attr( $attributes['usernamePlaceholder'] ); ?>">
        </p>
        <p class="boosted-front-end-email">
            <?php if ( ! empty( $attributes['emailLabel'] ) ) : ?><label for="user_email"><?php echo wp_kses_post( $attributes['emailLabel'] ); ?></label><?php endif; ?>
            <input class="boosted-front-end-email-field" type="email" id="user_email" name="user_email" required placeholder="<?php echo esc_attr( $attributes['emailPlaceholder'] ); ?>">
        </p>
        <p class="boosted-front-end-password">
            <?php if ( ! empty( $attributes['passwordLabel'] ) ) : ?><label for="user_pass"><?php echo wp_kses_post( $attributes['passwordLabel'] ); ?></label><?php endif; ?>
            <input class="boosted-front-end-password-field" type="password" id="user_pass" name="user_pass" required placeholder="<?php echo esc_attr( $attributes['passwordPlaceholder'] ); ?>">
        </p>
        <p class="boosted-front-end-password-confirm">
            <?php if ( ! empty( $attributes['confirmPassword'] ) ) : ?><label for="user_pass_confirm"><?php echo wp_kses_post( $attributes['confirmPassword'] ); ?></label><?php endif; ?>
            <input class="boosted-front-end-password-confirm-field" type="password" id="user_pass_confirm" name="user_pass_confirm" required placeholder="<?php echo esc_attr( $attributes['confirmPasswordPlaceholder'] ); ?>">
        </p>
        <p class="boosted-front-end-submit">
            <input class="boosted-front-end-submit-btn" type="submit" value="<?php echo wp_kses_post( $attributes['registerButtonLabel'] ); ?>" aria-label="<?php esc_html_e( 'Register a new account', 'boosted-front-end-login' ); ?>">
        </p>
    </form>
<?php endif; ?>
</div>
