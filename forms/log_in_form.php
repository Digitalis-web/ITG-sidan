

<div class = "form center_vertical">
	<form id = "form" method = "post" enctype="multipart/form-data">
		<h1>Log in</h1>
		
		<div id = "ajax_info"><br>
		</div>
		<p onclick = "open_register_form()">
			Click here to create an account
		</p>
		<input name = "email" type = "text" placeholder = "Email *">
		<input name = "password" type = "password" placeholder = "Password *">
	</form>
	<input onclick = "login()" type = "submit" value = "Log in" id = "login">
	
</div>

