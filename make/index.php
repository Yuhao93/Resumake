<?php
	session_start();
	$uid;
	if(isset($_SESSION['uid'])){
		$uid = $_SESSION['uid'];
	}else if(isset($_COOKIE['remember'])){
		$_SESSION['uid'] = $_COOKIE['remember'];
		$uid = $_SESSION['uid'];
	}
	else{
	}
	include_once('../private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
	
	$user = $db->getUserById($uid);
	$username = $user->username;
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
	.CodeMirror {border: 2px solid #d0d0d0;}
	.CodeMirror-scroll{
		background:#FFFFFF;
	}
	.fullscreen {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            margin: 0;
            padding: 0;
            border: 0px solid #BBBBBB;
            opacity: 1;
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
			<a href="#" class="span2 btn btn-primary btn-large">Learn How</a>
			
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
			<input class="span3" id="resume-name" type="text" placeholder="Resume Name">
			<br>

			<p class="span1">Name</p>
			<input class="span3" type="text">
			<br>
			
			<p class="span1">Position</p>
			<input class="span3" type="text">
			<br>
			
			<p class="span1">Statement</p>
			<input class="span3" type="text">
			<br>
		</div>
		
		<!-------------Contact Information---------------->
		<div class="row span12 well">
			<h2>Contact Information</h2>
			<hr>
			<br>
			
			<p class="span1">Address</p>
			<input class="span3" type="text">
			<br>
			
			<p class="span1">City</p>
			<input class="span3" type="text">
			<br>
			
			<p class="span1">State</p>
			<select class="span3">
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
			<br>
			
			<p class="span1">Zip Code</p>
			<input class="span3" type="text">
		</div>
		
		<!-------------Education Information---------------->
		<div class="row span12 well">
			<h2>Education</h2>
			<hr>
			<div id="education-container">
			</div>
			
			<a href="#education-modal" data-toggle="modal" class="span2 btn btn-large">+ Add An Education</a>
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
			<a href="#skill-modal" class="span2 btn btn-large" data-toggle="modal">+ Add A Category</a>
		</div>
		<div class="modal hide" id="skill-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Category</h3>
			</div>
			<div class="modal-body">
				<p class="span1">Category</p>
				<input class="span3" type="text">
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
				<a href="#" class="btn btn-primary" data-dismiss="modal">Save</a>
			</div>
		</div>
		
		<!-------------Experience Information---------------->
		<div class="row span12 well">
			<h2>Experience</h2>
			<hr>
			<a href="#experience-modal" class="span2 btn btn-large" data-toggle="modal">+ Add Experience</a>
		</div>
		<div class="modal hide" id="experience-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Experience</h3>
			</div>
			<div class="modal-body">
				<p class="span1">Position</p>
				<input class="span3" type="text">
				<br>
				
				<p class="span1">Start Date</p>
				<input class="span3" type="date">
				<br>
								
				<p class="span1">End Date</p>
				<input class="span3" type="date">
				<br>
					
				<p class="span1">Group</p>
				<input class="span3" type="text">
				<br>
				
				<ul id="experience-item-list"></ul>
			
				<a href="#experience-fact-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Fact</a>
				<div id="experience-fact-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Fact</h5>
						<input type="text" class="span3" id="experience-fact">
						
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
				<a href="#" class="btn btn-primary" data-dismiss="modal">Save</a>
			</div>
		</div>
		
		<!-------------Activity Information---------------->
		<div class="row span12 well">
			<h2>Activity</h2>
			<hr>
			<a href="#activity-modal" class="span2 btn btn-large" data-toggle="modal">+ Add Activity</a>
		</div>
		<div class="modal hide" id="activity-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Activity</h3>
			</div>
			<div class="modal-body">
				<p class="span1">Position</p>
				<input class="span3" type="text">
				<br>
				
				<p class="span1">Start Date</p>
				<input class="span3" type="date">
				<br>
								
				<p class="span1">End Date</p>
				<input class="span3" type="date">
				<br>
					
				<p class="span1">Group</p>
				<input class="span3" type="text">
				<br>
			
				<ul id="activity-item-list"></ul>
			
				<a href="#activity-fact-collapse" class="btn btn-primary btn-small span2" data-toggle="collapse">+ Add A Fact</a>
				<div id="activity-fact-collapse" class="collapse span4">
					<br>
					<div class="well">
						<h5>Fact</h5>
						<input type="text" class="span3" id="activity-fact">
						
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
				<a href="#" class="btn btn-primary" data-dismiss="modal">Save</a>
			</div>
		</div>
		
		<div class="row span12">
			<a href="#" class="span2 btn btn-primary btn-large">Preview</a>
			<a id="code-submit" href="#" class="span2 btn btn-primary btn-large">Save</a>
			<br><br><br><br>
		</div>
		
		
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
	function getFormattedDate(date){
		var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		if(date == undefined || date.indexOf("-") == -1)
			return "";
		var year = date.split("-")[0];
		var num = date.split("-")[1];
		if(num.charAt(0) == '0')
			num = num.substring(1);
		var m = month[parseInt(num) - 1];
		return m + " " + year;
	}
	function addAward(){
		var award = $("#education-award-name").attr("value");
		$("#education-award-name").attr("value", "");
		$("#education-award-list").append('<li class="span3 education-award" id="award-' + pendingAwardCount + '">'+ award +
			'<button class="close pull-right" id="award-' + pendingAwardCount + '">x</button></li>');
		$("button#award-" + pendingAwardCount).click(function(){
			var id = $(this).attr("id").substring(6);
			$("li#award-" + id).remove();
		});
		pendingAwardCount++;
	}
	function saveEducation(){
		var school = "" + $("#education-school").attr("value");
		var degree = "" + $("#education-degree").attr("value");
		var startDate = "" + $("#education-startDate").attr("value");
		var endDate = "" + $("#education-endDate").attr("value");
		var awards = new Array();
		$(".education-award").each(function(index){
			var text = $(this).text()
			awards.push(text.substring(0, text.length - 1));
		});
		
		$("#education-school").attr("value", "");
		$("#education-degree").attr("value", "");
		$("#education-startDate").attr("value", "");
		$("#education-endDate").attr("value", "");
		$("#education-award-list").html("");
		
		resume.educationInfo.push({'school':school, 'degree':degree, 'startDate':startDate, 'endDate':endDate, 'awards':awards});
		
		var appendableText = '<div class="education-object" id = "edu-obj-' + pendingEducationCount + '"><a class="close" id="education-delete-' 
			+ pendingEducationCount + '">X</a>' + '<h3><a href="#">' + school + '</a></h3><p><strong>' + degree + '</strong> ' + getFormattedDate(startDate) 
			+ ' - ' + getFormattedDate(endDate) + '</p>';
		for(var i = 0; i < awards.length; i ++){
			appendableText += '<p><strong>' + awards[i] + '</strong></p>';
		}
		appendableText += '</div>';
		$("#education-container").append(appendableText);
		$("#education-delete-" + pendingEducationCount).click(function(){
			var id = $(this).attr("id").substring(17);
			var index = -1;
			$(".education-object").each(function(ind){
				var edu_id = $(this).attr("id").substring(8);
				if(edu_id == id)
					index = ind;
			});
			if(index != -1)
				resume.educationInfo.splice(index, 1);
			$("#edu-obj-" + id).remove();
		});
		pendingEducationCount ++;
	}
	</script>
	
	<script type="text/javascript">
	var resume = {'basicInfo':{}, 'contactInfo':{}, 'educationInfo':[], 'skillInfo':[], 'experienceInfo':[], 'activityInfo':[]};
	var pendingAwardCount = 0;
	var pendingEducationCount = 0;
	<?php
		echo 'var uid = ' . $uid . ';';
		echo 'var username = "' . $username . '";';
	?>
	$(document).ready(function(){
		$("#education-award-add").click(function(){
			addAward();
		});
		$("#education-save").click(function(){
			saveEducation();
		});
		$("#code-submit").click(function(){
			var content = editor.getValue();
			var name = $("#resume-name").attr("value");
			$.post('../private/php_scripts/addResume.php', {'uid':uid, 'username':username, 'content':content, 'name':name}, function(data){
				window.location.href = "../rmks/?uid=" + uid;
			});
		});
	});
    </script>
</body>
