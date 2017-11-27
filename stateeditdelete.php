<?php
	ob_start();
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");
?>
<?php
// find out how many rows are in the table 
$result = $mod->sel_record($conn,"STATE");
$numrows = mysqli_num_rows($result);
//echo "total rows = ".$numrows."<br>";
// number of rows to show per page
$rowsperpage = 5;

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

// get info from db 
$data = array('STATE_CODE', 'STATE_NAME');
$table = "STATE";
$where = '1 = 1';
$result = $mod->page_rec($conn, $data, $table, $where, $offset, $rowsperpage);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>state table maintenance</title>
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

<script type="text/javascript">
function passvars(a, b)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/get_update_state.php?state_code="+a+"&state_name="+b, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("answer").innerHTML=http.responseText;
		}
	}
}

function delstaterow(a, b)
{
//	$state_code = a;
	var http = new XMLHttpRequest();
	http.open("GET","includes/get_delete_state.php?state_code="+a+"&state_name="+b, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("answerd").innerHTML=http.responseText;
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
<article class="module width_half">
	<header><h3 class="tabs_involved">STATE Table Maintenance</h3></header>
    
    <form method="POST">
	<div class="tab_container">
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead>
        <tr><td><input type="submit" name="medits" value="E" /> <input type="submit" name="mdels"  value="D" /></td>
			<th>State ID</th> 
 			<th>State</th> 
			<th>Action</th> 
		</tr> 
		</thead>
		<tbody>
        	<?php
				while ($res = $result->fetch_object())
				{
            ?> 
		<tr>
			<td><input type="checkbox" name="state_med[]" value="<?php echo $res->STATE_CODE;?>" /></td> 
    		<td><?php echo $res->STATE_CODE;?></td> 
    		<td><?php echo $res->STATE_NAME;?></td>
     		<td><input type="button" name="state_code" src="images/icn_edit.png" title="Edit" onClick="passvars('<?php echo $res->STATE_CODE;?>', '<?php echo $res->STATE_NAME;?>')" style="background-image:url(images/icn_edit.png); height:15px; width:10px;"/>
                <input type="button" name="state_name" src="images/icn_trash.png" title="Trash" onClick="delstaterow('<?php echo $res->STATE_CODE;?>', '<?php echo $res->STATE_NAME;?>')"  style="background-image:url(images/icn_trash.png); height:15px; width:10px;"/></td>
		</tr> 
			<?php
				}
            ?>
		</tbody> 
		</table>
  		</form>        
<div class="module_content h1">
 
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
</div>           
</div><!-- end of #tab1 -->
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
<Div id="answer"></Div>
<Div id="answerd"></Div>
</article>
</tr> 
<?php
	if (isset($_REQUEST['supdate_state']))
	{
		$res = $ex->fetch_object();
//		echo "number of rows retrieved = ".($ex->num_rows)."<br>";
//		die;
		if ($ex->num_rows > 0) 
		{
			if ($res->state_code !== $state_code)
			{
//				echo "Retrieved state_code = ".($res->state_code)."<br>";
//				echo "Original state_code  = ".$state_code."<br>";				
				echo "<h4 class=".'"alert_error">'.$edited_sname.' STATE '.'ALREADY EXIST ! ... </h4>';
			}
		}
		elseif ($ex->num_rows == 0) 
		{
//			echo "state name after update      = ".$edited_sname."<br>";
//			echo "state code for above update  = ".$state_code."<br>";
//			die;
			$data = array('state_name'=>$edited_sname);
			$where = array('state_code'=>$state_code);
			$mod->update($conn,'state',$data, $where);

			$secondsWait = 0;
			echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';
		}
	}
	
	if (isset($_REQUEST['sdelete_state']))
	{
		$secondsWait = 0;
		echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';		
//		$res = $ex->fetch_object();
//		echo "number of rows retrieved for delete = ".($ex->num_rows)."<br>";
//		die;

//		alert asking for confirm to Delete may be asked. if 'NO', then exit elseif 'YES', proceed for delete.

// 		find out how many rows are in the table 
		$result = $mod->sel_record($conn,"STATE");
		$numrows = mysqli_num_rows($result);

// 		find out total pages
		$totalpages = ceil($numrows / $rowsperpage);
	}	
?>

<?php
	if (isset($_REQUEST['medits']))
	{
		if (isset($_REQUEST['state_med']))
		{
			$arr = $_REQUEST['state_med'];
		}
//		var_dump($arr);
?>
		<article class="module width_half">
		<header><h3 class="tabs_involved">STATE: Table Edit</h3>
		</header>

       <form method="POST">
      
		<table class="tablesorter" cellspacing="0">
		<thead> 
		<tr>
		<th>State ID</th>
		<th>State</th> 
		<th> </th>
		</tr>
		</thead>
        <tbody>
<?php
		foreach($arr as $key=>$val)
		{
			$where = array('STATE_CODE'=>$val);
//			$ex = $mod->select_with_cond($conn, 'state', $where);
//			$res = $ex->fetch_object();

			$res = $mod->select_single($conn, 'state', $where);
//			$res = $ex->fetch_object();
?>
			<tr>
           	<td><input type="text" name="state_cd[]" size="5" value="<?php echo $res->STATE_CODE; ?>" readonly /></td>
     		<td><input style="text-transform: uppercase;" type="text" name="state_nm[]" size="55"  value="<?php echo $res->STATE_NAME; ?>" autofocus/></td>
			</tr>
<?php
		}
?>		
		<div class="submit_link">
		<td><input type="submit" name="medit_state" value="SAVE Changes" class="alt_btn"/></td>
		</div>
	
		</tbody>
		</table>
        </form>
		</article><!-- end of content manager article -->
<!--		<div class="spacer"></div>-->
<?php
	}
?>

<?php
	if (isset($_REQUEST['mdels']))
	{
//		echo "inside stateedelv3.php mdels .."."<br>";
		if (isset($_REQUEST['state_med']))
		{
			$arr = $_REQUEST['state_med'];
		}
//		var_dump($arr);
?>
		<article class="module width_half">
		<header><h3 class="tabs_involved">STATE: Table Delete</h3>
		</header>

       <form method="POST">
      
		<table class="tablesorter" cellspacing="0">
		<thead> 
		<tr>
		<th>State ID</th>
		<th>State</th> 
		<th> </th>
		</tr>
		</thead>
        <tbody>
<?php
		foreach($arr as $key=>$val)
		{
			$where = array('STATE_CODE'=>$val);
			$ex = $mod->select_with_cond($conn, 'state', $where);
			$res = $ex->fetch_object();
?>
			<tr>
           	<td><input type="text" name="state_cd[]" size="5" value="<?php echo $res->STATE_CODE; ?>" readonly /></td>
     		<td><input type="text" name="state_nm[]" size="55"  value="<?php echo $res->STATE_NAME; ?>" readonly /></td>
			</tr>
<?php
		}
?>		
		<div class="submit_link">
		<td><input type="submit" name="mdelete_state" value="DELETE" class="alt_btn"/></td>
		</div>
	
		</tbody>
		</table>
        </form>
		</article><!-- end of content manager article -->
<!--		<div class="spacer"></div>-->
<?php
	}
?>
<?php 
//	for multiple edits of state table ...
	if (isset($_REQUEST['medit_state']))
	{
//		echo "inside medit_state in stateedelv2.php ...."."<br>";
//		die;

		if (isset($_REQUEST['state_cd']))
		{
			$arr_scode = $_REQUEST['state_cd'];
//			echo "multi edit state_code array var_dump ..."."<br>";
//			var_dump($arr_scode);	
		}				

		if (isset($_REQUEST['state_nm']))
		{
			$arr_sname = $_REQUEST['state_nm'];
//			echo "<br>"."multi edit state_name array var_dump ..."."<br>";
//			var_dump($arr_sname);	
//			die;			
		}				
//		echo "going inside forloop"."<br>";
		for ($j=0; $j < count($arr_sname); $j++)
		{

//			echo "inside forloop ..."."j = ".$j."<br>" ;
			if ( ! isset($arr_sname[$j])) 
			{
	 			$arr_sname[$j] = null;
			}

			$where = array('state_name'=>strtoupper($arr_sname[$j]));
			$res = $mod->select_single($conn, 'state', $where);
//			$res = $ex->fetch_object();

//			echo "Num Rows = ".($ex->num_rows)."<br>";			
			if ($ex->num_rows > 0) 
			{
				if ($res->STATE_CODE !== $arr_scode[$j])
				{
//					echo "Retrieved state_code = ".($res->state_code)."<br>";
//					echo "Original state_code  = ".$arr_scode[$j]."<br>";				
					echo "<h4 class=".'"alert_error">'.strtoupper($arr_sname[$j]).' STATE '.'ALREADY EXIST ! ... </h4>';
				}
			}
			elseif ($ex->num_rows == 0) 
			{
//				echo "state name after update      = ".strtoupper($arr_sname[$j])."<br>";
//				echo "state code for above update  = ".$arr_scode[$j]."<br>";
//				die;
				$data = array('state_name'=>strtoupper($arr_sname[$j]));
				$where = array('state_code'=>$arr_scode[$j]);
				$mod->update($conn,'state',$data, $where);
				$secondsWait = 0;
				echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';				
			}
		}
	}
?>       
</body>
</html>