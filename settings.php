<?php


/**
 * Create page options
 */
add_action('admin_menu', 'ut_add_plugin_page');

function ut_add_plugin_page(){

	add_options_page( __( 'Settings' ) . ' "Themes Switching"', 'Themes Switching', 'manage_options', 'themes_switching', 'ut_options_page_output' );
}

function ut_options_page_output(){ 
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>
		<form action="options.php" method="POST">
			<?php
				settings_fields( 'ut_group' );     
				do_settings_sections( 'ut_page' ); 
				submit_button();
			?>
		</form>
	</div>
	<?php
}


/**
 * Register settings
 */
add_action('admin_init', 'ut_plugin_settings');

function ut_plugin_settings(){

	register_setting( 'ut_group', 'ut_option', 'sanitize_callback' );

	add_settings_section( 'ut_id', '', '', 'ut_page' ); 

	add_settings_field('ut_desktop', __('Active Theme'), 'ut_active_theme', 'ut_page', 'ut_id' );
	add_settings_field('ut_tablet', __('Theme for Tablet'), 'ut_field_tablet', 'ut_page', 'ut_id' );
	add_settings_field('ut_phone', __('Theme for Phone'), 'ut_field_phone', 'ut_page', 'ut_id' );
}


/**
 * Add a settings link to your WordPress plugin on the plugin listing page.
 */
function ut_add_settings_link( $links ) {
	// Build and escape the URL.
	$url = esc_url( add_query_arg(
		'page',
		'themes_switching',
		get_admin_url() . 'admin.php'
	) );
	// Create the link.
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	// Adds the link to the end of the array.
	array_push(
		$links,
		$settings_link
	);
	return $links;
}
add_filter( 'plugin_action_links_unreal-themes-switching/unreal-themes-switching.php', 'ut_add_settings_link' );


/**
 * Desktop
 */
function ut_active_theme(){

	$current_theme      = wp_get_theme(); 
	$current_theme_name = $current_theme['Name']; ?>

	<p><kbd><?php echo $current_theme_name; ?></kbd></p>

	<?php
}


/**
 * Tablet
 */
function ut_field_tablet(){

	$val    = get_option('ut_option');
	$val    = $val ? $val['tablet'] : null;
	$themes = wp_get_themes(); ?>

	<select name="ut_option[tablet]">
		<option value="0"><?php echo __('- Select -'); ?></option>
		<?php foreach( (array)$themes as $theme ): ?>
			
			<?php if($theme->template === $val): ?>
				<option selected="selected" value="<?php echo $theme->template; ?>"><?php echo $theme['Name']; ?></option>
			<?php else: ?>
				<option value="<?php echo $theme->template; ?>"><?php echo $theme['Name']; ?></option>
			<?php endif; ?>
				
		<?php endforeach; ?>
	</select>

	<?php
}


/**
 * Phone
 */
function ut_field_phone(){

	$val    = get_option('ut_option');
	$val    = $val ? $val['phone'] : null;
	$themes = wp_get_themes(); ?>

	<select name="ut_option[phone]">
		<option value="0"><?php echo __('- Select -'); ?></option>
		<?php foreach( (array)$themes as $theme ): ?>
			
			<?php if($theme->template === $val): ?>
				<option selected="selected" value="<?php echo $theme->template; ?>"><?php echo $theme['Name']; ?></option>
			<?php else: ?>
				<option value="<?php echo $theme->template; ?>"><?php echo $theme['Name']; ?></option>
			<?php endif; ?>
				
		<?php endforeach; ?>
	</select>

	<?php
}