<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "connect_db.php";
//tb_us
$userid = $_POST["userid"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$birthday = $_POST["birthday"];
$sex = $_POST["sex"];
$fullname = $_POST["fname"]." ".$_POST["lname"];
$idcard = $_POST["idcard"];

$province = $_POST["province"];
$hi = $_POST["hi"];
$weight = $_POST["weight"];
$height = $_POST["height"];
$BMI = $weight / ( ( $height / 100 ) ** 2 );

//วันและเวลา
date_default_timezone_set('Asia/Bangkok');
$dt = date('Y/m/d H:i:s');


    $sql_us = "UPDATE tb_user SET fname='$fname',
            lname='$lname',
            birthday='$birthday',
            fullname='$fullname',
            sex='$sex',
            province='$province',
            hi='$hi',
            weight='$weight',
            height='$height',
            BMI=$BMI WHERE userid=$userid";
    $q1 = mysqli_query($conn,$sql_us);

    $sql_wh = ("INSERT INTO tb_wh(userid_wh, weight_wh, height_wh, BMI_wh, date_time_wh, idcard) 
    VALUES('$userid', '$weight', '$height', '$BMI', '$dt', '$idcard')");
    $q = mysqli_query($conn,$sql_wh);

        if(isset($q1)) {
            
            header("Location: us_page.php?n=1");

        }else{
            echo "ไม่สามารถบันทึกข้อมูลสินค้าได้ กรุณาตรวจสอบ";
        }

?>