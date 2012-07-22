<?php
    //Get the uid and rid
	$uid = $_POST['uid'];
    $rid = $_POST['rid'];
    
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
&lt;!DOCTYPE HTML&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
	&lt;title&gt;<?php echo $basicInfo['name']?>&lt;/title&gt;
	&lt;link rel="stylesheet" type="text/css" href="http://resumake.thegbclub.com/private/bootstrap/css/bootstrap.css"&gt;&lt;/link&gt;
	&lt;link rel="stylesheet" type="text/css" href="http://resumake.thegbclub.com/private/bootstrap/css/bootstrap-responsive.css"&gt;&lt;/link&gt;
	&lt;link rel="stylesheet" type="text/css" href="http://resumake.thegbclub.com/private/bootstrap/css/styles.css"&gt;&lt;/link&gt;
&lt;/head&gt;

&lt;body&gt;
	&lt;div class="navbar navbar-fixed-top"&gt;
      &lt;div class="navbar-inner"&gt;
        &lt;div class="container-fluid"&gt;
          &lt;div class="nav-collapse"&gt;
            &lt;ul class="nav"&gt;
              &lt;li&gt;&lt;a id="contact_menu" data-toggle="modal" href="#contactmodal"&gt;Contact&lt;/a&gt;&lt;/li&gt;
              &lt;li&gt;&lt;a id="print_menu" data-toggle="modal" href="http://resumake.thegbclub.com/printer/<?php echo $rid;?>"&gt;Print&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
          &lt;/div&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="container-fluid"&gt;
      &lt;div class="row-fluid"&gt;
        &lt;div class="span3"&gt;
          &lt;div class="well sidebar-nav"&gt;
            &lt;ul class="nav nav-list"&gt;
              &lt;li class="nav-header"&gt;&lt;h2&gt;Go To&lt;/h2&gt;&lt;/li&gt;
			  &lt;li class="nav-header"&gt;&lt;a href="#Personal"&gt;&lt;h4&gt;&nbsp;&nbsp;&nbsp;&nbsp;Personal&lt;/h4&gt;&lt;/a&gt;&lt;/li&gt;
				&lt;li&gt;&lt;a href="#Contact"&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Information&lt;/a&gt;&lt;/li&gt;
				
				<?php 
					if(sizeof($educationInfo) != 0){
                        echo '&lt;li class="nav-header"&gt;&lt;a href="#education-collapse" data-toggle="collapse"&gt;&lt;h4&gt;&nbsp;&nbsp;&nbsp;&nbsp;Education&lt;/h4&gt;&lt;/a&gt;&lt;/li&gt;';
                        echo '&lt;div class="collapse" id="education-collapse"&gt;';
                        for($i = 0; $i < sizeof($educationInfo); $i++){
                            echo '&lt;li&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a href="#education' . $i . '"&gt;' . $educationInfo[$i]['school'] . '&lt;/a&gt;&lt;/li&gt;';
                        }
                        echo '&lt;/div&gt;';
                    }
					
					if(sizeof($skillInfo) != 0){
						echo '&lt;li class="nav-header"&gt;&lt;a href="#skill-collapse" data-toggle="collapse"&gt;&lt;h4&gt;&nbsp;&nbsp;&nbsp;&nbsp;Skills&lt;/h4&gt;&lt;/a&gt;&lt;/li&gt;';
                        echo '&lt;div class="collapse" id="skill-collapse"&gt;';
                        for($i = 0; $i < sizeof($skillInfo); $i ++){
                            echo '&lt;li&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a href="#skill' . $i . '"&gt;' . $skillInfo[$i]['category'] . '&lt;/a&gt;&lt;/li&gt;';
                        }
                        echo '&lt;/div&gt;';
                    }
					
					if(sizeof($experienceInfo) != 0){
						echo '&lt;li class="nav-header"&gt;&lt;a href="#experience-collapse" data-toggle="collapse"&gt;&lt;h4&gt;&nbsp;&nbsp;&nbsp;&nbsp;Experience&lt;/h4&gt;&lt;/a&gt;&lt;/li&gt;';
                        echo '&lt;div class="collapse" id="experience-collapse"&gt;';
                        for($i = 0; $i < sizeof($experienceInfo); $i ++){
                            echo '&lt;li&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a href="#experience' . $i . '"&gt;' . $experienceInfo[$i]['position'] . '&lt;/a&gt;&lt;/li&gt;';
                        }
                        echo '&lt;/div&gt;';
                    }
					
					if(sizeof($activityInfo) != 0){
						echo '&lt;li class="nav-header"&gt;&lt;a href="#activity-collapse" data-toggle="collapse"&gt;&lt;h4&gt;&nbsp;&nbsp;&nbsp;&nbsp;Activity&lt;/h4&gt;&lt;/a&gt;&lt;/li&gt;';
                        echo '&lt;div class="collapse" id="activity-collapse"&gt;';
                        for($i = 0; $i < sizeof($activityInfo); $i ++){
                            echo '&lt;li&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a href="#activity' . $i . '"&gt;' . $activityInfo[$i]['position'] . '&lt;/a&gt;&lt;/li&gt;';
                        }
                        echo '&lt;/div&gt;';
                    }
				?>
            &lt;/ul&gt;
          &lt;/div&gt;
        &lt;/div&gt;
		
        &lt;div class="span9"&gt;
          &lt;div class="hero-unit"&gt;
            &lt;h1&gt;<?php echo $basicInfo['name'];?>&lt;/h1&gt;
            &lt;p&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $basicInfo['position']?>&lt;/p&gt;
			&lt;blockquote&gt;
				&lt;h4&gt;<?php echo $basicInfo['statement'];?>&lt;/h4&gt;
			&lt;/blockquote&gt;    
			&lt;/div&gt;

			&lt;section id="Personal"&gt;&lt;/section&gt;
			&lt;div class="row-fluid"&gt;
				&lt;h2 class="float-down"&gt;Personal&lt;/h2&gt;
				&lt;section id="Contact"&gt;&lt;/section&gt;
				&lt;div class="well"&gt;		
					&lt;h3&gt;Contact Information&lt;/h3&gt;
						&lt;address&gt;
							&lt;Strong&gt; &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $basicInfo['name'];?> &lt;/strong&gt;
							&lt;br&gt;&nbsp;&nbsp;<?php echo $contactInfo['address']?>
							&lt;br&gt;&nbsp;&nbsp;<?php echo $contactInfo['city'] . ',' . $contactInfo['state'] . ' ' . $contactInfo['zip'];?>
							&lt;br&gt;&nbsp;&nbsp;P: <?php echo $contactInfo['phoneNumber']?>
							&lt;br&gt;&nbsp;&nbsp;Email: &lt;a href="mailto:<?php echo $contactInfo['email']?>"&gt;<?php echo $contactInfo['email']?>&lt;/a&gt;
						&lt;/address&gt;
					&lt;p&gt;&lt;a class="btn btn-primary btn-large" id="contact_btn" data-toggle="modal" href="#contactmodal" &gt;Contact Me &raquo;&lt;/a&gt;&lt;/p&gt;
				&lt;/div&gt;
				
				&lt;div class="modal hide" id="contactmodal"&gt;
					&lt;div class="modal-header"&gt;
						&lt;button type="button" class="close" data-dismiss="modal"&gt;x&lt;/button&gt;
						&lt;h3&gt;Contact Me&lt;/h3&gt;
					&lt;/div&gt;
					&lt;div class="modal-body"&gt;
						&lt;form class="well"&gt;
							&lt;label&gt;Name&lt;/label&gt;
							&lt;input type="text" class="span9" placeholder="Name" name="name" id="email-name"&gt;
							
							&lt;label&gt;Subject&lt;/label&gt;
							&lt;input type="text" class="span9" placeholder="Subject" name="subject" id="email-subject"&gt;
							
							&lt;label&gt;Content&lt;/label&gt;
							&lt;textarea class="span12" placeholder="Content" name="content" rows="8" id="email-content"&gt;&lt;/textarea&gt;
						&lt;/form&gt;
						&lt;a href="mailto:ypma@uci.edu" class="btn btn-primary"&gt;Use Email Client&lt;/a&gt;
					&lt;/div&gt;
					&lt;div class="modal-footer"&gt;
						&lt;a href="#" class="btn" data-dismiss="modal"&gt;Close&lt;/a&gt;
						&lt;a href="#" class="btn btn-primary" data-dismiss="modal" id="email-send"&gt;Send&lt;/a&gt;
					&lt;/div&gt;
				&lt;/div&gt;
				&lt;div class="modal hide" id="thanksmodal"&gt;
					&lt;div class="modal-header"&gt;
						&lt;button type="button" class="close" data-dismiss="modal"&gt;x&lt;/button&gt;
						&lt;h3&gt;Thank You!&lt;/h3&gt;
					&lt;/div&gt;
					&lt;div class="modal-body"&gt;
						&lt;div class="hero-unit"&gt;
						&lt;h2&gt;Thanks for getting in touch! Your email has been sent.&lt;/h2&gt;
						&lt;/div&gt;
					&lt;/div&gt;
					&lt;div class="modal-footer"&gt;
						&lt;a href="#" class="btn" data-dismiss="modal"&gt;Close&lt;/a&gt;
					&lt;/div&gt;
				&lt;/div&gt;
				
				&lt;hr&gt;
			&lt;/div&gt;			
		
		<?php 
			if(sizeof($educationInfo) != 0){
				echo '&lt;section id="Education"&gt;&lt;/section&gt;&lt;div class="row-fluid"&gt;&lt;h2 class="float-down"&gt;Education&lt;/h2&gt;';
				for($i = 0; $i < sizeof($educationInfo); $i ++){
					$education = $educationInfo[$i];
					$awards = $education['awards'];
					echo '&lt;section id="education' . $i . '"&gt;&lt;/section&gt;';
					echo '&lt;div class="well"&gt;';
					echo '&lt;h3&gt;' . $education['school'] . '&lt;/h3&gt;';
					echo '&lt;p&gt;&lt;strong&gt;&nbsp;&nbsp;&nbsp;&nbsp;' . $education['degree'] . '&lt;/strong&gt; ' . getFullDate($education['startDate'], $education['endDate']) . '&lt;/p&gt;';
					for($j = 0; $j < sizeof($awards); $j ++)
						echo '&lt;p&gt;&lt;strong&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $awards[$j] . '&lt;/strong&gt;&lt;/p&gt;';
					echo '&lt;/div&gt;';
				}
				echo '&lt;hr&gt;&lt;/div&gt;';
			}
			
			if(sizeof($skillInfo) != 0){
				echo '&lt;section id="Skills"&gt;&lt;/section&gt;&lt;div class="row-fluid"&gt;&lt;h2 class="float-down"&gt;Skills&lt;/h2&gt;';
				for($i = 0; $i < sizeof($skillInfo); $i ++){
					echo '&lt;section id="skill' . $i . '"&gt;&lt;/section&gt;';
					echo '&lt;div class="well"&gt;';
					echo '&lt;h3&gt;' . $skillInfo[$i]['category'] . '&lt;/h3&gt;';
					echo '&lt;ul class="nav nav-tabs nav-stacked"&gt;';
					for($j = 0; $j < sizeof($skillInfo[$i]['skills']); $j++){
						echo '&lt;li&gt;&lt;a id="skill' . $i . '_' . $j . '"&gt;' . $skillInfo[$i]['skills'][$j]['name'] . '&lt;/a&gt;&lt;/li&gt;';
					}
					echo '&lt;/ul&gt;';
					echo '&lt;/div&gt;';
				}
				echo '&lt;hr&gt;&lt;/div&gt;';
			}
			
			if(sizeof($experienceInfo) != 0){
				echo '&lt;section id="Experience"&gt;&lt;/section&gt;';
				echo '&lt;div class="row-fluid"&gt;';
				echo '&lt;h2 class="float-down"&gt;Experience&lt;/h2&gt;';
				for($i = 0; $i < sizeof($experienceInfo); $i ++){
					echo '&lt;section id="experience' . $i . '"&gt;&lt;/section&gt;';
					echo '&lt;div class="well"&gt;';
					echo '&lt;h3&gt;' . $experienceInfo[$i]['position'] . ' ' . getFullDate($experienceInfo[$i]['startDate'], $experienceInfo[$i]['endDate']) . '&lt;/h3&gt;';
					echo $experienceInfo[$i]['group'];
					echo '&lt;ul&gt;';
					$isLink = false;
					for($j = 0; $j < sizeof($experienceInfo[$i]['items']); $j++){
						$item = $experienceInfo[$i]['items'][$j];
						if($item['type'] == 'desc'){
							if($isLink){
								echo '&lt;/ul&gt;';
							}
							echo '&lt;li&gt;' . $item['desc'] . '&lt;/li&gt;';
							$isLink = false;
						}else if($item['type'] == 'link'){
							if(!$isLink){
								echo '&lt;ul class="nav nav-tabs nav-stacked"&gt;';
							}
							echo '&lt;li&gt;&lt;a href="' . $item['link'] . '" target="_blank"&gt;' . $item['name'] . '&lt;/a&gt;&lt;/li&gt;';
							$isLink = true;
						}
					}
					echo '&lt;/ul&gt;';
					echo '&lt;/div&gt;';
				}
				echo '&lt;hr&gt;&lt;/div&gt;';
			}
			
			if(sizeof($activityInfo) != 0){
				echo '&lt;section id="Activity"&gt;&lt;/section&gt;';
				echo '&lt;div class="row-fluid"&gt;';
				echo '&lt;h2 class="float-down"&gt;Activities&lt;/h2&gt;';
				for($i = 0; $i < sizeof($activityInfo); $i ++){
					echo '&lt;section id="activity' . $i . '"&gt;&lt;/section&gt;';
					echo '&lt;div class="well"&gt;';
					echo '&lt;h3&gt;' . $activityInfo[$i]['position'] . ' ' . getFullDate($activityInfo[$i]['startDate'], $activityInfo[$i]['endDate']) . '&lt;/h3&gt;';
					echo $activityInfo[$i]['group'];
                    $isLink = false;
					echo '&lt;ul&gt;';
					for($j = 0; $j < sizeof($activityInfo[$i]['items']); $j++){
						$item = $activityInfo[$i]['items'][$j];
						if($item['type'] == 'fact'){
							if($isLink){
								echo '&lt;/ul&gt;';
							}
							echo '&lt;li&gt;' . $item['desc'] . '&lt;/li&gt;';
							$isLink = false;
						}else if($item['type'] == 'link'){
							if(!$isLink){
								echo '&lt;ul class="nav nav-tabs nav-stacked"&gt;';
							}
							echo '&lt;li&gt;&lt;a href="' . $item['link'] . '" target="_blank"&gt;' . $item['name'] . '&lt;/a&gt;&lt;/li&gt;';
							$isLink = true;
						}
					}
					echo '&lt;/ul&gt;';
					echo '&lt;/div&gt;';
				}
				echo '&lt;hr&gt;';
				echo '&lt;/div&gt;';
			}
		?>	
		&lt;/div&gt;
	&lt;/div&gt;
	&lt;/div&gt;
	&lt;script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"&gt;&lt;/script&gt;
	&lt;script type="text/javascript" src="http://resumake.thegbclub.com/private/bootstrap/js/bootstrap.js"&gt;&lt;/script&gt;
	&lt;script type="text/javascript" src="http://resumake.thegbclub.com/private/bootstrap/js/script.js"&gt;&lt;/script&gt;
	&lt;script type="text/javascript"&gt;
	$(document).ready(function(){
		$('#email-send').click(function(){
			var name = $('#email-name').attr('value');
			var subject = $('#email-subject').attr('value');
			var content = $('#email-content').attr('value');
			$.post('http://resumake.thegbclub.com/private/php_scripts/sendemail.php', {'name':name, 'subject':subject, 'content':content}, function(data){
				$('#thanksmodal').modal('show');
			});
		});
	});
	&lt;/script&gt;
	&lt;script type="text/javascript"&gt;
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
	&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;