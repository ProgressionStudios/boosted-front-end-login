<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php if (isset($_SESSION['login_error'])): ?>
		<div class="boosted-front-end-login-error" role="alert">
			<?php echo $_SESSION['login_error']; ?>
			<?php unset($_SESSION['login_error']); ?>
		</div>
	<?php endif; ?>
    <form class="boosted-front-end-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Login-Form">
		<input type="hidden" name="action" value="front_end_login">
		<p>
			<label for="username"><?php esc_html_e( 'Username or Email', 'boosted-front-end-login' ); ?></label>
			<input class="boosted-front-end-username" type="text" id="username" name="username" required>
		</p>
		<p>
			<label for="password"><?php esc_html_e( 'Password', 'boosted-front-end-login' ); ?></label>
			<input class="boosted-front-end-password" type="password" id="password" name="password" required>
		</p>
		<p>
			<label class="boosted-front-end-remember">
				<input name="remember" type="checkbox" id="rememberme" value="forever"> <?php esc_html_e( 'Remember Me', 'boosted-front-end-login' ); ?>
			</label>
		</p>
		<p>
			<input class="boosted-front-end-submit" type="submit" value="<?php esc_html_e( 'Log In', 'boosted-front-end-login' ); ?>" aria-label="<?php esc_html_e( 'Log in to your account', 'boosted-front-end-login' ); ?>">
		</p>
		<p>
			<?php if ( get_option('users_can_register') ): ?>	
				<a class="boosted-login-register" href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Register', 'boosted-front-end-login' ); ?></a> | 
			<?php endif; ?>
			<a class="boosted-lost-password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost Password?', 'boosted-front-end-login' ); ?></a>
		</p>
	</form>
</div>
