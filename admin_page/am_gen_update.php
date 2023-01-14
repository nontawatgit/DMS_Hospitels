<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "../connect_db.php";
//tb_gen
$gen_id = $_POST["gen_id"];
$body_temp = $_POST["body_temp"];
$heart_rate = $_POST["heart_rate"];
$bp_top = $_POST["bp_top"];
$bp_low = $_POST["bp_low"];
$spo2 = $_POST["spo2"];
$note_gen = $_POST["note_gen"];

date_default_timezone_set('Asia/Bangkok');
$dt = date('Y/m/d H:i:s');

$note_gen_edit = "ผู้ดูแลระบบ แก้ไข* ".$dt;


    $sql = "UPDATE tb_gen SET body_temp='$body_temp',
            heart_rate='$heart_rate',
            bp_top='$bp_top',
            bp_low='$bp_low',
            spo2='$spo2',
            note_gen='$note_gen_edit' WHERE gen_id=$gen_id";
    $q = mysqli_query($conn,$sql);

        if(isset($q)) {
            header("Location: am_gen_page.php?n=1");


        }else{
            echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
        }

?>