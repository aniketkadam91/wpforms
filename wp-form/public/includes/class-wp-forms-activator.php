<?php

class Wp_Forms_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'forms';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			first_name varchar(50),
			last_name varchar(50),
			email varchar(50),
			phone_number varchar(50),
			PRIMARY KEY  (id)
		)";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

	}

}