<!DOCTYPE HTML>

<?php
	$uid = 0;
	$ext = 0;
	$fileUploaded = false;
	$fileError = false;
	session_start();
    
    //If you are not logged in, go to the main page
	if(!isset($_COOKIE['remember']) && !isset($_SESSION['uid'])){
		header('Location: /');
	}else{
        //set the session cookie if it is not set
        if(!isset($_SESSION['uid']))
            $_SESSION['uid'] = $_COOKIE['remember'];
		$uid = $_SESSION['uid'];
        
        //Get the user from the session id
        include_once('private/php_scripts/dbObject.php');
        $db = new dbObject;
        $db->connect();
        $user = $db->getUserById($uid);
        $usernameFromUid = $user->username;
        
        //Get the user from GET
        $username = $_GET['uid'];
        
        //If you are not the user of this profile page, navigate to your profile page
        if($usernameFromUid != $username){
            header('Location: /users/' . $usernameFromUid);
        }else{
            //Get all the resumes pertaining to you via uid
            $resumes = $db->getResumesByUid($uid);
            
            //Get the img file path and the user info
            $imgpath = '../' . $user->imagepath;	
			$user_info = json_decode($user->info);
            
            //If a file was uploaded
            if(sizeof($_FILES) != 0 && $_FILES['img']['tmp_name'] != ''){
                //Get the uploaded file and its attributes, if the file is not an image format
                //fileError
                $name = $_FILES['img']['name'];
                $tmp = $_FILES['img']['tmp_name'];
                $a = getimagesize($tmp);
                $image_type = $a[2];
                if($image_type == 6 || ($image_type > 0 && $image_type < 4)){
                    $fileError = false;
                }else{
                    $fileError = true;
                }
		
                //If there is no error
                if(!$fileError){
                    //build the new path and move the file to its permanent location
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $newpath = 'imgs/' . $username . '.' . $ext;
                    $fileUploaded = move_uploaded_file($tmp,$newpath);

                    //load the file into SimpleImage
                    include('private/php_scripts/SimpleImage.php');
                    $image = new SimpleImage();
                    $image->load($newpath);
                    $width_ratio = 512/$image->getWidth();
                    $height_ratio = 512/$image->getHeight();

                    //Test to see if the file is large in any way
                    //If it is, scale it down to a reasonable size
                    if($width_ratio < 1 && $height_ratio < 1){
                        if($width_ratio > $height_ratio)
                            $image->resizeToHeight(512);
                        else $image->resizeToWidth(512);
                    }else if($width_ratio < 1){
                        $image->resizeToWidth(512);
                    }else if($height_ratio < 1){
                        $image->resizeToHeight(512);
                    }
                    
                    //save the new image
                    $image->save($newpath);
                    
                    $newpath = '../' . $newpath;
                }
            }
        }
	}
?>
<html lang="en">
<head>
	<title><?php echo $user->name?></title>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap-responsive.css"></link>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/jquery.Jcrop.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/jquery.Jcrop.css"></link>
	
	<style type="text/css">
	body{
		padding-top:60px;
	}
	img{
		max-width:none;
	}
	.center-modal{
		left:0px;
	}
    div.btn-checkbox{
      width:10px;
      height:10px;
      padding:0px;
      border:1px solid #a0a0a0;
      background-color:#f8f8f8;
      cursor:pointer;
      display:inline-block;
    }div.btn-checkbox:hover{
      border:1px solid #808080;
    }
    div.checkbox-selected{
      background-color:#efefef;
    }
    div.checkbox-selected-mark{
      display:inline-block;
      width:14px;
      height:15px;
      background:url(../private/imgs/check.png) no-repeat -4px -6px;
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
				</div>
				<ul class="nav pull-right">
					<li><a href='#' id='btn-logout'>Logout</a></li>
				</ul>
			</div>
		</div>
    </div>
	<center>
	<div class="modal hide span12 center-modal offset1" id="editimagemodal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Crop Your Profile Image</h3>
		</div>
		<div class="modal-body row">
			<div class="span4 pull-left">
				<h3>Profile Image Preview</h3>
				<br><br><br>
				<div style="width:254px;height:254px;overflow:hidden;">
				<?php 
					if($fileUploaded && !$fileError){
						echo '<img src="' . $newpath . '" id="image-preview"/>';
					}
				?>
				</div>
			</div>
			<div class="span6 pull-right">
				<?php 
					if($fileUploaded && !$fileError){
						echo '<img src="' . $newpath . '" id="preview-large"/>';
					}
				?>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Cancel</a>
			<a href="#" class="btn btn-primary" data-dismiss="modal" id="img-edit-done">Done</a>
		</div>
	</div> 
	</center>
    <div class="container-fluid">
		<div class="row-fluid">
			<div class="span3 columns">
				<div class="page-header">
					<h1><?php echo $user->name;?></h1>
				</div>
		
				<div class="thumbnail">
					<img src="<?php if($imgpath == '../') echo '../private/default/me.jpg'; else echo $imgpath?>" width="254" height="254" alt="" id="profile-img">
					<br>
					<br>
					<center>
						<a class="btn btn-primary" href="#picture-modal" data-toggle="modal">Change Profile Picture</a>
					</center>
					<br>
				</div>
				<br>
				<div class="well">
                    <p><h5 id='info-statement'>&nbsp;&nbsp;Statement: <?php if($user_info)echo $user_info->{'statement'}?></h5></p>
                    <br>
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
					<p><h5 id='info-email'>&nbsp;&nbsp;Email: <?php if($user_info)echo $user_info->{'email'} ?></h5></p>
					<p><h5 id='info-phone'>&nbsp;&nbsp;Phone Number: <?php if($user_info)echo $user_info->{'phone'}?></h5></p>
					<br>
					<a class="btn btn-primary btn-large" href="#infomodal" id="editinfo" data-toggle="modal">Edit My Information</a>
					<br>
				</div>
			</div>	
			<div class="span9 fixed-inbox">
                <div class="modal hide" id="html-modal">
                    <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h4>Use the Html code below to put your resume on your website</h4>
					</div>
                    <div class="modal-body">
                        <textarea class="span12" id="html-textarea" rows="12" style="resize:none;"></textarea>
                    </div>
                    <div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Done</a>
					</div>
                </div>
				<div class="modal hide" id="picture-modal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h3>Upload Your Profile Picture</h3>
					</div>
					<div class="modal-body">
						<form class="well" enctype="multipart/form-data" action="<?php echo $username?>" method="post">
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
                            <h2>Statement</h2>
                            <input type="text" class="span5" id="modal-statement">
                            <br>
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
                <div class="page-alert-container"></div>
                <?php
                    $hasDraft = $db->hasDraft($uid);
                    if($hasDraft == '1')
                        echo '<div class="btn-group span6">';
                ?>
				<a href="/make/" class="btn-primary btn span2">Add New Resume</a>
                <?php
                    if($hasDraft == '1'){
                        echo '<a href="/draft/" class="btn-primary btn span2">Draft</a>';
                        echo '</div>';
                    }
                ?>
                
                
                <div class="btn-group span4">
                    <a href="#" class="btn btn-small btn-primary" id="edit-btn"><i class="icon-white icon-wrench"></i> Edit</a>
                    <a href="#" class="btn btn-small btn-primary" id="print-btn"><i class="icon-white icon-print"></i> Print</a>
                    <a href="#" class="btn btn-small btn-primary" id="trash-btn"><i class="icon-white icon-trash"></i> Trash</a>
                    <a href="#" class="btn btn-small btn-primary" id="html-btn"><i class="icon-white icon-share"></i> Html</a>
                </div>
                
				<table class="table table-striped">
					<thead>
                        <th><div class="btn-checkbox" id="check-all"></div> Select</th>
						<th>Resume</th>
						<th>Created On</th>
					</thead>
                    <tbody id="resume-tbody">
                    <?php
                        foreach($resumes as $resume){
                            echo '<tr>';
                            echo '<td>';
                            echo '<div class="btn-checkbox btn-item-label" rid-label="' . $resume->rid . '"></div>';
                            echo '</td>';
                            
                            echo '<td>';
                            
                            //The Link of the resume
                            echo '<a href="../rmks/' . $username . '/' . $resume->rid . '">';
                            
                            //The Name of the resume
                            echo $resume->name;
                            
                            echo '</a>';
                            echo '</td>';
                            echo '<td>';
                            
                            //The date it was created
                            echo 'Created On ' . date('F j, Y', $resume->date_created);
                            
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
    $('#edit-btn').click(function(index){
        if($(".btn-item-label.checkbox-selected").length != 1){
            $(".page-alert-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button><strong>Wait! </strong> You can only edit one resume at a time.</div>');
        }else{
            window.location.href = '../edit/' + $(".btn-item-label.checkbox-selected").attr('rid-label');
        }
    });
    
    $('#print-btn').click(function(index){
        if($(".btn-item-label.checkbox-selected").length != 1){
            $(".page-alert-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button><strong>Wait! </strong> You can only print one resume at a time.</div>');
        }else{
            window.location.href = '../print/' + $(".btn-item-label.checkbox-selected").attr('rid-label');
        }
    });
    
    $('#trash-btn').click(function(index){
        var resumeDelete = new Array();
        $(".btn-item-label").each(function(index){
            var className = $(this).attr("class");
            if(className.indexOf(" checkbox-selected") != -1)
                resumeDelete.push($(this).attr("rid-label"));
        });
        
        $.post('../private/php_scripts/resumeedit.php', {'request':'delete', 'resumes':resumeDelete, 'username':username, 'uid':uid}, function(data){
            var content = "";
            if(data != "]"){
                var resumes = eval('(' + data + ')');

                for(var i = 0; i < resumes.length; i++){
                    content += resumes[i];
                }
            }
            $("#resume-tbody").html(content);
            $('.btn-checkbox').each(function(index){
      
                $(this).click(function(index){
                    var className = $(this).attr("class");
                    if(className.indexOf(" checkbox-selected") == -1){
                        className += " checkbox-selected";
                        $(this).html('<div class="checkbox-selected-mark"></div>');
                        if($(this).attr("id") == "check-all"){
                            $('.btn-checkbox').each(function(index){
                                if($(this).attr("class").indexOf(" checkbox-selected") == -1){
                                    var className = $(this).attr("class");
                                    $(this).attr("class", className + " checkbox-selected");
                                    $(this).html('<div class="checkbox-selected-mark"></div>');
                                }
                            });
                        }
                    }else{
                        className = className.replace(" checkbox-selected", "");
                        $(this).html('');
                        if($(this).attr("id") == "check-all"){
                            $('.btn-checkbox').each(function(index){
                                if($(this).attr("class").indexOf(" checkbox-selected") != -1){
                                    var className = $(this).attr("class");
                                    $(this).attr("class", className.replace(" checkbox-selected", ""));
                                    $(this).html('');
                                }
                            });
                        }
                    }
                    $(this).attr("class", className);
                });
            });
        });
    });
    
    $('#html-btn').click(function(index){
        if($(".btn-item-label.checkbox-selected").length != 1){
            $(".page-alert-container").html('<div class="alert alert-info"><button class="close" data-dismiss="alert">×</button><strong>Wait! </strong> You can only share one resume at a time.</div>');
        }else{
            $("#html-textarea").html("");
            $.post("../download.php", {'uid':uid, 'rid':$(".btn-item-label.checkbox-selected").attr("rid-label")}, function(data){
                $("#html-textarea").html(data);
                $("#html-modal").modal('show');
            });
        }
    });
    
    //checkbox stuff
    $('.btn-checkbox').each(function(index){
      
      $(this).click(function(index){
        var className = $(this).attr("class");
        if(className.indexOf(" checkbox-selected") == -1){
          className += " checkbox-selected";
          $(this).html('<div class="checkbox-selected-mark"></div>');
          if($(this).attr("id") == "check-all"){
            $('.btn-checkbox').each(function(index){
            if($(this).attr("class").indexOf(" checkbox-selected") == -1){
              var className = $(this).attr("class");
                $(this).attr("class", className + " checkbox-selected");
                $(this).html('<div class="checkbox-selected-mark"></div>');
              }
            });
          }
        }else{
          className = className.replace(" checkbox-selected", "");
          $(this).html('');
          if($(this).attr("id") == "check-all"){
            $('.btn-checkbox').each(function(index){
              if($(this).attr("class").indexOf(" checkbox-selected") != -1){
                var className = $(this).attr("class");
                $(this).attr("class", className.replace(" checkbox-selected", ""));
                $(this).html('');
              }
            });
          }
        }
        $(this).attr("class", className);
      });
    });
    
    //image crop stuff
	var img_x = 0, img_y = 0, img_width = 254, img_height = 254;
	function showPreview(coords){
		if (parseInt(coords.w) > 0){
			var rx = 254 / coords.w;
			var ry = 254 / coords.h;
			var x = Math.round(rx * coords.x);
			var y = Math.round(ry * coords.y);
			var width = Math.round(rx * $('#preview-large').css('width').split("px")[0]);
			var height = Math.round(ry * $('#preview-large').css('height').split("px")[0]);
			img_x = coords.x;
			img_y = coords.y;
			img_width = coords.w;
			img_height = coords.h;
			
			jQuery('#image-preview').css({
				width: width + 'px',
				height: height + 'px',
				marginLeft: '-' + x + 'px',
				marginTop: '-' + y + 'px'
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
			$.post('../private/php_scripts/logout.php', function(data){
				window.location.href = '/';
			});
		});
		$('#img-edit-done').click(function(){
			$.post('../private/php_scripts/resize.php', {'x':img_x, 'y':img_y, 'width':img_width, 'height':img_height, 'file':username + '.' + ext, 'username':username}, function(data){
				$('#profile-img').attr('src', '../' + data);
			});
		});
		$("#editinfo").modal({'show':false});
		$("#infomodal").on('show', function(){
            $("#modal-statement").attr('value', info.statement);
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
            info.statement = $("#modal-statement").attr('value');
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
			$.post('../private/php_scripts/updateInfo.php', {'uid':uid, 'info':info}, function(data) {
                $('#info-statement').html('&nbsp&nbspStatement: ' + info.statement);
				$('#info-age').html('&nbsp&nbspAge: ' + info.age);
				$('#info-birthday').html('&nbsp&nbspBirthday: ' + info.birthday);
				$('#info-gender').html('&nbsp&nbspGender: ' + info.gender);
				$('#info-occupation').html('&nbsp&nbspOccupation: ' + info.occupation);
				$('#info-address').html('&nbsp&nbspAddress: ' + info.address);
				$('#info-city').html('&nbsp&nbspCity: ' + info.city);
				$('#info-state').html('&nbsp&nbspState: ' + info.state);
				$('#info-zip').html('&nbsp&nbspZip: ' + info.zip);
				$('#info-email').html('&nbsp;&nbsp;Email: ' + info.email);
				$('#info-phone').html('&nbsp&nbspPhone Number: ' + info.phone);
			});
		});
	});
	var info = <?php if($user_info)echo $user->info;else echo '{}' ?>;
	var uid = <?php echo $uid ?>;
	var username = '<?php echo $username ?>';
	var ext = '<?php echo $ext ?>';
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
