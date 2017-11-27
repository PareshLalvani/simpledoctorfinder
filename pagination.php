<?php 
include_once("dfcontroller.php");
if (isset($_GET["page"])) 
{ 
	$page  = $_GET["page"]; 
} 
else 
{ 
	$page = 1; 
}; 
$start_from = ($page - 1) * 10; 
$sql = "SELECT * FROM state LIMIT $start_from, 10"; 
$ex = $conn->query($sql);
while($res = $ex->fetch_object())
{
	$ressel[] = $res;
}

?> 
<table>
<tr><td>state_code</td><td>state_name</td></tr>
<?php 
foreach($ressel as $res)
{
?> 
    <tr>
    <td><?php echo $res->STATE_CODE; ?></td>
    <td><?php echo $res->STATE_NAME; ?></td>
    </tr>
<?php 
};
?>
</table>
<?php
/*
$sql = "SELECT COUNT(state_code) FROM state"; 
$res1 = mysql_query($sql,$connection); 
$row = mysql_fetch_row($res1); 
$total_records = $row[0];
*/

$sql1 = "SELECT * FROM state"; 
$ex1 = $conn->query($sql1);
$total_records = $ex1->num_rows;

//echo "Total Records = ".$total_records; 
$total_pages = ceil($total_records / 10);
for ($i=1; $i<=$total_pages; $i++) { 
    echo "<a href='pagination.php?page=".$i."'>".$i."</a> "; 
};
?>

