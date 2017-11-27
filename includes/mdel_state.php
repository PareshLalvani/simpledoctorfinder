<?php
	echo "inside mdel_state.php";
	include_once("../dfcontroller.php");
	$arr = $_REQUEST['mdel_arr'];
	var_dump($arr);
?>
<article class="module width_half">
	<header><h3 class="tabs_involved">STATE: Multi Delete</h3>
	</header>
	<form method="POST">
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
				<?php 
				foreach($arr as $val)
				{	
    				<td><input type="text" name="state_code" size="5" value="<?php echo $val; ?>" readonly/></td> 
     				<td><input type="text" name="state_name" size="55"  value="<?php echo $val; ?>" readonly/></td>
                    
					<div class="submit_link">
					<td><input type="submit" name="delete_state" value="DELETE" class="alt_btn"/></td> 
					</div>;
				}
				 ?>					
				</tr> 
			</tbody> 
			</table>
     </form>
</article><!-- end of content manager article -->      