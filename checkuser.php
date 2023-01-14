<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
include "connect_db.php";
include "login.html";
if (isset($_POST['idcard'])){


//รับค่า
$userid = isset($_SESSION["userid"]);
$idcard = $_POST['idcard'];
$tel = $_POST['tel'];

$sql = "SELECT * FROM tb_user WHERE idcard='$idcard' AND tel='$tel'";
$q = mysqli_query($conn,$sql);
	if(mysqli_num_rows($q) == 1){
		$row = mysqli_fetch_array($q);
		$_SESSION['userid'] = $row["userid"];
		$_SESSION['fullname'] = $row["fullname"];
		$_SESSION['email'] = $row["email"];
		$_SESSION['idcard'] = $row["idcard"];
		$_SESSION['tel'] = $row["tel"];
		$_SESSION['birthday'] = $row["birthday"];
		$_SESSION['sex'] = $row["sex"];
		$_SESSION['user_leve'] = $row["user_leve"];
		$_SESSION['verify_status'] = $row["verify_status"];
		if($_SESSION['user_leve'] == "a" AND $_SESSION['verify_status'] == "verify"){
			header ("refresh:1; url=admin_page/am_page.php");
			echo "<script>
            	$(document).ready(function(){
					Swal.fire({
						icon: 'success',
						title: 'เข้าสู่ระบบสำเร็จ',
						text: 'Login Successfully.',
						timer: 1500,
						showConfirmButton: false
					});
				});
			</script>";
			
		}else if($_SESSION['user_leve'] == "u" AND $_SESSION['verify_status'] == "verify"){
			header ("refresh:1; url=us_page.php");
			echo "<script>
            	$(document).ready(function(){
					Swal.fire({
						icon: 'success',
						title: 'เข้าสู่ระบบสำเร็จ',
						text: 'Login Successfully.',
						timer: 1500,
						showConfirmButton: false
					});
				});
			</script>";
		}else if($_SESSION['verify_status'] == "unverified"){
			header ("refresh:2; url=login.html");
			echo "<script>
			$(document).ready(function(){
				Swal.fire({
					icon: 'error',
					title: 'ผู้ใช้ยังไม่ได้รับการยืนยัน!!',
					text: 'โปรดรอดำเนินการยืนยันสักครู่',
					timer: 2500,
					showConfirmButton: false
				});
			});
		</script>";
		}
	}else{
		header ("refresh:1; url=login.html");
		echo "<script>
		$(document).ready(function(){
			Swal.fire({
				icon: 'error',
				title: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!!',
				text: 'โปรดลองใหม่',
				timer: 2500,
				showConfirmButton: false
			});
		});
	</script>";
	}
}else{
	header("Location: login.html");
}

?>
