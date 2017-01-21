function update_school_info(){
	
	var raw_info = $("#info").val();
	
	// prepares the content for databse format with the prepare_content function
	var content = prepare_content(raw_info);
	$("#info").val(content);
	
	var form = document.getElementById("update_form");
	var form_data = new FormData(form);
	
	$("#info").val(raw_info);
	
	$.ajax({
		type: "POST",
		url: "ajax/ajax_update_school.php",
		data: form_data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){$("#ajax_info").css("color", "black"); $("#ajax_info").html('Updating...');},
		success: function(data){
			var result = $.trim(data);
			console.log(result);
			
			if(result === "true")
			{
				setTimeout(function(){location.reload();}, 1000);
				$("#ajax_info").html("Sucsesfully updated information");
				$("#ajax_info").css("color", "green");
				
			}
			else
			{ // In case there's an error from the server
				$("#ajax_info").html(result);
				$("#ajax_info").css("color", "red");
				
				//Shake animation effect.
				shake($("#create"));
			}
		}
	});
	
}

function create_post()
{
	
	var raw_content = $("#content").val();
	
	// prepares the content for databse format with the prepare_content function
	var content = prepare_content(raw_content);
	$("#content").val(content);
	
	var form = document.getElementById("form");
	var form_data = new FormData(form);
	
	$("#content").val(raw_content);
	
	
	$.ajax({
		type: "POST",
		url: "ajax/ajax_create_post.php",
		data: form_data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){ $("#ajax_info").html('Connecting...');},
		success: function(data){
			var result = $.trim(data);
			console.log(result);
			
			if(result === "true") {
				setTimeout(function(){location.reload();}, 1000);
				$("#ajax_info").html("Your post has been added!");
				$("#ajax_info").css("color", "green");
			}
			else if (result.indexOf("<b>Warning</b>:  POST") != -1){
				$("#ajax_info").html("The images you are trying to upload are too big");
				$("#ajax_info").css("color", "red");
			}
			else
			{ // In case there's an error from the server
				$("#ajax_info").html(result);
				$("#ajax_info").css("color", "red");
				
				//Shake animation effect.
				shake($("#create"));
			}
		}
	});
}


function register()
{
	var button = $("#register");
	
	// Checks if the button has the error class. This means that there is an error in one or more of the fields
	if(!button.hasClass("error_border")){
		
		var form = document.getElementById("form");
		var form_data = new FormData(form);
		
		
		$.ajax({
			type: "POST",
			url: "ajax/ajax_register.php",
			data: form_data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(){ $("#ajax_info").html('Connecting...');},
			success: function(data){
				var result = $.trim(data);
				
				console.log(result);
				if(result === "true")
				{
					
					$("#ajax_info").html("Your account has been created! <p onclick = 'open_log_in_form()'>Click here to log in</p>");
					$("#ajax_info").css("color", "green");
					
				}
				else
				{ // in case there's an error from the server
					$("#ajax_info").html(result);
					$("#ajax_info").css("color", "red");
					
					//Shake animation effect.
					shake($("#register"));
				}
			}
		});
	}
	else
	{
		//Shake animation effect.
		shake($("#register"))
	}
}

function login()
{
	var form = document.getElementById("form");
	var form_data = new FormData(form);
	
	$.ajax({
		type: "POST",
		url: "ajax/ajax_login.php",
		data: form_data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){ $("#ajax_info").html('Connecting...');},
		success: function(data){
			var result = $.trim(data);
			console.log(result);
			
			if(result === "true")
			{
				setTimeout(function(){location.reload();}, 500);
				$("#ajax_info").html("You have been logged in!");
				$("#ajax_info").css("color", "green");
				
			}
			else
			{
				$("#ajax_info").html("Wrong password or email!");
				$("#ajax_info").css("color", "red");
				
				//Shake animation effect.
				shake($("#login"));
			}
		}
	});
}


function delete_gallery_post(post_id){
	if(confirm("Are you sure that you want to delete this post?")){
		location.href = "actions/delete_gallery_post.php?id=" + post_id;
	}
}

function delete_post(post_id){
	if(confirm("Are you sure that you want to delete this post?")){
		location.href = "actions/delete_post.php?id=" + post_id;
	}
}

function logout()
{
	
	$.ajax(
	{
		url: "actions/logout.php",
		success: function(data){
			location.reload(true);
		}
	});
}

function upload_report(){
	var form = document.getElementById("reports_form");
	var form_data = new FormData(form);
	
	$.ajax({
		type: "POST",
		url: "ajax/ajax_upload_report.php",
	data: form_data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function(){ $("#reports_ajax_info").html('Connecting...');},
	success: function(data){
	var result = $.trim(data);
	console.log(result);
	
	if(result === "true")
	{
	setTimeout(function(){location.reload();}, 500);
	$("#reports_ajax_info").html("Report has been uploaded");
	$("#reports_ajax_info").css("color", "green");
	
	}
	else
	{
	$("#reports_ajax_info").html(result);
	$("#reports_ajax_info").css("color", "red");
	
	}
	}
	});
	}
	
	
	function upload_gallery(){
	var form = document.getElementById("form");
	var form_data = new FormData(form);
	
	$.ajax({
	type: "POST",
	url: "ajax/ajax_upload_gallery.php",
	data: form_data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function(){ $("#ajax_info").html('Connecting...');},
	success: function(data){
	var result = $.trim(data);
	
	
	if(result === "true")
	{
	setTimeout(function(){location.reload();}, 500);
	$("#ajax_info").html("Your images have been uploaded");
	$("#ajax_info").css("color", "green");
	
	}
	else if (result.indexOf("<b>Warning</b>:  POST") != -1){
	$("#ajax_info").html("The images you are trying to upload are too big");
	$("#ajax_info").css("color", "red");
	}
	else
	{
	$("#ajax_info").html(result);
	$("#ajax_info").css("color", "red");
	
	}
	}
	});
	}
	
	
	function update_page_text(){
	
	var raw_info = $("#info").val();
	
	// prepares the content for databse format with the prepare_content function
	var content = prepare_content(raw_info);
	$("#info").val(content);
	
	var form = document.getElementById("update_form");
	var form_data = new FormData(form);
	
	$("#info").val(raw_info);
	
	$.ajax({
	type: "POST",
	url: "ajax/ajax_update_page.php",
	data: form_data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function(){$("#ajax_info").css("color", "black"); $("#ajax_info").html('Updating...');},
	success: function(data){
	var result = $.trim(data);
	console.log(result);
	
	if(result === "true")
	{
	setTimeout(function(){location.reload();}, 1000);
	$("#ajax_info").html("Sucsesfully updated information");
	$("#ajax_info").css("color", "green");
	
	}
	else
	{ // In case there's an error from the server
	$("#ajax_info").html(result);
	$("#ajax_info").css("color", "red");
	
	//Shake animation effect.
	shake($("#create"));
	}
	}
	});
	
	}
	
	
		