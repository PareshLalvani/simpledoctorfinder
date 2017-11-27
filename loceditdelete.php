<?php
	ob_start();
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("dfcontroller.php");
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Location table maintenance</title>
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
//	alert("inside get_city.php");		
	var http = new XMLHttpRequest();
	http.open("GET","includes/obtaincities.php?state_code="+selstate, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
//			alert(http.status);			
//			alert(http.responseText);
			document.getElementById("answer").innerHTML=http.responseText;
		}
	}
}

function get_loc(selcity)
{
	var http = '<?php if (isset($_SESSION['city_code'])){unset($_SESSION['city_code']);}?>';
	var http = new XMLHttpRequest();
	http.open("GET","includes/obtainloc.php?city_code="+selcity, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
//			alert(http.status);			
//			alert(http.responseText);			
			document.getElementById("target-content").innerHTML=http.responseText;
		}
	}
}

function editlocrow(a, b)
{
//	alert('inside editlocrow');
	var http = new XMLHttpRequest();
	http.open("GET","includes/get_update_loc.php?loc_code="+a+"&location="+b, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("answerd").innerHTML=http.responseText;
		}
	}
}

function dellocrow(a, b)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/get_delete_loc.php?loc_code="+a+"&location="+b, true);
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
<article class="module width_half" >
		<header><h3 class="tabs_involved">LOCATION Table Maintenance</h3>
<!--		<ul class="tabs">
   			<li><a href="#tab1">Posts</a></li>
    		<li><a href="#tab2">Comments</a></li>	
		</ul>	-->		
		</header>
				<div class="module_content" >

					<fieldset>
                   		<label>STATE</label>
                   		 <select style="width:35%;" id="state_code" name="state_code" onchange="get_city(this.value)" >
    						<option value="">Select Your State</option>
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
                   		<label>CITY</label>
                   	 <select style="width:35%;" name="city_code" id="answer" onchange="get_loc(this.value)" >
    						<option value="">Select Your City</option>
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

			   		<div class="module_content h1"></div>
                	<div id="target-content"></div> 
		</article> <!-- end of post new article -->
<!--<div id="answer"></div>-->
<div id="answerd"></div>

<?php
	if (isset($_REQUEST['lupdate_loc']))
	{
		$res = $ex->fetch_object();
//		echo "number of rows retrieved = ".($ex->num_rows)."<br>";
//		die;
		if ($ex->num_rows > 0) 
		{
			if ($res->loc_code !== $loc_code)
			{
//				echo "Retrieved loc_code = ".($res->loc_code)."<br>";
//				echo "Original loc_code  = ".$loc_code."<br>";				
				echo "<h4 class=".'"alert_error">'.$edited_location.' LOCATION '.'ALREADY EXIST ! ... </h4>';
			}
		}
		elseif ($ex->num_rows == 0) 
		{
//			echo "Location after update      = ".$edited_location."<br>";
//			echo "Loc code for above update  = ".$loc_code."<br>";
//			die;
			$data = array('location'=>$edited_location);
			$where = array('loc_code'=>$loc_code);
			$mod->update($conn,'location',$data, $where);

			$secondsWait = 0;
			echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';
		}
	}
	
	if (isset($_REQUEST['ldelete_loc']))
	{
//		$res = $ex->fetch_object();
//		echo "number of rows retrieved for delete = ".($ex->num_rows)."<br>";
//		die;

//		alert asking for confirm to Delete may be asked. if 'NO', then exit elseif 'YES', proceed for delete.

		$secondsWait = 0;
		echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';
	}	
?>
</body>
<script>
jQuery(document).ready(function() {
jQuery("#target-content").load("includes/obtainloc.php?page=1");
    jQuery("#pagination li").live('click',function(e){
    e.preventDefault();
        jQuery("#target-content").html('loading...');
        jQuery("#pagination li").removeClass('active');
        jQuery(this).addClass('active');
        var pageNum = this.id;
        jQuery("#target-content").load("includes/obtainloc.php?page=" + pageNum);
    });
    });
</script>
</html>
</body>
</html>