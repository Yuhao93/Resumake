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
    p{
        margin-bottom:0px;
        font-size:12px;
    }
    hr{
        border-top:2px solid #EEE;
        margin-top:3px;
        margin-bottom:4px;
    }
    </style>
    
</head>

<body>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="modal hide">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Attention!</h3>
            </div>
            <div class="modal-body" id="attention-modal">
                <p>When printing your resume, please note that, in order to keep your resume short:</p>
                <ul>
                    <li>The descriptions of your skills won't be included.</li>
                    <li>Only your the top three experiences (Which should be your most relevant) will be included<li>
                    <li>Only two items from each experience will be included</li>
                    <li>Only your the top two activities (Which should be your most relevant) will be included</li>
                    <li>Only two items from each activity will be included</li>
                    <li>You may have to edit your resume (or create a printer version)</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal" id="understood-btn">Okay</a>
            </div>
        </div>
        
        <div class="span12">
            <center><h1><?php echo $basicInfo['name'];?></h1>
            <p><?php echo $basicInfo['position']?></p></center>
			<blockquote>
				<h5><?php echo $basicInfo['statement'];?></h5>
			</blockquote>    
			<div class="row-fluid">
				<div>		
					<h4>Contact Information</h4>
						<address>
                            <p>
							&nbsp;&nbsp;<?php echo $contactInfo['address'] . ', ' . $contactInfo['city'] . ',' . $contactInfo['state'] . ' ' . $contactInfo['zip'];?>
							<br>&nbsp;&nbsp;P: <?php echo $contactInfo['phoneNumber'] . ' Email: ' . $contactInfo['email']?>
                            </p>
						</address>
				</div>
				
				<hr>
			</div>			
		
		<?php 
			if(sizeof($educationInfo) != 0){
				echo '<div class="row-fluid"><h4>Education</h4>';
				for($i = 0; $i < sizeof($educationInfo); $i ++){
					$education = $educationInfo[$i];
					$awards = $education['awards'];
					echo '<div>';
					echo '<p><strong>' . $education['school'] . '</strong> -&nbsp;' . $education['degree'] . ' ' . getFullDate($education['startDate'], $education['endDate']) . '</p>';
                    echo '<p>Awards: ';
					for($j = 0; $j < sizeof($awards); $j ++){
						echo $awards[$j];
                        if ($j != sizeof($awards) - 1)
                            echo ', ';
                    }
                    echo '</p>';
                    if($i != sizeof($educationInfo) - 1)
                        echo '<br>';
					echo '</div>';
				}
				echo '<hr></div>';
			}
			
			if(sizeof($skillInfo) != 0){
				echo '<div class="row-fluid"><h4>Skills</h4>';
				for($i = 0; $i < sizeof($skillInfo); $i ++){
					echo '<div>';
					echo '<p><strong>' . $skillInfo[$i]['category'] . '</strong></p>';
                    
					echo '<p>';
					for($j = 0; $j < sizeof($skillInfo[$i]['skills']); $j++){
						echo $skillInfo[$i]['skills'][$j]['name'];
                        if($j != sizeof($skillInfo[$i]['skills']) - 1)
                            echo ', ';
					}
					echo '</p>';
                    if($i != sizeof($skillInfo) - 1)
                        echo '<br>';
					echo '</div>';
				}
				echo '<hr></div>';
			}
			
			if(sizeof($experienceInfo) != 0){
				echo '<div class="row-fluid">';
				echo '<h4>Experience</h4>';
                $expMin = sizeof($experienceInfo);
                if($expMin > 3)
                    $expMin = 3;
				for($i = 0; $i < $expMin; $i ++){
					echo '<div>';
					echo '<p><strong>' . $experienceInfo[$i]['position'] . ' ' . getFullDate($experienceInfo[$i]['startDate'], $experienceInfo[$i]['endDate']) . '</strong></p>';
					echo $experienceInfo[$i]['group'];
					echo '<ul>';
                    $min = sizeof($experienceInfo[$i]['items']);
                    if($min > 2)
                        $min = 2;
					for($j = 0; $j < $min; $j++){
						$item = $experienceInfo[$i]['items'][$j];
						if($item['type'] == 'desc'){
							echo '<li>' . $item['desc'] . '</li>';
						}else if($item['type'] == 'link'){
							echo '<li>' . $item['link'] . '</li>';
						}
					}
					echo '</ul>';
					echo '</div>';
				}
				echo '<hr></div>';
			}
			
			if(sizeof($activityInfo) != 0){
				echo '<div class="row-fluid">';
				echo '<h4>Activities</h4>';
                $actMin = sizeof($activityInfo);
                if($actMin > 2)
                    $actMin = 2;
				for($i = 0; $i < $actMin; $i ++){
					echo '<div>';
					echo '<p><strong>' . $activityInfo[$i]['position'] . ' ' . getFullDate($activityInfo[$i]['startDate'], $activityInfo[$i]['endDate']) . '</strong></p>';
					$min = sizeof($activityInfo[$i]['items']);
                    if($min > 2)
                        $min = 2;
					echo '<ul>';
					for($j = 0; $j < $min; $j++){
						$item = $activityInfo[$i]['items'][$j];
						if($item['type'] == 'fact'){
							echo '<li>' . $item['desc'] . '</li>';
						}else if($item['type'] == 'link'){
							echo '<li>' . $item['link']  . '</li>';
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
    $('#attention-modal').modal('show');
    $('#okay-btn').click(function(){
        window.print();
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
