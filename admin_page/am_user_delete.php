<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "../connect_db.php";
$userid = $_REQUEST["proid"];
$sql_user = "DELETE FROM tb_user WHERE userid=$userid";
$sql_wh = "DELETE FROM tb_wh WHERE userid_wh=$userid";
$sql_mr = "DELETE FROM tb_mr WHERE userid_mr=$userid";
$sql_gen = "DELETE FROM tb_gen WHERE userid_gen=$userid";
$sql_blood = "DELETE FROM tb_blood WHERE userid_b=$userid";
$sql_ap = "DELETE FROM tb_ap WHERE userid_ap=$userid";
$q = mysqli_query($conn,$sql_user);
$q1 = mysqli_query($conn,$sql_wh);
$q2 = mysqli_query($conn,$sql_mr);
$q3 = mysqli_query($conn,$sql_gen);
$q4 = mysqli_query($conn,$sql_blood);
$q5 = mysqli_query($conn,$sql_ap);

    if(isset($q)){
        header("Location: am_user_page.php?m=1");

    }else{
        echo "ไม่สามารถลบข้อมูลได้";
    }

?>