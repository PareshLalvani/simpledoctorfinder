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
<title>Registration of USERS</title>
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

function convuppercase(a)
{
	var estate = document.getElementById("a");
	estate.value = estate.value.toUpperCase();
}

function get_city(selstate)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/getstcities.php?state_code="+selstate, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("canswer").innerHTML=http.responseText;
		}
	}
}	

function get_loc(selcity)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/obtainctloc.php?RD_CITY_CD="+selcity, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("lanswer").innerHTML=http.responseText;
		}
	}
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
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post" class="quick_search">		
		<article class="module width_full" >
			<header><h3>Search : DOCTORS WITH FOLLOWING CRITERIA </h3></header>
				<div class="module_content" >

			<fieldset> 
				<label>SELECT SPECIALITY : </label>
 						<select name="SP_CODE" id="SP_CODE" style="width:50%;">
                            <option value=""> Select Speciality </option>
 							<?php
								while($res = $selallsp->fetch_object())
								 {
              				?>
	           				 <option value="<?php echo $res->SP_CODE ?>"><?php echo $res->SPECIALITY; ?></option>
                   			<?php
 	                 			 }
                   			?>
                        </select> 
			</fieldset>
            
 			<fieldset>                               
				<label>SELECT STATE : </label>
	           	   <select style="width:25%;" id="STATE_CD" name="STATE_CD" onChange="get_city(this.value)">
    					<option value="">Select State</option>
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
				<label>SELECT CITY : </label>
                  	<select style="width:25%;" name="CITY_CODE" id="canswer" onChange="get_loc(this.value)" >
    					<option value="">Select City</option>
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
				<label>SELECT LOCATION : </label>				
                   	<select style="width:40%;" name="LOC_CODE" id="lanswer" >
    					<option value="">Select Location</option>
						<?php
                  	  		 foreach ($slocs as $res)
							 {
						?>
                       	<option value="<?php echo $res->LOC_CODE; ?>"><?php echo $res->LOCATION; ?></option>
               	     	<?php
               	     		 }
               	     	?>
             	 	</select>
			</fieldset>

			<fieldset>
				<label>SELECT FEES RANGE : </label>            
					<input style="width:17%;" type="number" id="CHARGE_F" name="FEES_FROM" placeholder="Enter Fees in Rs.(FROM)" /> 
					<input style="width:17%;" type="number" id="CHARGE_T" name="FEES_TO" placeholder="Enter Fees in Rs.(TO)" />                     
			</fieldset>

<div class="clear"></div>
				<label>              </label>
					<input type="submit" name="DOCT_SEARCH" value="SEARCH" class="alt_btn" />
					<input type="submit" value="RESET" class="alt_btn"/>                    
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['DOCT_SEARCH']))
	{
		if (isset($_REQUEST['SP_CODE']))
		{
			$sp_code = $_REQUEST['SP_CODE'];
			$_SESSION['SP_CODE'] = $sp_code;			
//			echo "sp_code = ".$sp_code."<br>";		
		} 
		
		if (isset($_REQUEST['STATE_CD']))
		{
			$state_code = $_REQUEST['STATE_CD'];
//			echo "state_code = ".$state_code."<br>";						
		} 

		if (isset($_REQUEST['CITY_CODE']))
		{
			$city_code = $_REQUEST['CITY_CODE'];
//			echo "city_code = ".$city_code."<br>";						
		} 
		
		if (isset($_REQUEST['LOC_CODE']))
		{
			$loc_code = $_REQUEST['LOC_CODE'];
			$_SESSION['LOC_CODE'] = $loc_code;					
//			echo "loc_code = ".$loc_code."<br>";											
		} 

		if (isset($_REQUEST['FEES_FROM']))
		{
			$fees_from = $_REQUEST['FEES_FROM'];
			$_SESSION['FEES_FROM'] = $fees_from;
//			echo "fees = ".$fees_from."<br>";					
		} else
		{
			$fees_from = 0.00;
		}

		if (isset($_REQUEST['FEES_TO']))
		{
			$fees_to = $_REQUEST['FEES_TO'];
			$_SESSION['FEES_TO'] = $fees_to;
//			echo "fees = ".$fees_to."<br>";					
		} else
		{
			$fees_to= 0.00;
		}
		
//		$status, $sp_code, $loc_code, $fees_from, $fees_to are to be sent as parametes to searchdisp.php
//		header("Location:searchdisp.php?status=$status&sp_code=$sp_code&loc_code=$loc_code&fees_from=$fees_from&fees_to=$fees_to");
		header("Location:searchdisp.php");    	   	
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