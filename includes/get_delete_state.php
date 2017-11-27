<?php
	include_once("../dfcontroller.php");
	$state_code = $_REQUEST['state_code'];
	$state_name = $_REQUEST['state_name'];
//	echo "inside get_delete_state ...";	
?>
<article class="module width_half">
	<header><h3 class="tabs_involved">STATE: Delete</h3>
	</header>
	<form method="POST">
	<div class="tab_container">
		<div id="tab1" class="tab_content">  
			<table class="tablesorter" cellspacing="0">
			<thead> 
				<tr> 
    				<th>State ID</th> 
    				<th>State</th> 
    				<th>Action</th> 
				</tr> 
			</thead> 
			<tbody> 
				<tr>
				
    				<td><input type="text" name="state_code" size="5" value="<?php echo $state_code; ?>" readonly/></td> 
     				<td><input type="text" name="state_name" size="55"  value="<?php echo $state_name; ?>" readonly/></td>
                    
					<div class="submit_link">
					<td><input type="submit" name="sdelete_state" value="DELETE" class="alt_btn"/></td> 
                    </div>
				</tr> 
			</tbody> 
			</table>
     </form>
</div>
<div id="answerd"></div>
</article><!-- end of content manager article -->    