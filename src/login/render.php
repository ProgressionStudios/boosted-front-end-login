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
        $login_error = get_transient( 'login_error_' . $user_id );

        if ( $login_error ) :
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
			<?php echo wp_kses( $login_error, $allowed_html ); ?>
            <?php delete_transient( 'login_error_' . $user_id ); ?>
		</div>
	<?php endif; ?>
    <form class="boosted-front-end-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Login-Form">
		<?php wp_nonce_field( 'front_end_login_action', 'front_end_login_nonce' ); ?>
		<input type="hidden" name="action" value="front_end_login">
		<p class="boosted-front-end-username">
			<label for="username"><?php esc_html_e( 'Username or Email', 'boosted-front-end-login' ); ?></label>
			<input class="boosted-front-end-username" type="text" id="username" name="username" required>
		</p>
		<p class="boosted-front-end-username">
			<label for="password"><?php esc_html_e( 'Password', 'boosted-front-end-login' ); ?></label>
			<input class="boosted-front-end-password" type="password" id="password" name="password" required>
		</p>
		<p class="boosted-front-end-remember">
			<label class="boosted-front-end-remember">
				<input name="remember" type="checkbox" id="rememberme" value="forever"> <?php esc_html_e( 'Remember Me', 'boosted-front-end-login' ); ?>
			</label>
		</p>
		<p class="boosted-front-end-submit">
			<input class="boosted-front-end-submit" type="submit" value="<?php esc_html_e( 'Log In', 'boosted-front-end-login' ); ?>" aria-label="<?php esc_html_e( 'Log in to your account', 'boosted-front-end-login' ); ?>">
		</p>
		<nav class="class="boosted-front-end-navigation">
			<?php if ( get_option('users_can_register') ): ?>	
				<a class="boosted-front-end-navigation-register" href="<?php echo esc_url( wp_registration_url() ); ?>">
					<?php esc_html_e( 'Register', 'boosted-front-end-login' ); ?>
				</a> | 
			<?php endif; ?>
			<a class="boosted-front-end-navigation-lost" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost Password?', 'boosted-front-end-login' ); ?></a>
		</nav>
	</form>
<?php endif; ?>
</div>
