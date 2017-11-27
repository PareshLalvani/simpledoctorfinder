<?php
include_once("../dfmodel.php");
include_once("../dfcontroller.php");

$limit = 4;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
  
//$sql = "SELECT * FROM posts ORDER BY title ASC LIMIT $start_from, $limit";
//$rs_result = mysql_query ($sql);  
  
$data = array('CITY_CODE', 'CITY_NAME', 'STATE_CODE');
$table = "CITY";
//$where = "state_code = '$state_code'";
$where = "state_code = '7'";
$rs_result = $mod->page_rec($conn, $data, $table, $where, $start_from, $limit);
?>

<!--
<table class="table table-bordered table-striped">  
<thead>  
<tr>  
<th>title</th>  
<th>body</th>  
</tr>  
</thead>  
<tbody>  
-->
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
<!--                	<div id="answer">-->
<!--  					<td><input type="checkbox" name="city_edel_chkb"></td> -->
  					<td></td> 
    				<td><?php echo $res->CITY_CODE;?></td> 
    				<td><?php echo $res->CITY_NAME;?></td>
    				<td><?php echo $res->STATE_CODE;?></td>
                    <input type="hidden" name="asdf" value="$res->STATE_CODE"  />
 
    				<td><input type="button" name="city_code" src="images/icn_edit.png" title="Edit" onClick="editcityrow('<?php echo $res->CITY_CODE;?>', '<?php echo $res->CITY_NAME;?>')" style="background-image:url(images/icn_edit.png); height:15px; width:10px;"/> 
                    	<input type="button" name="city_name" src="images/icn_trash.png" title="Trash" onClick="delcityrow('<?php echo $res->CITY_CODE;?>', '<?php echo $res->CITY_NAME;?>')" style="background-image:url(images/icn_trash.png); height:15px; width:10px;"/></td>

				</tr>
<!--                	</div> -->
					<?php
						}
                   	?> 
			</tbody> 
			</table>

<?php  
//while ($row = mysql_fetch_assoc($rs_result)) {  
?>
<!--  
            <tr>  
            <td><? //echo $row["title"]; ?></td>  
            <td><? //echo $row["body"]; ?></td>  
            </tr> 
-->             
<?php  
//};  
?>
<!--
</tbody>  
</table>
-->