<?php
include("controller.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form >
<table align="left" border="1">
	<tr>
    	<td>
        	NAME
        </td>
        <td>
        	MOBILE
        </td>
    </tr>
    <?php
		while ($res = $data->fetch_object())
		{
	 ?>
    <tr>
    	<td>
        	<?php echo $res->name; ?>
        </td>
        <td>
        	<?php echo $res->mobile; ?>
        </td>
	</tr>
	<?php
		}?>
   
</table>
<table border="1">
 <tr>
    <td colspan="2">
    	<?php
		
		 echo "<a href='list.php' style='text-decoration:none'>".'< All'."</a> ";
		 		
    	 echo "<a href='pagination.php?page=1' style='text-decoration:none'>".'> Page 	 '."</a> ";
		
		 ?>
         <?php 
		 	
		 echo "<a href='pagination.php?start=".$start."' style='text-decoration:none'>".'Previous'."</a> "; 	  
		 for ($i=1; $i<=$totalpages; $i++)
				 
		  { 
            echo "<a href='pagination.php?page=".$i."' style='text-decoration:none'>".$i."</a> "; 
			
			}
		 echo "<a href='pagination.php?page=$totalpages' style='text-decoration:none'>".''."</a>";
		  
		 echo "<a href='pagination.php?nxt=".$start."' style='text-decoration:none'>".'Next '."</a> "; 	     
?>
    </td>
</tr>        
</table>

</form>
</body>
</html>