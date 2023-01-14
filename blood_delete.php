<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "connect_db.php";
$b_id = $_REQUEST["proid"];
$sql = "DELETE FROM tb_blood WHERE b_id=$b_id";
$q = mysqli_query($conn,$sql);
if(isset($q)){
    header("Location: blood_page.php?m=1");
}else{
	echo "ไม่สามารถลบข้อมูลได้";
}
?>