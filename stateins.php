<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{ // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Registration of States</title>
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
/*
function preferedMast(x) 
{
//    prefer = document.forms[0].sclm.value;
//    alert("You prefered Master: " + prefer);
//	document.forms[0].sclm.style.background = "white";
//	document.getElementById("sclm").style.background = "white";
}

function backgcolor(x) 
{
//    x.style.background = "yellow";
}

function searchstate()
{
	http = new XMLHttpRequest();
	var estate = document.getElementById("state");
	estate.value = estate.value.toUpperCase();
	http.open("GET","includes/findstate.php?estate="+estate.value, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4)
		{
			//alert(http.responseText);
			document.getElementById("answer").innerHTML = http.responseText;
		}
	}
}
*/

function convuppercase()
{
	var estate = document.getElementById("state");
	estate.value = estate.value.toUpperCase();
}
</script>
</head>
<body>
<?php
	ob_start();
	include_once("includes/header.php");
?>
<?php
	include_once("includes/left.php");
?>
<?php
	if (!isset($_SESSION['logintype']))
	{
		echo "<h4 class=".'"alert_error">'.' PLEASE LOGIN TO HAVE ACCESS TO THIS PAGE ... !</h4>';
		exit(header("refresh:3;index.php"));			
	}
	else
		if ($_SESSION['logintype'] !== "Admin")
		{
			echo "<h4 class=".'"alert_error">'.' ONLY ADMIN IS AUTHORISED TO THIS PAGE ... !</h4>';
		exit(header("refresh:3;index.php"));			
		}
?>
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post">

		<article class="module width_half" >
			<header><h3>State: Registration</h3></header>
				<div class="module_content" >
 
                    <div id="answer"></div>
					<fieldset>
						<label>STATE</label>
							<input style="width:50%;" type="text" id = "state" name="state" onKeyUp="convuppercase()"/>
                    </fieldset>

<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="SAVE_STATE" value="SAVE" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['SAVE_STATE']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_error">'.$state_name.' STATE '.'ALREADY EXISTS ! ... RESET TO ENTER ANOTHER STATE</h4>';
		}
		else
		{
			$data 		= array('state_name'=>$state_name);
			$ex = $mod->insert($conn,'state',$data);
			echo "<h4 class=".'"alert_success">'.$state_name.' '.'INSERTED SUCCESSFULLY ...</h4>';
			header("refresh:3;index.php");				
		}
	}

//	ob_end_flush();
//	ob_clean();
//	ob_end_clean();
	ob_flush();
?>		
<!--		<h4 class="alert_error">An Error Message</h4>	-->
<!--		<h4 class="alert_success">A Success Message</h4>	-->
<div class="spacer"></div>
</section>
</body>
</html>