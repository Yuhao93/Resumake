<?
	if(!isset($_COOKIE['uid']))
		setcookie('uid', 1);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Yuhao Phil Ma</title>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap-responsive.css"></link>
	<style type="text/css">
	body{
		padding-top:60px;
	}
	</style>
	<?php 
		include_once('../private/dbObject.php');
		$db = new dbObject;
		$db->connect();
		
		$uid = $_COOKIE['uid'];
		$user = $db->getUserById($uid);
		$user_info = json_decode($user->info);
	?>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<div class="nav-collapse">
					<a class="brand" href="#">
						<?php echo $user->name;?>
					</a>
					<ul class="nav">
						<li><a href="resume">My Resume</a></li>
					</ul>
				</div>
			</div>
		</div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3 columns">
			<div class="page-header">
				<h1><?php echo $user->name;?></h1>
				<a href=""><small><em>"<?php echo $user->quote;?>"</em></small></a>
			</div>
			
			<div class="thumbnail">
				<img src="me.jpg" width="254" height="254" alt="">
				<br>
				<br>
				<center>
					<a class="btn btn-primary" href="">Change Profile Picture</a>
				</center>
				<br>
			</div>
			<br>
			<div class="well">
				<p><h4>Personal Information</h4></p>
				<p><h5>&nbsp;&nbsp;Age: <?php echo $user_info->{'age'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Birthday: <?php echo $user_info->{'birthday'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Gender: <?php echo $user_info->{'gender'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Occupation: <?php echo $user_info->{'occupation'}?></h5></p>
				<br>
				
				
				<p><h4>Contact Information</h4></p>
				<p><h5>&nbsp;&nbsp;Address: <?php echo $user_info->{'address'}?></h5></p>
				<p><h5>&nbsp;&nbsp;City: <?php echo $user_info->{'city'}?></h5></p>
				<p><h5>&nbsp;&nbsp;State: <?php echo $user_info->{'state'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Zip Code: <?php echo $user_info->{'zip'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Email: <a href="mailto:ypma@uci.edu"><?php echo $user_info->{'email'}?></a></h5></p>
				<p><h5>&nbsp;&nbsp;Phone Number: <?php echo $user_info->{'phone'}?></h5></p>
				<br>
				<a class="btn btn-primary btn-large" href="">Edit My Information</a>
				
				<br>
			</div>
        </div>	
        <div class="span9 fixed-inbox">
			<table class="table table-striped">
				<thead>
					<th>Profile</th>
					<th>From</th>
					<th>Subject</th>
					<th>Date</th>
				</thead>
				<tr>
					<td><img src="me.jpg" width="32" height="32"></td>
					<td><a href="">Yuhao Phil Ma</a></td>
					<td>A Job Offer</td>
					<td>June 12 2012 8:00pm</td>
				</tr>
				<tr>
					<td><img src="me.jpg" width="32" height="32"></td>
					<td><a href="">Yuhao Phil Ma</a></td>
					<td>A Job Offer</td>
					<td>June 11 2012 8:00pm</td>
				</tr>
				<tr>
					<td><img src="me.jpg" width="32" height="32"></td>
					<td><a href="">Yuhao Phil Ma</a></td>
					<td>A Job Offer</td>
					<td>June 10 2012 8:00pm</td>
				</tr>
				<tr>
					<td><img src="me.jpg" width="32" height="32"></td>
					<td><a href="">Yuhao Phil Ma</a></td>
					<td>A Job Offer</td>
					<td>June 9 2012 8:00pm</td>
				</tr>
				<tr>
					<td><img src="me.jpg" width="32" height="32"></td>
					<td><a href="">Yuhao Phil Ma</a></td>
					<td>A Job Offer</td>
					<td>June 8 2012 8:00pm</td>
				</tr>
			</table>
		</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	});
	</script>
</body>