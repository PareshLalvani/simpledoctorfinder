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
<title>Registration of Locations (Areas) of a City</title>
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
function get_city(selstate)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/obtaincities.php?state_code="+selstate, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
//			alert(http.status);			
//			alert(http.responseText);
			document.getElementById("answer").innerHTML=http.responseText;
		}
	}
}

function convuppercase()
{
	var estate = document.getElementById("location");
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
			<header><h3>Location: Registration</h3></header>
				<div class="module_content" >

					<fieldset>
                   		<label>STATE</label>
                   		 <select style="width:35%;" id="state_code" name="state_code" onchange="get_city(this.value)" >
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
                   		 <select style="width:35%;" name="city_code" id="answer" >
    						<option value="">Select Your City</option>
						<?php
                      		 foreach ($scities as $res)
                        	 {
                      	?>
                         	 <option value="<?php echo $res->CITY_CODE; ?>"><?php echo $res->CITY_NAME; ?></option>
                       	<?php
                       		 }
                       	?>
                   		 </select>                        
					</fieldset>

					<fieldset>
						<label>LOCATION</label>
						<input style="width:50%;text-transform:uppercase;" type="text" id = "location" name="location" onKeyUp="convuppercase()"/>
                    </fieldset>
<div class="clear"></div>	
			<footer>
				<div class="submit_link">
					<input type="submit" name="SAVE_LOC" value="SAVE" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['SAVE_LOC']))
	{
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_error">'.$location.' Location '.'ALREADY EXIST ! ... Reset & Enter another city...</h4>';
		}
		else
		{
			$data = array('location'=>$location, 'city_code'=>$city_code);
			$ex = $mod->insert($conn,'location',$data);
			echo "<h4 class=".'"alert_success">'.$location.' '.'INSERTED SUCCESSFULLY ...RESET TO ENTER ANOTHER</h4>';
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