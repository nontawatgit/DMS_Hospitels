<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require "connect_db.php";

$userid_mr = $_POST["userid"];
$mood_level = $_POST["mood_level"];
$stress_level = $_POST["stress_level"];
$note_mood = $_POST["note_mood"];
$rest = $_POST["rest"];
$idcard = $_POST["idcard"];

date_default_timezone_set('Asia/Bangkok');
$date_time_mr = date('Y/m/d H:i:s');


	$sql = ("INSERT INTO tb_mr(userid_mr, mood_level, note_mood, stress_level, rest, date_time_mr, idcard) 
			VALUES('$userid_mr', '$mood_level', '$note_mood', '$stress_level', $rest, '$date_time_mr', '$idcard')");
	$q = mysqli_query($conn,$sql);

	if(isset($q)) {
		header("Location: mr_page.php?s=1");

			}else{
				echo mysqli_error($conn);
			}

?>