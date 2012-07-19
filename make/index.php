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
    
    //Get the tooltip from an id, saves space in the markup
    $tooltip = array();
    
    //basic
    $tooltip["basic-resume"] = "The name of your resume goes (e.g. My Resume, Joe's Computer Science Resume, Resume #1). This is purely for your organization only as no one else will be able to see your resume title.";
    $tooltip["basic-name"] = "This is where your name goes. You are free to change your name to anything you want, just understand that this is what anyone who looks at your resume will see first.";
    $tooltip["basic-position"] = "This is what you would introduce yourself as (e.g. Computer Science Engineer, Hobbyist, Free-Lance Painter, Environmentalist, Dragon-slayer). This should accurately summarize what you do and how you want to appear to the companies who view your resume.";
    $tooltip["basic-statement"] = "";
    
    //contact
    $tooltip["contact-address"] = "";
    $tooltip["contact-city"] = "";
    $tooltip["contact-state"] = "";
    $tooltip["contact-zip"] = "";
    $tooltip["contact-phoneNumber"] = "";
    $tooltip["contact-email"] = "";
    
    //education
    $tooltip["education-school"] = "";
    $tooltip["education-degree"] = "";
    $tooltip["education-startDate"] = "";
    $tooltip["education-endDate"] = "";
    $tooltip["education-award"] = "";
    
    //skill
    $tooltip["skill-category"] = "";
    $tooltip["skill-name"] = "";
    $tooltip["skill-desc"] = "";
    
    //experience
    $tooltip["experience-position"] = "";
    $tooltip["experience-startDate"] = "";
    $tooltip["experience-endDate"] = "";
    $tooltip["experience-group"] = "";
    $tooltip["experience-fact"] = "";
    $tooltip["experience-link-name"] = "";
    $tooltip["experience-link"] = "";
    
    //activity
    $tooltip["activity-position"] = "";
    $tooltip["activity-startDate"] = "";
    $tooltip["activity-endDate"] = "";
    $tooltip["activity-group"] = "";
    $tooltip["activity-fact"] = "";
    $tooltip["activity-link-name"] = "";
    $tooltip["activity-link"] = "";
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
			
			<a id="label-basic-resume" href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["basic-resume"]?>">Resume</a>
			<input class="span3" type="text" placeholder="Resume Name" id="basic-resume" value="[Resume Name]">
			<br>

			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["basic-name"]?>">Name</a>
			<input class="span3" type="text" value="<?php echo $name?>" id="basic-name">
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["basic-position"]?>">Position</a>
			<input class="span3" type="text" id="basic-position">
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["basic-statement"]?>">Statement</a>
			<input class="span3" type="text" id="basic-statement">
			<br>
		</div>
		
		<!-------------Contact Information---------------->
		<div class="row span12 well">
			<h2>Contact Information</h2>
			<hr>
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["contact-address"]?>">Address</a>
			<input class="span3" type="text" value="<?php echo $info["address"]?>" id="contact-address">
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["contact-city"]?>">City</a>
			<input class="span3" type="text" value="<?php echo $info["city"]?>" id="contact-city">
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["contact-state"]?>">State</a>
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
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["contact-zip"]?>">Zip Code</a>
			<input class="span3" type="text" value="<?php echo $info["zip"]?>" id="contact-zip">
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["contact-phoneNumber"]?>">Phone Number</a>
			<input class="span3" type="text" value="<?php echo $info["phone"]?>" id="contact-phone">
			<br>
			<br>
			
			<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["contact-email"]?>">Email</a>
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
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["education-school"]?>">School</a>
				<input class="span3" type="text" id="education-school">
				<br>
			
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["education-degre"]?>">Degree</a>
				<input class="span3" type="text" id="education-degree">
				<br>
			
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["education-startDate"]?>">Start Date</a>
				<input class="span3" type="date" id="education-startDate">
				<br>
			
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["education-endDate"]?>">End Date</a>
				<input class="span3" type="date" id="education-endDate">
				<br>

				<ul id="education-award-list">
				</ul>
				
				<a href="#education-award-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add an Award</a>
				
				<div id="education-award-collapse" class="collapse span4">
					<br>
					<div class="well">
						<a href="#" rel="tooltip" title="<?php echo $tooltip["education-award"]?>">Award</a><br>
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
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["skill-category"]?>">Category</a>
				<input class="span3" type="text" id="skill-category">
				<br>
				<ul id="skill-list">
				</ul>
			
				<a href="#skill-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Skill</a>
				<div id="skill-collapse" class="collapse span4">
					<br>
					<div class="well">
						<a href="#" rel="tooltip" title="<?php echo $tooltip["skill-name"]?>">Skill Name</a>
						<input type="text" class="span3" id="skill-name">
						<br>
						<a href="#" rel="tooltip" title="<?php echo $tooltip["skill-desc"]?>">Skill Description</a>
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
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["experience-position"]?>">Position</a>
				<input class="span3" type="text" id="experience-position">
				<br>
				
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["experience-startDate"]?>">Start Date</a>
				<input class="span3" type="date" id="experience-start-date">
				<br>
								
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["experience-endDate"]?>">End Date</a>
				<input class="span3" type="date" id="experience-end-date">
				<br>
					
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["experience-group"]?>">Group</a>
				<input class="span3" type="text" id="experience-group">
				<br>
				
				<ul id="experience-item-list"></ul>
			
				<a href="#experience-fact-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Fact</a>
				<div id="experience-fact-collapse" class="collapse span4">
					<br>
					<div class="well">
						<a href="#" rel="tooltip" title="<?php echo $tooltip["experience-fact"]?>">Fact</a>
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
						<a href="#" rel="tooltip" title="<?php echo $tooltip["experience-link-name"]?>">Link Name</a>
						<input type="text" class="span3" id="experience-link-name">
						<br>
						<a href="#" rel="tooltip" title="<?php echo $tooltip["experience-link"]?>">Link</a>
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
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["activity-position"]?>">Position</a>
				<input class="span3" type="text" id="activity-position">
				<br>
				
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["activity-startDate"]?>">Start Date</a>
				<input class="span3" type="date" id="activity-start-date">
				<br>
								
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["activity-endDate"]?>">End Date</a>
				<input class="span3" type="date" id="activity-end-date">
				<br>
					
				<a href="#" rel="tooltip" class="span1" title="<?php echo $tooltip["activity-group"]?>">Group</a>
				<input class="span3" type="text" id="activity-group">
				<br>
			
				<ul id="activity-item-list"></ul>
			
				<a href="#activity-fact-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Fact</a>
				<div id="activity-fact-collapse" class="collapse span4">
					<br>
					<div class="well">
						<a href="#" rel="tooltip" title="<?php echo $tooltip["activity-fact"]?>">Fact</a>
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
						<a href="#" rel="tooltip" title="<?php echo $tooltip["activity-link-name"]?>">Link Name</a>
						<input type="text" class="span3" id="activity-link-name">
						<br>
						<a href="#" rel="tooltip" title="<?php echo $tooltip["activity-link"]?>">Link</a>
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
            <a id="code-preview" href="#" class="span2 btn btn-primary btn-large">Preview</a>
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
    <script type="text/javascript" src="../private/bootstrap/js/json2.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/make-script.min.js"></script>
    <script type="text/javascript">
        $("#label-basic-resume").tooltip();
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
