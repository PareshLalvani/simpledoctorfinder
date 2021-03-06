<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" id="font-awesome-style-css" href="../css/bootstrap3.min.css" type="text/css" media="all">

<!--<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />-->

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="../js/jquery-1.8.2.min.js"></script>
<title>phpflow.com : Source code of simaple ajax pagination</title>
</head>
<body>
<div><h3>Source code : PHP simaple ajax pagination</h3></div>
<div id="target-content" >loading...</div>

<?php
include_once("../dfmodel.php");
include_once("../dfcontroller.php"); 
$limit = 4;
//$sql = "SELECT COUNT(id) FROM posts";  

	$table = "CITY";
//	$where = array('state_code'=>$state_code);	
	$where = array('state_code'=>'7');	
	$scities = $mod->select_with_cond($conn, $table, $where);	

//$rs_result = mysql_query($sql);  
//$row = mysql_fetch_row($rs_result);  
//$total_records = $row[0];
$total_records = mysqli_num_rows($scities);    
$total_pages = ceil($total_records / $limit); 
?>
<div align="center">
<ul class='pagination text-center' id="pagination">
<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
            if($i == 1):?>
            <li class='active'  id="<?php echo $i;?>"><a href='pagination.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
            <?php else:?>
            <li id="<?php echo $i;?>"><a href='pagination.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
        <?php endif;?>          
<?php endfor;endif;?>  
</div>
</body>
<script>
jQuery(document).ready(function() {
jQuery("#target-content").load("pagination.php?page=1");
    jQuery("#pagination li").live('click',function(e){
    e.preventDefault();
        jQuery("#target-content").html('loading...');
        jQuery("#pagination li").removeClass('active');
        jQuery(this).addClass('active');
        var pageNum = this.id;
        jQuery("#target-content").load("pagination.php?page=" + pageNum);
    });
    });
</script>