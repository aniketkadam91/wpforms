<?php
//echo "hrllo";die;
/**
 * 
 */
class Wpf_List extends WP_List_Table

{

	function __construct() {
        parent::__construct( array(
            'singular' => 'post',
            'plural' => 'posts',
            'ajax' => false
        ) );
    }
 
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'id' => 'id',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number'
        );
        return $columns;
    }
 
    function prepare_items() {
        global $wpdb;
 
        $query = "SELECT * FROM wp_forms  ORDER BY id ASC";
 
        $data = $wpdb->get_results( $query );
 
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count( $data );
 
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page' => $per_page
        ) );
 
        $data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );
 
        $this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
        $this->items = $data;
    }
 
    function column_default( $item, $column_name ) {
    	//echo "<pre>";print_r($item->first_name);echo "</pre>";
        switch( $column_name ) {
            case 'id':
                return '<a href="' . get_edit_post_link( $item->ID ) . '">' . $item->id . '</a>';
            case 'first_name':
                return  $item->first_name;
            case 'last_name':
                return $item->last_name;
            case 'email':
                return $item->email;
            case 'phone_number':
                return $item->phone_number;
            default:
                return print_r( $item, true );
        }
    }

    // Define the bulk actions
	function get_bulk_actions() {
	  $actions = array(
	    'delete' => 'Delete'
	  );
	  return $actions;
	}

	// Handle bulk actions
	function process_bulk_action() {
	  if ( 'delete' === $this->current_action() ) {
	    $post_ids = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : array();

	    // Loop through each ID and delete the post
	    foreach ( $post_ids as $post_id ) {
	      wp_delete_post( $post_id );
	    }
	  }
	}



}

$lstTable = new Wpf_List();
$lstTable->prepare_items();
$lstTable->display();
?>