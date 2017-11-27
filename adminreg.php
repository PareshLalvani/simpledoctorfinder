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
<title>Registration of ADMINS</title>
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
	include_once("includes/header.php");
?>
<?php
	include_once("includes/left.php");
?>
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post">		
		<article class="module width_full" >
			<header><h3>ADMIN : SignUp (Registration) </h3></header>
				<div class="module_content" >
			<fieldset> 
				<label>TITLE & LOCATION  : </label>
 					<select name="RA_PREFIX_CD" style="width:15%;">
                        <option value=""> Select your Title </option>
						<?php
							 while($res = $allprefix->fetch_object()) 
							 {
           				?>
	       				<option value="<?php echo $res->PREFIX_CODE ?>"><?php echo $res->PREFIX_NAME ?></option>
               			<?php
                 			 }
               			?>
	               </select> 
                   
	           	   <select style="width:18%;" id="RA_STATE_CD" name="RA_STATE_CD" onChange="get_city(this.value)">
    					<option value="">Select your state</option>
						<?php
							 while($res = $allstatesel->fetch_object()) 
                   		  	 {
                   		?>
                   		<option value="<?php echo $res->STATE_CODE; ?>"><?php echo $res->STATE_NAME; ?></option>
                   		<?php
                   			 }
                   		?>
               		</select>
                  	<select style="width:18%;" name="RA_CITY_CD" id="canswer" onChange="get_loc(this.value)" >
    					<option value="">Select your city</option>
						<?php
                    		foreach ($scities as $res)
                    		{
                   		?>
                        <option value="<?php echo $res->CITY_CODE; ?>"><?php echo $res->CITY_NAME; ?></option>
                   	   	<?php
                       		 }
                   	   	?>
                   	</select>
                          
                   	<select style="width:18%;" name="RA_LOC_CD" id="lanswer" >
    					<option value="">Select your Location</option>
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
					<label>NAME   : </label>
					<input style="width:50%;text-transform:uppercase;" type="text" id="RA_NAME" name="RA_NAME" placeholder="Enter Admin's Name" onKeyUp="convuppercase(this.value)" required />
                </fieldset>

				<fieldset> 
					<label>GENDER :  </label>
	               		<input type="radio" name="RA_GENDER" value="Male" /> Male
                   		<input type="radio" name="RA_GENDER" value="Female" /> Female 
                </fieldset>
                    
				<fieldset> 
					<label>LOGIN ID : </label>
						<input type="text" style="width:50%;" name="RA_LOGIN_ID" placeholder="Enter Login id" required /> 
                </fieldset>

				<fieldset> 
					<label>PASSWORD : </label>
						<input type="password" style="width:50%;" name="RA_PSWD" placeholder="Enter Password" maxlength="20" required />
                </fieldset>

				<fieldset> 
					<label>EMAIL ID : </label>
						<input type="text" style="width:50%;" name="RA_EMAIL" placeholder="Enter Email Id." required /> 
                </fieldset>
                                
				<fieldset> 
					<label>CONTACT NOS. : </label>
						<input type="text" style="width:23%;" name="RA_MOBILE" placeholder="Enter Mobile No.(10 Digits)" required />
                        <input type="text" style="width:24%;" name="RA_LL_PHONE" placeholder="Enter Landline No. with STD code" /> 
                </fieldset>

				<fieldset> 
					<label>CONTACT ADDRESS : </label>
						<textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 name="RA_ADDRESS" onKeyUp="convuppercase(this.value)" ></textarea>
                </fieldset> 
                
				</div>
<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="SAVE_ADMIN_REG" value="SAVE" class="alt_btn" />
					<input type="submit" value="RESET" class="alt_btn"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['SAVE_ADMIN_REG']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_error">'.$ra_name.' ADMIN '.'ALREADY EXISTS ! ... RESET TO REG ANOTHER ADMIN</h4>';
		}
		else
		{
			$data 		= array('RA_PREFIX_CD'=>$ra_prefix_cd, 'RA_NAME'=>$ra_name, 'RA_GENDER'=>$ra_gender, 'RA_LOGIN_ID'=>$ra_login_id, 'RA_PSWD'=>$ra_pswd, 'RA_EMAIL'=>$ra_email, 'RA_MOBILE'=>$ra_mobile, 'RA_LL_PHONE'=>$ra_ll_phone, 'RA_ADDRESS'=>$ra_address, 'RA_LOC_CD'=>$ra_loc_cd, 'RA_STATUS'=>$ra_status); 
			
			$ex = $mod->insert($conn,'regadmin',$data);
			echo "<h4 class=".'"alert_success">'.$ra_name.' '.'INSERTED SUCCESSFULLY ...</h4>';
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