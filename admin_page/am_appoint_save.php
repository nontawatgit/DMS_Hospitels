<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require "../connect_db.php";

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

date_default_timezone_set('Asia/Bangkok');
$createdate_ap = date('Y/m/d H:i:s');

$ap_title = $sign_ap." | ".$hospital_ap;
$ap_detail = "<b>".$hospital_ap."</b> <br>"."<b>วันที่ : </b>".$date_ap." <br>"."<b>เวลา : </b>".$starttime_ap." - ".$endtime_ap." <br>"."<b>ผู้นัดหมาย : </b>".$sign_ap." <br><br>"."<b>หมายเหตุ : </b>".$note_ap."<br>";

    $sql = ("INSERT INTO tb_ap(userid_ap, ap_title, ap_detail, ap_startdate, ap_enddate, ap_starttime, ap_endtime, ap_createdate, idcard, note_ap, hospital_ap, status_ap, sign_ap) 
    VALUES('$userid_ap', '$ap_title', '$ap_detail', '$date_ap', '$date_ap', '$starttime_ap', '$endtime_ap', '$createdate_ap', '$idcard', '$note_ap', '$hospital_ap', 'รออนุมัติ', '$sign_ap')");
    $q = mysqli_query($conn,$sql);

    if(isset($q)) {
        header("Location: am_appoint_page.php?s=1");
        }else{
            echo mysqli_error($conn);
        }

?>