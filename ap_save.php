<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require "connect_db.php";

$userid_ap = $_POST["userid"];
$note_ap = $_POST["note_ap"];
$hospital_ap = $_POST["hospital_ap"];
$date_ap = $_POST["date_ap"];
$starttime_ap = $_POST["starttime_ap"];
$endtime_ap = $_POST["endtime_ap"];
$sign_ap = $_POST["fullname"];
$idcard = $_POST["idcard"];

date_default_timezone_set('Asia/Bangkok');
$createdate_ap = date('Y/m/d H:i:s');

$ap_title = $_POST["fullname"]." | ".$_POST["hospital_ap"];
$ap_detail = "<b>".$_POST["hospital_ap"]."</b> <br>"."<b>วันที่ : </b>".$_POST["date_ap"]." <br>"."<b>เวลา : </b>".$_POST["starttime_ap"]." - ".$_POST["endtime_ap"]." <br>"."<b>ผู้นัดหมาย : </b>".$_POST["fullname"]." <br><br>"."<b>หมายเหตุ : </b>".$_POST["note_ap"]."<br>";

    $sql = ("INSERT INTO tb_ap(userid_ap, ap_title, ap_detail, ap_startdate, ap_enddate, ap_starttime, ap_endtime, ap_createdate, idcard, note_ap, hospital_ap, status_ap, sign_ap) 
            VALUES('$userid_ap', '$ap_title', '$ap_detail', '$date_ap', '$date_ap', '$starttime_ap', '$endtime_ap', '$createdate_ap', '$idcard', '$note_ap', '$hospital_ap', 'รออนุมัติ', '$sign_ap')");
    $q = mysqli_query($conn,$sql);

	if(isset($q)) {
			header("Location: appoint_page.php?s=1");
			}else{
				echo mysqli_error($conn);
			}

?>