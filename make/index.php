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
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Resumaker</title>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap-responsive.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/jquery.Jcrop.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/codemirror.css">
	
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
					<a class="brand" href="../<?php echo $user->username?>">
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
			<h3 class="span9">Build your resume using Resumake's easy to learn and easy to use formatting</h3>
			<a href="#" class="span2 btn btn-primary btn-large">Learn How</a>
			<h4>Protip: Need more space? Press F11 to toggle <a href="javascript:toggleFullscreenEditing()">FullScreen Mode</a></h4>
		</div>
		
		<div class="row span12">
		<br>
			<span>Name of Your Resume</span>
			<input type="text" placeholder="Resume Name">
		</div>
		<div class="row span12">
			<textarea id="code" name="code">###################################
# Your basic information
###################################
Name:
Position:
Statement:

###################################
# Contact Information
###################################
Address:
City:
State:
Zip:
Phone-Number:
Email:

###################################
# Education
# To add additional Educations
#   copy and paste the 
#   following five lines
# To add extra awards
#   add the line
#   Award:
###################################
School:
Degree:
Start-Date:
End-Date:

###################################
# Skills
# To add additional Skills 
#   copy and paste the 
#   following three lines
###################################
Skill-Category:
Skill-Name:
Skill-Description:

###################################
# Experience
#   To add additional 
#   experiences copy and paste
#   the following few lines
# To add additional Experience 
#   facts, add the line
#   Experience-Fact:
# To make a link add the lines
#   Experience-Link-Name:
#   Experience-Link:
###################################
Experience-Title:
Experience-Start-Date:
Experience-End-Date:
Experience-Group:

###################################
# Activity
#   To add additional
#   Activities, copy and paste
#   the following lines
# To add facts, add the line
#   Activity-Fact:
# To add links, add the lines
#   Activity-Link-Name:
#   Activity-Link:
###################################
Activity-Title: 
Activity-Start-Date: 
Activity-End-Date: </textarea>
		</div>
		
		<div class="row span12">
		<br>
			<a href="#" class="span2 btn btn-primary btn-large">Preview</a>
			<a href="#" class="span2 btn btn-primary btn-large">Save</a>
			
		</div>
		
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/jquery.Jcrop.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/codemirror.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/resumakeformat.js"></script>
	<script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: false,
        mode: "text/x-java",
		extraKeys: {"F11": toggleFullscreenEditing, "Esc": toggleFullscreenEditing}
      });
	  function toggleFullscreenEditing()
    {
        var editorDiv = $('.CodeMirror-scroll');
        if (!editorDiv.hasClass('fullscreen')) {
            toggleFullscreenEditing.beforeFullscreen = { height: editorDiv.height(), width: editorDiv.width() }
            editorDiv.addClass('fullscreen');
            editorDiv.height('100%');
            editorDiv.width('100%');
            editor.refresh();
        }
        else {
            editorDiv.removeClass('fullscreen');
            editorDiv.height(toggleFullscreenEditing.beforeFullscreen.height);
            editorDiv.width(toggleFullscreenEditing.beforeFullscreen.width);
            editor.refresh();
        }
    }
    </script>
</body>
