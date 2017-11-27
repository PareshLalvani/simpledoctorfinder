<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("../dfcontroller.php");
	$state_code = $_REQUEST['state_code'];
	$_SESSION['state_code'] = $state_code;
	$table = "city";
	$where = array('STATE_CODE'=>$state_code);
//	echo "inside obtaincities.php ..."."<br>";
	$scities = $mod->select_with_cond($conn, $table, $where);		
?>
<fieldset>
	<label>CITY</label>
    <select style="width:35%;" name="city_code" id="answer" >
    	<option value="">Select Your City</option>
		<?php
			 while($res = $scities->fetch_object())
             {
        ?>
        <option value="<?php echo $res->CITY_CODE; ?>"><?php echo $res->CITY_NAME; ?></option>
        <?php
        	 }
        ?>
     </select>                        
</fieldset>
