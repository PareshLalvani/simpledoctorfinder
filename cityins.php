<?php
	ob_start();
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
<title>Registration of Cities</title>
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
	var estate = document.getElementById("city_name");
	estate.value = estate.value.toUpperCase();
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
		ob_flush();
?>
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post">		
		<article class="module width_half" >
			<header><h3>City: Registration</h3></header>
				<div class="module_content" >
					<fieldset>
                   		<label>STATE</label>
                   		 <select style="width:35%;" id="state_code" name="state_code" >
    						<option value="">Select Your State</option>
						<?php
							 while($res = $allstatesel->fetch_object())
                        	 {
                      	?>
                         	 <option value="<?php echo $res->STATE_CODE; ?>"><?php echo $res->STATE_NAME; ?></option>
                       	<?php
                       		 }
                       	?>
                   		 </select>                        
					</fieldset>
 
					<fieldset>
						<label>CITY</label>
						<input style="width:50%;text-transform:uppercase;" type="text" id = "city_name" name="city_name"/>
                    </fieldset>

<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="SAVE_CITY" value="SAVE" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['SAVE_CITY']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_error">'.$city_name.' CITY '.'ALREADY EXISTS ! ... RESET TO ENTER ANOTHER CITY</h4>';
		}
		else
		{
			$data 		= array('city_name'=>$city_name, 'state_code'=>$state_code);
			$ex = $mod->insert($conn,'city',$data);
			echo "<h4 class=".'"alert_success">'.$city_name.' '.'INSERTED SUCCESSFULLY ...RESET TO ENTER ANOTHER</h4>';
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