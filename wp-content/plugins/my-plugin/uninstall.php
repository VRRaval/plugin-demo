<?php 
if(!defined('WP_UNINSTALL_PLUGIN')){
    header("Location: /wordpress/demo");
    die();
}

//Perform some function here when plugin in uninstall

global $wpdb , $table_prefix;
$tbl_emp = $table_prefix.'emp';

$q = "DROP TABLE `$tbl_emp` ";
$wpdb->query($q);