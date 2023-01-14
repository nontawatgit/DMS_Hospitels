
<?php
include "../connect_db.php";
$userid = $_REQUEST["proid"];

$sql = "UPDATE tb_user SET verify_status='verify' WHERE userid=$userid";
$q = mysqli_query($conn,$sql);


if(isset($q)) {
    header("Location: am_verify_page.php?s=1");
}else{
	echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
}