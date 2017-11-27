<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("../dfcontroller.php");
	$state_code = "";
	if (isset($_REQUEST['state_code']))
	{
		$state_code = $_REQUEST['state_code'];
		$_SESSION['state_code'] = $state_code;
	}
	elseif (isset($_SESSION['state_code']))
	{
		$state_code = $_SESSION['state_code'];
	}

$limit = 4;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;

//echo "page = ".$page."<br>";
//echo "start_from = ".$start_from."<br>";
//echo "state_code = ".$state_code."<br>";

$table = "CITY";
$where = array('STATE_CODE'=>$state_code);
$scities = $mod->select_with_cond($conn, $table, $where);	
$total_records = mysqli_num_rows($scities);    
$total_pages = ceil($total_records / $limit); 
 	
$data = array('CITY_CODE', 'CITY_NAME', 'STATE_CODE');
$table = "CITY";
$where = "state_code = '$state_code'";
$rs_result = $mod->page_rec($conn, $data, $table, $where, $start_from, $limit);	
?>
		<form method="POST">
		<div class="tab_container">
			<div id="tab1" class="tab_content">	</div>
			<table class="tablesorter" cellspacing="0"> 

			<thead> 
				<tr> 
   					<th></th> 
    				<th>City ID</th> 
    				<th>City</th> 
    				<th>State Code</th> 
    				<th>Actions</th> 
				</tr> 
			</thead> 
			<tbody> 
                	<?php
						while ($res = $rs_result->fetch_object())
	                   	{
                   	?> 
				<tr>
               	<div id="target-content">
<!--   					<td><input type="checkbox" name="city_edel_chkb"></td> -->
   					<td></td>                     
    				<td><?php echo $res->CITY_CODE;?></td> 
    				<td><?php echo $res->CITY_NAME;?></td>
    				<td><?php echo $res->STATE_CODE;?></td>
                    <input type="hidden" name="asdf" value="$res->STATE_CODE"  />
 
    				<td><input type="button" name="city_code" src="images/icn_edit.png" title="Edit" onClick="editcityrow('<?php echo $res->CITY_CODE;?>', '<?php echo $res->CITY_NAME;?>')" style="background-image:url(images/icn_edit.png); height:15px; width:10px;"/> 
                    	<input type="button" name="city_name" src="images/icn_trash.png" title="Trash" onClick="delcityrow('<?php echo $res->CITY_CODE;?>', '<?php echo $res->CITY_NAME;?>')" style="background-image:url(images/icn_trash.png); height:15px; width:10px;"/></td>

				</tr>
                	</div> 
					<?php
						}
                   	?> 
			</tbody> 
			</table>
            </form>

<div align="center">
<ul class='pagination text-center' id="pagination">
<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
            if($i == 1):?>
            <li class='active'  id="<?php echo $i;?>"><a href='includes/getstatecities.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
            <?php else:?>
            <li id="<?php echo $i;?>"><a href='includes/getstatecities.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
        <?php endif;?>          
<?php endfor;endif;?>  
</div>
</body>
</html>