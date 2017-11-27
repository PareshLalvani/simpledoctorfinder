<?php
	class connection
	{
		public function connect()
		{
			$server = "localhost";
			$user   = "root";
			$pass   = "";
			$db     = "doctorfinder";
			return $connection = new MySQLi($server, $user, $pass, $db);
		}
	}
	class model 
	{
		function login($conn, $data, $table, $where, $pswdstr, $appcond)
		{
			$k = "";
			foreach($data as $key)
			{
				$k = $k."`".$key."`,";
			}
			$k = rtrim($k,', ');

			$str = "";
			foreach($where as $key=>$val)
			{
				foreach($pswdstr as $key1=>$val1)
				{
					$str = $str."(`".$key."` = '".$val."' and `".$key1."` = '".$val1."') or ";
				}
			}
			$str = trim($str, " or ");

			$appstr = "";
			foreach($appcond as $key=>$val)
			{
				$appstr = $appstr."`".$key."` = '".$val."' and ";
			}
			$appstr = trim($appstr, " and ");

			$sql = "select $k from $table where ($str) and $appstr";

//			echo $sql ;
//			die;
			return $ex = $conn->query($sql);
		}

		function sel_record($conn, $table)
		{
			$sql = "select * from $table ";
			$ex = $conn->query($sql);
			return $ex;
		}

		function page_rec($conn, $data, $table, $where, $start, $norows)
		{
			$k = "";
			$r = "";
			foreach($data as $key)
			{
				$k = $k."`".$key."`,";
			}
			$k = rtrim($k,', ');
			$sql = "select $k from $table where $where limit $start, $norows";
//			echo $sql;
//			die;
			$ex = $conn->query($sql);
			return $ex;
		}
		
		function insert($conn, $table, $data)
		{
			$k = "";
			$v = "";	
			
			foreach($data as $key=>$val)
			{
				$k = $k."`".$key."`,";
//				$k = $k.$key.", ";
				$v = $v."'".$val."',";
			}
				
			$k = rtrim($k,', ');
			$v = rtrim($v,',');
			
			$insertsql="insert into $table ($k) values ($v)";
//			echo $insertsql;
//			die;
			return $ex = $conn->query($insertsql);
		}

		function select_all($conn, $table)
		{
			$sql = "select * from $table";
			$ex = $conn->query($sql);
			return $ex;
		}		

		function select_with_cond($conn, $table, $where)
		{
			$r = "";
			$k = "";
			$whr="";			
			foreach($where as $key=>$val)
				{
					$whr = $whr."`".$key."` = '".$val."' and ";
				}
				
			$k   = rtrim($k,', ');
			$whr = rtrim($whr,' and ');			
			
			$sql = "select * from $table where $whr";
//			echo $sql."<br>";
//			die;
			$ex = $conn->query($sql);
			return $ex;
		}		

		function select_query_count_with_cond($conn, $table, $where)
		{
			$r = "";
			$k = "";
			$whr="";			

			foreach($where as $key=>$val)
			{
				$whr = $whr."`".$key."` = '".$val."' and ";
			}

			$k   = rtrim($k,', ');
			$whr = rtrim($whr,' and ');

			if (isset($_SESSION['FEES_FROM']))
			{
				$fees_from = $_SESSION['FEES_FROM'];
			}

			if (isset($_SESSION['FEES_TO']))
			{
				$fees_to = $_SESSION['FEES_TO'];
			}

			if ((!empty($fees_from)) && (!empty($fees_to)))
			{
				$sql = "select * from $table where $whr and `RD_CHARGE_I` between $fees_from and $fees_to";	
			}
			else
			{
				$sql = "select * from $table where $whr";
			}
//			echo $sql."<br>";
//			die;
			$ex = $conn->query($sql);
			return $ex;
		}		

		function select_with_limit_cond($conn, $data, $table, $where, $start, $norows)
		{
			$d = "";
			foreach($data as $key)
			{
				$d = $d."`".$key."`,";
			}
			$d = rtrim($d,', ');
						
			$r = "";
			$k = "";
			$whr="";			

			foreach($where as $key=>$val)
			{
				$whr = $whr."`".$key."` = '".$val."' and ";
			}

			$k   = rtrim($k,', ');
			$whr = rtrim($whr,' and ');

			if (isset($_SESSION['FEES_FROM']))
			{
				$fees_from = $_SESSION['FEES_FROM'];
			}

			if (isset($_SESSION['FEES_TO']))
			{
				$fees_to = $_SESSION['FEES_TO'];
			}
			
			if ((!empty($fees_from)) && (!empty($fees_to)))
			{
				$sql = "select $d from $table where $whr and `RD_CHARGE_I` between $fees_from and $fees_to limit $start, $norows";	
			}
			else
			{
				$sql = "select $d from $table where $whr limit $start, $norows";
			}
//			echo $sql."<br>";
//			die;
			$ex = $conn->query($sql);
			return $ex;
		}		
		
		function select_single($conn, $table, $where)
		{
			$r = "";
			$k = "";
			$whr="";			
			foreach($where as $key=>$val)
				{
					$whr = $whr."`".$key."` = '".$val."' and ";
				}
				
			$k   = rtrim($k,', ');
			$whr = rtrim($whr,' and ');			
			
			$sql = "select * from $table where $whr";
//			echo $sql."<br>";
//			die;
			$ex = $conn->query($sql);
			return $r = $ex->fetch_object();
		}		

		function selall_with_pgntn($conn, $data, $table, $where, $startfrom, $drows)
		{
			$k = "";
			$r = "";
			foreach($data as $key)
			{
				$k = $k."`".$key."`,";
			}
			$k = rtrim($k,', ');
			$sql = "select $k from $table where $where limit $startfrom, $drows";
//			echo $sql;
//			die;
			$ex = $conn->query($sql);
			while($res = $ex->fetch_object())
			{
				$r[] = $res;
			}
			return $r;
		}		

		function selcnt_for_pgntn($conn, $data, $table, $where)
		{
			$k = "";
			foreach($data as $key)
			{
				$k = $k."`".$key."`,";
			}
			$k = rtrim($k,', ');
			$sql = "select * from $table where $where";
//			echo $sql."<br>";
//			die;			
			$ex = $conn->query($sql);
			return $ex->num_rows;
		}		

		function jointable($conn, $data, $table, $jtable1, $jc1, $jtable2, $jc2, $where)
		{
			$cnd1 = "";
			$cnd2 = "";
			$cnd3 = "";			 
			$k = "";
			foreach($data as $key=>$val)
			{
				$k = $k."`".$val."`, ";
			}
			$k   = rtrim($k,', ');

			foreach($jc1 as $key=>$val)
			{
				$cnd1 = $cnd1.$val." = "  ;
			}
			$cnd1 = rtrim($cnd1,' = ');

			foreach($jc2 as $key=>$val)
			{
				$cnd2 = $cnd2.$val." = "  ;
			}
			$cnd2 = rtrim($cnd2,' = ');
			$sql="select $k from $table join $jtable1 on $cnd1 join $jtable2 on $cnd2 where $where";
//			echo $sql."<br>";
//			die;
			return $ex = $conn->query($sql);
		}

		function update($conn, $table, $data, $where)
		{
			$k = "";
			$whr="";
	
			foreach($data as $key=>$val)
			{
				$k = $k."`".$key."` = '".$val."', ";
			}
		
			foreach($where as $key=>$val)
			{
				$whr = $whr."`".$key."` = '".$val."' and ";
			}
				
			$k   = rtrim($k,', ');
			$whr = rtrim($whr,' and ');

				$sql="update $table 
				           set $k where $whr";
//				echo $sql;
//			    die;
			$ex = $conn->query($sql);		
		}
		
		function delete($conn,$table,$where)
		{
			$whr = "";
			foreach($where as $key=>$val)
			{
				$whr = $whr."`".$key."` = '".$val."' and ";
			}
			$whr = rtrim($whr,' and ');
			$sql = "delete from $table where $whr";
//			echo $sql."<br>";
//			die; 
			$ex = $conn->query($sql);					
		}
	}
?>
