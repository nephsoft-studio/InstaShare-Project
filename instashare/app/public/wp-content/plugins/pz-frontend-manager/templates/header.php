<?php do_action( 'pzfm_before_html_content_hook' ); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="apple-touch-icon" sizes="76x76" href="">
		<link rel="icon" type="image/png" href="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>
			<?php echo bloginfo( 'name' ) ?> | <?php the_title(); ?>
		</title>
		<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
		<?php wp_head(); ?>
		<?php do_action( 'pzfm_before_header_hook' ); ?>
	</head>
	<?php
		$roles			= is_user_logged_in() ? join( ' ', pzfm_user_role( get_current_user_id() ) ) : '';
		$current_page	= !empty($_GET['dashboard']) ? sanitize_text_field( $_GET['dashboard'] ) : 'home';
		$login_check	= is_user_logged_in() ? 'pzfm-login' : '';
		echo sprintf(
			'<body id="pzfm-body-wrap" class="pzfm-dashboard-wrap page-%s %s pzfm-%s %s">',
			get_the_ID(),
			$roles,
			$current_page,
			$login_check
		);
	?>