<div <?php echo get_block_wrapper_attributes(); ?>>
    <?php if (isset($_SESSION['lost_password_error'])): ?>
        <div class="boosted-front-end-login-error" role="alert">
            <?php echo $_SESSION['lost_password_error']; ?>
            <?php unset($_SESSION['lost_password_error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['lost_password_message'])): ?>
        <div class="boosted-front-end-login-success" role="alert">
            <?php echo $_SESSION['lost_password_message']; ?>
            <?php unset($_SESSION['lost_password_message']); ?>
        </div>
    <?php endif; ?>

    <form class="boosted-front-end-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" name="Lost-Password-Form">
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
