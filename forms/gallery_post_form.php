
<div class = "form center_vertical ">
	<form id = "form" method = "post" enctype="multipart/form-data">
		<h1>Gallery Post</h1>
		
		<div id = "ajax_info">
			<br>
		</div>
		<input type = "text" name = "title" placeholder = "Title">
		
		<h3>Images:</h3>
		<div id = "file_inputs_container"> <!-- Container for all the input elements that will be created here automaticly from javascript --->
			<input type = "file" name = "image1" onchange="addImageInput(event)">
		</div>
		
		
	</form>
	
	<input type = "submit" id = "create" value = "Create" onclick = "upload_gallery()">
	
	
	
</div>





