<?php
include 'include/user_connect.php'; 
$conn = mysqli_connect($host,$username,$password);
if(isset($conn)){
	//echo "เชื่อมต่อเครื่องสำเร็จ";
	$conn_db = mysqli_select_db($conn,$db);
	if(isset($conn_db)){
		//echo "เลือกฐานข้อมูลสำเร็จ";
	}else{
		echo "เลือกฐานข้อมูลไม่สำเร็จ";
	}	
}else{
	echo "ไม่สามารถเชื่อมต่อเครื่องได้";
}
?>