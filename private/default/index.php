<!--
  --  User index template
  -->

<?php
	$uid;
	$fileUploaded = false;
	$fileError = false;
	session_start();
	if(!isset($_COOKIE['remember']) && !isset($_SESSION['uid'])){
		header('Location: /');
	}else{
		$uid = $_SESSION['uid'];
	}
	include_once('private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
	$username = str_replace('.php', '', basename(__FILE__));
	$user = $db->getUserByUsername($username);
		
	if($user)		
		$user_info = json_decode($user->info);
	else $user_info = json_decode('{}');

	if(sizeof($_FILES) != 0){
		$name = $_FILES['img']['name'];
		$tmp = $_FILES['img']['tmp_name'];
		$a = getimagesize($tmp);
		$image_type = $a[2];
		if($image_type == 6 || ($image_type > 0 && $image_type < 4)){
			$fileError = false;
		}else $fileError = true;
		
		if(!$fileError){
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			include('private/php_scripts/SimpleImage.php');
			$newpath = 'imgs/' . $username . '.' . $ext;
			move_uploaded_file($tmp,$newpath);
			$fileUploaded = true;

			$image = new SimpleImage();
			$image->load($newpath);
			$width_ratio = 512/$image->getWidth();
			$height_ratio = 512/$image->getHeight();

			if($width_ratio < 1 && $height_ratio < 1){
				if($width_ratio > $height_ratio)
					$image->resizeToHeight(512);
				else $image->resizeToWidth(512);
			}else if($width_ratio < 1){
				$image->resizeToWidth(512);
			}else if($height_ratio < 1){
				$image->resizeToHeight(512);
			}else{
				$noneed = true;
			}
			if(!$noneed){
				$image->save($newpath);
			}
		}
	}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title><?php echo $user->name?></title>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap-responsive.css"></link>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/jquery.Jcrop.min.js"></script>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/jquery.Jcrop.css"></link>
	
	<style type="text/css">
	body{
		padding-top:60px;
	}
	img{
		max-width:none;
	}
	</style>
</head>
<body>
	<center><div class="modal hide span12" id="editimagemodal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Crop Your Profile Image</h3>
		</div>
		<div class="modal-body row">
			<div class="span6" style="width:254px;height:254px;overflow:hidden;">
				<?php 
					if($fileUploaded && !$fileError){
						echo '<img src="' . $newpath . '" id="image-preview"/>';
					}
				?>
			</div>
			<div class="span6">
				<?php 
					if($fileUploaded && !$fileError){
						echo '<img src="' . $newpath . '" id="preview-large"/>';
					}
				?>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Cancel</a>
			<a href="#" class="btn btn-primary" data-dismiss="modal">Done</a>
		</div>
	</div> 
	</center>
	
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<div class="nav-collapse">
					<a class="brand" href="#">
						<?php echo $user->name?>
					</a>
				</div>
				<ul class="nav pull-right">
					<li><a href='#' id='btn-logout'>Logout</a></li>
				</ul>
			</div>
		</div>
    </div>

    <div class="container-fluid">
		
		<div class="row-fluid">
			<div class="span3 columns">
				<div class="page-header">
					<h1><?php echo $user->name;?></h1>
				</div>
		
				<div class="thumbnail">
					<img src="private/default/me.jpg" width="254" height="254" alt="">
					<br>
					<br>
					<center>
						<a class="btn btn-primary" href="#picture-modal" data-toggle="modal">Change Profile Picture</a>
					</center>
					<br>
				</div>
				<br>
				<div class="well">
					<p><h4>Personal Information</h4></p>
					<p><h5 id='info-age'>&nbsp;&nbsp;Age: <?php if($user_info)echo $user_info->{'age'}?></h5></p>
					<p><h5 id='info-birthday'>&nbsp;&nbsp;Birthday: <?php if($user_info)echo $user_info->{'birthday'}?></h5></p>
					<p><h5 id='info-gender'>&nbsp;&nbsp;Gender: <?php if($user_info)echo $user_info->{'gender'}?></h5></p>
					<p><h5 id='info-occupation'>&nbsp;&nbsp;Occupation: <?php if($user_info)echo $user_info->{'occupation'}?></h5></p>
					<br>
			
				
					<p><h4>Contact Information</h4></p>
					<p><h5 id='info-address'>&nbsp;&nbsp;Address: <?php if($user_info)echo $user_info->{'address'}?></h5></p>
					<p><h5 id='info-city'>&nbsp;&nbsp;City: <?php if($user_info)echo $user_info->{'city'}?></h5></p>
					<p><h5 id='info-state'>&nbsp;&nbsp;State: <?php if($user_info)echo $user_info->{'state'}?></h5></p>
					<p><h5 id='info-zip'>&nbsp;&nbsp;Zip Code: <?php if($user_info)echo $user_info->{'zip'}?></h5></p>
					<p><h5>&nbsp;&nbsp;Email: <a id='info-email' href="mailto:<?php if($user_info)echo $user_info->{'email'} ?>"><?php if($user_info)echo $user_info->{'email'}?></a></h5></p>
					<p><h5 id='info-phone'>&nbsp;&nbsp;Phone Number: <?php if($user_info)echo $user_info->{'phone'}?></h5></p>
					<br>
					<a class="btn btn-primary btn-large" href="#infomodal" id="editinfo" data-toggle="modal">Edit My Information</a>
					<br>
				</div>
			</div>	
			<div class="span9 fixed-inbox">
				<div class="modal hide" id="picture-modal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h3>Upload Your Profile Picture</h3>
					</div>
					<div class="modal-body">
						<form class="well" enctype="multipart/form-data" action="<?php echo $username . '.php'?>" method="post">
							<input type="file" name="img"/>
							<br>
							<input type="submit" name="submit" value="submit" class="btn btn-primary"/>
						</form>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Cancel</a>
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
						<a href="#" class="btn btn-primary" id="confirm-info" data-dismiss="modal">Save</a>
					</div>
				</div>
			
				<h3>My Resumes</h3>
				<a href="#" class="btn-primary btn btn-large">Add New Resume</a>
				<table class="table table-striped">
					<thead>
						<th>Resume</th>
						<th>For</th>
						<th>Created On</th>
						<th>Description</th>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	function showPreview(coords){
		if (parseInt(coords.w) > 0){
			var rx = 254 / coords.w;
			var ry = 254 / coords.h;

			jQuery('#image-preview').css({
				width: Math.round(rx * $('#preview-large').css('width').split("px")[0]) + 'px',
				height: Math.round(ry * $('#preview-large').css('height').split("px")[0]) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
		}
	}
	$(document).ready(function(){
		<?php 
			if($fileUploaded && !$fileError){
				echo "$('#editimagemodal').modal('show');";
				echo "jQuery(function(){";
				echo "  jQuery('#preview-large').Jcrop({onChange: showPreview,onSelect: showPreview,aspectRatio: 1});";
				echo "});";
			}
		 ?>
		 
		$("#btn-logout").click(function(){
			$.post('private/php_scripts/logout.php', function(data){
				window.location.href = '/';
			});
		});
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
		$("#confirm-info").click(function(){
			info.age = $("#modal-age").attr('value');
			info.birthday = $("#modal-birthday").attr('value');
			info.gender = $("#modal-gender").attr('value');
			info.occupation = $("#modal-occupation").attr('value');
			info.address = $("#modal-address").attr('value');
			info.city = $("#modal-city").attr('value');
			info.state = $("#modal-state").attr('value');
			info.zip = $("#modal-zipcode").attr('value');
			info.email = $("#modal-email").attr('value');
			info.phone = $("#modal-phonenumber").attr('value');
			$.post('private/php_scripts/updateInfo.php', {'uid':uid, 'info':info}, function(data) {
				$('#info-age').html('&nbsp&nbspAge: ' + info.age);
				$('#info-birthday').html('&nbsp&nbspBirthday: ' + info.birthday);
				$('#info-gender').html('&nbsp&nbspGender: ' + info.gender);
				$('#info-occupation').html('&nbsp&nbspOccupation: ' + info.occupation);
				$('#info-address').html('&nbsp&nbspAddress: ' + info.address);
				$('#info-city').html('&nbsp&nbspCity: ' + info.city);
				$('#info-state').html('&nbsp&nbspState: ' + info.state);
				$('#info-zip').html('&nbsp&nbspZip: ' + info.zip);
				$('#info-email').attr('href', 'mailto:' + info.email);
				$('#info-email').html(info.email);
				$('#info-phone').html('&nbsp&nbspPhone Number: ' + info.phone);
			});
		});
	});
	var info = <?php if($user_info)echo $user->info;else echo '{}' ?>;
	var uid = <?php echo $uid ?>;
	</script>
</body>
