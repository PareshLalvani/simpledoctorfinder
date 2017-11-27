<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{ // session isn't started
	    session_start();
	}
//	ob_start();	
	include_once("dfcontroller.php");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>ADMIN profile view / update</title>
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
<?php
	if (!isset($_SESSION['username']))
	{
		echo "<h4 class=".'"alert_error">'.' PLEASE FIRST SIGNUP TO UPDATE PROFILE ...! </h4>';
		exit(header("refresh:3;index.php"));	
	}
	else if ($_SESSION['logintype'] == "Admin")
	{
		$where = array('ra_name'=>$_SESSION['username']);
		$result = $mod->select_single($conn, 'regadmin', $where);		
	}
	else
	{
		echo '<h4 class="'.'alert_error"> YOU DO NOT HAVE ACCESS TO THIS PAGE ...! </h4>';
		exit(header("refresh:3;index.php"));
	}
?>
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post">		
		<article class="module width_full" >
			<header><h3><?php echo "Welcome Admin : ".$_SESSION['username'];?></h3></header>
			<div class="module_content" >
				<fieldset> 
					<label>TITLE & ADMIN'S LOCATION : </label>
 						<select name="RA_PREFIX_CD" style="width:13%;">
                            <option> Select your Title </option>
 							<?php
                   				 foreach($allprefix as $res1 )
								 {
              				?>
	           				 <option value="<?php echo $res1->PREFIX_CODE ?>" <?php if($result->RA_PREFIX_CD == $res1->PREFIX_CODE)
							   {
									echo "selected"; 
						       }
							?>><?php echo $res1->PREFIX_NAME ?></option>
                   			<?php
 	                 			 }
                   			?>                                         
                       </select>

 						<?php
                            $where = array('LOC_CODE'=>$result->RA_LOC_CD);
                            $r2    = $mod->select_single($conn, 'location', $where);
//							print_r($r2);
                            $where2 = array('CITY_CODE'=>$r2->CITY_CODE);
                            $r3    = $mod->select_single($conn, 'city', $where2);
//							print_r($r3); 							
                        ?>
                   	   <select style="width:18%;" id="RA_STATE_CD" name="RA_STATE_CD" onChange="get_city(this.value)">
    						<option> Select Your State </option>
							<?php
                      	 		 foreach($allstatesel as $res2)
                      		  	 {
                     	 	?>
                      	 	<option value="<?php echo $res2->STATE_CODE; ?>" <?php if($r3->STATE_CODE == $res2->STATE_CODE)
							   {
									echo "selected"; 
						       }
							?> ><?php echo $res2->STATE_NAME; ?></option>
                     		<?php
                    	   		 }
                   	    	?>
                   		</select>
                        
                        <?php
                            $where2  = array('STATE_CODE'=>$r3->STATE_CODE);
                            $scities = $mod->select_with_cond($conn, 'city', $where2);
//							print_r($scities);													
						?>
                  		<select style="width:18%;" id="canswer" name="RA_CITY_CD" onChange="get_loc(this.value)" >
    						<option> Select Your City </option>
							<?php
                  	     		 foreach ($scities as $res3)
                  	 	     	 {
                  		   	?><option value="<?php echo $res3->CITY_CODE; ?>" <?php if($r2->CITY_CODE == $res3->CITY_CODE)
							   {echo "selected";}
							?> ><?php echo $res3->CITY_NAME; ?></option>
                    	   	<?php
                    	   		 }
                    	  	?>
                   		 </select>
                         
                        <?php
                            $where2 = array('CITY_CODE'=>$r2->CITY_CODE);
                            $slocs  = $mod->select_with_cond($conn, 'location', $where2);
//							print_r($slocs);													
						?>                          
                   	   <select style="width:18%;" name="RA_LOC_CD" id="lanswer">
    					<option value="">Select Your Location</option>
						<?php
                   			 foreach ($slocs as $res4)
                  		  	 {
               			?><option value="<?php echo $res4->LOC_CODE; ?>" <?php if($result->RA_LOC_CD == $res4->LOC_CODE)
							   {
									echo "selected"; 
						       }
							?> ><?php echo $res4->LOCATION; ?></option>
                      	 <?php
                     	 	 }
                      	 ?>
                   		</select>                            
                </fieldset>

				<fieldset>
					<label>NAME   : </label>
					<input style="width:50%;text-transform:uppercase;" type="text" id="RA_NAME" name="RA_NAME" value="<?php echo $result->RA_NAME; ?>" onKeyUp="convuppercase(this.value)" />
                </fieldset>

				<fieldset> 
					<label>GENDER :  </label>
	               		<input type="radio" name="RA_GENDER" <?php if($result->RA_GENDER == "Male")
							{
								echo "checked";
							}?> value="Male" /> Male
                   		<input type="radio" name="RA_GENDER" <?php if($result->RA_GENDER == "Female")
							{
								echo "checked";
							}?> value="Female" /> Female 
                </fieldset>
                    
				<fieldset> 
					<label>LOGIN ID : </label>
						<input type="text" style="width:50%;" name="RA_LOGIN_ID" value="<?php echo $result->RA_LOGIN_ID; ?>" required /> 
                </fieldset>

				<fieldset> 
					<label>PASSWORD : </label>
						<input type="password" style="width:50%;" name="RA_PSWD" value="<?php echo $result->RA_PSWD; ?>" maxlength="20" required />
                </fieldset>

				<fieldset> 
					<label>EMAIL ID. : </label>
						<input type="text" style="width:50%;" name="RA_EMAIL" value="<?php echo $result->RA_EMAIL; ?>" required /> 
                </fieldset>                
                
				<fieldset> 
					<label>Contact Nos. : </label>
						<input type="text" style="width:23%;" name="RA_MOBILE" value="<?php echo $result->RA_MOBILE; ?>" required />
                        <input type="text" style="width:24%;" name="RA_LL_PHONE" value="<?php echo $result->RA_LL_PHONE; ?>" /> 
                </fieldset>
 
				<fieldset> 
					<label>RESI. ADDRESS : </label>
                    <textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 id="RA_ADDRESS" name="RA_ADDRESS"> <?php echo $result->RA_ADDRESS ;?> </textarea>
                </fieldset> 
				</div>
       
<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="UPDATE_ADMIN_REG" value="UPDATE" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['UPDATE_ADMIN_REG']))
	{
	
		$data 		= array('RA_PREFIX_CD'=>$ra_prefix_cd, 'RA_NAME'=>$ra_name, 'RA_GENDER'=>$ra_gender, 'RA_LOGIN_ID'=>$ra_login_id, 'RA_PSWD'=>$ra_pswd, 'RA_EMAIL'=>$ra_email, 'RA_MOBILE'=>$ra_mobile, 'RA_LL_PHONE'=>$ra_ll_phone, 'RA_ADDRESS'=>$ra_address, 'RA_LOC_CD'=>$ra_loc_cd, 'RA_STATUS'=>$ra_status); 

		$where = array('ra_name'=>$_SESSION['username']);
		$ex = $mod->update($conn,'regadmin',$data, $where);
		echo "<h4 class=".'"alert_success">'.'Admin '.$ra_name.' '.'PROFILE UPDATED SUCCESSFULLY ...</h4>';
		header("refresh:3;index.php");	
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