<?php
    //Get the uid and rid
	$uid = $_GET['uid'];
    $rid = $_GET['rid'];
    
    //Get the resume object from the rid
	include_once('private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
    $resume_obj = $db->getResumeByRid($rid);
	$resume = json_decode($resume_obj->content, true);
    
    //Get the info of the resumejson
	$basicInfo = $resume['basicInfo'];
	$contactInfo = $resume['contactInfo'];
	$educationInfo = $resume['educationInfo'];
	$skillInfo = $resume['skillInfo'];
	$experienceInfo = $resume['experienceInfo'];
	$activityInfo = $resume['activityInfo'];
    
    function formatDate($date){
        $months = array('January','February','March'
            ,'April','May','June'
            ,'July','August','September'
            ,'October','November','December');
            
        if(strrpos($date, "-") === false)
            return "";
        $chunks = split("-", $date);
        $monthIndex = (strrpos($chunks[1], "0") == 0) ? (int)substr($chunks[1], 0) : (int)$chunks[1];
        $month = $months[$monthIndex];
        $year = $chunks[0];
        return $month . " " . $year;
    }
    
    function getFullDate($startDate, $endDate){
        if(formatDate($endDate) == ""){
            if(formatDate($startDate) == "")
                return "";
            else return formatDate($startDate) . " - Ongoing";
        }else{
            if(formatDate($startDate) == "")
                return " Until " . formatDate($endDate);
            else return formatDate($startDate) . " - " . formatDate($endDate);
        }
            
    }
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
	<title><?php echo $basicInfo['name']?></title>
	<link rel="stylesheet" type="text/css" href="../../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../../private/bootstrap/css/bootstrap-responsive.css"></link>
	<link rel="stylesheet" type="text/css" href="../../private/bootstrap/css/styles.css"></link>
</head>

<body>
	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="nav-collapse">
            <ul class="nav">
              <li><a id="contact_menu" data-toggle="modal" href="#contactmodal">Contact</a></li>
              <li><a id="print_menu" data-toggle="modal" href="../../printer/<?php echo $rid?>">Print</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header"><h2>Go To</h2></li>
			  <li class="nav-header"><a href="#Personal"><h4>&nbsp;&nbsp;&nbsp;&nbsp;Personal</h4></a></li>
				<li><a href="#Contact">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Information</a></li>
				
				<?php 
					if(sizeof($educationInfo) != 0){
                        echo '<li class="nav-header"><a href="#education-collapse" data-toggle="collapse"><h4>&nbsp;&nbsp;&nbsp;&nbsp;Education</h4></a></li>';
                        echo '<div class="collapse" id="education-collapse">';
                        for($i = 0; $i < sizeof($educationInfo); $i++){
                            echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#education' . $i . '">' . $educationInfo[$i]['school'] . '</a></li>';
                        }
                        echo '</div>';
                    }
					
					if(sizeof($skillInfo) != 0){
						echo '<li class="nav-header"><a href="#skill-collapse" data-toggle="collapse"><h4>&nbsp;&nbsp;&nbsp;&nbsp;Skills</h4></a></li>';
                        echo '<div class="collapse" id="skill-collapse">';
                        for($i = 0; $i < sizeof($skillInfo); $i ++){
                            echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#skill' . $i . '">' . $skillInfo[$i]['category'] . '</a></li>';
                        }
                        echo '</div>';
                    }
					
					if(sizeof($experienceInfo) != 0){
						echo '<li class="nav-header"><a href="#experience-collapse" data-toggle="collapse"><h4>&nbsp;&nbsp;&nbsp;&nbsp;Experience</h4></a></li>';
                        echo '<div class="collapse" id="experience-collapse">';
                        for($i = 0; $i < sizeof($experienceInfo); $i ++){
                            echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#experience' . $i . '">' . $experienceInfo[$i]['position'] . '</a></li>';
                        }
                        echo '</div>';
                    }
					
					if(sizeof($activityInfo) != 0){
						echo '<li class="nav-header"><a href="#activity-collapse" data-toggle="collapse"><h4>&nbsp;&nbsp;&nbsp;&nbsp;Activity</h4></a></li>';
                        echo '<div class="collapse" id="activity-collapse">';
                        for($i = 0; $i < sizeof($activityInfo); $i ++){
                            echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#activity' . $i . '">' . $activityInfo[$i]['position'] . '</a></li>';
                        }
                        echo '</div>';
                    }
				?>
            </ul>
          </div>
        </div>
		
        <div class="span9">
          <div class="hero-unit">
            <h1><?php echo $basicInfo['name'];?></h1>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $basicInfo['position']?></p>
			<blockquote>
				<h4><?php echo $basicInfo['statement'];?></h4>
			</blockquote>    
			</div>

			<section id="Personal"></section>
			<div class="row-fluid">
				<h2 class="float-down">Personal</h2>
				<section id="Contact"></section>
				<div class="well">		
					<h3>Contact Information</h3>
						<address>
							<Strong> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $basicInfo['name'];?> </strong>
							<br>&nbsp;&nbsp;<?php echo $contactInfo['address']?>
							<br>&nbsp;&nbsp;<?php echo $contactInfo['city'] . ',' . $contactInfo['state'] . ' ' . $contactInfo['zip'];?>
							<br>&nbsp;&nbsp;P: <?php echo $contactInfo['phoneNumber']?>
							<br>&nbsp;&nbsp;Email: <a href="mailto:<?php echo $contactInfo['email']?>"><?php echo $contactInfo['email']?></a>
						</address>
					<p><a class="btn btn-primary btn-large" id="contact_btn" data-toggle="modal" href="#contactmodal" >Contact Me &raquo;</a></p>
				</div>
				
				<div class="modal hide" id="contactmodal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Contact Me</h3>
					</div>
					<div class="modal-body">
						<form class="well">
							<label>Name</label>
							<input type="text" class="span9" placeholder="Name" name="name" id="email-name">
							
							<label>Subject</label>
							<input type="text" class="span9" placeholder="Subject" name="subject" id="email-subject">
							
							<label>Content</label>
							<textarea class="span12" placeholder="Content" name="content" rows="8" id="email-content"></textarea>
						</form>
						<a href="mailto:ypma@uci.edu" class="btn btn-primary">Use Email Client</a>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Close</a>
						<a href="#" class="btn btn-primary" data-dismiss="modal" id="email-send">Send</a>
					</div>
				</div>
				<div class="modal hide" id="thanksmodal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h3>Thank You!</h3>
					</div>
					<div class="modal-body">
						<div class="hero-unit">
						<h2>Thanks for getting in touch! Your email has been sent.</h2>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Close</a>
					</div>
				</div>
				
				<hr>
			</div>			
		
		<?php 
			if(sizeof($educationInfo) != 0){
				echo '<section id="Education"></section><div class="row-fluid"><h2 class="float-down">Education</h2>';
				for($i = 0; $i < sizeof($educationInfo); $i ++){
					$education = $educationInfo[$i];
					$awards = $education['awards'];
					echo '<section id="education' . $i . '"></section>';
					echo '<div class="well">';
					echo '<h3>' . $education['school'] . '</h3>';
					echo '<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;' . $education['degree'] . '</strong> ' . getFullDate($education['startDate'], $education['endDate']) . '</p>';
					for($j = 0; $j < sizeof($awards); $j ++)
						echo '<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $awards[$j] . '</strong></p>';
					echo '</div>';
				}
				echo '<hr></div>';
			}
			
			if(sizeof($skillInfo) != 0){
				echo '<section id="Skills"></section><div class="row-fluid"><h2 class="float-down">Skills</h2>';
				for($i = 0; $i < sizeof($skillInfo); $i ++){
					echo '<section id="skill' . $i . '"></section>';
					echo '<div class="well">';
					echo '<h3>' . $skillInfo[$i]['category'] . '</h3>';
					echo '<ul class="nav nav-tabs nav-stacked">';
					for($j = 0; $j < sizeof($skillInfo[$i]['skills']); $j++){
						echo '<li><a id="skill' . $i . '_' . $j . '">' . $skillInfo[$i]['skills'][$j]['name'] . '</a></li>';
					}
					echo '</ul>';
					echo '</div>';
				}
				echo '<hr></div>';
			}
			
			if(sizeof($experienceInfo) != 0){
				echo '<section id="Experience"></section>';
				echo '<div class="row-fluid">';
				echo '<h2 class="float-down">Experience</h2>';
				for($i = 0; $i < sizeof($experienceInfo); $i ++){
					echo '<section id="experience' . $i . '"></section>';
					echo '<div class="well">';
					echo '<h3>' . $experienceInfo[$i]['position'] . ' ' . getFullDate($experienceInfo[$i]['startDate'], $experienceInfo[$i]['endDate']) . '</h3>';
					echo $experienceInfo[$i]['group'];
					echo '<ul>';
					$isLink = false;
					for($j = 0; $j < sizeof($experienceInfo[$i]['items']); $j++){
						$item = $experienceInfo[$i]['items'][$j];
						if($item['type'] == 'desc'){
							if($isLink){
								echo '</ul>';
							}
							echo '<li>' . $item['desc'] . '</li>';
							$isLink = false;
						}else if($item['type'] == 'link'){
							if(!$isLink){
								echo '<ul class="nav nav-tabs nav-stacked">';
							}
							echo '<li><a href="' . $item['link'] . '" target="_blank">' . $item['name'] . '</a></li>';
							$isLink = true;
						}
					}
					echo '</ul>';
					echo '</div>';
				}
				echo '<hr></div>';
			}
			
			if(sizeof($activityInfo) != 0){
				echo '<section id="Activity"></section>';
				echo '<div class="row-fluid">';
				echo '<h2 class="float-down">Activities</h2>';
				for($i = 0; $i < sizeof($activityInfo); $i ++){
					echo '<section id="activity' . $i . '"></section>';
					echo '<div class="well">';
					echo '<h3>' . $activityInfo[$i]['position'] . ' ' . getFullDate($activityInfo[$i]['startDate'], $activityInfo[$i]['endDate']) . '</h3>';
					echo $activityInfo[$i]['group'];
                    $isLink = false;
					echo '<ul>';
					for($j = 0; $j < sizeof($activityInfo[$i]['items']); $j++){
						$item = $activityInfo[$i]['items'][$j];
						if($item['type'] == 'fact'){
							if($isLink){
								echo '</ul>';
							}
							echo '<li>' . $item['desc'] . '</li>';
							$isLink = false;
						}else if($item['type'] == 'link'){
							if(!$isLink){
								echo '<ul class="nav nav-tabs nav-stacked">';
							}
							echo '<li><a href="' . $item['link'] . '" target="_blank">' . $item['name'] . '</a></li>';
							$isLink = true;
						}
					}
					echo '</ul>';
					echo '</div>';
				}
				echo '<hr>';
				echo '</div>';
			}
		?>	
		</div>
	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="../../private/bootstrap/js/script.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#email-send').click(function(){
			var name = $('#email-name').attr('value');
			var subject = $('#email-subject').attr('value');
			var content = $('#email-content').attr('value');
			$.post('../../sendemail.php', {'name':name, 'subject':subject, 'content':content}, function(data){
				$('#thanksmodal').modal('show');
			});
		});
	});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php
				for($i = 0; $i < sizeof($skillInfo); $i++){
					for($j = 0; $j < sizeof($skillInfo[$i]['skills']); $j ++){
						$skill = $skillInfo[$i]['skills'][$j];
                        if($skill['desc'] != "")
                            echo '$("#skill' . $i . '_' . $j . '").popover({title:"' . $skill['name'] . '", content:"' . $skill['desc'] . '",placement:"left"});';
					}
				}
			?>
			$("#contact_btn").modal({show:false});
		});
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
