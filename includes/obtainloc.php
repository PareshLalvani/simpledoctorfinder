<?php
	if(session_id() == '' || !isset($_SESSION)) 
	{
	    // session isn't started
	    session_start();
	}
	include_once("../dfcontroller.php");
	$city_code = "";
	if (isset($_REQUEST['city_code']))
	{
		$city_code = $_REQUEST['city_code'];
		$_SESSION['city_code'] = $city_code;
	}
	elseif (isset($_SESSION['city_code']))
	{
		$city_code = $_SESSION['city_code'];
	}
	$limit = 4;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
		$start_from = ($page-1) * $limit;

		//echo "page = ".$page."<br>";
		//echo "start_from = ".$start_from."<br>";
		//echo "state_code = ".$state_code."<br>";

$table = "location";
$where = array('CITY_CODE'=>$city_code);
//echo "inside obtainloc.php .."."<br>";
$slocs = $mod->select_with_cond($conn, $table, $where);	
$total_records = mysqli_num_rows($slocs);    
$total_pages = ceil($total_records / $limit); 
 	
$data = array('LOC_CODE', 'LOCATION', 'CITY_CODE');
$table = "location";
$where = "CITY_CODE = '$city_code'";
$rs_result = $mod->page_rec($conn, $data, $table, $where, $start_from, $limit);	
?>
		<form method="POST">
		<div class="tab_container">
			<div id="tab1" class="tab_content">	
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th> 
    				<th>LOC ID</th> 
    				<th>LOCATION</th> 
    				<th>CITY CODE</th> 
    				<th>Actions</th> 
				</tr> 
			</thead> 
			<tbody> 
                	<?php
						while($res = $rs_result->fetch_object())
	                   	{
                   	?> 
				<tr>
                	<div id="target-content">
   					<td><input type="checkbox" name="city_edel_chkb"></td> 
    				<td><?php echo $res->LOC_CODE;?></td> 
    				<td><?php echo $res->LOCATION;?></td>
    				<td><?php echo $res->CITY_CODE;?></td>
                    <input type="hidden" name="asdf" value="$res->CITY_CODE"  />
    				<td><input type="button" name="loc_code" src="images/icn_edit.png" title="Edit" onClick="editlocrow('<?php echo $res->LOC_CODE;?>', '<?php echo $res->LOCATION;?>')" style="background-image:url(images/icn_edit.png); height:15px; width:10px;"/> 
                    	<input type="button" name="city_name" src="images/icn_trash.png" title="Trash" onClick="dellocrow('<?php echo $res->LOC_CODE;?>', '<?php echo $res->LOCATION;?>')" style="background-image:url(images/icn_trash.png); height:15px; width:10px;"/></td>
				</tr>
                	</div> 
					<?php
						}
                   	?> 
			</tbody> 
			</table>
            </form>
                        
<div class="clear"></div>	
		</article> <!-- end of post new article -->
        <div align="center">
<ul class='pagination text-center' id="pagination">
<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
            if($i == 1):?>
            <li class='active'  id="<?php echo $i;?>"><a href='includes/obtainloc.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
            <?php else:?>
            <li id="<?php echo $i;?>"><a href='includes/obtainloc.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
        <?php endif;?>          
<?php endfor;endif;?>  
</div>