<?php
	include_once('private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
	$user = $db->getUserByUsername(str_replace('.php', '', basename(__FILE__)));
		
	if($user)		
		$user_info = json_decode($user->info);
	else $user_info = json_decode('{}');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title><?php echo $user->name?></title>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap-responsive.css"></link>
	
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
					<a class="brand" href="#">
						<?php echo $user->name?>
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
				<a href="#quotemodal" data-toggle="modal"><small><em><?php if($user->quote == '') echo '"[Add Quote]"';	else echo '"' . $user->quote . '"';?></em></small></a>
			</div>
			
			<div class="thumbnail">
				<img src="private/default/me.jpg" width="254" height="254" alt="">
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
				<p><h5>&nbsp;&nbsp;Age: <?php if($user_info)echo $user_info->{'age'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Birthday: <?php if($user_info)echo $user_info->{'birthday'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Gender: <?php if($user_info)echo $user_info->{'gender'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Occupation: <?php if($user_info)echo $user_info->{'occupation'}?></h5></p>
				<br>
				
				
				<p><h4>Contact Information</h4></p>
				<p><h5>&nbsp;&nbsp;Address: <?php if($user_info)echo $user_info->{'address'}?></h5></p>
				<p><h5>&nbsp;&nbsp;City: <?php if($user_info)echo $user_info->{'city'}?></h5></p>
				<p><h5>&nbsp;&nbsp;State: <?php if($user_info)echo $user_info->{'state'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Zip Code: <?php if($user_info)echo $user_info->{'zip'}?></h5></p>
				<p><h5>&nbsp;&nbsp;Email: <a href="mailto:<?php if($user_info)echo $user_info->{'email'} ?>"><?php if($user_info)echo $user_info->{'email'}?></a></h5></p>
				<p><h5>&nbsp;&nbsp;Phone Number: <?php if($user_info)echo $user_info->{'phone'}?></h5></p>
				<br>
				<a class="btn btn-primary btn-large" href="#infomodal" id="editinfo" data-toggle="modal">Edit My Information</a>
				
				<br>
			</div>
        </div>	
        <div class="span9 fixed-inbox">
			<div class="modal hide" id="quotemodal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>Edit Your Quote</h3>
				</div>
				<div class="modal-body">
					<form class="well">
						<textarea style="resize:none" rows="3" class="span12 input-xlarge" id="modal-quote"></textarea>
					</form>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Cancel</a>
					<a href="#" class="btn btn-primary">Save</a>
				</div>
			</div>
			
			<div class="modal hide" id="infomodal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>Edit Your Information</h3>
				</div>
				<div class="modal-body">
					<form class="well">
						<h2>Personal Information</h2>
						<label>Age</label>
						<input type="text" class="span5" id="modal-age">
						<label>Birthday</label>
						<input type="date" class="span5" id="modal-birthday">
						<label>Gender</label>
						<select class="span5" id="modal-gender">
							<option>Male</option>
							<option>Female</option>
						</select>
						<label>Occupation</label>
						<input type="text" class="span5" id="modal-occupation">
						
						<h2>Contact Information</h2>
						<label>Address</label>
						<input type="text" class="span5" id="modal-address">
						<label>City</label>
						<input type="text" class="span5" id="modal-city">
						<label>State</label>
						<select class="span5" id="modal-state">
							<option></option>
							<option>Alabama</option>
							<option>Alaska</option>
							<option>Arizona</option>
							<option>Arkansas</option>
							<option>California</option>
							<option>Colorado</option>
							<option>Connecticut</option>
							<option>Delaware</option>
							<option>Florida</option>
							<option>Georgia</option>
							<option>Hawaii</option>
							<option>Idaho</option>
							<option>Illinois</option>
							<option>Indiana</option>
							<option>Iowa</option>
							<option>Kansas</option>
							<option>Kentucky</option>
							<option>Louisiana</option>
							<option>Maine</option>
							<option>Maryland</option>
							<option>Massachusetts</option>
							<option>Michigan</option>
							<option>Minnesota</option>
							<option>Mississippi</option>
							<option>Missouri</option>
							<option>Montana</option>
							<option>Nebraska</option>
							<option>Nevada</option>
							<option>New Hampshire</option>
							<option>New Jersey</option>
							<option>New Mexico</option>
							<option>New York</option>
							<option>North Carolina</option>
							<option>North Dakota</option>
							<option>Ohio</option>
							<option>Oklahoma</option>
							<option>Oregon</option>
							<option>Pennsylvania</option>
							<option>Rhode Island</option>
							<option>South Carolina</option>
							<option>South Dakota</option>
							<option>Tennessee</option>
							<option>Texas</option>
							<option>Utah</option>
							<option>Vermont</option>
							<option>Virginia</option>
							<option>Washington</option>
							<option>West Virginia</option>
							<option>Wisconsin</option>
							<option>Wyoming</option>
						</select>
						<label>Zip Code</label>
						<input type="text" class="span5" id="modal-zipcode">
						<label>Email</label>
						<input type="text" class="span5" id="modal-email">
						<label>Phone Number</label>
						<input type="text" class="span5" id="modal-phonenumber">
					
					</form>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Cancel</a>
					<a href="#" class="btn btn-primary">Save</a>
				</div>
			</div>
			
			
			<table class="table table-striped">
				<thead>
					<th>Profile</th>
					<th>From</th>
					<th>Subject</th>
					<th>Date</th>
				</thead>
			</table>
		</div>
		</div>
	</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#editinfo").modal({'show':false});
		$("#infomodal").on('show', function(){
			$("#modal-age").attr('value', info.age);
			$("#modal-birthday").attr('value', info.birthday);
			$("#modal-gender").attr('value', info.gender);
			$("#modal-occupation").attr('value', info.occupation);
			$("#modal-address").attr('value', info.address);
			$("#modal-city").attr('value', info.city);
			$("#modal-state").attr('value', info.state);
			$("#modal-zipcode").attr('value', info.zip);
			$("#modal-email").attr('value', info.email);
			$("#modal-phonenumber").attr('value', info.phone);
		});
		$("#quotemodal").on('show', function(){
			$("#modal-quote").attr('value', quote);
		});
	});
	var info = <?php if($user_info)echo $user->info;else echo '{}' ?>;
	var quote = <?php if($user_info)echo '"' . $user->quote . '"'; ?>;
	</script>
</body>