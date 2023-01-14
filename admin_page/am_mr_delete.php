<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include "../connect_db.php";
$mr_id = $_REQUEST["proid"];
$sql = "DELETE FROM tb_mr WHERE mr_id=$mr_id";
$q = mysqli_query($conn,$sql);
if(isset($q)){
    header("Location: am_mr_page.php?m=1");

}else{
	echo "ไม่สามารถลบข้อมูลได้";
}
?>