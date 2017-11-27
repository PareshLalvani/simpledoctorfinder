<?php
	include_once("../dfcontroller.php");
	$loc_code = $_REQUEST['loc_code'];
	$location = $_REQUEST['location'];
	$orig_location = $location;
//	echo "inside get_update_loc.php";
?>
<article class="module width_half">
	<header><h3 class="tabs_involved">LOCATION: Edit</h3>
	</header>
    <form method="POST"> 
	<div class="tab_container">
		<div id="tab1" class="tab_content">     
			<table class="tablesorter" cellspacing="0">
			<thead> 
				<tr> 
    				<th>LOC ID</th> 
    				<th>LOCATION</th> 
    				<th>Action</th> 
				</tr> 
			</thead> 
			<tbody> 
				<tr>
    				<td><input type="text" name="loc_code" size="5" value="<?php echo $loc_code; ?>" readonly/></td> 
     				<td><input style="text-transform: uppercase;" type="text" name="location" size="55"  value="<?php echo $location; ?>"  autofocus/></td>
					<div class="submit_link">
					<td><input type="submit" name="lupdate_loc" value="SAVE Changes" class="alt_btn"/></td> 
                    </div>
				</tr> 
			</tbody> 
			</table>
    </form>
</div> 
<Div id="answerd"></Div> 
      
</article><!-- end of content manager article -->      