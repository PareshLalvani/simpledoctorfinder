<?php
	include_once("../dfcontroller.php");
	$city_code = $_REQUEST['city_code'];
	$city_name = $_REQUEST['city_name'];
//	echo "inside get_delete_city ...";	
?>
<article class="module width_half">
	<header><h3 class="tabs_involved">CITY: Delete</h3>
	</header>
	<form method="POST">
	<div class="tab_container">
		<div id="tab1" class="tab_content">  
			<table class="tablesorter" cellspacing="0">
			<thead> 
				<tr> 
    				<th>City ID</th> 
    				<th>City</th> 
    				<th>Action</th> 
				</tr> 
			</thead> 
			<tbody> 
				<tr>
				
    				<td><input type="text" name="city_code" size="5" value="<?php echo $city_code; ?>" readonly/></td> 
     				<td><input type="text" name="city_name" size="55"  value="<?php echo $city_name; ?>" readonly/></td>
                    
					<div class="submit_link">
					<td><input type="submit" name="cdelete_city" value="DELETE" class="alt_btn"/></td> 
                    </div>
				</tr> 
			</tbody> 
			</table>
     </form>
</div>
<div id="answerd"></div>
</article><!-- end of content manager article -->    