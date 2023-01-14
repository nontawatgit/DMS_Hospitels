<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "../connect_db.php";
//tb_blood
$mr_id = $_POST["mr_id"];
$mood_level = $_POST["mood_level"];
$stress_level = $_POST["stress_level"];
$rest = $_POST["rest"];
$note_mood = $_POST["note_mood"];
$date_time_mr = $_POST["date_time_mr"];

date_default_timezone_set('Asia/Bangkok');
$dt = date('Y/m/d H:i:s');

$note_mr = "ผู้ดูแลระบบ แก้ไข* ".$dt;


$sql = "UPDATE tb_mr SET mood_level='$mood_level',
		stress_level='$stress_level',
        rest='$rest',
        note_mood='$note_mood',
		note_mr='$note_mr' WHERE mr_id=$mr_id";
$q = mysqli_query($conn,$sql);


if(isset($q)) {
	header("Location: am_mr_page.php?n=1");

}else{
	echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
}

?>