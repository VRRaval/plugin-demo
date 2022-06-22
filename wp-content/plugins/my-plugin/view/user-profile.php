<?php
if(!defined('ABSPATH')){
    header('location: /wordpress/demo');
    die();
}
if(isset($_POST['update-profile'])){
    $userId = esc_sql($_POST['userId']);
    $fname = esc_sql($_POST['first_name']);
    $lname = esc_sql($_POST['last_name']);
    $userName = esc_sql($_POST['username']);
    $email = esc_sql($_POST['email']);
    
    //Upload User profile  Image
    if($_FILES['user_profile_img']['error'] ==0 ){
        $userImg = $_FILES['user_profile_img'];
        $ext = explode('/', $userImg['type'])[1];
        $fileName = "$userId.$ext";
        $userProfile = wp_upload_bits($fileName, null, file_get_contents($userImg['tmp_name']));
        if(!metadata_exists('user', $userId, 'user_profile_img_url')){
            add_user_meta($userId, 'user_profile_img_url', $userProfile['url']);
            add_user_meta($userId, 'user_profile_img_path', esc_sql($userProfile['file']));
        }else{
            update_user_meta($userId, 'user_profile_img_url', $userProfile['url']);
            update_user_meta($userId, 'user_profile_img_path', esc_sql($userProfile['file']));
        }
    }
        
    $userData = array(
        'ID' => $userId,
        'first_name' => $fname,
        'last_name' => $lname,
        'user_login' => $userName,
        'user_email' => $email,
    );
    $user = wp_update_user($userData);
    if(is_wp_error($user)){
        echo 'Can not update : '.$user->get_error_message();
    }
}
$userId = get_current_user_id();
$user = get_userdata($userId);
if($userId != false):
$fname = get_usermeta($userId,'first_name');
$lname = get_usermeta($userId,'last_name');
$userName = get_usermeta($userId,'user_login');
$email = get_usermeta($userId,'user_email');
$userPro = get_usermeta($userId,'user_profile_img_url');
?>
<?php
 if($userPro != ''){
    echo '<img src="'.$userPro.'" width="150px" />';
 }
?>
<h1>Welcome <?php echo " $fname $lname "; ?><small style="color: inherit;">(Not <?php echo "$fname $lname?"; ?> <a href="<?php echo wp_logout_url(); ?>">Logout)</a></small></h1>
<form action="<?php echo get_the_permalink(); ?>" method="post" enctype="multipart/form-data">

    <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
	            <input type="file" name="user_profile_img" id="user_profile_img" class="form-control input-sm">
			</div>
		</div>
    </div>
    <div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
	            <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name" value="<?php echo $fname; ?>">
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name" value="<?php echo $lname; ?>">
			</div>
	    </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username" value="<?php echo $userName; ?>">
            </div>   
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email" value="<?php echo $email; ?>">
            </div>   
        </div>
    </div>
	<!-- <div class="row">
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
	</div> -->
    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
	<input type="submit" value="Update Profile" name="update-profile" class="btn btn-info btn-block">
</form>
<?php endif; ?>