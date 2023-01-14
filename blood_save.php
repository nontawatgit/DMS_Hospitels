<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require "connect_db.php";

$userid_b = $_POST["userid"];
$blood_sugar = $_POST["blood_sugar"];
$blood_fat = $_POST["blood_fat"];
$note_b = $_POST["note_b"];
$idcard = $_POST["idcard"];

date_default_timezone_set('Asia/Bangkok');
$date_time_b = date('Y/m/d H:i:s');


	$sql = ("INSERT INTO tb_blood(userid_b, blood_sugar, blood_fat, note_b, date_time_b, idcard) 
			VALUES('$userid_b', '$blood_sugar', '$blood_fat', '$note_b', '$date_time_b', '$idcard')");
	$q = mysqli_query($conn,$sql);

	if(isset($q)) {
			header("Location: blood_page.php?s=1");
			}else{
				echo mysqli_error($conn);
			}

?>