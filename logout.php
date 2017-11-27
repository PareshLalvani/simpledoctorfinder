<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{
    // session isn't started
    session_start();
	ob_start();
	}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>DoctorFinder</title>
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
<?php
	if(isset($_SESSION['loggedkey']) && $_SESSION['loggedkey'] == 'yes') 
	{
//		echo "before session destroy ...";
		session_destroy();
		echo "<h4 class=".'"alert_success">'.$_SESSION['logintype']. ' '.$_SESSION['username'].' '.'Logged Out Successfully ...</h4>';
		exit(header("refresh:3;index.php"));
	}
	else
	{
		echo "<h4 class=".'"alert_error">NO ONE STILL NOT LOGGED IN ...</h4>';		
		exit(header("refresh:3;index.php"));
	}
	ob_flush();
	ob_end_flush();
	ob_clean();
	ob_end_clean();
?>
		<div class="spacer"></div>
</section>
</body>
</html>