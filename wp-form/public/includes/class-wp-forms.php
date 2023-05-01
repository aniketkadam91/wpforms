<?php

add_shortcode( 'wpforms', array( 'Wp_Forms', 'wpdocs_wpforms_func' ) );

class Wp_Forms{

	public function __construct() {
		
		//Register Styles
        add_action( 'wp_enqueue_scripts', array($this, 'register_styles' ));

        //Register Scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

        //Admin ajax call to insert form data
        add_action( 'wp_ajax_update_form_data', array( $this, 'update_form_data' ) );
        add_action( 'wp_ajax_nopriv_update_form_data', array( $this, 'update_form_data' ) );
		
	}

	public function register_styles(){
        wp_register_style( 'wpform_style', plugins_url('../css/wpfstyle.css', __FILE__) );
        wp_enqueue_style( 'wpform_style' );
	}

	public function register_scripts(){
		//custom js file
		wp_register_script( 'wpform_script', plugins_url('../js/wpfscript.js', __FILE__) );
		wp_localize_script( 'wpform_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		wp_enqueue_script( 'wpform_script' );

		//vaidation js file
		wp_register_script( 'wp_validation_script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js' );
		wp_enqueue_script( 'wp_validation_script' );

		//additional methos js file
		wp_register_script( 'wp_additional_script', 'https://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/additional-methods.js' );
		wp_enqueue_script( 'wp_additional_script' );

	}

	public static function wpdocs_wpforms_func( $atts, $content = "" ) {
		return <<<HTML
			<div class="container wpforms_container">
			    <form id="wpform" action="#" method="post">
			    <div class="input_wrapper">
			    	<label><b>First Name</b></label>
					<input class="input_field" id="first_name" type="text" name="first_name" required>
			    </div>
			    <div class="input_wrapper">
					<label><b>Last Name</b></label>
					<input class="input_field" id="last_name" type="text" name="last_name" required>
				</div>
				<div class="input_wrapper">
					<label><b>E-mail</b></label>
					<input class="input_field" id="email_id" type="email" name="email_id" required>
				</div>
				<div class="input_wrapper">
					<label><b>Phone Number</b></label>
					<input class="input_field" id="phone_number" type="text" name="phone_number" required>
				</div>
				<button id="submit_button" class="wpf_submit" type="submit">Submit</button>
				</form>
			</div>
		    
		HTML;
	}


	public function update_form_data(){
		global $wpdb;
		
		$aFromData = $_POST['form_val'];

		$table_name = $wpdb->prefix . 'forms';

		$email_id = $aFromData["email_id"];

		$wpdb->show_errors();
		$EmailValue = $wpdb->get_results("SELECT id FROM $table_name  WHERE email = '". $email_id ."' ");
		
		$EmailId = $EmailValue[0]->id;

		 $json = array();
		
		if(isset($EmailId) && !empty($EmailId)){

			$json['message'] = 'exists';
        	wp_send_json_success( $json );
			die();

		}else{

			$wpdb->insert($table_name, array(
				'id' => '',
				'first_name' => $aFromData['first_name'],
				'last_name' => $aFromData['last_name'],
				'email' => $aFromData['email_id'], 
				'phone_number' => $aFromData['phone_number']
			));

			$lastid = $wpdb->insert_id;

			if(isset($lastid)){

				$json['message'] = 'success';
	        	wp_send_json_success( $json );
				die();

			}else{

				$json['message'] = 'fail';
	        	wp_send_json_success( $json );
				die();

			}

		}

		//$wpdb->show_errors();
		
		//$wpdb->print_error();
		
		die();
	}

}