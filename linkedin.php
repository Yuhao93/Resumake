<!DOCTYPE HTML>
<?php
	include_once('private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
	session_start();
?>
<html lang="en">
<head>
	<title>LinkedIn Import</title>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="private/bootstrap/css/bootstrap-responsive.css"></link>
    <style type="text/css">
	body{
		padding-top:60px;
	}
	</style>
    <script type="text/javascript" src="http://platform.linkedin.com/in.js">
        api_key: zb8gl61hj3lq
        onLoad: onLinkedInLoad
    </script>
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

    <div class="container">
        <div class="well">
            <script type="IN/Login"></script>
            <div id="profile"></div>
        </div>
    </div>
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="private/bootstrap/js/json2.js"></script>
    <script type="text/javascript">
        function onLinkedInLoad() {
            IN.Event.on(IN, "auth", function() {onLinkedInLogin();});
        }
        function onLinkedInLogin() {
            var requestedAttributes = ["formattedName", "headline", "mainAddress", "phoneNumbers", "educations", "skills", "positions", "volunteer", "languages"];
            IN.API.Profile("me")
                .fields(requestedAttributes)
                .result(function(result) {
                    importLinkedInProfile(result.values[0]);
                })
                .error(function(err) {
                });
        }
        function importLinkedInProfile(profile) {
            var resume = {'basicInfo':{}, 'contactInfo':{}, 'educationInfo':[], 'skillInfo':[], 'experienceInfo':[], 'activityInfo':[]};
            
            var name = profile.formattedName || '';
            var position = profile.headline || '';
            resume.basicInfo = {'name':name, 'position':position, 'statement':''};
            
            var address = profile.mainAddress || '';
            var phoneNumber = ((profile.phoneNumbers == undefined) ? "" : profile.phoneNumbers.values[0].phoneNumber);
            resume.contactInfo = {'address':address, 'state':'', 'zip':'', 'city':'',
            'phoneNumber':phoneNumber, 'email':''};
            
            if(profile.educations != undefined)
                for(var i = 0; i < profile.educations._total; i++){
                    var education = profile.educations.values[i];
                    var schoolName = education.schoolName || '';
                    var degree = education.degree || '';
                    var fieldOfStudy = education.fieldOfStudy || '';
                    resume.educationInfo.push({'school':schoolName, 'degree':degree + ' in ' + fieldOfStudy, 'startDate':getDate(education.startDate), 'endDate':getDate(education.endDate)});
                }
            
            if(profile.skills != undefined){
                resume.skillInfo.push({'category':'', 'skills':[]});
                for(var i = 0; i <profile.skills._total; i++){
                    var skillName = profile.skills.values[i].skill.name || '';
                    resume.skillInfo[0].skills.push({'name': skillName, 'desc':''});
                }
            }
            
            if(profile.languages != undefined){
                resume.skillInfo.push({'category':'Languages', 'skills':[]);
                var ind = resume.skillInfo.length - 1;
                for(var i = 0; i < profile.languages; i++){
                    resume.skillInfo[ind].skills.push({'name':''});
                }
            }
            
            
            $("#profile").html(JSON.stringify(profile));
        }
        function getDate(instring){
            if(instring == undefined)
                return "";
            if(instring.year == undefined && instring.month == undefined)
                return "";
            if(instring.month == undefined)
                return instring.year;
            if(instring.day == undefined)
                return instring.year + '-' + instring.month;
            return instring.year + '-' + instring.month + '-' + instring.day;
        }
        
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
