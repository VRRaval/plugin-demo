<?php
if(!defined('ABSPATH')){
    header('location: /wordpress/demo');
    die();
}?>
<?php
if ( is_user_logged_in() ) {
$user = wp_get_current_user();
$msg = '';
if(isset($_POST['change-pass'])){
    $userOldPass = esc_sql($_POST['user_opassword']);
    $userNewPass = esc_sql($_POST['user_password']);
    $userConPass = esc_sql($_POST['user_cpassword']);
    
    if(!wp_check_password($userOldPass, $user->data->user_pass, $user->ID)){
        $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
        <strong>Error:</strong> Old Password wrong.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }elseif ($userNewPass != $userConPass) {
        $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
        <strong>Error:</strong> Password are not matching.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }elseif (strlen($userNewPass) < 7) {
        $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
        <strong>Error:</strong> Use minimum 7 character in password.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }elseif($userNewPass == $userConPass){
        wp_set_password($userNewPass, $user->ID);
        wp_set_current_user($user->ID, $user->user_login);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user->user_login);
        $msg = '<div class="alert alert-success alert-dismissible show" role="alert">
        <strong>Success:</strong> Password is successfully updated.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    else{
        $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
        <strong>Error:</strong> Something Wrong.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
?>
<div class="container">
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-12">
        <h4 class="text-center"><?php echo $msg; ?></h4>
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Please change password here <small>It's free!</small></h3>
			 	</div>
			 	<div class="panel-body">
                 <form method="post" class="wc-change-pwd-form">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="password" class="form-control input-sm" name="user_opassword" placeholder="Old Password" id="user_oldpassword" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="password" reuired class="form-control input-sm" name="user_password" placeholder="New Password" id="user_password" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="password" reuired class="form-control input-sm" name="user_cpassword" placeholder="Confirm Password" id="user_cpassword" required />
                            </div>
                        </div>
                    </div>
                        <?php
                            ob_start();
                            do_action('password_reset');
                            echo ob_get_clean();
                        ?>
                        <div class="log_user">
                            <?php wp_nonce_field('changePassword', 'formType'); ?>
                            <button type="submit" name="change-pass" class="btn btn-info btn-block">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>    
<?php } else { wp_redirect( site_url('user-login') ); } ?>