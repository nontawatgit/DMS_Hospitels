
<?php
include "../connect_db.php";
$ap_id = $_REQUEST["proid"];

$sql = "UPDATE tb_ap SET status_ap='ยกเลิก',
        ap_bg_color='#E40000' WHERE ap_id=$ap_id";
$q = mysqli_query($conn,$sql);


if(isset($q)) {
    header("Location: am_appoint_page.php?c=1");
}else{
	echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
}