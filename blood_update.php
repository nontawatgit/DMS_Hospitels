<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "connect_db.php";
//tb_blood
$b_id = $_POST["b_id"];
$blood_sugar = $_POST["blood_sugar"];
$blood_fat = $_POST["blood_fat"];
$note_b = $_POST["note_b"];

date_default_timezone_set('Asia/Bangkok');
$dt = date('Y/m/d H:i:s');

$note_b_edit = "แก้ไข* ".$dt;


$sql = "UPDATE tb_blood SET blood_sugar='$blood_sugar',
		blood_fat='$blood_fat',
        note_b='$note_b_edit' WHERE b_id=$b_id";
$q = mysqli_query($conn,$sql);


if(isset($q)) {
    header("Location: blood_page.php?n=1");


}else{
	echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
}

?>