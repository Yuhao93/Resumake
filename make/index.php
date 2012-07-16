<?php
	session_start();
    
    //If we are not logged in, go to the homepage
    if(!isset($_SESSION['uid']) && !isset($_COOKIE['remember'])){
        header('Location: /');
    }else{
        //If the session is not set but the cookie is, set the session to the cookie
        if(!isset($_SESSION['uid']))
            $_SESSION['uid'] = $_COOKIE['remember'];
        $uid = $_SESSION['uid'];
        include_once('../private/php_scripts/dbObject.php');
        $db = new dbObject;
        $db->connect();
	
        //Get the current user
        $user = $db->getUserById($uid);
        
        //Get the relevant information about the current user
        $name = $user->name;
        $info = json_decode($user->info, true);
        $username = $user->username;
    }
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Resumaker</title>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap-responsive.css"></link>
	
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
					<a class="brand" href="../users/<?php echo $user->username?>">
						<?php echo $user->name?>
					</a>
				</div>
				<ul class="nav pull-right">
					<li><a href='#' id='btn-logout'>Logout</a></li>
				</ul>
			</div>
		</div>
    </div>
    <div class="container">
		<div class="row span12">
			<h1>Resumake Builder</h1>
		</div>
		<div class="row span12">
			<h3 class="span9">Build your resume here</h3>
			<a href="../tutorial/" class="span2 btn btn-primary btn-large" target="_blank">Learn How</a>
			
		</div>
		<div class="row span12">
			<br><br>
		</div>
		<!-------------Basic Information---------------->
		<div class="row span12 well">
			
			<h2>Basic Information</h2>
			<hr>
			<br>
			
			<p class="span1">Resume</p>
			<input class="span3" type="text" placeholder="Resume Name" id="basic-resume" value="[Resume Name]">
			<br>

			<p class="span1">Name</p>
			<input class="span3" type="text" value="<?php echo $name?>" id="basic-name">
			<br>
			
			<p class="span1">Position</p>
			<input class="span3" type="text" id="basic-position">
			<br>
			
			<p class="span1">Statement</p>
			<input class="span3" type="text" id="basic-statement">
			<br>
		</div>
		
		<!-------------Contact Information---------------->
		<div class="row span12 well">
			<h2>Contact Information</h2>
			<hr>
			<br>
			
			<p class="span1">Address</p>
			<input class="span3" type="text" value="<?php echo $info["address"]?>" id="contact-address">
			<br>
			
			<p class="span1">City</p>
			<input class="span3" type="text" value="<?php echo $info["city"]?>" id="contact-city">
			<br>
			
			<p class="span1">State</p>
			<select class="span3" id="contact-state">
				<option></option>
				<?php 
					$stateList = "Alabama-Alaska-Arizona-Arkansas-California-Colorado" . 
						"-Connecticut-Delaware-Florida-Georgia-Hawaii-Idaho-Illinois-" . 
						"Indiana-Iowa-Kansas-Kentucky-Louisiana-Maine-Maryland-Massachusetts" . 
						"-Michigan-Minnesota-Mississippi-Missouri-Montana-Nebraska-Nevada-" . 
						"New Hampshire-New Jersey-New Mexico-New York-North Carolina-" . 
						"North Dakota-Ohio-Oklahoma-Oregon-Pennsylvania-Rhode Island-" . 
						"South Carolina-South Dakota-Tennessee-Texas-Utah-Vermont-" . 
						"Virginia-Washington-West Virginia-Wisconsin-Wyoming";
					$stateArray = split("-", $stateList);
					foreach($stateArray as $state){
						if($state == $info["state"])
							echo "<option selected>$state</option>";
						else echo "<option>$state</option>";
					}
				?>
			</select>
			<br>
			
			<p class="span1">Zip Code</p>
			<input class="span3" type="text" value="<?php echo $info["zip"]?>" id="contact-zip">
			<br>
			
			<p class="span1">Phone Number</p>
			<input class="span3" type="text" value="<?php echo $info["phone"]?>" id="contact-phone">
			<br>
			<br>
			
			<p class="span1">Email</p>
			<input class="span3" type="text" value="<?php echo $info["email"]?>" id="contact-email">
			<br>
		</div>
		
		<!-------------Education Information---------------->
		<div class="row span12 well">
			<h2>Education</h2>
			<hr>
			<div id="education-container">
			</div>
			
			<a href="#education-modal" data-toggle="modal" class="span2 btn btn-large" id="add-education-btn">+ Add An Education</a>
		</div>
		<div class="modal hide" id="education-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Education</h3>
			</div>
			<div class="modal-body">
				<p class="span1">School</p>
				<input class="span3" type="text" id="education-school">
				<br>
			
				<p class="span1">Degree</p>
				<input class="span3" type="text" id="education-degree">
				<br>
			
				<p class="span1">Start Date</p>
				<input class="span3" type="date" id="education-startDate">
				<br>
			
				<p class="span1">End Date</p>
				<input class="span3" type="date" id="education-endDate">
				<br>
			
				<p>Awards</p>
				<ul id="education-award-list">
				</ul>
				
				<a href="#education-award-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add an Award</a>
				
				<div id="education-award-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Award</h5>
						<input type="text" class="span3" id="education-award-name">
						<a href="#education-award-collapse" data-toggle="collapse" class="btn btn-primary btn-small span2" id="education-award-add">Add</a>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancel</a>
				<a href="#" class="btn btn-primary" data-dismiss="modal" id="education-save">Save</a>
			</div>
		</div>
		
		<!-------------Skill Information---------------->
		<div class="row span12 well">
			<h2>Skills</h2>
			<hr>
			<div id="skill-container">
			</div>
			<a href="#skill-modal" class="span2 btn btn-large" data-toggle="modal" id="add-skill-btn">+ Add A Category</a>
		</div>
		<div class="modal hide" id="skill-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Category</h3>
			</div>
			<div class="modal-body">
				<p class="span1">Category</p>
				<input class="span3" type="text" id="skill-category">
				<br>
				<ul id="skill-list">
				</ul>
			
				<a href="#skill-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Skill</a>
				<div id="skill-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Skill Name</h5>
						<input type="text" class="span3" id="skill-name">
						<br>
						<h5>Skill Description</h5>
						<textarea type="text" class="span3" id="skill-desc"></textarea>
						
						<a href="#skill-collapse" data-toggle="collapse" class="btn btn-primary btn-small span2" id="skill-add">Add</a>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancel</a>
				<a href="#" class="btn btn-primary" data-dismiss="modal" id="skill-save">Save</a>
			</div>
		</div>
		
		<!-------------Experience Information---------------->
		<div class="row span12 well">
			<h2>Experience</h2>
			<hr>
			<div id="experience-container"></div>
			<a href="#experience-modal" class="span2 btn btn-large" data-toggle="modal" id="btn-add-experience">+ Add Experience</a>
		</div>
		<div class="modal hide" id="experience-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Experience</h3>
			</div>
			<div class="modal-body">
				<p class="span1">Position</p>
				<input class="span3" type="text" id="experience-position">
				<br>
				
				<p class="span1">Start Date</p>
				<input class="span3" type="date" id="experience-start-date">
				<br>
								
				<p class="span1">End Date</p>
				<input class="span3" type="date" id="experience-end-date">
				<br>
					
				<p class="span1">Group</p>
				<input class="span3" type="text" id="experience-group">
				<br>
				
				<ul id="experience-item-list"></ul>
			
				<a href="#experience-fact-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Fact</a>
				<div id="experience-fact-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Fact</h5>
						<textarea class="span3" id="experience-desc"></textarea>
						
						<a href="#experience-fact-collapse" data-toggle="collapse" class="btn btn-primary btn-small span2" id="experience-fact-add">Add</a>
						<br>
						<br>
						<br>
					</div>
				</div>
				<br><br>
				<a href="#experience-link-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Link</a>
				<div id="experience-link-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Link Name</h5>
						<input type="text" class="span3" id="experience-link-name">
						<br>
						<h5>Link</h5>
						<input type="text" class="span3" id="experience-link">
						
						<a href="#experience-link-collapse" data-toggle="collapse" class="btn btn-primary btn-small span2" id="experience-link-add">Add</a>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancel</a>
				<a href="#" class="btn btn-primary" data-dismiss="modal" id="experience-save">Save</a>
			</div>
		</div>
		
		<!-------------Activity Information---------------->
		<div class="row span12 well">
			<h2>Activity</h2>
			<hr>
			<div id="activity-container"></div>
			<a href="#activity-modal" class="span2 btn btn-large" data-toggle="modal" id="btn-add-activity">+ Add Activity</a>
		</div>
		<div class="modal hide" id="activity-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Activity</h3>
			</div>
			<div class="modal-body">
				<p class="span1">Position</p>
				<input class="span3" type="text" id="activity-position">
				<br>
				
				<p class="span1">Start Date</p>
				<input class="span3" type="date" id="activity-start-date">
				<br>
								
				<p class="span1">End Date</p>
				<input class="span3" type="date" id="activity-end-date">
				<br>
					
				<p class="span1">Group</p>
				<input class="span3" type="text" id="activity-group">
				<br>
			
				<ul id="activity-item-list"></ul>
			
				<a href="#activity-fact-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Fact</a>
				<div id="activity-fact-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Fact</h5>
						<input type="text" class="span3" id="activity-desc">
						
						<a href="#activity-fact-collapse" data-toggle="collapse" class="btn btn-primary btn-small span2" id="activity-fact-add">Add</a>
						<br>
						<br>
						<br>
					</div>
					
				</div>
				<br><br>
				<a href="#activity-link-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Link</a>
				<div id="activity-link-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Link Name</h5>
						<input type="text" class="span3" id="activity-link-name">
						<br>
						<h5>Link</h5>
						<input type="text" class="span3" id="activity-link">
						
						<a href="#activity-link-collapse" data-toggle="collapse" class="btn btn-primary btn-small span2" id="activity-link-add">Add</a>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Cancel</a>
				<a href="#" class="btn btn-primary" data-dismiss="modal" id="activity-save">Save</a>
			</div>
		</div>
		
		<div class="row span12">
            <form action="../preview/" id="preview-form" method="POST">
                <input type="hidden" id="hidden-content" name="content">
                <a id="code-preview" href="#" class="span2 btn btn-primary btn-large">Preview</a>
            </form>
			<a id="code-submit" href="#" class="span2 btn btn-primary btn-large">Save</a>
			<br><br><br><br>
		</div>
		
		
	</div>
    <script type="text/javascript">
    <?php
		echo 'var uid = ' . $uid . ';';
		echo 'var username = "' . $username . '";';
	?>
    </script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/make-script.min.js"></script>
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
