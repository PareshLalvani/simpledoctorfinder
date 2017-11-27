<?php
	ob_start();
?>
<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");
?>
<?php
	ob_flush();
?>
<?php
	if(isset($_POST['Submit']))
	{
		// code for check server side validation
		if(empty($_SESSION['captcha_code']) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
		{  
			$msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.		
		}
		else
		{
			// Captcha verification is Correct. Final Code Execute here!		
		$msg="<span style='color:green'>The Validation code has been matched.</span>";		
		}
	}		

	if (isset($_REQUEST['Sign_In']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_success">LOGGED IN SUCCESSFULLY ...</h4>';
			header("refresh:3;index.php");
		}
		else
		{
			echo "<h4 class=".'"alert_error">INVALID USER CREDENTIALS ! ...</h4>';
//			header("refresh:3;login.php");
		}
	}
?>			
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Dashboard I Admin Panel</title>
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>
</head>
<body>
<?php
	include_once("includes/header.php");
?>
<?php
	include_once("includes/left.php");
?>
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post">		
		<article class="module width_half">
			<header><h3>Sign In</h3></header>
				<div class="module_content">
					<fieldset>
                   		<label>LOGIN TYPE</label>
                   		 <select style="width:40%;" name="logintype">
    						<option value="">Select Your Login</option>
                   			<option value="User">User</option>
                    		<option value="Dr. ">Doctor</option>
                    		<option value="Admin">Admin</option>
                   		 </select>                        
					</fieldset>

					<fieldset>
						<label>LOGIN ID / MOBILE No./ EMAIL Id</label>
							<input style="width:50%;" type="text" name="myloginid"/>
					</fieldset>
                    
					<fieldset>
						<label>PASSWORD</label>
							<input style="width:50%;" type="password" name="mypswd" />
					</fieldset>

					<fieldset><label></label>
                  		  <?php echo $msg;?>
                    </fieldset>

					<fieldset>
						<label>VALIDATION CODE</label>
	                        <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg' />
					</fieldset>

					<fieldset>
						<label>ENTER THE CODE ABOVE HERE :</label>
							<input style="width:50%;" id="captcha_code" type="text" name="captcha_code" />
					</fieldset>

					<fieldset><label></label>
                  		  CAN'T READ IMAGE? CLICK <a href='javascript: refreshCaptcha();'>HERE</a> TO REFRESH
                    </fieldset>

					<fieldset><label></label>
						<input name="Submit" type="submit" onclick= "return validate();" value="Submit Validation Code" class="button1" />
                    </fieldset>


					<fieldset>
						<label> </label>
							<input type="checkbox" name="storecookie" id="storecookie" value="Yes"/>REMEBER ME
                    </fieldset></div>

<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="Sign_In" value="Sign In" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article><!-- end of post new article -->
		</form>		

<!--		<h4 class="alert_error">An Error Message</h4>	-->
<!--		<h4 class="alert_success">A Success Message</h4>	-->
<div class="spacer"></div>
</section>
</body>
</html>