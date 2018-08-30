<?php

// if not called by WordPress, die
if ( ! defined('WP_UNINSTALL_PLUGIN') ) {
    die;
}
 
$option_name = 'brand-my-login-settings';
 
delete_option( $option_name );

?>