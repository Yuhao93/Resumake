<?php
	session_start();
	$user_not_found = false;
	$user_already_registered = false;
	
	include_once('private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
	
	$get_id = $_GET['id'];
	$user = $db->getUserByConfirmationCode($get_id);
	if(!$user)
		$user_not_found = true;
	else if($user->is_confirmed){
		$user_already_registered = true;
	}else{
		$uid = $user->uid;
		$db->confirmUser($uid);
		$_SESSION['uid'] = $uid;
	}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Resumake | Online Resumes</title>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap-responsive.css"></link>
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
		<div class="span10 offset2">
		<div class="hero-unit">
		<?php 
			if($user_not_found)
				echo "<h1>We Can't Seem To Find Your Account</h1><h2>Sorry</h2>";
			else if($user_already_registered)
				echo "<h1>You Are Already Registered!</h1><h2>You Can't Re-Register</h2>";
			else if(!$user_not_found && !$user_already_registered)
				echo '<h1>Congratulations ' . $user->name . '!</h1><h2>You Are Now Registered!</h2>';
			?>
		</div>
		</div>
	</div>
	
	<?php 
		if(!$user_not_found)
			echo '<div class="row"><div class="span8 offset2"><h2>You\'ll be redirected to your homepage in a few seconds</h2></div></div><br><div class="row"><div class="span8 offset2"><h2>Or Go Now </h2><a class="btn btn-primary btn-large" href="/' . $user->username . '">Go To Your Homepage</a></div></div>';
		else echo '<div class="row"><div class="span8 offset2"><h2>You\'ll be redirected to the homepage in a few seconds</h2></div></div><br><div class="row"><div class="span8 offset2"><h2>Go Back To The Homepage</h2><a class="btn btn-primary btn-large" href="/">Go Home</a></div></div>';
	?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout('redirect()', 3500);
		});
		function redirect(){
			window.location.href = '<?php
				if($user_not_found)
					echo '/';
				else
					echo '/' . $user->username;
			?>';
		}
	</script>
</body>
