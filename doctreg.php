<?php
//	ob_start();
?>
<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{ // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");

//	echo "04:25 PM is equivalent to ".date("H:i", strtotime("04:25 PM"));	
//	echo date("g:i a", strtotime("13:30"));
//	echo date("H:i", strtotime("1:30 PM"));

?>
<?php
//	ob_flush();
?>	
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Registration of DOCTORS</title>
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


function setTwoNumberDecimal(event) 
{
    this.value = parseFloat(this.value).toFixed(2);
}

  // Original JavaScript code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function checkTime(field)
  {
    var errorMsg = "";

    // regular expression to match required time format
    re = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/;
//	re = /^(\d{1,2}): (\d{2})(:00)?$?([ap]m)?$/;	

    if(field.value != '') 
	{
      if(regs = field.value.match(re)) 
	  {
        if(regs[4]) 
		{
          // 12-hour time format with am/pm
          if(regs[1] < 1 || regs[1] > 12) 
		  {
            errorMsg = "Invalid value for hours: " + regs[1];
          }
        } else 
		{
          // 24-hour time format
          if(regs[1] > 23) 
		  {
            errorMsg = "Invalid value for hours: " + regs[1];
          }
        }
        if(!errorMsg && regs[2] > 59) 
		{
          errorMsg = "Invalid value for minutes: " + regs[2];
        }
      } else 
	  {
        errorMsg = "Invalid time format: " + field.value;
      }
    }

    if(errorMsg != "") 
	{
		field.style.backgroundColor = '#fba';		
	    alert(errorMsg);
		field.focus();
		return false;
    }
		field.style.backgroundColor = '#bfa';
		return true;
  }

    function validateHhMm(inputField) 
	{
		var errorMsg = "";
        var isValid = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/.test(inputField.value);
        if (isValid) 
		{
            inputField.style.backgroundColor = '#bfa';
        } else 
		{
            inputField.style.backgroundColor = '#fba';
			errorMsg = "Invalid time format: " + inputField.value;			
        }
	    if(errorMsg != "") 
		{
			alert(errorMsg);
			inputField.focus();
			return false;
	    }
		return true;
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
		<header><h3 class="tabs_involved">Doctors' SignUp : (Registration)</h3>
		<ul class="tabs">
   			<li><a href="#tab1">General Details</a></li>
    		<li><a href="#tab2">Professional Details</a></li>
		</ul>
		</header>

		<div class="tab_container">
<!--			<div class="module_content" >-->
			<div id="tab1" class="tab_content">

			<fieldset> 
				<label>TITLE & LOCATION  : </label>
 					<select name="RD_PREFIX_CD" style="width:15%;">
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
                   
	           	   <select style="width:18%;" id="RD_STATE_CD" name="RD_STATE_CD" onChange="get_city(this.value)">
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
                  	<select style="width:18%;" name="RD_CITY_CD" id="canswer" onChange="get_loc(this.value)" >
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
                          
                   	<select style="width:18%;" name="RD_LOC_CD" id="lanswer" >
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
					<input style="width:50%;text-transform:uppercase;" type="text" id="RD_NAME" name="RD_NAME" placeholder="Enter Name" onKeyUp="convuppercase(this.value)" required />
                </fieldset>

				<fieldset> 
					<label>GENDER :  </label>
	               		<input type="radio" name="RD_GENDER" value="Male" /> Male
                   		<input type="radio" name="RD_GENDER" value="Female" /> Female 
                </fieldset>
                                   
				<fieldset> 
					<label>LOGIN ID : </label>
						<input type="text" style="width:50%;" name="RD_LOGIN_ID" placeholder="Enter Login id" required /> 
                </fieldset>

				<fieldset> 
					<label>PASSWORD : </label>
						<input type="password" style="width:50%;" name="RD_PSWD" placeholder="Enter Password" maxlength="20" required />
                </fieldset>

				<fieldset> 
					<label>EMAIL ID. : </label>
						<input type="text" style="width:50%;" name="RD_EMAIL" placeholder="Enter Email Id." required /> 
                </fieldset>                
                
				<fieldset> 
					<label>CONTACT NOS. : </label>
						<input type="text" style="width:23%;" name="RD_MOBILE" placeholder="Enter Mobile No.(10 Digits)" required />
                        <input type="text" style="width:24%;" name="RD_CLINIC_LL" placeholder="Enter clinic's Landline phone with STD code" /> 
                </fieldset>

				<fieldset> 
					<label>CLINIC ADDRESS : </label>
						<textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 name="RD_CLINIC_ADDRESS" onKeyUp="convuppercase(this.value)" ></textarea>
                </fieldset> 
                                
			</div><!-- end of #tab1 -->
			
			<div id="tab2" class="tab_content">
<!--			<table class="tablesorter" cellspacing="0">--> 
				<fieldset>
					<label>QUALIFICATIONS : </label>
					<input style="width:50%;text-transform:uppercase;" type="text" id="RD_QUALI" name="RD_QUALI" placeholder="Enter Qualifications" onKeyUp="convuppercase(this.value)" required />
                </fieldset>

				<fieldset>
					<label>MEDICAL REG. NO. : </label>
					<input style="width:50%;text-transform:uppercase;" type="text" id="RD_MRNO" name="RD_MRNO" placeholder="Enter Registration No." onKeyUp="convuppercase(this.value)" required />
                </fieldset>
                
				<fieldset> 
					<label>SPECIALITY : </label>
 						<select name="RD_SP_CD" id="RD_SP_CD" style="width:50%;">
                            <option value=""> Select Speciality </option>
 							<?php
								while($res = $selallsp->fetch_object())
//                   				 foreach($selallsp as $res )
								 {
              				?>
	           				 <option value="<?php echo $res->SP_CODE ?>"><?php echo $res->SPECIALITY ?></option>
                   			<?php
 	                 			 }
                   			?>
                        </select> 
         		</fieldset>                

				<fieldset>
					<label>DOCTOR'S FEES : </label>
					<input style="width:22%;" type="number" id="RD_CHARGE_I" name="RD_CHARGE_I" placeholder="Enter First time visit fees" onchange="setTwoNumberDecimal" required />
					<input style="width:22%;" type="number" id="RD_CHARGE_II" name="RD_CHARGE_II" placeholder="Subsequen visit fees" onchange="setTwoNumberDecimal" required />                    
                </fieldset>

				<fieldset>
					<label>OPD TIMINGS : MORNING <BR> FROM / TO (HH:MM) 24 HR FORMAT </label>
					<input style="width:10%;" type="text" id="RD_MOPD_FROM" name="RD_MOPD_FROM" onchange="validateHhMm(this);" />
					<input style="width:10%;" type="text" id="RD_MOPD_TO" name="RD_MOPD_TO" onchange="validateHhMm(this);"  />

					<label>OPD TIMINGS : EVENING <BR> FROM / TO (HH:MM) 24 HR FORMAT </label>
					<input style="width:10%;" type="text" id="RD_EOPD_FROM" name="RD_EOPD_FROM" onchange="validateHhMm(this);" />
					<input style="width:10%;" type="text" id="RD_EOPD_TO" name="RD_EOPD_TO" onchange="validateHhMm(this);"  />
                </fieldset>

				<fieldset>
					<label>APPOINTMENT SLOT TIMING RANGE : (HH:MM) 24 HR FORMAT </label>
						<input type="text" style="width:10%;" name="RD_APP_SLOT" onchange="validateHhMm(this);" required /> 
                </fieldset>
                                    
				<fieldset>
					<label>RESI. CONTACT NO & ADDRESS : </label>
                        <input type="text" style="width:15%;" name="RD_RESID_LL" placeholder="Enter Resi. Landline with STD code" /> 
              
						<textarea type="text" style="width:50%;text-transform:uppercase;" ROWS=4 COLS=25 name="RD_RESID_ADDRESS" onKeyUp="convuppercase(this.value)" ></textarea>
                </fieldset>
             
					<input type="submit" value="RESET" class="alt_btn" style="float:right"/>
					<input type="submit" name="SAVE_DOCT_REG" value="SAVE" class="alt_btn" style="float:right" />
                                    
			</div><!-- end of #tab2 -->
			<div class="clear"></div>
        
		</article><!-- end of content manager article -->
</form>
<?php
	if (isset($_REQUEST['SAVE_DOCT_REG']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_error">'.$rd_name.' USER '.'ALREADY EXISTS ! ... RESET TO REG ANOTHER DOCTOR</h4>';
		}
		else
		{
			$data 		= array('RD_PREFIX_CD'=>$rd_prefix_cd, 'RD_NAME'=>$rd_name, 'RD_GENDER'=>$rd_gender, 'RD_QUALI'=>$rd_quali, 'RD_SP_CD'=>$rd_sp_cd, 'RD_MRNO'=>$rd_mrno, 'RD_LOGIN_ID'=>$rd_login_id, 'RD_PSWD'=>$rd_pswd, 'RD_MOBILE'=>$rd_mobile, 'RD_EMAIL'=>$rd_email, 'RD_CLINIC_LL'=>$rd_clinic_ll, 'RD_CLINIC_ADDRESS'=>$rd_clinic_address, 'RD_RESID_LL'=>$rd_resid_ll, 'RD_RESID_ADDRESS'=>$rd_resid_address, 'RD_CHARGE_I'=>$rd_charge_i, 'RD_CHARGE_II'=>$rd_charge_ii, 'RD_MOPD_FROM'=>$rd_mopd_from, 'RD_MOPD_TO'=>$rd_mopd_to, 'RD_EOPD_FROM'=>$rd_eopd_from, 'RD_EOPD_TO'=>$rd_eopd_to, 'RD_APP_SLOT'=>$rd_app_slot, 'RD_LOC_CD'=>$rd_loc_cd, 'RD_STATUS'=>"ACTIVE"); 

			$ex = $mod->insert($conn,'regdoctor',$data);
			echo "<h4 class=".'"alert_success">'.$rd_name.' '.'INSERTED SUCCESSFULLY ...</h4>';
		}
	}

//	ob_end_flush();
//	ob_clean();
//	ob_end_clean();
?>		
</body>
</html>