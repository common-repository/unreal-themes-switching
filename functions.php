<?php

/**
 * Change theme
 */
add_filter('template', 'ut_change_theme');
add_filter('option_template', 'ut_change_theme');
add_filter('option_stylesheet', 'ut_change_theme');

function ut_change_theme($template) {

	/* class mobile detect */
	require_once( dirname(__FILE__) . '/lib/mobile-detect.php' );

	$detect     = new Mobile_Detect;
	$options    = get_option('ut_option');
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

	$template_tablet = (in_array($options['tablet'], ut_get_array_themes())) ? $options['tablet'] : $template;
	$template_phone  = (in_array($options['phone'], ut_get_array_themes())) ? $options['phone'] : $template;

	switch($deviceType):

		case 'computer': $theme = $template;
		break;

		case 'tablet':   $theme = $template_tablet;
		break;

		case 'phone':    $theme = $template_phone;
		break;

		default:         $theme = $template;
		break;

	endswitch;

	return $theme;
}

function ut_get_array_themes(){
	
	$result = array();
	$themes = wp_get_themes();

	foreach( (array)$themes as $theme ):

		$result[] = $theme->template;

	endforeach;

	return $result;
}