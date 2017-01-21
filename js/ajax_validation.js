function init_ajax_validation() { 
	

	// Checks if the elements are empty
	$("#lname , #fname, #school_code").on("blur", function() 
	{
		var incorrect = false;
		var element = $(this);
		var val = element.val();
		
		
		if(val.length === 0){
			incorrect = true;
		}
		
		if(incorrect){
			red_light_element(this);	
		}
		else 
		{
			green_light_element(this);	
		}
		
		update_button();
	});
	

	$("#password").on("change keyup input",function() {
		check_repeat_password();
		validate_password();
		update_button();
	});
	
	
	$("#password_repeat").on("change keyup input", function() {
		validate_password();
		check_repeat_password();
		update_button();
	});
	
	
	$("#email").on("change keyup input",function() 
	{
		
		var incorrect = false;
		var element = $(this);
		var val = element.val();
		// check if email does not contain "@"
		if(val.indexOf("@") == -1){
			incorrect = true;
		}
		
		// check if email does not contain a dot
		if(val.indexOf(".") == -1){
			incorrect = true;
		}
		
		
		if(val.length == 0){
			incorrect = true;
			}
		
		
		if(incorrect){
			red_light_element(this);	
		}
		else 
		{
			green_light_element(this);	
		}
		
		update_button();
		
	});
	
}	


function validate_password()
{	
	var incorrect = false;
	var element = $("#password");
	var val = element.val();
	val  = val.replace(/./g, '*');
	
	if(val.length < 7){
		incorrect = true;
		$("#ajax_info").html("Password has to be 7 characters or longer");
		$("#ajax_info").css("color", "red");
	}
	
	
	if(incorrect){
		red_light_element(element);	
	}
	else 
	{
		green_light_element(element);	
		$("#ajax_info").html("");
	}
	
	
}

function check_repeat_password(){
	var incorrect = false;
	var element = $("#password_repeat");
	var repeat_val = element.val();
	var password_val = $("#password").val();
	
	var repeat_length  = repeat_val.replace(/./g, '*').length;
	
	if(repeat_length > 0){
		
		if(repeat_val != password_val){
			incorrect = true;
			$("#ajax_info").html("Passwords must match");
			$("#ajax_info").css("color", "red");
		}
		
		
		if(incorrect){
			red_light_element(element);	
		}
		else 
		{
			green_light_element(element);	
			$("#ajax_info").html("");
		}
	}
	
}

// Updates the buttons color to show weather or all the fields have passed the validation
function update_button()
{
	var has_error = false;
	var button = $(".form input[type=submit]");
	var form = $("#form");
	var inputs = form.children("input");
	
	// Loops through all the inputs and makes sure they dont have the 'error'-class
	for(var i = 0; i < inputs.length;i++){

		var input = $(inputs[i]);
		
		if(input.hasClass("error_border")){
			has_error = true;
		}
		
		console.log("id: " +inputs[i].id);
		console.log("val: " +input.val());
		
		// check if the input is empty
		if(input.val().replace(/./g, '*').length == 0) {
			//console.log(input.val());
			has_error = true;
		}
		
		
	}
	
	
	if(has_error){
		red_light_element(button);	
	}
	else{
		green_light_element(button);	
	}
	
	
	
}


function red_light_element(element)
{
	$(element).addClass("error_border");
	$(element).removeClass("correct_border");
}


function green_light_element(element)
{
	$(element).removeClass("error_border");
	$(element).addClass("correct_border");
}
