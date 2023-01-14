<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
	session_start();
    require("connect_db.php");
    $userid = $_SESSION["userid"];
    $idcard = $_SESSION["idcard"];
    $fullname = $_SESSION['fullname'];
    if ($_SESSION['user_leve'] == "a"){
        echo "<script>
                $(document).ready(function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'หน้าสำหรับผู้ใช้งานระบบ',
                        text: 'กรุณาเข้าสู่ระบบก่อน!',
                        timer: 4000,
                        showConfirmButton: false
                    });
                });
            </script>";
            header ("refresh:2; url=login.html");
            exit();;
    }else if($_SESSION['verify_status'] == "unverified"){
        echo "<script>
                $(document).ready(function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'ผู้ใช้ยังไม่ได้รับการยืนยัน!!',
                        text: 'โปรดรอดำเนินการยืนยันสักครู่',
                        timer: 4000,
                        showConfirmButton: false
                    });
                });
            </script>";
            header ("refresh:2; url=login.html");
            exit();
    }
	if(!$_SESSION["userid"]){
        header("location:login.html");
    }else{
        $sqllogin = "SELECT * FROM tb_user WHERE userid='" . $_SESSION['userid'] . "'";
        $q = mysqli_query($conn,$sqllogin);
        $row = mysqli_fetch_array($q);
        

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>การนัดหมาย</title>
    
    <link rel="icon" type="image/png" href="img/dns-icon.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'include/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'include/topbar.php'; ?>
                <!-- End of Topbar -->
                    

                    <!-- Page Heading-->
                    <div class="text-center mb-3 mt-4">
                        <font size="8" style="color:black">การนัดหมาย</font><br>
                    </div>

                    
                    <div class="col-lg-12">
                    
                    <!-- Table -->
                    <div class="card shadow mb-4 mt-4">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">นัดหมาย</h6>
                                <!-- <a href="ap_add.php" class="btn btn-success btn-smll">เพิ่มการนัดหมาย<i class="bi bi-plus"></i></a> -->
                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_ap">เพิ่มการนัดหมาย<i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">
                            <table width="100%" class="table thead-dark table-hover table-bordered text-center table-striped" id="myTable">
                                <thead class="table-dark">
                                    <th width="170px">วันที่ทำการนัด</th>
                                    <th width="300px">โรงพยาบาล</th>
                                    <th width="120px">วันที่</th>
                                    <th width="180px">เวลา</th>
                                    <th>หมายเหตุ</th>
                                    <th width="120px">สถานะ</th>
                                    <th width="70px">คำสั่ง</th>
                                </thead>	
                                <tbody>
                                    <?php
                                    include "connect_db.php";
                                    $sql = "SELECT * FROM tb_ap WHERE userid_ap='" . $_SESSION['userid'] . "'";
                                    $q = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_array($q)){
                                    ?>
                                    <tr>
                                        <td><?php echo $row["ap_createdate"]; ?></td>
                                        <td><?php echo $row["hospital_ap"]; ?></td>
                                        <td><?php echo $row["ap_startdate"]; ?></td>
                                        <td><?php echo $row["ap_starttime"]." - ".$row["ap_endtime"]; ?></td>
                                        <td><?php echo $row["note_ap"]; ?></td>
                                        <td><?php if ($row["status_ap"] == "อนุมัติ" ) {
                                                    echo"<font color='#27AE60'>อนุมัติ";                                                 
                                                                 
                                                    } else if ($row["status_ap"] == "รออนุมัติ" ) {
                                                    echo "<font color='#F2BF00'>รออนุมัติ";

                                                    } else if ($row["status_ap"] == "ยกเลิก" ) {
                                                    echo "<font color='#E40000'>ยกเลิก";
                                                    
                                                    }; ?></td>
                                        
                                        <td>
                                            <a href="ap_cancel.php?proid=<?=$row["ap_id"];?>" class="btn btn-danger btn-del">ยกเลิก</a> 
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>

                <?php if (isset($_GET['s'])) : ?>
                    <div class="flash-data" data-flashdata1="<?= $_GET['s']; ?>"></div>
                <?php endif; ?>

                <?php if (isset($_GET['n'])) : ?>
                    <div class="flash-data" data-flashdata2="<?= $_GET['n']; ?>"></div>
                <?php endif; ?>

                <?php if (isset($_GET['m'])) : ?>
                    <div class="flash-data" data-flashdata="<?= $_GET['m']; ?>"></div>
                <?php endif; ?>
                


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">คุณแน่ใจหรือไม่ ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">คุณต้องการจะออกจากระบบใช่หรือไม่ ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Add Appoint Modal -->
    <div class="modal fade show" id="add_ap" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="ap_save.php">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:black">เพิ่มการนัดหมาย</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                            <input type="hidden" required name="userid" id="userid" value="<?=$userid?>" autocomplete="off" placeholder="โปรดกรอก">
                            <input type="hidden" required name="idcard" id="idcard" value="<?=$idcard?>" autocomplete="off" placeholder="โปรดกรอก">
                            <input type="hidden" required name="fullname" id="fullname" value="<?=$fullname?>" autocomplete="off" placeholder="โปรดกรอก">
                    <div class="modal-body">
                        <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="hospital_ap" class="col-sm-6 form-control-label" style="color:black" >Hospital - โรงพยาบาล</label></br>
									<input type="text" name="hospital_ap" list="hospital_ap" class="form-control form-control-user" required placeholder="โปรดเลือก">
                                <datalist id="hospital_ap">
                                    <option value='สถานพยาบาลรวมแพทย์(กระบี่)'>
                                    <option value='โรงพยาบาลเทพธารินทร์'>
                                    <option value='สถานพยาบาลนันอา'>
                                    <option value='โรงพยาบาลสินแพทย์'>
                                    <option value='โรงพยาบาลเมโย'>
                                    <option value='โรงพยาบาลวิภาวดี'>
                                    <option value='สถานพยาบาลเดอะซีเนียร์'>
                                    <option value='สถานพยาบาลเดอะซีเนียร์ สาขารัชดาภิเษก'>
                                    <option value='สถานพยาบาลผู้ป่วยเรื้อรังเดอะซีเนียร์  3'>
                                    <option value='โรงพยาบาลบางปะกอก 9 อินเตอร์เนชั่นแนล '>
                                    <option value='โรงพยาบาลบางมด'>
                                    <option value='สถานพยาบาลบางขุนเทียน'>
                                    <option value='สถานพยาบาลผู้ป่วยเรื้อรังสุทธิสาร'>
                                    <option value='โรงพยาบาลมิชชั่น'>
                                    <option value='โรงพยาบาลธนบุรี 2'>
                                    <option value='โรงพยาบาลกรุงธน 1'>
                                    <option value='โรงพยาบาลเยาวรักษ์'>
                                    <option value='สถานพยาบาลรัชดา - ท่าพระ'>
                                    <option value='โรงพยาบาลเจ้าพระยา'>
                                    <option value='โรงพยาบาลธนบุรี'>
                                    <option value='โรงพยาบาลศรีวิชัย '>
                                    <option value='โรงพยาบาลรามคำแหง'>
                                    <option value='โรงพยาบาลเวชธานี'>
                                    <option value='สถานพยาบาลนวศรีเนอสซิ่งโฮม'>
                                    <option value='โรงพยาบาลนครธน'>
                                    <option value='โรงพยาบาลพระราม 2'>
                                    <option value='โรงพยาบาลเซ็นทรัลเยนเนอรัล'>
                                    <option value='สถานพยาบาลพระราม 3'>
                                    <option value='โรงพยาบาลเกษมราษฎร์บางแค(เดิม500ต)'>
                                    <option value='สถานพยาบาลเพชรเกษม - บางแค'>
                                    <option value='โรงพยาบาลเกษมราษฎร์ประชาชื่น'>
                                    <option value='โรงพยาบาลบางโพ'>
                                    <option value='โรงพยาบาลไทยนครินทร์'>
                                    <option value='โรงพยาบาลบางนา 1'>
                                    <option value='โรงพยาบาลมนารมย์'>
                                    <option value='โรงพยาบาลศิครินทร์'>
                                    <option value='สถานพยาบาลผู้ป่วยเรื้อรังกล้วยน้ำไท 2'>
                                    <option value='โรงพยาบาลบางปะกอก 8'>
                                    <option value='สถานพยาบาลบางมด 3'>
                                    <option value='สถานพยาบาลเวชกรรมบางปะกอก 2 (เดิมส.พ.บางปะกอก 2 บางบอน)'>
                                    <option value='โรงพยาบาลตา  หู  คอ  จมูก'>
                                    <option value='โรงพยาบาลยันฮี'>
                                    <option value='โรงพยาบาล บี เอ็น เอช'>
                                    <option value='โรงพยาบาลกรุงเทพคริสเตียน'>
                                    <option value='โรงพยาบาลมเหสักข์'>
                                    <option value='โรงพยาบาลเปาโล เมโมเรียล นวมินทร์(เดิม100ต)'>
                                    <option value='สถานพยาบาลเจตนิน'>
                                    <option value='สถานพยาบาลผู้ป่วยเรื้อรังกว๋องสิวมูลนิธิ'>
                                    <option value='โรงพยาบาลหัวเฉียว'>
                                    <option value='โรงพยาบาลการแพทย์วิชัยยุทธ'>
                                    <option value='โรงพยาบาลเปาโลเมโมเรียล'>
                                    <option value='โรงพยาบาลพญาไท 2'>
                                    <option value='โรงพยาบาลวิชัยยุทธ '>
                                    <option value='สถานพยาบาลผู้ป่วยเรื้อรังวิชัยยุทธ'>
                                    <option value='สถานพยาบาลมะเร็งกรุงเทพ'>
                                    <option value='โรงพยาบาลกล้วยน้ำไท'>
                                    <option value='โรงพยาบาลบางไผ่'>
                                    <option value='โรงพยาบาลพญาไท 3'>
                                    <option value='สถานพยาบาลเวชกรรมเฉพาะทางอาชีวเวชศาสตร์อินเตอร์เมด'>
                                    <option value='โรงพยาบาลนวมินทร์'>
                                    <option value='โรงพยาบาลนวมินทร์ 9'>
                                    <option value='โรงพยาบาลเสรีรักษ์'>
                                    <option value='โรงพยาบาลเดชา'>
                                    <option value='โรงพยาบาลพญาไท 1'>
                                    <option value='โรงพยาบาลกรุงธน 2'>
                                    <option value='โรงพยาบาลนวมินทร์2'>
                                    <option value='โรงพยาบาลบางปะกอก 1'>
                                    <option value='โรงพยาบาลราษฎร์บูรณะ'>
                                    <option value='โรงพยาบาลเปาโลเมโมเรียล โชคชัย 4'>
                                    <option value='โรงพยาบาลเฉพาะทางศัลยกรรมตกแต่งกมล'>
                                    <option value='โรงพยาบาลลาดพร้าว'>
                                    <option value='สถานพยาบาลภัสรพิบาลเนอสซิ่งโฮม'>
                                    <option value='สถานพยาบาลศุขเวชเนอสซิ่งโฮม(ราม21)'>
                                    <option value='โรงพยาบาลคามิลเลียน'>
                                    <option value='โรงพยาบาลจักษุรัตนิน'>
                                    <option value='โรงพยาบาลบำรุงราษฎร์'>
                                    <option value='โรงพยาบาลสมิติเวช'>
                                    <option value='โรงพยาบาลสุขุมวิท'>
                                    <option value='โรงพยาบาลแพทย์ปัญญา'>
                                    <option value='โรงพยาบาลวิภาราม'>
                                    <option value='โรงพยาบาลสมิติเวชศรีนครินทร์'>
                                    <option value='โรงพยาบาลเกษมราษฎร์ สุขาภิบาล 3'>
                                    <option value='โรงพยาบาลเทียนฟ้ามูลนิธิ'>
                                    <option value='โรงพยาบาลเซนต์หลุยส์'>
                                    <option value='โรงพยาบาลบี.แคร์. เมดิคอลเซ็นเตอร์'>
                                    <option value='โรงพยาบาลสายไหม'>
                                    <option value='โรงพยาบาลวิชัยเวชอินเตอร์เนชั่นแนล หนองแขม (เดิมชื่อศรีวิชัย 2)'>
                                    <option value='โรงพยาบาลมงกุฎวัฒนะ'>
                                    <option value='สถานพยาบาลชินเขตงามวงศ์วาน'>
                                    <option value='โรงพยาบาลกรุงเทพ'>
                                    <option value='โรงพยาบาลคลองตัน'>
                                    <option value='โรงพยาบาลปิยะเวท'>
                                    <option value='โรงพยาบาลผิวหนังอโศก'>
                                    <option value='โรงพยาบาลพระราม 9'>
                                    <option value='โรงพยาบาลเพชรเวช'>
                                    <option value='โรงพยาบาลวัฒโนสถ'>
                                    <option value='โรงพยาบาลหัวใจกรุงเทพ'>
                                    <option value='สถานพยาบาลโกลเด้นเยียร์'>
                                    <option value='สถานพยาบาลเวชกรรมกรุงเทพอินเตอร์เนชั่นแนล'>
                                    <option value='สถานพยาบาลท่าเรือ'>
                                    <option value='โรงพยาบาลกาญจนบุรีเมโมเรียล'>
                                    <option value='โรงพยาบาลธนกาญจน์'>
                                    <option value='สถานพยาบาลคริสเตียนแม่น้ำแควน้อย'>
                                    <option value='โรงพยาบาลธีรวัฒน์'>
                                    <option value='โรงพยาบาลเอกชนเมืองกำแพง'>
                                    <option value='สถานพยาบาลแพทย์บัณฑิต'>
                                    <option value='โรงพยาบาลขอนแก่นราม'>
                                    <option value='โรงพยาบาลราชพฤกษ์'>
                                    <option value='โรงพยาบาลเวชประสิทธิ์'>
                                    <option value='โรงพยาบาลกรุงเทพจันทบุรี'>
                                    <option value='โรงพยาบาลสิริเวช'>
                                    <option value='โรงพยาบาลจุฬารัตน์ 11'>
                                    <option value='โรงพยาบาลโสธราเวช'>
                                    <option value='โรงพยาบาลกรุงเทพพัทยา'>
                                    <option value='โรงพยาบาลพัทยาเมโมเรียล'>
                                    <option value='โรงพยาบาลพัทยาอินเตอร์เนชั่นแนลฮอสพิทอล'>
                                    <option value='โรงพยาบาลเอกชล'>
                                    <option value='โรงพยาบาลเอกชล 2'>
                                    <option value='สถานพยาบาลชลเวช'>
                                    <option value='โรงพยาบาลปิยะเวช บ่อวิน'>
                                    <option value='โรงพยาบาลพญาไทศรีราชา'>
                                    <option value='โรงพยาบาลสมิติเวชศรีราชา'>
                                    <option value='โรงพยาบาลแหลมฉบังอินเตอร์เนชั่นแนล'>
                                    <option value='สถานพยาบาลเมดิคอลเวชการ'>
                                    <option value='โรงพยาบาลรวมแพทย์ชัยนาท'>
                                    <option value='โรงพยาบาลชัยภูมิรวมแพทย์'>
                                    <option value='โรงพยาบาลชัยภูมิ-ราม'>
                                    <option value='โรงพยาบาลธนบุรี - ชุมพร'>
                                    <option value='โรงพยาบาลวิรัชศิลป์'>
                                    <option value='สถานพยาบาลหมอเล็ก'>
                                    <option value='โรงพพยาบาลเกษมราษฎร์ศรีบุรินทร์'>
                                    <option value='โรงพยาบาลโอเวอร์บรู๊ค'>
                                    <option value='โรงพยาบาลช้างเผือก'>
                                    <option value='โรงพยาบาลเชียงใหม่ใกล้หมอ'>
                                    <option value='โรงพยาบาลเชียงใหม่ราม'>
                                    <option value='โรงพยาบาลเซ็นทรัลเชียงใหม่-เมโมเรียล'>
                                    <option value='โรงพยาบาลตาเซนต์ปีเตอร์'>
                                    <option value='โรงพยาบาลเทพปัญญา'>
                                    <option value='โรงพยาบาลแมคคอร์มิค'>
                                    <option value='โรงพยาบาลรวมแพทย์เชียงใหม่'>
                                    <option value='โรงพยาบาลราชเวชเชียงใหม่'>
                                    <option value='โรงพยาบาลลานนา'>
                                    <option value='โรงพยาบาลสยามราษฎร์เชียงใหม่'>
                                    <option value='สถานพยาบาลแมคเคน'>
                                    <option value='สถานพยาบาลโรคเด็กและเวชกรรมทั่วไป'>
                                    <option value='โรงพยาบาลตรังรวมแพทย์'>
                                    <option value='โรงพยาบาลราชดำเนิน'>
                                    <option value='โรงพยาบาลวัฒนแพทย์'>
                                    <option value='สถานพยาบาลเอกชนห้วยยอด'>
                                    <option value='โรงพยาบาลกรุงเทพ-ตราด'>
                                    <option value='โรงพยาบาลพะวอ'>
                                    <option value='โรงพยาบาลศาลายา'>
                                    <option value='ศาลายาเนอร์สซิ่งโฮมสถานพยาบาลผู้ป่วยเรื้อรัง'>
                                    <option value='โรงพยาบาลกรุงเทพคริสเตียนนครปฐม'>
                                    <option value='โรงพยาบาลเทพากร'>
                                    <option value='โรงพยาบาลสนามจันทร์'>
                                    <option value='โรงพยาบาลบัวใหญ่รวมแพทย์'>
                                    <option value='สถานพยาบาลปากช่องเมดิคอล'>
                                    <option value='สถานพยาบาลเวชกรรมกรุงเทพราชสีมา'>
                                    <option value='สถานพยาบาลเวชกรรมพิมายเมดิคอล'>
                                    <option value='โรงพยาบาล ป.แพทย์'>
                                    <option value='โรงพยาบาลกรุงเทพราชสีมา'>
                                    <option value='โรงพยาบาลโคราชเมโมเรียล'>
                                    <option value='โรงพยาบาลเซ้นต์แมรี่'>
                                    <option value='โรงพยาบาลเดอะโกลเดนเกต'>
                                    <option value='สถานพยาบาลรวมแพทย์ทุ่งสง'>
                                    <option value='โรงพยาบาลนครคริสเตียน'>
                                    <option value='โรงพยาบาลนครพัฒน์'>
                                    <option value='โรงพยาบาลนครินทร์'>
                                    <option value='สถานพยาบาลเวชกรรมพาเลช(เดิม29ต)'>
                                    <option value='สถานพยาบาลเวชกรรมแพทย์ช่องแค'>
                                    <option value='โรงพยาบาลปากน้ำโพ'>
                                    <option value='โรงพยาบาลร่มฉัตร'>
                                    <option value='โรงพยาบาลรวมแพทย์นครสวรรค์'>
                                    <option value='โรงพยาบาลรัตนเวช (นครสวรรค์)'>
                                    <option value='โรงพยาบาลศรีสวรรค์'>
                                    <option value='โรงพยาบาลอนันต์พัฒนา 2'>
                                    <option value='โรงพยาบาลชลลดา'>
                                    <option value='โรงพยาบาลเกษมราษฎร์รัตนาธิเบศร์'>
                                    <option value='โรงพยาบาลกรุงไทย'>
                                    <option value='โรงพยาบาลวิภารามปากเกร็ด(เดิมชื่อรพ.แม่น้ำ)'>
                                    <option value='โรงพยาบาลนนทเวช'>
                                    <option value='สถานพยาบาลการแพทย์รัตนาธิเบศร์(เดิม27ต)'>
                                    <option value='โรงพยาบาลนายแพทย์สุรเชษฐ์ '>
                                    <option value='โรงพยาบาลเอกชนบุรีรัมย์ (เดิม100ต)'>
                                    <option value='โรงพยาบาลนวนคร'>
                                    <option value='โรงพยาบาลภัทร-ธนบุรี'>
                                    <option value='โรงพยาบาลปทุมเวช'>
                                    <option value='โรงพยาบาลเอกปทุม'>
                                    <option value='โรงพยาบาลกรุงสยามเซนต์คาร์ลอส'>
                                    <option value='สถานพยาบาลเวชกรรมเมืองปทุม(เดิมโรงพยาบาลเมืองปทุม40ต)'>
                                    <option value='โรงพยาบาลเฉพาะทางแม่และเด็กแพทย์รังสิต'>
                                    <option value='โรงพยาบาลแพทย์รังสิต'>
                                    <option value='โรงพยาบาลกรุงเทพหัวหิน'>
                                    <option value='โรงพยาบาลซานเปาโลหัวหิน'>
                                    <option value='สถานพยาบาลชีวาศรม'>
                                    <option value='สถานพยาบาลอิมพีเรียล'>
                                    <option value='โรงพยาบาลโสธรเวช304'>
                                    <option value='สถานพยาบาลผู้ป่วยเรื้อรังเวลเนสแคร์'>
                                    <option value='โรงพยาบาลนวนครอยุธยา'>
                                    <option value='โรงพยาบาลโรจนเวช'>
                                    <option value='โรงพยาบาลพีรเวช'>
                                    <option value='โรงพยาบาลราชธานี'>
                                    <option value='โรงพยาบาลศุภมิตรเสนา'>
                                    <option value='โรงพยาบาลพะเยาราม'>
                                    <option value='โรงพยาบาลปิยะรักษ์'>
                                    <option value='สถานพยาบาลรวมแพทย์(พัทลุง)'>
                                    <option value='โรงพยาบาลชัยอรุณเวชการ'>
                                    <option value='โรงพยาบาลสหเวช'>
                                    <option value='สถานพยาบาลเวชกรรมทัศนเวช'>
                                    <option value='สถานพยาบาลศรีสุโข'>
                                    <option value='โรงพยาบาลพิษณุเวช'>
                                    <option value='โรงพยาบาลรวมแพทย์พิษณุโลก'>
                                    <option value='โรงพยาบาลรัตนเวช 2'>
                                    <option value='โรงพยาบาลรัตนเวช(พิษณุโลกเดิม60ต)'>
                                    <option value='โรงพยาบาลอินเตอร์เวชการ'>
                                    <option value='สถานพยาบาลรังสีรักษาและเวชศาสตร์นิวเคลียร์'>
                                    <option value='โรงพยาบาลเพชรรัชต์'>
                                    <option value='โรงพยาบาลเมืองเพชร-ธนบุรี'>
                                    <option value='สถานพยาบาลผลกำเนิดศิริ'>
                                    <option value='โรงพยาบาลเพชรรัตน์'>
                                    <option value='โรงพยาบาลเมืองเพชร'>
                                    <option value='สถานพยาบาลเวชกรรมนครหล่ม'>
                                    <option value='โรงพยาบาล แพร่-ราม'>
                                    <option value='โรงพยาบาลแพร่คริสเตียน'>
                                    <option value='โรงพยาบาลกรุงเทพภูเก็ต'>
                                    <option value='โรงพยาบาลมิชชั่นภูเก็ต'>
                                    <option value='โรงพยาบาลสิริโรจน์ '>
                                    <option value='โรงพยาบาลไทยอินเตอร์มหาสารคาม'>
                                    <option value='โรงพยาบาลมุกดาหารอินเตอร์เนชั่นแนล'>
                                    <option value='โรงพยาบาลนายแพทย์หาญ'>
                                    <option value='โรงพยาบาลหาญอินเตอร์เนชั่นแนล'>
                                    <option value='โรงพยาบาลสิโรรส'>
                                    <option value='โรงพยาบาลกรุงเทพจุรีเวช'>
                                    <option value='โรงพยาบาลร้อยเอ็ด - ธนบุรี'>
                                    <option value='สถานพยาบาลอันดามัน-ระนองการแพทย์'>
                                    <option value='โรงพยาบาลกรุงเทพระยอง'>
                                    <option value='โรงพยาบาลมงกุฏระยอง'>
                                    <option value='โรงพยาบาลรวมแพทย์ระยอง'>
                                    <option value='สถานพยาบาลหมอสงวน'>
                                    <option value='โรงพยาบาลซานคามิลโล'>
                                    <option value='สถานพยาบาลวัฒนเวช'>
                                    <option value='โรงพยาบาลพร้อมแพทย์'>
                                    <option value='โรงพยาบาลเมืองราช'>
                                    <option value='สถานพยาบาลแพทย์ประดิษฐ์'>
                                    <option value='โรงพยาบาลเบญจรมย์'>
                                    <option value='โรงพยาบาลเมืองนารายณ์'>
                                    <option value='โรงพยาบาลเขลางค์นคร-ราม'>
                                    <option value='สถานพยาบาลแวนแซนต์วูร์ด'>
                                    <option value='โรงพยาบาลศิริเวชลำพูน'>
                                    <option value='โรงพยาบาลหริภุญชัย-เมโมเรียล'>
                                    <option value='โรงพยาบาลเมืองเลยราม'>
                                    <option value='โรงพยาบาลประชารักษ์เวชการ'>
                                    <option value='โรงพยาบาลรักษ์สกล'>
                                    <option value='สถานพยาบาลพัทยเวช'>
                                    <option value='โรงพยาบาลกรุงเทพหาดใหญ่'>
                                    <option value='โรงพยาบาลมิตรภาพสามัคคี(มูลนิธิท่งเซียเซี่ยงตึ้ง)'>
                                    <option value='โรงพยาบาลราษฎร์ยินดี'>
                                    <option value='โรงพยาบาลศิครินทร์หาดใหญ่'>
                                    <option value='โรงพยาบาลรวมชัยประชารักษ์'>
                                    <option value='โรงพยาบาลจุฬารัตน์ 3'>
                                    <option value='โรงพยาบาลจุฬารัตน์ 9'>
                                    <option value='โรงพยาบาลเซ็นทรัลปาร์ค'>
                                    <option value='โรงพยาบาลบางนา 5'>
                                    <option value='โรงพยาบาลปิยะมินทร์'>
                                    <option value='สถานพยาบาลจุฬารัตน์ 5'>
                                    <option value='โรงพยาบาลบางนา 2'>
                                    <option value='สถานพยาบาลจุฬารัตน์สุวรรณภูมิ'>
                                    <option value='โรงพยาบาลชัยปราการ'>
                                    <option value='โรงพยาบาลบางปะกอก 3 พระประแดง'>
                                    <option value='โรงพยาบาลเมืองสมุทรปู่เจ้าสมิงพราย'>
                                    <option value='โรงพยาบาลกรุงเทพพระประแดง'>
                                    <option value='โรงพยาบาลเปาโลเมโมเรียล สมุทรปราการ'>
                                    <option value='โรงพยาบาลเมืองสมุทรปากน้ำ'>
                                    <option value='โรงพยาบาลรัทรินทร์'>
                                    <option value='โรงพยาบาลสำโรงการแพทย์'>
                                    <option value='สถานพยาบาลจุฬาเวช'>
                                    <option value='สถานพยาบาลเมืองสมุทรบางปู'>
                                    <option value='โรงพยาบาลแม่กลอง'>
                                    <option value='โรงพยาบาลมหาชัย 2'>
                                    <option value='โรงพยาบาลศรีวิชัยอินเตอร์เนชั่นแนล อ้อมน้อย (ศรีวิชัย 5-120ต)'>
                                    <option value='โรงพยาบาลมหาชัย'>
                                    <option value='โรงพยาบาลมหาชัย 3'>
                                    <option value='โรงพยาบาลวิชัยเวชอินเตอร์เนชั่นแนล สมุทรสาคร (เดิมศรีวิชัย 3-200ต)'>
                                    <option value='โรงพยาบาลเอกชัย'>
                                    <option value='สถานพยาบาลเจษฎาเวชการ'>
                                    <option value='สถานพยาบาลอภิณพเวชกรรม'>
                                    <option value='โรงพยาบาลเกษมราษฎร์สระบุรี'>
                                    <option value='โรงพยาบาลมิตรภาพเมโมเรียล'>
                                    <option value='โรงพยาบาลปภาเวช'>
                                    <option value='โรงพยาบาลสิงห์บุรีเวชการ  (หมอประเจิด)'>
                                    <option value='โรงพยาบาลพัฒนเวชสุโขทัย'>
                                    <option value='โรงพยาบาลรวมแพทย์สุโขทัย'>
                                    <option value='สถานพยาบาลหมออาคม'>
                                    <option value='สถานพยาบาลหมอสำเริง'>
                                    <option value='โรงพยาบาลพรชัย'>
                                    <option value='โรงพยาบาลศุภมิตร(เดิม164ต)'>
                                    <option value='โรงพยาบาลธนบุรีอู่ทอง'>
                                    <option value='โรงพยาบาลวิภาวดี-ปิยราษฎร์'>
                                    <option value='โรงพยาบาลกรุงเทพสมุย'>
                                    <option value='โรงพยาบาลไทยอินเตอร์เนชั่นแนล'>
                                    <option value='โรงพยาบาลบ้านดอนอินเตอร์'>
                                    <option value='โรงพยาบาลสมุยอินเตอร์เนชั่นแนล'>
                                    <option value='โรงพยาบาลทักษิณ'>
                                    <option value='โรงพยาบาลศรีวิชัยสุราษฎร์ธานี'>
                                    <option value='สถานพยาบาลเวียงเวช'>
                                    <option value='โรงพยาบาลรวมแพทย์(หมออนันต์)'>
                                    <option value='โรงพยาบาลสุรินทร์รวมแพทย์ '>
                                    <option value='โรงพยาบาลพิสัยเวช'>
                                    <option value='โรงพยาบาลรวมแพทย์หนองคาย'>
                                    <option value='โรงพยาบาลหนองคายวัฒนา'>
                                    <option value='โรงพยาบาลวีระพลการแพทย์(เดิมสถานพยาบาลวีระพลการแพทย์30ต)'>
                                    <option value='โรงพยาบาลอ่างทองเวชการ 2 (หมอประเจิด)'>
                                    <option value='โรงพยาบาลนอร์ทอีสเทอร์นวัฒนา'>
                                    <option value='โรงพยาบาลปัญญาเวชอินเตอร์'>
                                    <option value='โรงพยาบาลเอกอุดร'>
                                    <option value='สถานพยาบาลชัยเกษมการแพทย์ '>
                                    <option value='สถานพยาบาลรัตนแพทย์(เดิมสถานพยาบาลเวชกรรมรัตนแพทย์)'>
                                    <option value='โรงพยาบาลราชเวชอุบลราชธานี'>
                                    <option value='โรงพยาบาลอุบลรักษ์ธนบุรี'>
                                    <option value='โรงพยาบาลเอกชนร่มเกล้า'>
                                </datalist>
								</div>
							</div>

                            <div class="form-group row">
								<div class="col-sm-12">
                                    <label for="date_ap" class="col-sm-12 form-control-label" style="color:black" >Date - วันที่</label></br>
									<input type="date" required name="date_ap" id="date_ap" class="form-control form-control-user">
								</div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="starttime_ap" class="col-sm-12 form-control-label" style="color:black" >Start Time เวลาเริ่มต้น</label></br>
									<input type="time" required name="starttime_ap" id="starttime_ap" step="1800" class="form-control form-control-user">
								</div>
                                <div class="col-sm-6">
                                    <label for="endtime_ap" class="col-sm-12 form-control-label" style="color:black" >End Time เวลาสิ้นสุด</label></br>
									<input type="time" required name="endtime_ap" id="endtime_ap" step="1800" class="form-control form-control-user">
								</div>
                            </div>

                            <div class="form-group row">
								<div class="col-sm-12">
                                    <label for="note_ap" class="col-sm-12 form-control-label" style="color:black" >Note - ระบุอาการที่ต้องการพบแพทย์ หรือ หมายเหตุ</label></br>
									<input type="text" required name="note_ap" id="note_ap" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-12">
									<input type="hidden" name="note_b" id="note_b" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">บันทึกข้อมูล Save Data</button>
                                <button type="button" class="btn btn-danger btn-user btn-block mt-3" data-dismiss="modal">ยกเลิก</button>
							</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

    <!-- Bootstrap core JavaScript-->
    <!--<script src="vendor/jquery/jquery.min.js"></script>-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        $('.btn-del').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่ ?',
                text: 'คุณต้องการยกเลิกการนัดใช่หรือไม่ ?!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;
                }
            })

        })

        const flashdata = $('.flash-data').data('flashdata')
        if (flashdata) {
            Swal.fire({
                icon: 'success',
                title: 'ยกเลิกนัดหมายสำเร็จ',
                text: 'ยกเลิกการนัดหมายเรียบร้อยแล้ว!',
                timer: 1500,
				showConfirmButton: false
            })
        }

        const flashdata1 = $('.flash-data').data('flashdata1')
        if (flashdata1) {
            Swal.fire({
                icon: 'success',
                title: 'เพิ่มการนัดหมายสำเร็จ',
                text: 'ข้อมูลการนัดหมายได้ถูกเพิ่มเรียบร้อยแล้ว!',
                timer: 1500,
				showConfirmButton: false
            })
        }

        const flashdata2 = $('.flash-data').data('flashdata2')
        if (flashdata2) {
            Swal.fire({
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จ',
                text: 'ข้อมูลได้ถูกแก้ไขเรียบร้อยแล้ว!',
                timer: 1500,
				showConfirmButton: false
            })
        }
    </script>

</body>
<?php } ?>
</html>
