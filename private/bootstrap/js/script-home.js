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
	
	function submit_login(){
		var login = $("#login-email").attr("value");
		var pass = encrypt($("#login-pass").attr("value"));
		var remember = $("#login-remeber").attr("checked");
		$.post('private/php_scripts/login.php', {'email':login, 'password':pass, 'remember':remember}, function(data){
			var response = eval('(' + data + ')');
			if(response.result == 'pass'){
				var username = response.username;
				window.location.href = '/' + username;
			}else if(response.result == 'fail'){
				$('<div class="alert alert-error"><button class="close" data-dismiss="alert">×</button><strong>Oh No!</strong> Login Failed</div>').insertAfter("#login-submit");
			}
		});
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
			submit_login();
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
	$('#login-pass').keypress(function(e){
		if(e.which == 13){
			submit_login();
		}
	});