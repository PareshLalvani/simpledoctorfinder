<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("../dfcontroller.php");
	$state_code = $_REQUEST['state_code'];
	$table = "CITY";
	$where = array('state_code'=>$state_code);	
	$scities = $mod->select_with_cond($conn, $table, $where);	
?>
                   	<select style="width:18%;" name="RD_CITY_CD" id="RD_CITY_CD" >
    					<option value="">Select City</option>
                	<div id="canswer">
						<?php
							while($res = $scities->fetch_object())
                    		{
                   		?>
                        <option value="<?php echo $res->CITY_CODE; ?>"><?php echo $res->CITY_NAME; ?></option>
                	</div>                         
                   	   	<?php
                       		}
                   	   	?>
                   	</select>
