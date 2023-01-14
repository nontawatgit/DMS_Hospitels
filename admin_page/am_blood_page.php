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

    <title>น้ำตาล & ไขมันในเลือด</title>
    
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
                        <font size="8" style="color:black">น้ำตาล & ไขมันในเลือด</font><br>
                    </div>

                    <div class="card shadow mb-4 ">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">น้ำตาล & ไขมันในเลือด</h6>
                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_blood">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>
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
                                        <th>ระดับน้ำตาลในเลือด</th>
                                        <th>ไขมันในเลือด</th>
                                        <th>เลขบัตรประชาชน</th>
                                        <th>หมายเหตุ*</th>
                                    </thead>	
                                    <tbody>
                                        <?php
                                        include "../connect_db.php";
                                        $sql = "SELECT * FROM tb_blood ORDER BY userid_b ASC";
                                        $q = mysqli_query($conn,$sql);
                                        while($r = mysqli_fetch_array($q)){
                                        ?>
                                        <tr>
                                            <td>
                                            <?php
                                                $b_id1 = $r["b_id"];
                                                $sql_us = "SELECT * FROM tb_blood WHERE b_id=$b_id1";
                                                $q1 = mysqli_query($conn,$sql_us);
                                                $row_idcard = mysqli_fetch_array($q1);
                                                $idcard = $row_idcard["idcard"];

                                                $sql_fullname = "SELECT * FROM tb_user WHERE idcard ='$idcard ' ";
                                                $q2 = mysqli_query($conn,$sql_fullname);
                                                $row_name = mysqli_fetch_array($q2);
                                                
                                                $fullname = $row_name["fullname"];
                                            ?>
                                                <button type="button" class="addAttr btn btn-warning btn-smll ml-2" data-toggle="modal" data-target="#edit_blood" data-bid="<?=$r["b_id"];?>" data-efullname="<?=$fullname;?>" data-eidcard="<?=$idcard;?>" data-bloodsugar="<?=$r["blood_sugar"];?>" data-bloodfat="<?=$r["blood_fat"];?>" data-noteb="<?=$r["note_b"];?>"><i class="bi bi-pencil-square"></i></button> |
                                                <a href="am_blood_delete.php?proid=<?=$r["b_id"];?>" class="btn btn-danger btn-del"><i class="bi bi-trash-fill"></i></a> 
                                            </td>
                                            <td><?php echo $r["date_time_b"]; ?></td>
                                            <td><?php echo "HN".str_pad($r["userid_b"],8, "0", STR_PAD_LEFT); ?></td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php if ($r["blood_sugar"] <= 69) {
                                                    echo $r["blood_sugar"]." mg/dL"."<font color='#27AE60'> (ปกติ)";

                                                    } else if ($r["blood_sugar"] >= 70 AND $r["blood_sugar"] <= 100) {
                                                    echo $r["blood_sugar"]." mg/dL"."<font color='#27AE60'> (ปกติ)";
                                                                                                                        
                                                    } else if ($r["blood_sugar"] >= 101 AND $r["blood_sugar"] <= 125) {
                                                    echo $r["blood_sugar"]." mg/dL"."<font color='#F2BF00'> (มีภาวะความเสี่ยง)";
                                                                                                                        
                                                    } else if ($r["blood_sugar"] >= 126) {
                                                    echo $r["blood_sugar"]." mg/dL"."<font color='#E40000'> (เสี่ยงเป็นโรคเบาหวาน)";
                                                    }; ?></td>

                                            <td><?php if ($r["blood_fat"] <= 199) {
                                                    echo $r["blood_fat"]." mg/dL"."<font color='#27AE60'> (ปกติ)";

                                                    } else if ($r["blood_fat"] >= 200 AND $r["blood_fat"] <= 239) {
                                                    echo $r["blood_fat"]." mg/dL"."<font color='#F2BF00'> (ค่อนข้างสูง)";
              
                                                    } else if ($r["blood_fat"] >= 240) {
                                                    echo $r["blood_fat"]." mg/dL"."<font color='#E40000'> (อันตราย)";
                                                    }; ?></td>
                                            <td><?php echo $r["idcard"]; ?></td>
                                            <td><?php if($r['note_b']==""){echo "-"; }else{echo $r['note_b'];}; ?></td>
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

    <!-- Add Blood Modal -->
    <div class="modal fade show" id="add_blood" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="am_blood_save.php">
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
                                <div class="col-sm-12">
                                    <label for="blood_sugar" class="col-sm-12 form-control-label" style="color:black" >Blood Sugar - ระดับน้ำตาลในเลือด</label></br>
									<input type="number" required name="blood_sugar" id="blood_sugar" class="form-control form-control-user" min="0" max="500" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="blood_fat" class="col-sm-12 form-control-label" style="color:black" >Blood Lipid Levels - ระดับไขมันในเลือด</label></br>
									<input type="number" required name="blood_fat" id="blood_fat" class="form-control form-control-user" min="0" max="500" autocomplete="off" placeholder="โปรดกรอก">
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

    <!-- Edit Blood Modal -->
    <div class="modal fade show" id="edit_blood" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="am_blood_update.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:black">แก้ไขข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <input type="hidden" name="b_id" id="bid" required autocomplete="off">
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
                                <div class="col-sm-12">
                                    <label for="blood_sugar" class="col-sm-12 form-control-label" style="color:black" >Blood Sugar - ระดับน้ำตาลในเลือด</label></br>
									<input type="number" required name="blood_sugar" id="bloodsugar" class="form-control form-control-user" min="0" max="500" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="blood_fat" class="col-sm-12 form-control-label" style="color:black" >Blood Lipid Levels - ระดับไขมันในเลือด</label></br>
									<input type="number" required name="blood_fat" id="bloodfat" class="form-control form-control-user" min="0" max="500" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
									<input type="hidden" name="note_b" id="noteb" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
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
            var bid = $(this).data('bid');      
            var efullname = $(this).data('efullname');  
            var eidcard = $(this).data('eidcard');    
            var bloodsugar = $(this).data('bloodsugar');  
            var bloodfat = $(this).data('bloodfat');     
            var noteb = $(this).data('noteb');     

            $('#bid').val(bid);  
            $('#efullname').val(efullname);  
            $('#eidcard').val(eidcard);  
            $('#bloodsugar').val(bloodsugar);  
            $('#bloodfat').val(bloodfat);  
            $('#noteb').val(noteb);  
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

