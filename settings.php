<!DOCTYPE HTML>

<?php
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
    <div class="container span12">
        
		<ul class="nav nav-tabs nav-stacked">
            <li><a href="#" data-toggle="collapse" data-target="#passwordmenu" 
                onclick="$('#usernamemenu').collapse('hide');$('#removemenu').collapse('hide');">Change My Password</a></li>
            <li><div class="container span12 collapse in" id="passwordmenu">
                <br>
                <p>Click on the button below to send an email. In the email, there will be a code. Enter in your new password and the code below.</p>
                <a href="#" class="btn btn-primary">Send Email</a>
                <br>
                <p>Code</p>
                <input type="text">
                <p>New Password</p>
                <input type="password">
                <br>
                <a href="#" class="btn btn-primary">Change Password</a>
            </div></li>
        </ul>
        
        <ul class="nav nav-tabs nav-stacked"
            onclick="$('#passwordmenu').collapse('hide');$('#removemenu').collapse('hide');">
            <li><a href="#" data-toggle="collapse" data-target="#usernamemenu">Change My Username</a></li>
            <li><div class="container span12 collapse in" id="usernamemenu">
                <br>
                <p>Enter in your new username</p>
                <input type="text">
                <br>
                <a href="#" class="btn btn-primary">Change Username</a>
            </div></li>
        </ul>
        
        <ul class="nav nav-tabs nav-stacked"
            onclick="$('#usernamemenu').collapse('hide');$('#passwordmenu').collapse('hide');">
            <li><a href="#" data-toggle="collapse" data-target="#removemenu">Remove My Account</a></li>
            <li><div class="container span12 collapse in" id="removemenu">
                <br>
                <p>Are you sure? We're sad to see you go, but if you want to remove your account, enter in your password to confirm.</p>
                <input type="password">
                <br>
                <a href="#" class="btn btn-primary">Delete My Account</a>
            </div></li>
        </ul>
        
	</div>
    
    
    
    
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
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
