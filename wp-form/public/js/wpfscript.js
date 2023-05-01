jQuery(document).ready(function() {
  jQuery('#submit_button').click(function(e) {
    
    e.preventDefault();

    jQuery("label.error").remove();
    jQuery("label.success").remove();

    var first_name = jQuery("#first_name").val();
    var last_name = jQuery("#last_name").val();
    var email_id = jQuery("#email_id").val();
    var phone_number = jQuery("#phone_number").val();

    var form_val={
    	'first_name' : first_name,
    	'last_name' : last_name,
    	'email_id' : email_id,
    	'phone_number' : phone_number
    };

    var form_valid = jQuery("#wpform").valid();

    if(form_valid == true ){
    	jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "update_form_data", form_val : form_val},
         success: function(response) {
            console.log(response.data.message);
            if(response.data.message == "exists"){
            	//jQuery("#exists")
            	jQuery( '<label id="email_id-error" class="error" for="email_id">Email ID Already Exists.</label>' ).insertAfter( jQuery( "#email_id" ) );
            }else if(response.data.message == "success"){
            	jQuery( '<label id="form_success" class="success" >Form submitted successfully.</label>' ).insertAfter( jQuery( "#submit_button" ) );
            }else{
            	jQuery( '<label id="form_error" class="error">Please provide correct information.</label>' ).insertAfter( jQuery( "#submit_button" ) );
            }
         }
      })
    }
	    

  });


    jQuery('#wpform').validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email_id: {
                required: true,
                email: true
            },
            phone_number: {
                phoneUS: true,
                required: true
            }
        },
        messages: {			
			email_id: "Please enter a valid email address"
		},
        submitHandler: function (form) { // for demo
            //alert('valid form');
            console.log(form);
            return true;
        }
    });

});


