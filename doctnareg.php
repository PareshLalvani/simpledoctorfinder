<?php
//	ob_start();
?>
<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{ // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");
/*	
	echo "week of the date : 2013-06-06 = ".date("W", strtotime('2013-06-06'))."<br>";
	echo "week of the date : 2015-11-16 = ".date("W", strtotime('2015-11-16'))."<br>";
	echo "week of the date : 2015-12-31 = ".date("W", strtotime('2015-12-31'))."<br>";
	echo "week of the date : 2016-01-01 = ".date("W", strtotime('2016-01-01'))."<br>";
	echo "week of the date : 2016-01-04 = ".date("W", strtotime('2016-01-04'))."<br>";				
	die;
*/	
?>
<?php
//	ob_flush();
?>	
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>NON AVAILABILITY OF DOCTOR</title>
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
    
	<script language="javascript" type="text/javascript" src="js/datetimepicker.js">
//	Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//	Script featured on JavaScript Kit (http://www.javascriptkit.com)
//	For this script, visit http://www.javascriptkit.com 
	</script>    
    
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
	ob_start();
	include_once("includes/header.php");
?>
<?php
	include_once("includes/left.php");
?>
<?php
	if (!isset($_SESSION['username']))
	{
		echo "<h4 class=".'"alert_error">'.' PLEASE SIGN IN(LOGIN) TO ACCESS THIS PAGE ...! </h4>';
		exit(header("refresh:3;index.php"));			
	}
	else if ($_SESSION['logintype'] == "Dr. ")
	{
		$where = array('rd_name'=>$_SESSION['username']);
		$result = $mod->select_single($conn, 'regdoctor', $where);
		$_SESSION['loggedkey'] = $result->RD_ID;		
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
			<header><h3>DOCTORS : NON AVAILABILITY (Registration) </h3></header>
				<div class="module_content" >

				<fieldset>
					<label>DR. NAME   : </label>
					<input style="width:50%;" type="text" id="RD_NAME" name="RD_NAME" value="<?php echo $result->RD_NAME; ?>" readonly />
                </fieldset>

				<fieldset>
					<label>QUALIFICATIONS : </label>
					<input style="width:50%;" type="text" id="RD_QUALI" name="RD_QUALI" value="<?php echo $result->RD_QUALI; ?>" readonly />
                </fieldset>

				<fieldset>
					<label>MEDICAL REG. NO. : </label>
					<input style="width:50%;" type="text" id="RD_MRNO" name="RD_MRNO" value="<?php echo $result->RD_MRNO; ?>" readonly />
                </fieldset>

				<fieldset>
					<label>OPD TIMINGS : MORNING <BR>  FROM / TO (HH:MM) </label>
					<input style="width:10%;" type="text" id="RD_MOPD_FROM" name="RD_MOPD_FROM" value="<?php echo $result->RD_MOPD_FROM; ?>" readonly />
					<input style="width:10%;" type="text" id="RD_MOPD_TO" name="RD_MOPD_TO" value="<?php echo $result->RD_MOPD_TO; ?>" readonly />

					<label>OPD TIMINGS : EVENING <BR>  FROM / TO (HH:MM) </label>
					<input style="width:10%;" type="text" id="RD_EOPD_FROM" name="RD_EOPD_FROM" value="<?php echo $result->RD_EOPD_FROM; ?>" readonly  />
					<input style="width:10%;" type="text" id="RD_EOPD_TO" name="RD_EOPD_TO" value="<?php echo $result->RD_EOPD_TO; ?>" readonly/>
                </fieldset>

				<fieldset>
					<label>APPOINTMENT SLOT TIMING RANGE : (HH:MM) </label>
						<input type="text" style="width:10%;" name="RD_APP_SLOT" value="<?php echo $result->RD_APP_SLOT; ?>" readonly/> 
                </fieldset>
				<fieldset> 
					<label>NON AVAILABLE FROM : </label>
					<input style="width:18%;" name="DNA_STDATE" type="text" id="demo1" size="25"> <a href="javascript:NewCal('demo1','ddmmyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
                </fieldset>

				<fieldset> 
					<label>NON AVAILABLE TO : </label>
					<input style="width:18%;" type="text" id="demo2" name="DNA_ENDATE" ><a href="javascript:NewCal('demo2','ddmmyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
                </fieldset>
                    
				<fieldset> 
					<label>NON AVAILABLE TIME : </label>
 						<select name="DNA_ME_CODE" style="width:15%;">
                            <option value=""> Select Timings </option>
 							<?php
                   				 foreach($allopdtimings as $res )
								 {
									 if (($result->RD_MOPD_FROM == 0 && $result->RD_MOPD_TO == 0) &&
									 	(($res->OPD_TIME_NAME == "MORNING") || ($res->OPD_TIME_NAME == "MORN+EVEN"))) 
									 {
										CONTINUE;										 
									 }

									 if (($result->RD_EOPD_FROM == 0 && $result->RD_EOPD_TO == 0) &&
									 	(($res->OPD_TIME_NAME == "EVENING") || ($res->OPD_TIME_NAME == "MORN+EVEN"))) 
									 {
										CONTINUE;										 
									 }
              				?>
	           				 <option value="<?php echo $res->OPD_TIME_CODE ?>"><?php echo $res->OPD_TIME_NAME ?></option>
                   			<?php
 	                 			 }
                   			?>                                         
                       </select>
                </fieldset>
                                       
				</div>
<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="SAVE_DOCT_NAREG" value="SAVE" class="alt_btn" />
					<input type="submit" value="Reset"/>
				</div>
			</footer>
		</article> <!-- end of post new article -->
		</form>		
<?php

	if (isset($_REQUEST['SAVE_DOCT_NAREG']))
	{
		$res = $ex->fetch_object();
		if ($ex->num_rows > 0) 
		{
			echo "<h4 class=".'"alert_error">'.$_SESSION['logintype'].' HAS ALREADY REGISTERED NON AVAILABILITY... </h4>';
			exit(header("refresh:3;index.php"));						
		}
		else
		{
			
		$data = array('DNA_RD_ID'=>$dna_rd_id, 'DNA_STDATE'=>$dna_stdate, 'DNA_ENDATE'=>$dna_endate, 'DNA_WK_SRNO'=>$dna_wk_srno, 'DNA_ME_CODE'=>$dna_me_code); 

			$ex = $mod->insert($conn,'dna_schedule',$data);
			echo "<h4 class=".'"alert_success">'.$_SESSION['logintype'].' NA INSERTED SUCCESSFULLY ...</h4>';
			exit(header("refresh:3;index.php"));			
			
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