<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require "connect_db.php";

$userid_gen = $_POST["userid"];
$body_temp = $_POST["body_temp"];
$heart_rate = $_POST["heart_rate"];
$bp_top = $_POST["bp_top"];
$bp_low = $_POST["bp_low"];
$spo2 = $_POST["spo2"];
$note_gen = $_POST["note_gen"];
$idcard = $_POST["idcard"];

date_default_timezone_set('Asia/Bangkok');
$date_time_gen = date('Y/m/d H:i:s');


	$sql = ("INSERT INTO tb_gen(userid_gen, body_temp, heart_rate, bp_top, bp_low, spo2, note_gen, date_time_gen, idcard) 
			VALUES('$userid_gen', '$body_temp', '$heart_rate', '$bp_top', '$bp_low', '$spo2', '$note_gen', '$date_time_gen', '$idcard')");
	$q = mysqli_query($conn,$sql);

		if($q) {
            header("Location: gen_page.php?s=1");

			}else{
				echo mysqli_error($conn);
			}

?>