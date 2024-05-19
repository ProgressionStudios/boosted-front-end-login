<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php if (isset($_SESSION['login_error'])): ?>
		<div class="login-error" style="color: red;" role="alert">
			<?php echo $_SESSION['login_error']; ?>
			<?php unset($_SESSION['login_error']); ?>
		</div>
	<?php endif; ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Login-Form">
		<input type="hidden" name="action" value="front_end_login">
		<p>
			<label for="username"><?php esc_html_e( 'Username or Email', 'boosted-front-end-login' ); ?></label>
			<input type="text" id="username" name="username" required>
		</p>
		<p>
			<label for="password"><?php esc_html_e( 'Password', 'boosted-front-end-login' ); ?></label>
			<input type="password" id="password" name="password" required>
		</p>
		<p>
			<label>
				<input name="remember" type="checkbox" id="rememberme" value="forever"> <?php esc_html_e( 'Remember Me', 'boosted-front-end-login' ); ?>
			</label>
		</p>
		<p>
			<input type="submit" value="<?php esc_html_e( 'Log In', 'boosted-front-end-login' ); ?>" aria-label="<?php esc_html_e( 'Log in to your account', 'boosted-front-end-login' ); ?>">
		</p>
		<p><a href="#!"><?php esc_html_e( 'Lost Password?', 'boosted-front-end-login' ); ?></a></p>
		<p>Dont have account? <a href="#!">register</a></p>
	</form>
</div>
