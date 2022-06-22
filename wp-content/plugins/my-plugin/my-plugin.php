<?php
/*
Plugin Name: My Plugin
Description: My Custom plugin development first plugin.
Version: 1.0.0
Author: Vijay Raval
Author URI: https://demo.com
*/

if(!defined('ABSPATH')){
    header('location: /wordpress/demo');
    die();
}
function my_custom_script() {
    echo '<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">';
    echo '<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>';
    echo '<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>';
}
add_action( 'wp_head', 'my_custom_script' );
//when plugin is active initilize this function
function my_plugin_activation(){
    global $wpdb, $table_prefix;
    $tbl_emp = $table_prefix.'emp';
    
    $q = "CREATE TABLE IF NOT EXISTS `$tbl_emp` (`ID` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `email` VARCHAR(100) NOT NULL , `status` BOOLEAN NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
    $wpdb->query($q);

    $data = array(
        'name' => 'Vijay',
        'email' => 'vijayraval.it@gmail.com',
        'status' => 1
    );
    $wpdb->insert($tbl_emp , $data);
    
}
register_activation_hook(__FILE__,'my_plugin_activation');

//when plugin is deactivated initilize this function
function my_plugin_deactivation(){
    global $wpdb, $table_prefix;
    $tbl_emp = $table_prefix.'emp';

    $q = "TRUNCATE `$tbl_emp` ";
    $wpdb->query($q);
}
register_deactivation_hook(__FILE__,'my_plugin_deactivation');

//shortcode with attribute
/*function my_custom_sc($atts){
    $atts = array_change_key_case((array) $atts , CASE_LOWER); // Change the key to lower case default is lower.
    $atts = shortcode_atts(array(
        'type' => 'gallery', //Attribute default value
    ),$atts);
    ob_start();
    include 'view/'.$atts['type'].'.php';
    return ob_get_clean();
}
add_shortcode('my-att','my_custom_sc');*/

function my_custom_scripts(){
    $path_js = plugins_url('js/main.js',__FILE__);
    $path_css = plugins_url('css/style.css',__FILE__);
    $dep = array('jquery'); //optional
    $ver = filemtime(plugin_dir_path(__FILE__).'js/main.js'); //Optional , Default script is loaded in to the header , you can change to footer via add `true` parameter
    $ver_css = filemtime(plugin_dir_path(__FILE__).'css/style.css'); //Optional
    $is_login = is_user_logged_in() ? 1: 0;
    wp_enqueue_style('my-custom-style',$path_css, '', $ver_css);
    wp_enqueue_script('my-custom-script', $path_js, $dep, $ver, true);   
    wp_add_inline_script('my-custom-script', 'var is_login ='.$is_login.';','before'); 
}
add_action('wp_enqueue_scripts','my_custom_scripts');
//add_action('admin_enqueue_scripts','my_custom_scripts'); // using this we can add script in the admin

function my_custom_scripts_adm(){
    $path_js = plugins_url('admin/js/adm-main.js',__FILE__);  
    $dep = array('jquery'); //optional
    $ver = filemtime(plugin_dir_path(__FILE__).'admin/js/adm-main.js');
    wp_enqueue_script('my-custom-script-adm', $path_js, $dep, $ver, true);
}
add_action('admin_enqueue_scripts','my_custom_scripts_adm');
function show_data(){
    global $wpdb, $table_prefix;
    $tbl_emp = $table_prefix.'emp';

    $getData = "SELECT * FROM `$tbl_emp`";
    $results = $wpdb->get_results($getData);

    ob_start(); ?>
           <table class="table" border=1>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>status</th>
                    </tr>
                </thead>
            <tbody>
                <?php foreach($results as $row): ?>
                <tr>
                    <td><?php echo $row->ID;?></td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->email;?></td>
                    <td><?php if($row->status == 1){ echo 'Active';} else{ echo 'Deactive';} ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('show-emp','show_data');

//get post data using shortcode
function my_posts(){
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
    );
    $query = new wp_query($args);
    ob_start(); 
    if($query->have_posts()):
    ?>
    <ul>
        <?php while($query->have_posts()){
            $query->the_post();
            echo '<li><a href= '.get_the_permalink().'>'.get_the_title().'</a>'. '-> '.get_the_content().'</li>';
        } ?>
    </ul>

    <?php
    endif;
    wp_reset_postdata();
    $html = ob_get_clean();
    return $html;
}
add_shortcode('my-posts','my_posts');

function post_views(){
    if(is_single()){
        global $post;
        $views = get_post_meta($post->ID, 'views', true);
        if($views == ''){
            add_post_meta($post->ID, 'views', 1);
        }else{
            $views++;
            update_post_meta($post->ID, 'views', $views);
        }
        echo get_post_meta($post->ID, 'views', true);
    }
}
add_action('wp_head','post_views');

function my_plugin_page_function(){
    include 'admin/adm-main.php';
}
function my_plugin_subpage_function(){
    echo 'Hello sub page';
}
function my_plugin_menu(){
    add_menu_page('My Plugin Page', 'My Plugin Page', 'manage_options', 'my-plugin-page', 'my_plugin_page_function','dashicons-superhero', 6);

    add_submenu_page('my-plugin-page', 'All employee', 'All employee', 'manage_options', 'my-plugin-page', 'my_plugin_page_function');

    add_submenu_page('my-plugin-page', 'My plugin sub page', 'My plugin sub page', 'manage_options', 'my-plugin-subpage', 'my_plugin_subpage_function');
}
add_action('admin_menu','my_plugin_menu');

//ajax Call function

add_action('wp_ajax_my_serach_res','my_serach_res');
function my_serach_res(){
    global $wpdb, $table_prefix;
    $tbl_emp = $table_prefix.'emp';
    $searchTerm = $_POST['searchTerm'];

    if(!empty($searchTerm)){
       $getData = "SELECT * FROM `$tbl_emp` WHERE 
       `name` LIKE '%".$searchTerm."%'
       OR `email` LIKE '%".$searchTerm."%'
       OR `ID` LIKE '%".$searchTerm."%';";
    }else{
       $getData = "SELECT * FROM `$tbl_emp`;";
    }
    $results = $wpdb->get_results($getData);    
    ob_start();
    foreach($results as $row): ?>
        <tr>
            <td><?php echo $row->ID;?></td>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php if($row->status == 1){ echo 'Active';} else{ echo 'Deactive';} ?></td>
        </tr>
    <?php endforeach; 
    return ob_get_clean();
    wp_die();
}

// ajax Search front end
function search_front_end(){
    include 'admin/adm-main.php';
} 
add_shortcode('search-data','search_front_end');


function my_register_form(){
    ob_start();
    include 'view/register.php';
    return ob_get_clean();
}
add_shortcode('my-register-form','my_register_form');

function my_user_login_form(){
    ob_start();
    include 'view/login.php';
    return ob_get_clean();
}
add_shortcode('my-login-form','my_user_login_form');

function my_login_form(){
    if(isset($_POST['userLogin'])){
        $userName = esc_sql($_POST['username']);
        $password = esc_sql($_POST['password']);

        $loginData = array(
            'user_login' => $userName,
            'user_password' =>  $password,
            'remember'      => true
        );
        $user = wp_signon($loginData, false);
        
        if(!is_wp_error($user)){
           if($user->roles[0] == 'administrator'){
               wp_redirect(admin_url());
               exit;
           }else{
               wp_redirect(site_url('user-profile'));
               exit;
           }
        }else{
            $msg = '<div class="alert alert-danger alert-dismissible show" role="alert">
                    <strong>Error:</strong> '.$user->get_error_message().'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
        }
    }
}
add_action('template_redirect','my_login_form');

function user_profile(){
    ob_start();
    include 'view/user-profile.php';
    return ob_get_clean();

}
add_shortcode('user-profile','user_profile');

function my_user_redirect(){
    $userLogin = is_user_logged_in();

    if( $userLogin && (is_page('user-login') || is_page('register'))){
        wp_redirect(site_url('user-profile'));
        exit;
    }
    elseif( !$userLogin && is_page('user-profile')){
        wp_redirect(site_url('user-login'));
        exit;
    }
}
add_action('template_redirect','my_user_redirect');

function redirect_after_logout(){
    wp_redirect(site_url('user-login'));
    exit;
}
add_action('wp_logout','redirect_after_logout');

function user_pass_change(){
    ob_start();
    include 'view/change-password.php';
    return ob_get_clean();
}
add_shortcode('change-pass-form','user_pass_change');