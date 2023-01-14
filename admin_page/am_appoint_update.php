<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "../connect_db.php";
$ap_id = $_POST["ap_id"];
$sign_ap = $_POST["sign_ap"];
$hospital_ap = $_POST["hospital_ap"];
$date_ap = $_POST["date_ap"];
$starttime_ap = $_POST["starttime_ap"];
$endtime_ap = $_POST["endtime_ap"];
$note_ap = $_POST["note_ap"];

$sql_idcard = "SELECT * FROM tb_user WHERE fullname='$sign_ap' ";
$q = mysqli_query($conn,$sql_idcard);
$row = mysqli_fetch_array($q);

$idcard = $row["idcard"];
$userid_ap = $row["userid"];

$ap_title = $sign_ap." | ".$hospital_ap;
$ap_detail = "<b>".$hospital_ap."</b> <br>"."<b>วันที่ : </b>".$date_ap." <br>"."<b>เวลา : </b>".$starttime_ap." - ".$endtime_ap." <br>"."<b>ผู้นัดหมาย : </b>".$sign_ap." <br><br>"."<b>หมายเหตุ : </b>".$note_ap."<br>";

    $sql = "UPDATE tb_ap SET userid_ap='$userid_ap',
            ap_title='$ap_title',
            ap_detail='$ap_detail',
            ap_startdate='$date_ap',
            ap_enddate='$date_ap',
            ap_starttime='$starttime_ap',
            ap_endtime='$endtime_ap',
            idcard='$idcard',
            note_ap='$note_ap',
            hospital_ap='$hospital_ap',
            status_ap='รออนุมัติ',
            sign_ap='$sign_ap',
            ap_bg_color='#F2BF00' WHERE ap_id=$ap_id";
    $q = mysqli_query($conn,$sql);

if(isset($q)) {
    header("Location: am_appoint_page.php?u=1");


}else{
	echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
}

?>