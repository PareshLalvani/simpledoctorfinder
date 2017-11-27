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
<title>DOCTOR's profile view / update</title>
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
	ob_start();
	include_once("includes/left.php");
?>
<?php
	if (!isset($_SESSION['username']))
	{
		echo "<h4 class=".'"alert_error">'.' PLEASE FIRST SIGNUP TO UPDATE PROFILE ...! </h4>';
		exit(header("refresh:3;index.php"));			
	}
	else if ($_SESSION['logintype'] == "Dr. ")
	{
		$where = array('rd_name'=>$_SESSION['username']);
		$result = $mod->select_single($conn, 'regdoctor', $where);		
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
		<header><h3 class="tabs_involved"><?php echo "Welcome Doctor : ".$_SESSION['username'];?></h3>
		<ul class="tabs">
   			<li><a href="#tab1">General Details</a></li>
    		<li><a href="#tab2">Professional Details</a></li>
		</ul>
		</header>

		<div class="tab_container">
<!--			<div class="module_content" >-->
			<div id="tab1" class="tab_content">
				<fieldset> 
					<label>TITLE & LOCATION : </label>
 						<select name="RD_PREFIX_CD" style="width:13%;">
                            <option> Select your Title </option>
 							<?php
								while($res1 = $allprefix->fetch_object()) 
//                   				 foreach($allprefix as $res1 )
								 {
              				?>
	           				 <option value="<?php echo $res1->PREFIX_CODE ?>" <?php if($result->RD_PREFIX_CD == $res1->PREFIX_CODE)
							   {
									echo "selected"; 
						       }
							?>><?php echo $res1->PREFIX_NAME ?></option>
                   			<?php
 	                 			 }
                   			?>                                         
                       </select>

 						<?php
                            $where = array('LOC_CODE'=>$result->RD_LOC_CD);
                            $r2    = $mod->select_single($conn, 'location', $where);
//							print_r($r2);
                            $where2 = array('CITY_CODE'=>$r2->CITY_CODE);
                            $r3    = $mod->select_single($conn, 'city', $where2);
//							print_r($r3); 							
                        ?>
                   	   <select style="width:18%;" id="RD_STATE_CD" name="RD_STATE_CD" onChange="get_city(this.value)">
    						<option> Select Your State </option>
							<?php
								while($res2 = $allstatesel->fetch_object()) 
//                      	 		 foreach($allstatesel as $res2)
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
                  		<select style="width:18%;" id="canswer" name="RD_CITY_CD" onChange="get_loc(this.value)" >
    						<option> Select Your City </option>
							<?php
								while($res3 = $scities->fetch_object()) 
//                  	     		 foreach ($scities as $res3)
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
                   	   <select style="width:18%;" name="RD_LOC_CD" id="lanswer">
    					<option value="">Select Your Location</option>
						<?php
							while($res4 = $slocs->fetch_object()) 
//                   			 foreach ($slocs as $res4)
                  		  	 {
               			?><option value="<?php echo $res4->LOC_CODE; ?>" <?php if($result->RD_LOC_CD == $res4->LOC_CODE)
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
					<input style="width:50%;text-transform:uppercase;" type="text" id="RD_NAME" name="RD_NAME" value="<?php echo $result->RD_NAME; ?>" onKeyUp="convuppercase(this.value)" />
                </fieldset>

				<fieldset> 
					<label>GENDER :  </label>
	               		<input type="radio" name="RD_GENDER" <?php if($result->RD_GENDER == "Male")
							{
								echo "checked";
							}?> value="Male" /> Male
                   		<input type="radio" name="RD_GENDER" <?php if($result->RD_GENDER == "Female")
							{
								echo "checked";
							}?> value="Female" /> Female 
                </fieldset>
                    
				<fieldset> 
					<label>LOGIN ID : </label>
						<input type="text" style="width:50%;" name="RD_LOGIN_ID" value="<?php echo $result->RD_LOGIN_ID; ?>" required /> 
                </fieldset>

				<fieldset> 
					<label>PASSWORD : </label>
						<input type="password" style="width:50%;" name="RD_PSWD" value="<?php echo $result->RD_PSWD; ?>" maxlength="20" required />
                </fieldset>

				<fieldset> 
					<label>EMAIL ID. : </label>
						<input type="text" style="width:50%;" name="RD_EMAIL" value="<?php echo $result->RD_EMAIL; ?>" required /> 
                </fieldset>                
                
				<fieldset> 
					<label>CONTACT NOS. : </label>
						<input type="text" style="width:23%;" name="RD_MOBILE" value="<?php echo $result->RD_MOBILE; ?>" required />
                        <input type="text" style="width:24%; text-transform: uppercase;" name="RD_CLINIC_LL" value="<?php echo $result->RD_CLINIC_LL; ?>" /> 
                </fieldset>
 
				<fieldset> 
					<label>CLINIC ADDRESS : </label>
                    <textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 id="RD_CLINIC_ADDRESS" name="RD_CLINIC_ADDRESS"> <?php echo $result->RD_CLINIC_ADDRESS;?> </textarea>
                </fieldset> 
			</div><!-- end of #tab1 -->

			<div id="tab2" class="tab_content">
<!--			<table class="tablesorter" cellspacing="0">--> 

				<fieldset>
					<label>QUALIFICATIONS : </label>
					<input style="width:50%;text-transform:uppercase;" type="text" id="RD_QUALI" name="RD_QUALI" value="<?php echo $result->RD_QUALI; ?>" onKeyUp="convuppercase(this.value)" required />
                </fieldset>

				<fieldset>
					<label>MEDICAL REG. NO. : </label>
					<input style="width:50%;text-transform:uppercase;" type="text" id="RD_MRNO" name="RD_MRNO" value="<?php echo $result->RD_MRNO; ?>" onKeyUp="convuppercase(this.value)" required />
                </fieldset>

				<fieldset> 
					<label>SPECIALITY : </label>
 						<select name="RD_SP_CD" id="RD_SP_CD" style="width:50%;">
                            <option value=""> Select Speciality </option>
 							<?php
								while($res = $selallsp->fetch_object())
								 {
              				?>
	           				 <option value="<?php echo $res->SP_CODE ?>" <?php if($result->RD_SP_CD == $res->SP_CODE)
							   {
									echo "selected"; 
						       }
							?> ><?php echo $res->SPECIALITY ?></option>
                   			<?php
 	                 			 }
                   			?>
                        </select> 
         		</fieldset> 

				<fieldset>
					<label>DOCTOR'S FEES : </label>
					<input style="width:22%;" type="number" id="RD_CHARGE_I" name="RD_CHARGE_I" value="<?php echo $result->RD_CHARGE_I; ?>" required />
					<input style="width:22%;" type="number" id="RD_CHARGE_II" name="RD_CHARGE_II" value="<?php echo $result->RD_CHARGE_II; ?>" required />                    
                </fieldset>

				<fieldset>
					<label>OPD TIMINGS : MORNING <BR>  FROM / TO (HH:MM) </label>
					<input style="width:10%;" type="time" id="RD_MOPD_FROM" name="RD_MOPD_FROM" value="<?php echo $result->RD_MOPD_FROM; ?>" required />
					<input style="width:10%;" type="time" id="RD_MOPD_TO" name="RD_MOPD_TO" value="<?php echo $result->RD_MOPD_TO; ?>" required />

					<label>OPD TIMINGS : EVENING <BR>  FROM / TO (HH:MM) </label>
					<input style="width:10%;" type="time" id="RD_EOPD_FROM" name="RD_EOPD_FROM" value="<?php echo $result->RD_EOPD_FROM; ?>" required />
					<input style="width:10%;" type="time" id="RD_EOPD_TO" name="RD_EOPD_TO" value="<?php echo $result->RD_EOPD_TO; ?>" required />
                </fieldset>

				<fieldset>
					<label>APPOINTMENT SLOT TIMING RANGE : (HH:MM) </label>
						<input type="text" style="width:10%;" name="RD_APP_SLOT" value="<?php echo $result->RD_APP_SLOT; ?>" required /> 
                </fieldset>
                
				<fieldset>
					<label>RESI. CONTACT NO & ADDRESS : </label>
                        <input type="text" style="width:15%;text-transform:uppercase;" name="RD_RESID_LL" value="<?php echo $result->RD_RESID_LL;?>" /> 
              
						<textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 name="RD_RESID_ADDRESS"><?php echo $result->RD_RESID_ADDRESS;?></textarea>
                </fieldset                

					><input type="submit" value="Reset" style="float:right"/>
					<input type="submit" name="UPDATE_DOCT_REG" value="SAVE" class="alt_btn" style="float:right" />
       
			</div><!-- end of #tab2 -->
			<div class="clear"></div>
		</article> <!-- end of post new article -->
</form>		
<?php
	if (isset($_REQUEST['UPDATE_DOCT_REG']))
	{
			$data 		= array('RD_PREFIX_CD'=>$rd_prefix_cd, 'RD_NAME'=>$rd_name, 'RD_GENDER'=>$rd_gender, 'RD_QUALI'=>$rd_quali, 'RD_SP_CD'=>$rd_sp_cd, 'RD_MRNO'=>$rd_mrno, 'RD_LOGIN_ID'=>$rd_login_id, 'RD_PSWD'=>$rd_pswd, 'RD_MOBILE'=>$rd_mobile, 'RD_EMAIL'=>$rd_email, 'RD_CLINIC_LL'=>$rd_clinic_ll, 'RD_CLINIC_ADDRESS'=>$rd_clinic_address, 'RD_RESID_LL'=>$rd_resid_ll, 'RD_RESID_ADDRESS'=>$rd_resid_address, 'RD_CHARGE_I'=>$rd_charge_i, 'RD_CHARGE_II'=>$rd_charge_ii, 'RD_MOPD_FROM'=>$rd_mopd_from, 'RD_MOPD_TO'=>$rd_mopd_to, 'RD_EOPD_FROM'=>$rd_eopd_from, 'RD_EOPD_TO'=>$rd_eopd_to, 'RD_APP_SLOT'=>$rd_app_slot, 'RD_LOC_CD'=>$rd_loc_cd, 'RD_STATUS'=>"ACTIVE");

		$where = array('rd_name'=>$_SESSION['username']);

		$ex = $mod->update($conn,'regdoctor',$data, $where);
		echo "<h4 class=".'"alert_success">'.'Doctor '.$rd_name.' '.'PROFILE UPDATED SUCCESSFULLY ...</h4>';
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