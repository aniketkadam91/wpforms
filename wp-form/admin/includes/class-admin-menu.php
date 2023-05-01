<?php 

/**
 * 
 */
class Admin_Menu 
{
	
	function __construct()
	{
		// Hook for adding admin menus
 		add_action('admin_menu', array($this, 'wpf_admin_menu' ));
	}

	public function wpf_admin_menu(){
		add_menu_page(
            'WP Form',
           	'WP Form',
            'manage_options',
            'wp-forms',
            array( __CLASS__, 'wpf_menu_page' ),
            'dashicons-tagcloud',
            6
        );
	}
	public  function wpf_menu_page() { 
        if ( is_file( plugin_dir_path( __FILE__ ) . 'wpf_menu_page.php' ) ) {
        	if(!class_exists('Link_List_Table')){
			   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
			}
            include_once plugin_dir_path( __FILE__ ) . 'wpf_menu_page.php';
        }
    }
}

$oAdminMenu = new Admin_Menu();

?>