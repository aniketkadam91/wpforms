<?php
/*
Plugin Name:  WP Form 
Description:  Simple user Registration form and which stores user information in database. 
Version:      1.0
Author:       Aniket
*/

function activate_wp_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'public/includes/class-wp-forms-activator.php';
	Wp_Forms_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-forms-deactivator.php
 */
// function deactivate_wp_forms() {
// 	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-forms-deactivator.php';
// 	Wp_Forms_Deactivator::deactivate();
// }

register_activation_hook( __FILE__, 'activate_wp_forms' );
//register_deactivation_hook( __FILE__, 'deactivate_wp_forms' );


require plugin_dir_path( __FILE__ ) . 'admin/includes/class-admin-menu.php';

require plugin_dir_path( __FILE__ ) . 'public/includes/class-wp-forms.php';

function run_wp_forms() {

	$plugin = new Wp_Forms();
	//$plugin->run();

}
run_wp_forms();