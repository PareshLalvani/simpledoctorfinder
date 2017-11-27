<?php
//	ob_start();
?>
<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{ // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");
?>
<?php
//	ob_flush();
?>	
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>States, Cities & Location Masters</title>
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

<script>
function preferedMast(x) 
{
    prefer = document.forms[0].sclm.value;
    alert("You prefered Master: " + prefer);
	document.forms[0].sclm.style.background = "white";
	document.getElementById("sclm").style.background = "white";
}

function backgcolor(x) 
{
    x.style.background = "yellow";
}
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
		<article class="module width_half" >
			<header><h3>State, City, Location :   Registration</h3></header>
				<div class="module_content" >
					<fieldset>
                   		<label>STATE / CITY / LOCATION</label>
                   		 <select id="sclm" style="width:35%;" name="scl" onchange="preferedMast(this)" onBlur="preferedMast(this)" onfocus="backgcolor(this)" >
    						<option value="">Select Your Master</option>
                   			<option value="State">State</option>
                    		<option value="City">City</option>
                    		<option value="Location">Location</option>
                   		 </select>                        
					</fieldset>

					<fieldset>
						<label>STATE</label>
							<input style="width:50%;" type="text" name="state"/>
					</fieldset>

<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="SAVE" value="Save" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['Sign_In']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_success">'.$_SESSION['logintype']. ' '.$_SESSION['username'].' '.'LOGGED IN SUCCESSFULLY ...</h4>';
			header("refresh:3;index.php");
		}
		else
		{
			echo "<h4 class=".'"alert_error">INVALID USER CREDENTIALS ! ...</h4>';
			header("refresh:3;login.php");
		}
	}
//	ob_end_flush();
//	ob_clean();
//	ob_end_clean();
?>		
<!--		<h4 class="alert_error">An Error Message</h4>	-->
<!--		<h4 class="alert_success">A Success Message</h4>	-->
<div class="spacer"></div>
</section>
</body>
</html>