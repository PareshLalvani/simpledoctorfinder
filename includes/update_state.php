<?php
	include_once("../dfcontroller.php");
	if (isset($_REQUEST['state_code']))
	{
		$state_code = $_REQUEST['state_code'];
	}
	echo "state code = ".$state_code;
		
	if (isset($_REQUEST['state_name']))
	{
		$state_name = $_REQUEST['state_name'];
	}
	echo "state name = ".$state_name;	

/*
	$sql = "update state set state_name = $state_name where state_code = '$state_code'";
	echo $sql."<br>";
	die;
	$ex   = $conn->query($sql);

*/
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Maintenance of states</title>
</head>
<body>
<article class="module width_half">
	<header><h3 class="tabs_involved">STATE: Update</h3>
	</header>
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
					<Div id="answer">
    				<td><input type="text" name="state_code" size="5" value="<?php echo $state_code ?>" readonly/></td> 
     				<td><input type="text" name="state_name" size="55" value="<?php echo $state_name ?>" onKeyUp="convuppercase()"/></td>
                    </Div> 
					<td><input type="submit" name="UPDATE_STATE" value="UPDATE" class="alt_btn" /></td>
				</tr> 
			</tbody> 
			</table>
</article><!-- end of content manager article -->      
</body>
</html>