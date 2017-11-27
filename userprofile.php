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
<title>USER's profile view / update</title>
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
	else if ($_SESSION['logintype'] == "User")
	{
		$where = array('ru_name'=>$_SESSION['username']);
		$result = $mod->select_single($conn, 'reguser', $where);		
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
			<header><h3><?php echo "Welcome User : ".$_SESSION['username'];?></h3></header>
			<div class="module_content" >
				<fieldset> 
					<label>TITLE & USER'S LOCATION : </label>
 						<select name="RU_PREFIX_CD" style="width:13%;">
                            <option> Select your Title </option>
 							<?php
                   				 foreach($allprefix as $res1 )
								 {
              				?>
	           				 <option value="<?php echo $res1->PREFIX_CODE ?>" <?php if($result->RU_PREFIX_CD == $res1->PREFIX_CODE)
							   {
									echo "selected"; 
						       }
							?>><?php echo $res1->PREFIX_NAME ?></option>
                   			<?php
 	                 			 }
                   			?>                                         
                       </select>

 						<?php
                            $where = array('LOC_CODE'=>$result->RU_LOC_CD);
                            $r2    = $mod->select_single($conn, 'location', $where);
//							print_r($r2);
                            $where2 = array('CITY_CODE'=>$r2->CITY_CODE);
                            $r3    = $mod->select_single($conn, 'city', $where2);
//							print_r($r3); 							
                        ?>
                   	   <select style="width:18%;" id="RU_STATE_CD" name="RU_STATE_CD" onChange="get_city(this.value)">
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
                  		<select style="width:18%;" id="canswer" name="RU_CITY_CD" onChange="get_loc(this.value)" >
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
                   	   <select style="width:18%;" name="RU_LOC_CD" id="lanswer">
    					<option value="">Select Your Location</option>
						<?php
                   			 foreach ($slocs as $res4)
                  		  	 {
               			?><option value="<?php echo $res4->LOC_CODE; ?>" <?php if($result->RU_LOC_CD == $res4->LOC_CODE)
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
					<input style="width:50%;text-transform:uppercase;" type="text" id="RU_NAME" name="RU_NAME" value="<?php echo $result->RU_NAME; ?>" onKeyUp="convuppercase(this.value)" />
                </fieldset>

				<fieldset> 
					<label>GENDER :  </label>
	               		<input type="radio" name="RU_GENDER" <?php if($result->RU_GENDER == "Male")
							{
								echo "checked";
							}?> value="Male" /> Male
                   		<input type="radio" name="RU_GENDER" <?php if($result->RU_GENDER == "Female")
							{
								echo "checked";
							}?> value="Female" /> Female 
                </fieldset>
                    
				<fieldset> 
					<label>LOGIN ID : </label>
						<input type="text" style="width:50%;" name="RU_LOGIN_ID" value="<?php echo $result->RU_LOGIN_ID; ?>" required /> 
                </fieldset>

				<fieldset> 
					<label>PASSWORD : </label>
						<input type="password" style="width:50%;" name="RU_PSWD" value="<?php echo $result->RU_PSWD; ?>" maxlength="20" required />
                </fieldset>

				<fieldset> 
					<label>EMAIL ID. : </label>
						<input type="text" style="width:50%;" name="RU_EMAIL" value="<?php echo $result->RU_EMAIL; ?>" required /> 
                </fieldset>                
                
				<fieldset> 
					<label>Contact Nos. : </label>
						<input type="text" style="width:23%;" name="RU_MOBILE" value="<?php echo $result->RU_MOBILE; ?>" required />
                        <input type="text" style="width:24%;" name="RU_LL_PHONE" value="<?php echo $result->RU_LL_PHONE; ?>" /> 
                </fieldset>
 
				<fieldset> 
					<label>RESI. ADDRESS : </label>
                    <textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 id="RU_ADDRESS" name="RU_ADDRESS"> <?php echo $result->RU_ADDRESS ;?> </textarea></textarea>
                </fieldset> 
				</div>
       
<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="UPDATE_USER_REG" value="UPDATE" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php
	if (isset($_REQUEST['UPDATE_USER_REG']))
	{
	
		$data 		= array('RU_PREFIX_CD'=>$ru_prefix_cd, 'RU_NAME'=>$ru_name, 'RU_GENDER'=>$ru_gender, 'RU_LOGIN_ID'=>$ru_login_id, 'RU_PSWD'=>$ru_pswd, 'RU_EMAIL'=>$ru_email, 'RU_MOBILE'=>$ru_mobile, 'RU_LL_PHONE'=>$ru_ll_phone, 'RU_ADDRESS'=>$ru_address, 'RU_LOC_CD'=>$ru_loc_cd, 'RU_STATUS'=>$ru_status); 

		$where = array('ru_name'=>$_SESSION['username']);
//		$where = array('ru_name'=>'ANIL');

		$ex = $mod->update($conn,'reguser',$data, $where);
		echo "<h4 class=".'"alert_success">'.'User '.$ru_name.' '.'PROFILE UPDATED SUCCESSFULLY ...</h4>';
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