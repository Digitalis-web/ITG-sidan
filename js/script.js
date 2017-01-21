
window.onload = function () { 
	
	
	init();
	
	function init(){
		load_components();
		init_center_vertical();
		init_center_hori();
		init_center_text_vertical();	
		init_post_images();
		
		//toggle_form(false);
	}
	
	
	window.onresize = function(event) {
		init_center_vertical();
		init_center_hori();
		init_center_text_vertical();
	};
	
	function load_components(){
		//	document.getElementById("nav").innerHTML='<object type="text/html" data="nav.php" class ="nav_load_div" ></object>';
		/*
			$( "#nav" ).load( "nav.php",
			function(){
			
			
			});
		*/
		
	}
	
	
	
	function remove_px (string){
		
		var string = string.substring(0, string.length-2);
		return string;
		
	}
	
}



// This will center the post images
function init_post_images()
{
	$(".post_image").each(function(){
		
		var post_image_height = $(this).height(); // gets the height of the image
		var container = $(this).parents(".single_post_container");
		var container_height = $(container).outerHeight();
		var margin = container_height / 2 - post_image_height / 2;
		
		console.log(container);
		
		$(this).css("marginTop", margin + "px");
	});
	
	
}

function init_center_text_vertical(){
	
	var elements = document.getElementsByClassName("center_text_vertical");
	for(var i = 0; i < elements.length; i++){
		element = elements[i];
		parent = element.parentNode;
		
		parent_height = $(parent).height(); 
		console.log(parent);
		console.log(parent_height);
		element.style.lineHeight = parent_height + "px";
		
		
	}
}

function init_center_hori(){
	divs = document.getElementsByClassName("center_hori_js");
	for(var i = 0; i < divs.length; i++){
		div = divs[i];
		parent = div.parentNode;
		
		
		parent_width = $(parent).outerWidth();
		div_width = $(div).outerWidth();
		
		
		margin = parent_width / 2 - div_width / 2;
		
		$(div).css("marginLeft", margin + "px");
		
	}
	
}


function init_center_vertical(){
	
	divs = document.getElementsByClassName("center_vertical");
	for(var i = 0; i < divs.length; i++){
		div = divs[i];
		parent = div.parentNode;
		
		
		//parent_height = remove_px(style_parent.getPropertyValue('height'));
		parent_height = $(parent).outerHeight();
		//div_height = remove_px(style_div.getPropertyValue('height'));
		div_height = $(div).outerHeight();
		
		
		margin = parent_height / 2 - div_height / 2;
		
		
		div.style.marginTop = margin + "px";
	}
	
}







// Gives a div a shake effect. Used when entering wrong password
function shake(div){           
	
	// makes sure the div isn't already shaking
	if($(div).css("left") == "auto" || $(div).css("left") == "0px"){
		var interval = 100;                                                                                                 
		var distance = 10;                                                                                                  
		var times = 4;                                                                                                      
		
		$(div).css('position','relative');                                                                                  
		
		for(var iter=0;iter<(times+1);iter++){                                                                              
			$(div).animate({ 
				left:((iter%2==0 ? distance : distance*-1))
			},interval);                                   
		}//for                                                                                                              
		
		$(div).animate({ left: 0},interval);                                                                                
	}
}

/* This function will load a form from a different page. The login form and the register form will be loaded like this*/
function load_form(page){
	
	el = document.getElementById("form_container");
	
	page = "forms/" + page;
	$("#form_container").load(page,
	
	function(){
		init_center_vertical();
		/*
			form_width = $("#form_container .form").outerWidth();
			form_height = $("#form_container .form").outerHeight();
			
			window_width = $(this).width();
			window_height = $(this).height();
			
			
			
			left = window_width / 2 - form_width / 2;
			var top = window_height / 2 - form_height / 2;
			
			$("#form_container .form").css("marginTop", top);
			$("#form_container .form").css("marginLeft", left);
		*/
		
		init_ajax_validation(); // Initailises all ajax validation functions. This is needed cause new elements have been added to the page.
	}
	
	);
}

var form_shown = false;

// Toggles the form on and off. If the hide argument is true then it means that it should only be toggled off
function toggle_form()
{
	var time = 500;
	
	if (form_shown) {
		$("#form_container").fadeOut(time);
	}
	else
	{
		$("#form_container").fadeIn(time);
	}
	form_shown = !form_shown;
	
}

// Closes the form when the background is clicked
function close_form(e)
{
	e = e || window.event;
	clicked = e.target || e.srcElement; // gets the clicked element
	
	// makes sure that the clicked element is the background and not the form itself
	if(clicked.id == "form_container"){
		toggle_form();
	}
	
}

// Show the form
function open_form()
{
	if(!form_shown)
	{
		toggle_form();
		
	}
}

function open_gallery_form()
{
	load_form("gallery_post_form.php");
	open_form();
}

function open_register_form()
{
	load_form("register_form.php");
	open_form();
}

function open_log_in_form()
{
	load_form("log_in_form.php");
	open_form();
}

// If the meeting varable is 1 then it tells the form-page that the post that is to be created should be of the type 'meeting'
function open_create_post_form(meeting)
{
	load_form("create_post_form.php?meeting="+meeting);
	open_form();
}


function add_image_to_textarea(element)
{
	//element.disabled = true;
	
	var parent = element.parentNode;
	var index = Array.prototype.indexOf.call(parent.children, element) + 1; // gets the index of the input to which an image was added
	
	
	// Gets the new images name. The element.value will return a path to the file. The path string is then split into an array with a backslash
	// as seperator cause the image name itself will be after the last backslash in the string
	var image_path_split = element.value.split("\\"); 
	var image_name = image_path_split[image_path_split.length-1]; // Gets the last index which will be the images name
	
	
	var content_div = $("#content");
	var val = content_div.val();
	
	
	var tag = "\n[image]" + image_name + " | " + index + "[/image]";
	content_div.val(val + tag);
	
	//	prepare_content();
	
}

// This function will be called when ever a change accurs in a intup element for an image.
// At first only one input element will be visible and when this element is chagned (when an image is selected) then another
// input element will be added to the form to allow the user to add mutiple images to one post. 
// The function does this by getting the parrent of the changed element which is a container div
// for all input elements for the images. It then makes sure that there arn't any input elements
// in the container that are already empty, cause it that case there's no need to add another empty file input element
function addImageInput(e){
	e = e || window.event;
	var element = e.target || e.srcElement; // gets the changed element
	
	var parent = element.parentNode;
	
	var inputs = parent.children; // Gets all the file inputs
	
	// Makes sure that you cannot add more than a certain amout of images to your post
	if(inputs.length < 10){ 
		var empty_exists = false;
		// loops through all the input elements and checks if there is an empty one already
		for (var i = 0; i < inputs.length; i++) {
			if(inputs[i].value == ""){
				empty_exists = true;
			}
		}
		// If there isn't an empty one already
		if(!empty_exists){
			newElement = element.cloneNode(true); // Makes a copy of an old input element
			newElement.name = "image" + (inputs.length+1); // Gives the image a unique name
			newElement.value = "";
			parent.appendChild(newElement); // adds a new input element
			init_center_vertical();
			
		}
	}
	
	add_image_to_textarea(element); // Adds the image tag for this image into the textfield
	
}

// This function will be run everytime the content textarea is changed. 
// This function will get all the content from the content textarea and prepares it for the database by replacing all 
// tags and line breaks with custom tags. This is needed cause the PHP wont be able to handle line breaks properly.
// The prepared content input will be stored in the database and will contain certain custom tags that will later be decoded
// back into html tags, such as headers, images and line breaks
function prepare_content(content){
	content = content.replace(/\n/g, "[br]"); // This will replace all the occurrences of "\n"
	
	return content;	
}

// This function will decode the custom tags in a content into html tags 
function decode_content(content, post_id, show_images, limited){
	
	content = content.replace(/\[br\]/g, "<br>"); 
	
	while(content.indexOf("[h]") != -1 && content.indexOf("[/h]") != -1){
		content = content.replace(/\[h\]/g, "<h3>"); 
		content = content.replace(/\[\/h\]/g, "</h3>"); 
	}
	
	// converts cusom image tags to HTML tags
	content = convert_image_tags(content, post_id, show_images);
	
	var row_limit = 8;
	
	if(limited) 
	{
		var row_split = content.split("<br>");
		// Limits the amout of rows
		if(row_split.length > row_limit)
		{
			console.log(row_split.length);
			content = "";
			for (var i = 0; i < row_split.length;i++) {
				if(i < row_limit)
				{
					content +=row_split[i] + "<br>"; 
				}
			}
			
		}
	}
	
	return content;
}

// this function converts the custom tags on in a text into acutal HTML tags
function convert_image_tags(content, post_id, show_images){
	
	// As long as there are still image tags in the content
	while(content.indexOf("[image]") != -1){
		var start_index = content.indexOf("[image]") + 7; // plus seven cause the length of the tag is 7
		var end_index = content.indexOf("[/image]"); 
		
		var image_info = content.substring(start_index, end_index); // Gets the string between the tags
		var whole_tag = content.substring(start_index - 7, end_index + 8); // gets the entire tag
		
		var image_index = image_info.split("|")[1].trim(); // get the index of the image from the info tag
		
		var html_img_tag = "<img src = 'actions/get_post_image.php?post_id=" + post_id + "&index=" +image_index+"'>";
		
		if(show_images){
			content = content.replace(whole_tag, html_img_tag);
		}
		else{
			content = content.replace(whole_tag, "");
		}
		
	}
	
	
	return content;
}




