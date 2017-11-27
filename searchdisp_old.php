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
	$status = "ACTIVE";
	$sp_code   = $_SESSION['SP_CODE'];	
	$loc_code  = $_SESSION['LOC_CODE'];
	$fees_from = $_SESSION['FEES_FROM'];
	$fees_to   = $_SESSION['FEES_TO'];	

	$table = "regdoctor";
	$data  = array('RD_SP_CD', 'RD_MRNO',  'RD_NAME', 'RD_QUALI', 'RD_LOC_CD', 'RD_CLINIC_LL', 'RD_CLINIC_ADDRESS', 'RD_MOPD_FROM', 'RD_MOPD_TO', 'RD_EOPD_FROM', 'RD_EOPD_TO', 'RD_APP_SLOT', 'RD_CHARGE_I', 'RD_CHARGE_II', 'RD_STATUS' );

	$where = array();
	$where['RD_STATUS'] = $status;
	if (!empty($sp_code))
	{
		$where['RD_SP_CD'] = $sp_code;
	}
	else if (!empty($loc_code))
	{
		$where['RD_LOC_CD'] = $loc_code;		
	}

//		patched for pagination

// find out how many rows are in the table 
$result = $mod->select_query_count_with_cond($conn, "regdoctor", $where);
$numrows = mysqli_num_rows($result);
// echo "total rows = ".$numrows."<br>";

// number of rows to show per page
$rowsperpage = 1;

// find out total pages
$totalpages = ceil($numrows / $rowsperpage);
	
// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) 
{
   // cast var as int
   $currentpage = $_GET['currentpage'];
} else 
{
   // default page num
   $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) 
{
   // set current page to last page
   $currentpage = $totalpages;
} // end if	

// if current page is less than first page...
if ($currentpage < 1) 
{
   // set current page to first page
   $currentpage = 1;
} // end if

// Obtain the offset of the list i.e. next hauling of the data to be displayed, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;
// echo "offset = ".$offset."<br>";

// get info from db 
// $ex = $mod->select_with_limit_cond($conn, $data, $table, $where);	
$ex = $mod->select_with_limit_cond($conn, $data, $table, $where, $offset, $rowsperpage);
		
?>		
<section id="main" class="column">
		<div class="clear"></div>
		<form method="post">		
		<article class="module width_full" >
			<header><h3>Doctors : </h3></header>
				<div class="module_content" >                

				<?php
					while($result = $ex->fetch_object())
	                {
				?>
			<fieldset>
					<label>NAME & <BR> Qualifications : </label>
					<input style="width:45%;" type="text" id="RD_NAME" name="RD_NAME" value="<?php echo $result->RD_NAME; ?>" readonly />
					<input style="width:25%;" type="text" id="RD_QUALI" name="RD_QUALI" value="<?php echo $result->RD_QUALI; ?>" readonly />
			</fieldset>
				<?php
					//		to obtain speciality from sp_code	
					$table1 = 'speciality';
					$where1 = array('SP_CODE'=>$result->RD_SP_CD);
					$spec = $mod->select_single($conn, $table1, $where1);
				?>                  
			<fieldset>                            
				<label>Speciality & <BR> Location: </label>
					<input style="width:25%;" type="text" id="speciality" name="speciality" value="<?php echo $spec->SPECIALITY; ?>" readonly />
				<?php
					//		to obtain location details from location table	
					$table1 = 'location';
					$where1 = array('LOC_CODE'=>$result->RD_LOC_CD);
					$location = $mod->select_single($conn, $table1, $where1);
					
					//		to obtain city details from city table	
					$table2 = 'city';
					$where2 = array('CITY_CODE'=>$location->CITY_CODE);					
					$city   = $mod->select_single($conn, $table2, $where2);

					//		to obtain state details from state table	
					$table3 = 'state';
					$where3 = array('STATE_CODE'=>$city->STATE_CODE);					
					$state   = $mod->select_single($conn, $table3, $where3);
					
				?>                          
					<input style="width:16%;" type="text" id="state" name="state" value="<?php echo $state->STATE_NAME; ?>" readonly />                    
					<input style="width:13%;" type="text" id="city" name="city" value="<?php echo $city->CITY_NAME; ?>" readonly />                     
					<input style="width:13%;" type="text" id="location" name="location" value="<?php echo $location->LOCATION; ?>" readonly />                     
			</fieldset>                    

			<fieldset>
					<label>MEDICAL <BR> REGISTRATION No. : </label>
					<input style="width:45%;" type="text" id="RD_MRNO" name="RD_MRNO" value="<?php echo $result->RD_MRNO; ?>" readonly />
			</fieldset>                    

			<fieldset>
					<label>CONTACT NO. & <BR> CLINIC ADDRESS: </label>
						<input type="text" style="width:23%;" id="RD_CLINIC_LL" name="RD_CLINIC_LL" value="<?php echo $result->RD_CLINIC_LL; ?>" readonly />
                    <textarea readonly type="text" style="width:50%;" ROWS=4 COLS=25 id="RD_CLINIC_ADDRESS" name="RD_CLINIC_ADDRESS"> <?php echo $result->RD_CLINIC_ADDRESS;?>  </textarea>
			</fieldset>

				<fieldset>
					<label>OPD TIMINGS : MORNING <BR>  FROM / TO (HH:MM) </label>
					<input style="width:10%;" type="time" id="RD_MOPD_FROM" name="RD_MOPD_FROM" value="<?php echo $result->RD_MOPD_FROM; ?>" readonly />
					<input style="width:10%;" type="time" id="RD_MOPD_TO" name="RD_MOPD_TO" value="<?php echo $result->RD_MOPD_TO; ?>" readonly />

					<label>OPD TIMINGS : EVENING <BR>  FROM / TO (HH:MM) </label>
					<input style="width:10%;" type="time" id="RD_EOPD_FROM" name="RD_EOPD_FROM" value="<?php echo $result->RD_EOPD_FROM; ?>" readonly />
					<input style="width:10%;" type="time" id="RD_EOPD_TO" name="RD_EOPD_TO" value="<?php echo $result->RD_EOPD_TO; ?>" readonly />
                </fieldset>

				<fieldset>
					<label>APPOINTMENT SLOT TIMING RANGE : (HH:MM) </label>
						<input type="time" style="width:10%;" name="RD_APP_SLOT" value="<?php echo $result->RD_APP_SLOT; ?>"readonly /> 
                </fieldset>

				<fieldset>
					<label>DOCTOR'S FEES in INR <BR> FIRST TIME & SUBSEQUENT: </label>
					<input style="width:22%;" type="number" id="RD_CHARGE_I" name="RD_CHARGE_I" value="<?php echo $result->RD_CHARGE_I; ?>" readonly />
					<input style="width:22%;" type="number" id="RD_CHARGE_II" name="RD_CHARGE_II" value="<?php echo $result->RD_CHARGE_II; ?>" readonly />                    
                </fieldset>

  				<?php
					}
				?>

<div class="clear"></div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="BACK_TO_SEARCH" value="BACK TO SEARCH" class="alt_btn" />
<!--					<input type="submit" value="BOOK APPOINTMENT"/>-->
				</div>
			</footer>
<div class="spacer"></div>            

<div align="center">
<ul class='pagination text-center' id="pagination">
<strong>
<?php
/******  build the pagination links ******/
// range of num links to show
$range = 3;

//echo "php_self = ".$_SERVER['PHP_SELF'];

// if not on page 1, don't show back links
if ($currentpage > 1) 
{
   // show << link to go back to page 1
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
} // end if

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) 
{
   // if it's a valid page number...
	if (($x > 0) && ($x <= $totalpages)) 
   {

      // if we're on current page...
      if ($x == $currentpage) 
	  {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else 
	  {
         // make it a link
		 echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> "; 
      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links    
if ($currentpage != $totalpages) 
{
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
    // echo forward link for lastpage
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
} // end if
/****** end build pagination links ******/
?>
</strong>
</div>
		</article> <!-- end of post new article -->
		</form>		

<div class="spacer"></div>
</section>
<?php
	if (isset($_REQUEST['BACK_TO_SEARCH']))
	{
		header("Location:searchdoct.php");    	   	
	}
?>

<?php
	ob_end_flush();
	ob_clean();
	ob_end_clean();
?>
</body>
</html>