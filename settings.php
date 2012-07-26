<!DOCTYPE HTML>

<?php
    session_start();
    //If you are not logged in, go to the main page
	if(!isset($_COOKIE['remember']) && !isset($_SESSION['uid'])){
		header('Location: /');
	}else{
        //set the session cookie if it is not set
        if(!isset($_SESSION['uid']))
            $_SESSION['uid'] = $_COOKIE['remember'];
		$uid = $_SESSION['uid'];
        
        //Get the user from the session id
        include_once('private/php_scripts/dbObject.php');
        $db = new dbObject;
        $db->connect();
        $user = $db->getUserById($uid);
        $username = $user->username;
	}
?>
<html lang="en">
<head>
	<title>Settings</title>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap-responsive.css"></link>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<style type="text/css">
	body{
		padding-top:60px;
	}
	</style>
</head>
<body>
	
	
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<div class="nav-collapse">
					<a class="brand" href="/users/<?php echo $username?>">
						<?php echo $user->name?>
					</a>
				</div>
			</div>
		</div>
    </div>
    <center>
    <h1>Settings</h1>
    </center>
    
    <div class="modal hide" id="message-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h1 id="message-title"></h1>
        </div>
        <div class="modal-body">
            <h2 id="message-body"></h2>
        </div>
        <div class="modal-footer">
            <a href="" class="btn" data-dismiss="modal">Okay</a>
        </div>
    </div>
    
    <div class="container span12">
        
		
        <ul class="nav nav-tabs nav-stacked">
            <li><a href="#" data-toggle="collapse" data-target="#passwordmenu" 
                onclick="$('#usernamemenu').collapse('hide');$('#removemenu').collapse('hide');">Change My Password</a></li>
            <li><div class="container span12 collapse in" id="passwordmenu">
                <br>
                <p>Click on the button below to send an email. In the email, there will be a code. Enter in your new password and the code below.</p>
                <a href="#" class="btn btn-primary" id="settings-send-email">Send Email</a>
                <br>
                <br>
                <div id="change-password-container"></div>
                <br>
                <p>Code</p>
                <input type="text" id="settings-password-code">
                <p>New Password</p>
                <input type="password" id="settings-new-password">
                <br>
                <a href="#" class="btn btn-primary" id="settings-change-password">Change Password</a>
            </div></li>
        </ul>
        
        <ul class="nav nav-tabs nav-stacked"
            onclick="$('#passwordmenu').collapse('hide');$('#removemenu').collapse('hide');">
            <li><a href="#" data-toggle="collapse" data-target="#usernamemenu">Change My Username</a></li>
            <li><div class="container span12 collapse in" id="usernamemenu">
                <br>
                <br>
                <div id="change-username-container"></div>
                <br>
                <p>Enter in your new username</p>
                <input type="text" id="settings-new-username">
                <br>
                <a href="#" class="btn btn-primary" id="settings-change-username">Change Username</a>
            </div></li>
        </ul>
        
        <ul class="nav nav-tabs nav-stacked"
            onclick="$('#usernamemenu').collapse('hide');$('#passwordmenu').collapse('hide');">
            <li><a href="#" data-toggle="collapse" data-target="#removemenu">Remove My Account</a></li>
            <li><div class="container span12 collapse in" id="removemenu">
                <br>
                <br>
                <div id="delete-account-container"></div>
                <br>
                <p>Are you sure? We're sad to see you go, but if you want to remove your account, enter in your password to confirm.</p>
                <input type="password" id="settings-delete-password">
                <br>
                <a href="#" class="btn btn-primary" id="settings-delete-account">Delete My Account</a>
            </div></li>
        </ul>
        
	</div>
    
    
    
    <?php include "private/php_scripts/encryption.php" ?>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("#passwordmenu").collapse("hide");
        $("#removemenu").collapse("hide");
        $("#usernamemenu").collapse("hide");
        
        $("#settings-send-email").click(function(){
            $.post("/private/php_scripts/settings.php", {'request':'sendEmail', 'uid':uid}, function(data){
                $("#message-title").html("Okay");
                $("#message-body").html("An email has been sent.");
                $("#message-modal").modal('show');
            });
        });
        
        $("#settings-change-password").click(function(){
            if($("#settings-password-code").attr("value") == ""){
                $("#change-password-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button>'
                    + '<strong>Wait! </strong> You need to enter in the code that was emailed to you.</div>');
                return;
            }
            if($("#settings-new-password").attr("value") == ""){
                $("#change-password-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button>' 
                    + '<strong>Wait! </strong> You need to enter in a new password.</div>');
                return;
            }
            alert(encrypt($("#settings-new-password").attr("value")));
            $.post("/private/php_scripts/settings.php", {'request':'changePassword', 
                'uid':uid, 'password':encrypt($("#settings-new-password").attr("value")), 'code':$("#settings-password-code").attr("value")}, function(data){
                $("#message-title").html("Okay");
                $("#message-body").html("Your password has been changed");
                $("#message-modal").modal('show');
            });
        });
        
        $("#settings-change-username").click(function(){
            if($("#settings-new-username").attr("value") == ""){
                $("#change-username-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button>'
                    + '<strong>Wait! </strong> You need to enter in  new username.</div>');
                return;
            }
            $.post("/private/php_scripts/settings.php", {'request':'changeUsername', 'uid':uid, 'username':$("#settings-new-username").attr("value")}, function(data){
                alert(data);
            });
        });
        
        $("#settings-delete-account").click(function(){
            if($("#settings-delete-password").attr("value") == ""){
                $("#delete-account-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button>'
                    + '<strong>Wait! </strong> You need to enter in your password.</div>');
                return;
            }
            $.post("/private/php_scrips/settings.php", {'request':'delete', 'uid':uid, 'password':encrypt($("#settings-delete-password").attr("value"))}, function(data){
                window.location.href="/";
            });
        });
        
        
        var uid = '<?php echo $uid?>';
    </script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-33395111-1']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
</body>
</html>
