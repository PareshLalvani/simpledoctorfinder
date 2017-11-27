<?php
	include_once("../dfcontroller.php");
	$city_code = $_REQUEST['RD_CITY_CD'];
	$table = "location";
	$where = array('city_code'=>$city_code);	
	$slocs = $mod->select_with_cond($conn, $table, $where);
?>
<select style="width:18%;" name="RD_LOC_CD" id="RD_LOC_CD" >
    <option value="">Select Location</option>
<div id="lanswer">
	<?php
		 while($resloc = $slocs->fetch_object()) 
		 {
	?>
    <option value="<?php echo $resloc->LOC_CODE; ?>"><?php echo $resloc->LOCATION; ?></option>
</div>    
    <?php
         }
    ?>
</select>   
