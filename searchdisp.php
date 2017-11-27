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
	if (isset($_SESSION['SP_CODE']))
	{
		$sp_code   = $_SESSION['SP_CODE'];	
	}
	if (isset($_SESSION['LOC_CODE']))
	{
		$loc_code   = $_SESSION['LOC_CODE'];	
	}	
	if (isset($_SESSION['FEES_FROM']))
	{
		$fees_from   = $_SESSION['FEES_FROM'];	
	}	
	if (isset($_SESSION['FEES_TO']))
	{
		$fees_to   = $_SESSION['FEES_TO'];	
	}	

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
$rowsperpage = 2;

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
            		&nbsp &nbsp
					<?php echo " Dr. ".$result->RD_NAME."<br>"; ?>
            		&nbsp &nbsp                    
                    <?php echo $result->RD_QUALI."<br>"; ?>
                    <?php echo "<br>" ?>
				<?php
					//		to obtain speciality from sp_code	
					$table1 = 'speciality';
					$where1 = array('SP_CODE'=>$result->RD_SP_CD);
					$spec = $mod->select_single($conn, $table1, $where1);
				?>                  
					&nbsp &nbsp
				    <?php echo $spec->SPECIALITY."<br>"; ?>
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
            		&nbsp &nbsp
				<?php echo $state->STATE_NAME.", "; echo $city->CITY_NAME.", "; echo $location->LOCATION."<br>"; ?>                    <?php echo "<br>" ?>                    
            		&nbsp &nbsp
					<?php echo " REG. NO. : ".$result->RD_MRNO."<br>"; ?>
                    <?php echo "<br>" ?>
            		&nbsp &nbsp                    
					<?php echo " CONTACT NO.(LL) : ".$result->RD_CLINIC_LL; ?>
            		&nbsp &nbsp &nbsp &nbsp                     
					<?php echo " ADDRESS : ".$result->RD_CLINIC_ADDRESS."<br>"; ?>
                    <?php echo "<br>" ?>                    
            		&nbsp &nbsp                    
					<?php echo " OPD TIMINGS : MORNING :".$result->RD_MOPD_FROM."  To  ".$result->RD_MOPD_TO." Hrs. ";?>
                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
					<?php echo "    EVENING :".$result->RD_EOPD_FROM."  To  ".$result->RD_EOPD_TO." Hrs. "; ?>
                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
					<?php echo " APPOINTMENT SLOT RANGE : ".$result->RD_APP_SLOT." Min. "."<br>"; ?>
                    <?php echo "<br>" ?>  
            		&nbsp &nbsp
   					<?php echo " FIRST TIME FEES: Rs.".$result->RD_CHARGE_I."/-"."<br>"; ?>
            		&nbsp &nbsp                    
					<?php echo " SUBSEQUNT TIME FEES: Rs.".$result->RD_CHARGE_II."/-"; ?>
                    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp                     
<!--				<input type="submit" name="BOOK_APPOINTMENT" value="BOOK" class="alt_btn"/>-->
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