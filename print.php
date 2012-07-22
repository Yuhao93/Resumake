<?php
    //Get the uid and rid
	$uid = $_POST['uid'];
    $rid = $_POST['rid'];
    
    $uid = 34;
    $rid = 76;
    
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
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap-responsive.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/styles.css"></link>
    <style type="text/css">
    body{
        padding-top:0px;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
            <center><h1><?php echo $basicInfo['name'];?></h1>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $basicInfo['position']?></p></center>
			<blockquote>
				<h5><?php echo $basicInfo['statement'];?></h5>
			</blockquote>    
			<div class="row-fluid">
				<div>		
					<h4>Contact Information</h4>
						<address>
							<br>&nbsp;&nbsp;<?php echo $contactInfo['address'] . ', ' . $contactInfo['city'] . ',' . $contactInfo['state'] . ' ' . $contactInfo['zip'];?>
							<br>&nbsp;&nbsp;P: <?php echo $contactInfo['phoneNumber'] . ' Email:' . $contactInfo['email']?>
						</address>
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
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/script.js"></script>
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
