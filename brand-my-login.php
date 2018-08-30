<?php
/*
Plugin name: Brand My Login
Description: Brand Your WordPress Login Page.
Version: 1.0.0
Author: Muhammad Alnajlat
Author URI: https://futuremediahouse.jp/
Copyright: Future Media House
Text Domain: brand-my-login
License: GPLv2 or later

Brand My Login is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Brand My Login is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}


define( 'BML_DOMAIN',					 'brand-my-login' );
define( 'BML_OPTION_GROUP',				 'brand-my-login-settings-group' );
define( 'BML_OPTION_NAME',				 'brand-my-login-settings' ); // Value is typed again in uninstall.php
define( 'BML_SETTINGS_ERROR_SLUG_TITLE', 'brand-my-login-error-messages' );


if ( is_admin() ) {
	
	require_once( dirname( __FILE__ ) . '/admin/brand-my-login-admin.php' );

}



/**
 * Plugin Front-end Effects
 */


if ( !empty( get_option( BML_OPTION_NAME )['logo_image_id'] ) ) {

	add_filter( 'login_headerurl', 'bml_loginlogo_url' );
	function bml_loginlogo_url($url) {
		return get_site_url();
	}

	add_filter( 'login_headertitle', 'bml_loginlogo_title' );
	function bml_loginlogo_title($title) {
		return get_bloginfo('name');
	}

}


add_action( 'login_enqueue_scripts', 'bml_login_page_style' );
function bml_login_page_style() {
	$bml_settings = get_option( BML_OPTION_NAME );

	$logo_image_url		= wp_get_attachment_url( $bml_settings['logo_image_id'] );
	$bg_image_url		= wp_get_attachment_url( $bml_settings['bg_image_id'] );
	$bg_position		= $bml_settings['bg_position'];
	if ( !empty($bg_position) ){
		$bg_position_arr= explode('-', $bml_settings['bg_position']);
	}
	$accent_color		= $bml_settings['accent_color'];
	$form_border_width	= $bml_settings['form_border_width'];
	$form_border_radius	= $bml_settings['form_border_radius'];
	?>


    <style type="text/css" id="bml-style">		

	<?php if ( !empty($bg_image_url) ) : ?>

		body.login {
			<?php if (!empty($bg_position)) : ?>
				background-position: <?php echo "{$bg_position_arr[0]} {$bg_position_arr[1]}"; ?>;
			<?php endif; ?>
			background-image: url(<?php echo $bg_image_url; ?>);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
		}

	<?php endif; ?>

	<?php if ( ( !empty($accent_color) && intval($form_border_width) !== 0 ) || !empty($logo_image_url) ) : ?>

		#login h1 a, .login h1 a {
			width: 100%;
		}
		
	<?php endif; ?>

	<?php if ( !empty($accent_color) && intval($form_border_width) !== 0 ) : ?>		
		
		#login h1 a:focus, .login h1 a:focus {
			box-shadow: none;
        }

		#login h1 a, .login h1 a,
		body.login div#login p#nav,
		body.login div#login p#backtoblog {
			background-color: #fff;
		}

		#login h1 a, .login h1 a {
			box-sizing: border-box;
			margin: 0 auto;
			padding: 50px 0;
			background-position: center center;
        }

		body.login div#login form#loginform,
		body.login div#login form#lostpasswordform{
			margin-top: 0;
		}

		body.login div#login p#nav,
		body.login div#login p#backtoblog {
			margin: 0;
			padding: 8px 24px;
		}

		body.login div#login p#backtoblog{
			padding-bottom: 20px;
		}		

	<?php endif; ?>
	

	<?php if ( !empty($logo_image_url) ) : ?>
		#login h1 a, .login h1 a {
			background-image: url(<?php echo $logo_image_url; ?>);
			background-size: auto 84px;
        }
	<?php endif; ?>
		

	<?php if ( !empty($accent_color) ) : ?>

		<?php if ( intval($form_border_width) !== 0 ) : ?>
			#login h1 a, .login h1 a,
			body.login div#login form#loginform,
			body.login div#login p#nav,
			body.login div#login p#backtoblog,
			body.login div#login p.message,
			body.login div#login form#lostpasswordform{
				border: solid <?php echo $accent_color; ?>;
				border-width : <?php echo $form_border_width; ?>px;
			}

			body.login div#login #login_error,
			body.login div#login .message,
			body.login div#login .success{
				margin-bottom: 0;
				border-right: <?php echo $form_border_width; ?>px solid <?php echo $accent_color; ?>;
				border-left-width: <?php echo $form_border_width; ?>px;
			}

		
			#login h1 a, .login h1 a {
				border-bottom-width: 0;
			}
			body.login div#login form#loginform,
			body.login div#login p#nav,
			body.login div#login p.message,
			body.login div#login form#lostpasswordform{
				border-top-width: 0;
				border-bottom-width: 0;
			}
			body.login div#login p#backtoblog{
				border-top-width: 0;
			}

			body.login div#login p.message{
				margin-bottom: 0;
			}
		<?php endif; ?>
		

		body.login div#login p.submit input#wp-submit{
			background: <?php echo $accent_color; ?>;
			border-width: 0;
			box-shadow: none;
			text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.15), 1px 0 1px rgba(0, 0, 0, 0.15), 0 1px 1px rgba(0, 0, 0, 0.15), -1px 0 1px rgba(0, 0, 0, 0.15);
		}

		body.login div#login input:focus {
			border-color: <?php echo $accent_color; ?>;
    		box-shadow: none;
		}

		body.login div#login input#rememberme:checked:before{
			color: <?php echo $accent_color; ?>;
		}

		body.login div#login p#backtoblog a:hover,
		body.login div#login p#nav a:hover,
		.login h1 a:hover {
			color: <?php echo $accent_color; ?>;
		}
		body.login div#login p#backtoblog a:focus,
		body.login div#login p#nav a:focus {
			box-shadow: 0 0 0 1px <?php echo $accent_color; ?>, 0 0 2px 1px <?php echo $accent_color; ?>;
		}
	<?php endif; ?>


	<?php if ( intval($form_border_radius) !== 0 ) : ?>

		<?php if ( !empty($accent_color) && intval($form_border_width) !== 0 ) : ?>
			
			#login h1 a, .login h1 a{
				border-top-right-radius: <?php echo $form_border_radius; ?>px;
				border-top-left-radius: <?php echo $form_border_radius; ?>px;
			}

			body.login div#login p#backtoblog{
				border-bottom-right-radius: <?php echo $form_border_radius; ?>px;
				border-bottom-left-radius: <?php echo $form_border_radius; ?>px;
			}

		<?php else: ?>

			.login form{
				border-radius: <?php echo $form_border_radius; ?>px;
			}

		<?php endif; ?>
	
	<?php endif; ?>

	
    </style>



	<?php if ( !empty($accent_color) && intval($form_border_width) !== 0 ) : ?>

		<script type="text/javascript" id="bml-script">

			document.addEventListener("DOMContentLoaded", function(event) {
				if ( document.getElementById('nav') == null && document.getElementById('backtoblog') == null ) {

					document.getElementById('loginform').style.borderBottomWidth = '<?php echo $form_border_width; ?>px';

					<?php if ( intval($form_border_radius) !== 0 ) : ?>

						document.getElementById('loginform').style.borderBottomRightRadius = '<?php echo $form_border_radius; ?>px';
						document.getElementById('loginform').style.borderBottomLeftRadius = '<?php echo $form_border_radius; ?>px';

					<?php endif; ?>

				}
			});
		

		</script>	

	<?php endif; ?>


<?php
}
