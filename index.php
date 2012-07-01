<!--
  --  Resumake Front Page	
  -->

<?php
	session_start();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Resumake | Online Resumes</title>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap-responsive.css"></link>
	<style type="text/css">
	</style>
	
</head>
<body>
	<br>
	<div class="row">
		<div class="page-header">
			<h1 class="offset1">
			<img src="private/imgs/logo.png"></img>
			<small>Here's an idea, let's give everyone an online resume, for free.</small>
			</h1>
		</div>
	</div>
	<br>
	
	<div class="row">
		<div class="modal hide" id="registermodal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Register | The Right Thing To Do</h3>
			</div>
			<div class="modal-body">
				<form class="well">
					
					<label id="register-modal-name-label">Name</label>
					<input type="text" class="span5" placeholder="Name" id="register-modal-name">
				
					<label id="register-modal-email-label">Email</label>
					<input type="text" class="span5" placeholder="Email" id="register-modal-email">
					
					<label id="register-modal-username-label">Username</label>
					<input type="text" class="span5" placeholder="Username" id="register-modal-username">
					
					<label id="register-modal-password-label">Password</label>
					<input type="password" class="span5" placeholder="Password" id="register-modal-password">
					
					<label>Confirm Password</label>
					<input type="password" class="span5" placeholder="Confirm Password" id="register-modal-confirm">
					
				</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" id="register-modal-cancel">Close</a>
				<a href="#messagemodal" class="btn btn-primary" id="register-modal-submit">Register</a>
			</div>
		</div>
		
		<div class="modal hide" id="messagemodal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Thanks For Registering</h3>
			</div>
			<div class="modal-body">
				<h2>You should recieve an email soon!</h2>
				<h3>Please follow the instructions in the email to confirm your account</h3>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" id="register-modal-cancel">Close</a>
			</div>
		</div>
		
		<div class="span6 offset2 columns">
			<div id="carousel" class="carousel slide">
				<div class="carousel-inner">
					<div class="item active">
						<img src="private/imgs/home1.png" alt="">
						<div class="carousel-caption">
							<h4>Bringing resume websites to the masses</h4>
							<p>Now you don't need to know how to make a website to have an online resume. You don't need your own webspace either. Making a website resume is tricky, if you don't do it right, it can be unattractive. Luckily, resumake is here to make a professional looking website resume for you, for free.</p>
						</div>
					</div>
					
					<div class="item">
						<img src="private/imgs/home2.png" alt="">
						<div class="carousel-caption">
							<h4>Create a professional resume website in minutes</h4>
							<p>Make an online copy of a resume in minutes. Upload the information you want to include in your resume; resumake does the rest. No web programming needed. Bring your resume into the modern age and impress your future employers with a neat and professional looking online resume.</p>
						</div>
					</div>
					
					<div class="item">
						<img src="private/imgs/home3.png" alt="">
						<div class="carousel-caption">
							<h4>Powered by Twitter's powerful Bootstrap API</h4>
							<p>Twitter's Bootstrap API is a service offered by Twitter. It can be used to make a website look sleek, innovative, and professional. By utilizing this webservice, we can do the same to your online resume. Your resume will be formatted into a web template that implements Bootstrap, making it and you look great.</p>
						</div>
					</div>
				</div>
				<a class="left carousel-control" href="#carousel" data-slide="prev">&lsaquo;</a>
				<a class="right carousel-control" href="#carousel" data-slide="next">&rsaquo;</a>
			</div>
		</div>
		
		<div class="span4 well">
			<h2>Login</h2>
			<form>
				<br>
				<p>Email</p>
				<input type="text" class="span3" placeholder="email" id="login-email">
				<br>
				<p>Password</p>
				<input type="password" class="span3" placeholder="password" id="login-pass">
				<br>
				<a href="#" class="btn btn-primary btn-large" id="login-submit">Login</a>
			</form>
			<br>
			<br>
			
			<h2>Or Get Started And Register</h2>
			<a id="register-btn" href="#registermodal" data-toggle="modal" class="btn btn-primary btn-large">Register</a>
			
		</div>
		
	</div>
	<?php include "private/php_scripts/encryption.php" ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	function submit_register(){
		var isOk = true;
		$(".removable-alert").remove();
		var name = $("#register-modal-name").attr("value")
		var username = $("#register-modal-username").attr("value")
		var password = encrypt($("#register-modal-password").attr("value"));
		var confirm = encrypt($("#register-modal-confirm").attr("value"));
		var email = $("#register-modal-email").attr("value")
		
		
		//Check for errors
		if(name.length == 0){
			$("<div class='alert alert-error removable-alert'>" + 
				"<strong>Oh No!</strong> Your name is empty" + 
				"</div>").insertAfter("#register-modal-name-label");
			isOk = false;
		}
		
		if(username.length == 0){
			$("<div class='alert alert-error removable-alert'>" + 
				"<strong>Oh No!</strong> Your username is empty" + 
				"</div>").insertAfter("#register-modal-username-label");
			isOk = false;
		}
		
		if($("#register-modal-password").attr("value").length == 0){
			$("<div class='alert alert-error removable-alert'>" + 
				"<strong>Oh No!</strong> Your password is empty" + 
				"</div>").insertAfter("#register-modal-password-label");
			isOk = false;
		}else if(password != confirm){
			$("<div class='alert alert-error removable-alert'>" + 
				"<strong>Oh No!</strong> Your passwords don't seem to match" + 
				"</div>").insertAfter("#register-modal-password-label");
			isOk = false;
		}
		
		if(email.length == 0){
			$("<div class='alert alert-error removable-alert'>" + 
				"<strong>Oh No!</strong> Your email is empty" + 
				"</div>").insertAfter("#register-modal-email-label");
			isOk = false;
		}else if(email.indexOf("@") == -1){
			$("<div class='alert alert-error removable-alert'>" + 
				"<strong>Oh No!</strong> Your email doesn't seem valid" + 
				"</div>").insertAfter("#register-modal-email-label");
			isOk = false;
		}
		
		//If there are no errors, test to see if there are any conflicts in the database
		//If there aren't any, the user has been created, lead the user to the page
		if(isOk){
			$.post('private/php_scripts/register.php', {'name':name, 'username':username, 'password':password, 'email':email}, function(data) {
				var results = eval('(' + data + ')');
				var errors = results.errors;
				if(errors.length != 0){
					for(var i = 0; i < errors.length; i++){
						if(errors[i] == 'username'){
							$("<div class='alert alert-error removable-alert'><strong>Oh No!</strong> Your username has been taken</div>").insertAfter("#register-modal-username-label");
						}else if(errors[i] == 'email'){
							$("<div class='alert alert-error removable-alert'><strong>Oh No!</strong> Your email has already been taken</div>").insertAfter("#register-modal-email-label");
						}
					}
				}else{
					$("#registermodal").modal('hide');
					$("#messagemodal").modal('show');
				}
			});
		}
	}
	$(document).ready(function(){
		$("#carousel").carousel({'interval':12000});
		$("#register-btn").modal({'show':false});
		$("#registermodal").on('hide', function(){
			$(".removable-alert").remove();
		});
		
		//When the register submit button is clicked
		$("#register-modal-submit").click(function(){
			submit_register();
		});
		
		$("#login-submit").click(function(){
			var login = $("#login-email").attr("value");
			var pass = encrypt($("#login-pass").attr("value"));
			$.post('private/php_scripts/login.php', {'email':login, 'password':pass}, function(data){
				var response = eval('(' + data + ')');
				if(response.result == 'pass'){
					var username = response.username;
					window.location.href = '/' + username;
				}else if(response.result == 'fail'){
					
				}
			});
		});
	});
	
	//On Enter key press
	$('#register-modal-password').keypress(function(e) {
        if(e.which==13){
            submit_register();
        }
	});
	$('#register-modal-confirm').keypress(function(e) {
        if(e.which==13){
            submit_register();
        }
	});
	</script>
</body>
