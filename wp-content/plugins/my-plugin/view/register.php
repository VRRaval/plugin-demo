<?php
if(!defined('ABSPATH')){
    header('location: /wordpress/demo');
    die();
}
$msg = '';
    if(isset($_POST['register'])){
        global $wpdb;
        $fName = $wpdb->escape($_POST['first_name']);
        $lName = $wpdb->escape($_POST['last_name']);
        $userName = $wpdb->escape($_POST['username']);
        $email = $wpdb->escape($_POST['email']);
        $password = $wpdb->escape($_POST['password']);
        $conPassword = $wpdb->escape($_POST['password_confirmation']);

        if($password == $conPassword){
            $userData = array(
                'user_login' => $userName,
                'user_email' => $email,
                'first_name' => $fName,
                'last_name'  => $lName,
                'display_name'  => $fName.' '.$lName,
                'user_pass' =>  $password,
            );
            $result = wp_insert_user( $userData );
            //$result = wp_create_user($userName, $password, $email ); // also this function is checking user is exist
            if(!is_wp_error($result)){
                //echo 'User Created ID:'.$result;
                $msg = '<div class="alert alert-success alert-dismissible show" role="alert">
                        <strong>Success:</strong> User has been register successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                add_user_meta($result, 'type', 'student');
                wp_redirect( site_url('user-login') );

            } else{
                $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
                        <strong>Error:</strong> '.$result->get_error_message().'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
            }
        }
        else{
            $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
                    <strong>Error:</strong> Password must match!.
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
			    		<h3 class="panel-title">Please sign up here <small>It's free!</small></h3>
			 			</div>
			 			<div class="panel-body">
			    		<form action="<?php echo get_the_permalink(); ?>" method="post" role="form">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
			    					</div>
			    				</div>
			    			</div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username">
                                    </div>   
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email">
                                    </div>   
                                </div>
                            </div>
			    			

			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
			    					</div>
			    				</div>
			    			</div>
			    			
			    			<input type="submit" value="Register" name="register" class="btn btn-info btn-block">
			    		
			    		</form>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>
</div>

    