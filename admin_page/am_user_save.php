<?php
require "../connect_db.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$idcard = $_POST["idcard"];
$tel = $_POST["tel"];
$birthday = $_POST["birthday"];
$sex = $_POST["sex"];
$fullname = $_POST["fname"]." ".$_POST["lname"];
$weight = $_POST["weight"];
$height = $_POST["height"];
$province = $_POST["province"];
$hi = $_POST["hi"];
$user_leve = $_POST["user_leve"];
$BMI = $weight / ( ( $height / 100 ) ** 2 );

//วันและเวลา
date_default_timezone_set('Asia/Bangkok');
$dt = date('Y/m/d H:i:s');

$check = "SELECT idcard FROM tb_user WHERE idcard = '$idcard' OR email = '$email' OR tel = '$tel'";
$result1 = mysqli_query($conn,$check) or die(mysqli_error($conn));
$num = mysqli_num_rows($result1);

		if($num > 0){
			echo "<script>";
			echo "alert(\"ข้อมูลซ้ำ กรุณาเพิ่มใหม่อีกครั้ง\");";
			echo "window.history.back()";
			echo "</script>";
		}else{
			$sql = ("INSERT INTO tb_user(fname, lname, fullname, email, idcard, tel, birthday, sex, hn_id, user_leve, weight, height, BMI, province, hi) 
					VALUES('$fname', '$lname', '$fullname', '$email', '$idcard', '$tel', '$birthday', '$sex', '$hn_id', '$user_leve', '$weight', '$height', '$BMI', '$province', '$hi')");
			$q = mysqli_query($conn,$sql);
			
			$sql_tb_wh = ("INSERT INTO tb_wh(weight_wh, height_wh, BMI_wh, date_time_wh, idcard) 
			VALUES('$weight', '$height', '$BMI', '$dt', '$idcard')");
			$q = mysqli_query($conn,$sql_tb_wh);
		if($q) {
                header("Location: am_user_page.php?s=1");
			}else{
				echo mysqli_error($conn);
			}
		}
?>
