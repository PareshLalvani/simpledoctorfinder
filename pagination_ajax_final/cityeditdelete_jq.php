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
	<title>city table maintenance</title>
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
<!--	<link rel="stylesheet" id="font-awesome-style-css" href="css/bootstrap3.min.css" type="text/css" media="all">-->
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>-->
	<script type="text/javascript" charset="utf8" src="js/jquery-1.8.2.min.js"></script>
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
	http.open("GET","includes/getstatecities_jq.php?state_code="+selstate, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("target-content").innerHTML=http.responseText;
		}
	}
}

function editcityrow(a, b)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/get_update_city.php?city_code="+a+"&city_name="+b, true);
	http.send();
	http.onreadystatechange = function()
	{		
		if(http.readyState==4 && http.status==200)
		{
			document.getElementById("target-content").innerHTML=http.responseText;
		}
	}
}

function delcityrow(a, b)
{
	var http = new XMLHttpRequest();
	http.open("GET","includes/get_delete_city.php?city_code="+a+"&city_name="+b, true);
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
/*
	if (!isset($_SESSION['logintype']))
	{
		echo "<h4 class=".'"alert_error">'.' PLEASE LOGIN TO HAVE ACCESS TO THIS PAGE ... !</h4>';
		header("refresh:3;index.php");			
	}
	else
		if ($_SESSION['logintype'] !== "Admin")
		{
			echo "<h4 class=".'"alert_error">'.' ONLY ADMIN IS AUTHORISED TO THIS PAGE ... !</h4>';
			header("refresh:3;index.php");				
		}
*/		
	ob_flush();	
?>
<article class="module width_half">
		<header><h3 class="tabs_involved">CITY Table Maintenance</h3>
<!--		<ul class="tabs">
   			<li><a href="#tab1">Posts</a></li>
    		<li><a href="#tab2">Comments</a></li>	
		</ul>	-->		
		</header>

					<fieldset>
                   		<label>STATE</label>
                   		 <select style="width:35%;" id="state_code" name="state_code" onChange="get_city(this.value)" >
    						<option value="">Select Your State</option>
						<?php
                       		 while($res1 = $allstatesel->fetch_object())
                        	 {
                      	?>
                         	 <option value="<?php echo $res1->STATE_CODE; ?>"><?php echo $res1->STATE_NAME; ?></option>
                       	<?php
                       		 }
                       	?>
                   		 </select>
					</fieldset>

		<div class="tab_container">
			<div id="tab1" class="tab_content">	
			<table class="tablesorter" cellspacing="0"> 
                                       
			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
					<div id="target-content" >loading...</div>
<!--                	<div id="answer"></div>-->
					<Div id="answerd"></Div>		
		</article><!-- end of content manager article -->

		<div class="module_content h1"></div>

<div align="center">
<ul class='pagination text-center' id="pagination">
<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
            if($i == 1):?>
            <li class='active'  id="<?php echo $i;?>"><a href='includes/getstatecities_jq.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
            <?php else:?>
            <li id="<?php echo $i;?>"><a href='includes/getstatecities_jq.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
        <?php endif;?>          
<?php endfor;endif;?>  
</div>

<?php
	if (isset($_REQUEST['cupdate_city']))
	{
		$res = $ex->fetch_object();
//		echo "number of rows retrieved = ".($ex->num_rows)."<br>";
//		die;
		if ($ex->num_rows > 0) 
		{
			if ($res->city_code !== $city_code)
			{
//				echo "Retrieved city_code = ".($res->city_code)."<br>";
//				echo "Original city_code  = ".$city_code."<br>";				
				echo "<h4 class=".'"alert_error">'.$edited_cname.' CITY '.'ALREADY EXIST ! ... </h4>';
			}
		}
		elseif ($ex->num_rows == 0) 
		{
//			echo "city name after update      = ".$edited_cname."<br>";
//			echo "city code for above update  = ".$city_code."<br>";
//			die;
			$data = array('city_name'=>$edited_cname);
			$where = array('city_code'=>$city_code);
			$mod->update($conn,'city',$data, $where);

			$secondsWait = 0;
			echo '<meta http-equiv="refresh" content="'.$secondsWait.'">';
		}
	}
	
	if (isset($_REQUEST['cdelete_city']))
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
jQuery("#target-content").load("includes/getstatecities_jq.php?page=1");
    jQuery("#pagination li").live('click',function(e){
    e.preventDefault();
        jQuery("#target-content").html('loading...');
        jQuery("#pagination li").removeClass('active');
        jQuery(this).addClass('active');
        var pageNum = this.id;
        jQuery("#target-content").load("includes/getstatecities_jq.php?page=" + pageNum);
    });
    });
</script>
</html>