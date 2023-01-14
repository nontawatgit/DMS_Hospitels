<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
	session_start();
    require("../connect_db.php");
    $userid = $_SESSION["userid"];
    $idcard = $_SESSION["idcard"];
    if ($_SESSION["user_leve"] != "a"){
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
        header ("refresh:2; url=../login.html");
        exit();
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
            header ("refresh:2; url=../login.html");
            exit();
    }
	if(!$_SESSION["userid"]){
        header("location:../login.html");
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

    <title>ข้อมูลรายงานทั้วไป</title>
    
    <link rel="icon" type="image/png" href="../img/dns-icon.png">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include '../include/am_sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include '../include/am_topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading-->
                    <div class="text-center mb-4">
                        <font size="8" style="color:black">ข้อมูลรายงานทั่วไป</font><br>
                    </div>

                    <div class="card shadow mb-4 ">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลรายงานทั่วไป</h6>
                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_gen">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table width="100%" class="table thead-dark table-hover table-bordered table-striped dt-responsive nowrap" id="myTable">
                                    <thead class="table-dark">
                                        <th width="110px">คำสั่ง</th>
                                        <th>วันที่ส่งรายงาน</th>
                                        <th>HN</th>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>อุณหภูมิ</th>
                                        <th>อัตราการเต้นของหัวใจ</th>
                                        <th>ความดันตัวบน</th>
                                        <th>ความดันตัวล่าง</th>
                                        <th>ความอิ่มตัวของออกซิเจน</th>
                                        <th>หมายเหตุ*</th>
                                        <th>เลขบัตรประชาชน</th>

                                    </thead>	
                                    <tbody>
                                            <?php
                                                include "../connect_db.php";
                                                $sql = "SELECT * FROM tb_gen ORDER BY userid_gen ASC";
                                                $q = mysqli_query($conn,$sql);
                                                while($r = mysqli_fetch_array($q)){
                                            ?>
                                        <tr>
                                            <td>
                                            <?php
                                                include "../connect_db.php";
                                                $gen_id1 = $r["gen_id"];
                                                $sql_us = "SELECT * FROM tb_gen WHERE gen_id=$gen_id1";
                                                $q1 = mysqli_query($conn,$sql_us);
                                                $row_idcard = mysqli_fetch_array($q1);
                                                $idcard = $row_idcard["idcard"];

                                                $sql_fullname = "SELECT * FROM tb_user WHERE idcard ='$idcard ' ";
                                                $q2 = mysqli_query($conn,$sql_fullname);
                                                $row_name = mysqli_fetch_array($q2);

                                                $fullname = $row_name["fullname"];
                                            ?>
                                                <button type="button" class="addAttr btn btn-warning btn-smll ml-2" data-toggle="modal" data-target="#edit_gen" data-genid="<?=$r["gen_id"];?>" data-efullname="<?=$fullname;?>" data-eidcard="<?=$idcard;?>" data-bodytemp="<?=$r["body_temp"];?>" data-heartrate="<?=$r["heart_rate"];?>" data-bptop="<?=$r["bp_top"];?>" data-bplow="<?=$r["bp_low"];?>" data-espo2="<?=$r["spo2"];?>"><i class="bi bi-pencil-square"></i></button> |
                                                <a href="am_gen_delete.php?proid=<?=$r["gen_id"];?>" class="btn btn-danger btn-del"><i class="bi bi-trash-fill"></i></a> 
                                            </td>
                                            <td><?php echo $r["date_time_gen"]; ?></td>
                                            <td><?php echo "HN".str_pad($r["userid_gen"],8, "0", STR_PAD_LEFT); ?></td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php if ($r["body_temp"] <= 35.3) {
                                                    echo $r["body_temp"]." °C";

                                                    } else if ($r["body_temp"] >= 35.4 AND $r["body_temp"] <= 37.4) {
                                                    echo $r["body_temp"]." °C"."<font color='#27AE60'> (ปกติ)";
                                                                                                                        
                                                    } else if ($r["body_temp"] >= 37.5 AND $r["body_temp"] <= 38.4) {
                                                    echo $r["body_temp"]." °C"."<font color='#F2BF00'> (มีไข้ต่ำ)";
                                                                                                                        
                                                    } else if ($r["body_temp"] >= 38.5 AND $r["body_temp"] <= 39.4) {
                                                    echo $r["body_temp"]." °C"."<font color='#FF941B'> (มีไข้สูง)";
                                                                                                                        
                                                    } else if ($r["bp_top"] >= 40) {
                                                    echo $r["body_temp"]." °C"."<font color='#E40000'> (มีไข้สูงมาก)";
                                                    }; ?></td>
                                            <td><?php if ($r["heart_rate"] >= 60 AND $r["heart_rate"] <= 100) {
                                                    echo $r["heart_rate"]." ครั้ง/นาที"."<font color='#27AE60'> (ปกติ)";
                                                                                                                        
                                                    } else {
                                                    echo $r["heart_rate"]." ครั้ง/นาที"."<font color='#E40000'> (ผิดปกติ)";
                                                    
                                                    }; ?></td>
                                            <td><?php if ($r["bp_top"] < 121) {
                                                    echo $r["bp_top"]." mmHg"."<font color='#27AE60'> (ปกติ)";
                                                                                                                        
                                                    } else if ($r["bp_top"] >= 121 AND $r["bp_top"]<=139 ) {
                                                    echo $r["bp_top"]." mmHg"."<font color='#F2BF00'> (ค่อนข้างสูง)";
                                                                                                                        
                                                    } else if ($r["bp_top"] >= 139 AND $r["bp_top"]<=159) {
                                                    echo $r["bp_top"]." mmHg"."<font color='#FF941B'> (สูง)";
                                                                                                                        
                                                    } else if ($r["bp_top"] >= 160) {
                                                    echo $r["bp_top"]." mmHg"."<font color='#E40000'> (สูงมาก)";
                                                    }; ?></td>

                                            <td><?php if ($r["bp_low"] < 80) {
                                                    echo $r["bp_low"]." mmHg"."<font color='#27AE60'> (ปกติ)";
                                                                                                                        
                                                    } else if ($r["bp_low"] >= 80 AND $r["bp_low"]<=89 ) {
                                                    echo $r["bp_low"]." mmHg"."<font color='#F2BF00'> (ค่อนข้างสูง)";
                                                                                                                        
                                                    } else if ($r["bp_low"] >= 90 AND $r["bp_low"]<=99) {
                                                    echo $r["bp_low"]." mmHg"."<font color='#FF941B'> (สูง)";
                                                                                                                        
                                                    } else if ($r["bp_low"] >= 100) {
                                                    echo $r["bp_low"]." mmHg"."<font color='#E40000'> (สูงมาก)";
                                                    }; ?></td>

                                            <td><?php if ($r["spo2"] <= 95) {
                                                    echo $r["spo2"]." %"."<font color='#E40000'> (ผิดปกติ)";
                                                                                                                        
                                                    } else if ($r["spo2"] >= 96 AND $r["spo2"] <= 100 ) {
                                                    echo $r["spo2"]." %"."<font color='#27AE60'> (ปกติ)";
                                                    
                                                    }; ?></td>
                                            <td><?php if($r['note_gen']==""){echo "-"; }else{echo $r['note_gen'];}; ?></td>

                                            <td><?php echo $r["idcard"]; ?></td>
                                            
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

    <!-- View Profile Modal -->
    <div class="modal fade show" id="view_profile" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:black">Profile - ข้อมูลส่วนตัว</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mt-3 mb-2">
                            <img class="col-lg-12" src="../img/undraw_profile.svg " width="180" height="180">
                        </div>
                            <div class="text-center mt-3">
                                <font size="6" style="color:black"> <?php echo $row["fullname"]." (Admin)"; ?></font><br>

                                <font size="4" style="color:black"> <?php 
                                                                        $today = date("Y-m-d");
                                                                        $diff = date_diff(date_create($row["birthday"]), date_create($today));
                                                                        echo "<b>วันเกิด </b>".$row["birthday"]."<b> | </b>"."<b>อายุ </b>".$diff->format('%y')." ปี ".$diff->format('%m')." เดือน";
                                                                    ?></font><br>
                                <font size="4" style="color:black"> <?php echo "<b> เพศ </b>".$row["sex"]."<b> | </b>"; ?></font>
                                <font size="4" style="color:black"> <?php echo "<b> น้ำหนัก/ส่วนสูง </b>".$row["weight"]." กก. ".$row["height"]." ซม. "; ?></font><br>
                                <font size="4" style="color:black"> <?php if ($row['BMI'] <= 18.5) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI"], 2 )." (น้ำหนักต่ำกว่าเกณฑ์)";
                                                                    
                                                                    } else if ($row['BMI'] > 18.5 AND $row['BMI']<=22.9 ) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI"], 2 )." (ปกติ/สมส่วน)";
                                                                    
                                                                    } else if ($row['BMI'] > 22.9 AND $row['BMI']<=24.9) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI"], 2 )." (น้ำหนักเกิน)";

                                                                    } else if ($row['BMI'] > 24.9 AND $row['BMI']<=29.9) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI"], 2 )." (โรคอ้วน)";
                                                                    
                                                                    } else if ($row['BMI'] > 30.0) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI"], 2 )." (โรคอ้วนอันตราย)";
                                                                    }; ?></font><br>
                                <font size="4" style="color:black"> <?php echo "<b>จังหวัด </b>".$row["province"]; ?></font><br>
                                <font size="4" style="color:black"> <?php echo "<b>สิทธิ </b>".$row["hi"]; ?></font><br>
                            </div><br>

                            <div>
                                <button type="button" class="btn btn-danger btn-user btn-block mt-1" data-dismiss="modal">ออก</button>
							</div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Add Gen Modal -->
    <div class="modal fade show" id="add_gen" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="am_gen_save.php">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:black">เพิ่มข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="fullname" class="col-sm-6 form-control-label" style="color:black" >ชื่อ - นามสกุล</label></br>
                                    <input type="text" name="fullname" list="fullname" class="form-control form-control-user" required placeholder="โปรดเลือก" autocomplete="off">
                                <datalist id="fullname">
                                    <?php
                                    include "../connect_db.php";
                                    $sql = "SELECT * FROM tb_user WHERE verify_status = 'verify'";
                                    $q = mysqli_query($conn,$sql);
                                    while($r = mysqli_fetch_array($q)){
                                    ?>
                                    <option value=<?php echo "'".$r["fullname"]."'"; ?>>                     
                                <?php } ?>
                                </datalist>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="body_temp" class="col-sm-12 form-control-label" style="color:black" >อุณหภูมิ</label></br>
									<input type="text" required name="body_temp" id="body_temp" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="heart_rate" class="col-sm-12 form-control-label" style="color:black" >อัตราการเต้นของหัวใจ</label></br>
									<input type="number" required name="heart_rate" id="heart_rate" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="bp_top" class="col-sm-12 form-control-label" style="color:black" >ความดันตัวบน</label></br>
									<input type="number" required name="bp_top" id="bp_top" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="bp_low" class="col-sm-12 form-control-label" style="color:black" >ความดันตัวล่าง</label></br>
									<input type="number" required name="bp_low" id="bp_low" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="spo2" class="col-sm-12 form-control-label" style="color:black" >Oxygen Saturation - ความอิ่มตัวของออกซิเจน</label></br>
									<input type="number" required name="spo2" id="spo2" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
									<input type="hidden" name="note_gen" id="note_gen" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
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

    <!-- Edit Gen Modal -->
    <div class="modal fade show" id="edit_gen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="am_gen_update.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:black">แก้ไขข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <input type="hidden" name="gen_id" id="genid" required autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="fullname" class="col-sm-12 form-control-label" style="color:black" >ชื่อ - นามสกุล</label></br>
									<input readonly type="text" name="fullname" id="efullname" class="form-control form-control-user" value="<?=$fullname;?>" placeholder="โปรดกรอก"></input>
								</div>
                                <div class="col-sm-6">
                                    <label for="idcard" class="col-sm-12 form-control-label" style="color:black" >Citizen ID - เลขบัตรประชาชน</label></br>
									<input readonly type="text" name="idcard" id="eidcard" class="form-control form-control-user" value="<?=$idcard;?>" placeholder="โปรดกรอก"></input>
								</div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="body_temp" class="col-sm-12 form-control-label" style="color:black" >อุณหภูมิ</label></br>
									<input type="text" required name="body_temp" id="bodytemp" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="heart_rate" class="col-sm-12 form-control-label" style="color:black" >อัตราการเต้นของหัวใจ</label></br>
									<input type="number" required name="heart_rate" id="heartrate" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="bp_top" class="col-sm-12 form-control-label" style="color:black" >ความดันตัวบน</label></br>
									<input type="number" required name="bp_top" id="bptop" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="bp_low" class="col-sm-12 form-control-label" style="color:black" >ความดันตัวล่าง</label></br>
									<input type="number" required name="bp_low" id="bplow" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="spo2" class="col-sm-12 form-control-label" style="color:black" >Oxygen Saturation - ความอิ่มตัวของออกซิเจน</label></br>
									<input type="number" required name="spo2" id="espo2" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
									<input type="hidden" name="note_gen" id="note_gen" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
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
                    <a class="btn btn-primary" href="../Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <?php include '../include/datatable.php'; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    
    <!-- ระบข้อมูล Edit -->
    <script>
            $('.addAttr').click(function() {
            var genid = $(this).data('genid');      
            var efullname = $(this).data('efullname');  
            var eidcard = $(this).data('eidcard');     
            var bodytemp = $(this).data('bodytemp');     
            var heartrate = $(this).data('heartrate');     
            var bptop = $(this).data('bptop');     
            var bplow = $(this).data('bplow');     
            var espo2 = $(this).data('espo2');     
    
            $('#genid').val(genid);  
            $('#efullname').val(efullname);  
            $('#eidcard').val(eidcard);  
            $('#bodytemp').val(bodytemp);  
            $('#heartrate').val(heartrate);  
            $('#bptop').val(bptop);  
            $('#bplow').val(bplow);  
            $('#espo2').val(espo2);  
  
            } );
    </script>

    <!-- แจ้งเตือน -->
    <script>
        $('.btn-del').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่ ?',
                text: 'คุณต้องการลบข้อมูลใช่หรือไม่ ?!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
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
                title: 'ลบข้อมูลสำเร็จ',
                text: 'ข้อมูลได้ถูกลบไปแล้ว!',
                timer: 1500,
				showConfirmButton: false
            })
        }

        const flashdata1 = $('.flash-data').data('flashdata1')
        if (flashdata1) {
            Swal.fire({
                icon: 'success',
                title: 'เพิ่มข้อมูลสำเร็จ',
                text: 'ข้อมูลได้ถูกเพิ่มเรียบร้อยแล้ว!',
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
<?php } 
?>
</html>

