
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require "../connect_db.php";

$fullname = $_POST["fullname"];
$blood_sugar = $_POST["blood_sugar"];
$blood_fat = $_POST["blood_fat"];
$note_b = $_POST["note_b"];

$sql_idcard = "SELECT * FROM tb_user WHERE fullname='$fullname' ";
$q = mysqli_query($conn,$sql_idcard);
$row = mysqli_fetch_array($q);

$idcard = $row["idcard"];
$userid_b = $row["userid"];

date_default_timezone_set('Asia/Bangkok');
$date_time_b = date('Y/m/d H:i:s');

	$sql = ("INSERT INTO tb_blood(userid_b, blood_sugar, blood_fat, note_b, date_time_b, idcard) 
			VALUES('$userid_b', '$blood_sugar', '$blood_fat', '$note_b', '$date_time_b', '$idcard')");
	$q = mysqli_query($conn,$sql);

	if(isset($q)) {
			header("Location: am_blood_page.php?s=1");
			}else{
				echo mysqli_error($conn);
			}

?>