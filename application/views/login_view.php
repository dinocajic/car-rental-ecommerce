<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <?php
            if (!empty($login_errors)) {
                ?><h1>We could not log you in</h1><br /><?php
            } else {
                ?><h1>Login to Your Account</h1><br /><?php
            }
            ?>
            <form id="login" method="post" action="<?php echo base_url(); ?>login">
                <input type="text"     name="login_email"    placeholder="Username" />
                <input type="password" name="login_password" placeholder="Password" />
                <input type="submit"   name="login_submit"   class="login loginmodal-submit" value="Login" />
            </form>

            <div class="login-help">
                <a href="<?php echo base_url(); ?>register">Register</a> - <a href="<?php echo base_url(); ?>reset_password">Forgot Password</a>
            </div>
        </div>
    </div>
</div>

<?php
if (!empty($login_errors) || isset($display_login)) {
    ?>
    <script type="text/javascript">
        $('#login-modal').modal('show');
    </script>
    <?php
}
?>