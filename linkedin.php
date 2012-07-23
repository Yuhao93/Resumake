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
        authorize: true
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
    
    <p>This example demonstrates the use of a login button to control what's displayed.  It also demonstrates how to use the LinkedIn auth events in a user flow.</p>

<!-- NOTE: be sure to set onLoad: onLinkedInLoad -->
<script type="text/javascript">
function onLinkedInLoad() {
  IN.Event.on(IN, "auth", function() {onLinkedInLogin();});
  IN.Event.on(IN, "logout", function() {onLinkedInLogout();});
}

function onLinkedInLogout() {
  setLoginBadge(false);
}

function onLinkedInLogin() {
  // we pass field selectors as a single parameter (array of strings)
  IN.API.Profile("me")
    .fields(["id", "firstName", "lastName", "pictureUrl", "publicProfileUrl"])
    .result(function(result) {
      setLoginBadge(result.values[0]);
    })
    .error(function(err) {
      alert(err);
    });
}

function setLoginBadge(profile) {
  if (!profile) {
    profHTML = "<p>You are not logged in</p>";
  }
  else {
    var pictureUrl = profile.pictureUrl || "http://static02.linkedin.com/scds/common/u/img/icon/icon_no_photo_80x80.png";
    profHTML = "<p><a href=\"" + profile.publicProfileUrl + "\">";
    profHTML = profHTML + "<img align=\"baseline\" src=\"" + pictureUrl + "\"></a>";      
    profHTML = profHTML + "&nbsp; Welcome <a href=\"" + profile.publicProfileUrl + "\">";
    profHTML = profHTML + profile.firstName + " " + profile.lastName + "</a>! <a href=\"#\" onclick=\"IN.User.logout(); return false;\">logout</a></p>";
  }
  document.getElementById("loginbadge").innerHTML = profHTML;
}
</script>

<!-- need to be logged in to use; if not, offer a login button -->
<script type="IN/Login"></script>

<div id="loginbadge">
  <p>Login badge renders here if the current user is authorized.</p>
</div>
    
    
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="private/bootstrap/js/bootstrap.js"></script>
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
