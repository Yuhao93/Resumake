<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Resumake | It's Coming</title>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap.css"></link>
	<link rel="stylesheet" type="text/css" href="../private/bootstrap/css/bootstrap-responsive.css"></link>
</head>
<body>
    <div class="modal hide" id="sentModal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Thanks!</h3>
        </div>
        <div class="modal-body">
            <h2>Thanks for putting yourself on the list!</h2>
            <h3>We'll notify you when Resumake is out and ready for use!</h3>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Ok</a>
        </div>
    </div>
    
    <div class="row">
		<div class="page-header">
			<h1 class="offset1">
			<img src="../private/imgs/logo.png"></img>
			<small>Here's an idea, let's give everyone an online resume, for free.</small>
			</h1>
		</div>
	</div>
    <br>
	<div class="container">
    <div class="hero-unit row span10">
        <h1>Resumake: The Online Resume Solution</h1>
        <br><br>
        <h2>Sign With Your Email For More Info</h2>
        <div id="alert-container"></div>
        <div class="row span10" style="position:relative;margin-left:0px;">
            
            <input type="text" style="height:32px;width:750px;font-size:24px;padding-top:13px;padding-bottom:10px;margin-top:8px;" placeholder="Your Email" id="preview-email">
            <a href="#" class="btn btn-primary btn-large" style="display:inline-block;width:190px;height:36px;border-radius:2px;font-size:24px;position:absolute;right:-10px;top:8px;" id="preview-register">Sign Up</a>
        </div>
        <div class="row span10" style="margin-left:0px;">

        <div class="collapse" id="video">
            <center><!-- Video Goes Here --></center>
        </div>
        <!--<center><h2><a href="#video" data-toggle="collapse">Watch The Video</a></h2></center>-->
        </div>
    </div>
    

    <div class="row span11">
        <br>
        <center><h1 class="row span11">Create An Online Resume That You Can Easily Show Your Future Employers</h1></center>
        <br><br><br><br><br>
        <section class="span5">
            <div class="page-header">
                <h2>Resumake Lets You Have An Online Resume For Free.<br><small>No Webserver or Programming Needed.</small></h2>
            </div>
            <p>Adapt to the changing times and get an online resume. Today, companies not only accept online resumes but also prefer them. It makes it easier for them to find certain skills and experiences in their applicants. Needless to say, having an online resume is becoming a necessity.</p>
            <p>Let Resumake give you an online resume. Free and Simple.</p>
            <p>After you have uploaded your online resume, companies that are eager to find new employees will be able to access our database of resumes. Our double-blinded match-making process ensures that when a company contacts you, both sides will be excited to pursue the offer.</p>
        </section>
        <div class="thumbnail span5">
            <img src="../private/imgs/home1.png">
        </div>
    </div>
    <div class="row span11">
        <br><br><br><br><br><br>
        <center><h1 class="row span11">No Tricky Web Programming, No Hassle, Just That Simple</h1></center>
        <br><br><br><br><br>
        <div class="thumbnail span5">
            <img src="../private/imgs/home2.png">
        </div>
        <section class="span5">
            <div class="page-header">
                <h2>Upload A Resume And You're Done<br><small>No Need For Any Web Programming Or Rented Server Space</small></h2>
            </div>
            <p>Typically, the process of making an online resume is long and expensive. Creating a professional looking website is hard and time-consuming. In order to do it well, you have to invest a lot of time that could be spent doing other things.</p>
            <p>To host up your webpage, you need server space. This can be achieved through a free website making service that creates an unprofessional and unnattractive website or through renting or buying server space, which can often times be expensive.</p>
            <p>Resumake makes it easy to host an online resume. We don't charge you any fee for hosting your resume and we streamline your resume making process. You can even import your profile from LinkedIn to make the process even easier</p>
        </section>
    </div>
    
    <div class="row span11">
        <br><br><br><br><br><br>
        <center><h1 class="row span11">Let Resumake Play Match-maker</h1></center>
        <br><br><br><br><br>
        <section class="span5">
            <div class="page-header">
                <h2>Employers Are Looking For Resumes And You Have One<br><small>We Think We Can Work Something Out.</small></h2>
            </div>
            <p>Resumake's advanced match-making algorithm makes both parties benefit. Every applicant that a company pursues that doesn't end in an acceptance of an offer is time and money lost. Likewise, any company that you pursue that doesn't end in an offer is time lost.</p>
            <p>Our double-blind match-making algorithm makes sure that companies target the resumes that are the best fit for their criteria and that you only show up on the radars of companies that can make an offer to appease both sides.</p>
        </section>
        <div class="thumbnail span5">
            <img src="../private/imgs/home3.png">
        </div>
    </div>
    
    <div class="row span11">
        <br><br><br><br><br><br>
        <section class="span11">
            <div class="page-header">
                <h1>Coming Soon<br><small>Sign Up Now</small></h1>
            </div>
            <p>Give us your email and we'll let you know as soon as Resumake is up and running. With our first release coming soon, be sure to get in on the action right when its released.</p>
        </section>
    </div>
    <div class="row span11">
    <br><br><br><br><br><br><br>
    </div>
    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="../private/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
    function register(){
        var email = $("#preview-email").attr("value");
        email = email.replace(" ", "");
        if(validateEmail(email) && email.substring(email.length - 4) == ".edu"){
            $("#sentModal").modal('show');
            $.post("../private/php_scripts/previewRegister.php", {'email':email}, function(data){});
        }else{
            var alertText = '<div class="alert alert-error" style="font-size:18px;"><button class="close" data-dismiss="alert">x</button><strong>Oh No!</strong> Please enter in a valid .edu email address.</div>'
            $("#alert-container").html(alertText);
        }
    }
    $(document).ready(function(){
        $("#preview-register").click(function(){
            register();
        });
        $('#preview-email').keypress(function(e){
            if(e.which == 13){
                register();
		}
        });
    });
    function validateEmail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
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
</html>
