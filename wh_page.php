<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
	session_start();
    require("connect_db.php");
    $userid = $_SESSION["userid"];
    $idcard = $_SESSION["idcard"];
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
            exit();
        //echo "<center>หน้าสำหรับผู้ใช้งานระบบ <a href=login.html>กรุณาเข้าสู่ระบบก่อน</a></center>";
        //exit();
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

    <title>รายงาน น้ำหนัก ส่วนสูง และ BMI</title>

    <link rel="icon" type="image/png" href="img/dns-icon.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


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
                    <div class="text-center mb-3">
                        <font size="8" style="color:black">รายงาน น้ำหนัก ส่วนสูง และ BMI</font><br>
                    </div>

                    
                    <div class="col-lg-12">
                    
                    <!-- Table -->
                    <div class="card shadow mb-4 ">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">น้ำหนัก ส่วนสูง และ BMI</h6>

                            </div>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">
                            <table width="100%" class="table thead-dark table-hover table-bordered text-center table-striped" id="myTable">
                                <thead class="table-dark">
                                    <th>วันที่ส่งรายงาน</th>
                                    <th>น้ำหนัก</th>
                                    <th>ส่วนสูง</th>
                                    <th>BMI</th>
                                    <th>คำสั่ง</th>
                                </thead>	
                                <tbody>
                                    <?php
                                    include "connect_db.php";
                                    $sql = "SELECT * FROM tb_wh WHERE userid_wh='" . $_SESSION['userid'] . "'";
                                    $q = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_array($q)){
                                    ?>
                                    <tr>
                                        <td><?php echo $row["date_time_wh"]; ?></td>
                                        <td><?php echo $row["weight_wh"]; ?></td>
                                        <td><?php echo $row["height_wh"]; ?></td>
                                        <td><?php if ($row['BMI_wh'] <= 18.5) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI_wh"], 2 )." (น้ำหนักต่ำกว่าเกณฑ์)";
                                                                    
                                                                    } else if ($row['BMI_wh'] > 18.5 AND $row['BMI_wh']<=22.9 ) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI_wh"], 2 )." (ปกติ/สมส่วน)";
                                                                    
                                                                    } else if ($row['BMI_wh'] > 22.9 AND $row['BMI_wh']<=24.9) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI_wh"], 2 )." (น้ำหนักเกิน)";

                                                                    } else if ($row['BMI_wh'] > 24.9 AND $row['BMI_wh']<=29.9) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI_wh"], 2 )." (โรคอ้วน)";
                                                                    
                                                                    } else if ($row['BMI_wh'] > 30.0) {
                                                                        echo "<b>BMI </b>".number_format( $row["BMI_wh"], 2 )." (โรคอ้วนอันตราย)";
                                                                    }; ?></td>
                                        <td>
                                            <a href="wh_delete.php?proid=<?=$row["wh_id"];?>" class="btn btn-danger btn-del"><i class="bi bi-trash-fill mr-2"></i>ลบ</a> 
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

        <!-- Add Gen Modal -->
        <div class="modal fade show" id="add_gen" tabindex="-1" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form method="post" action="gen_save.php">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:black">เพิ่มข้อมูล</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <input type="hidden" required name="userid" id="userid" value="<?=$userid?>" autocomplete="off" placeholder="โปรดกรอก">
                            <input type="hidden" required name="idcard" id="idcard" value="<?=$idcard?>" autocomplete="off" placeholder="โปรดกรอก">
                        <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="body_temp" class="col-sm-12 form-control-label" style="color:black" >Body Temperature - อุณหภูมิ</label></br>
                                        <input type="text" required name="body_temp" id="body_temp" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="heart_rate" class="col-sm-12 form-control-label" style="color:black" >Heart Rate - อัตราการเต้นของหัวใจ</label></br>
                                        <input type="number" required name="heart_rate" id="heart_rate" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="bp_top" class="col-sm-12 form-control-label" style="color:black" >Blood Pressure(Top) - ความดันตัวบน</label></br>
                                        <input type="number" required name="bp_top" id="bp_top" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="bp_low" class="col-sm-12 form-control-label" style="color:black" >Blood Pressure(low) - ความดันตัวล่าง</label></br>
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
                    <form method="post" action="gen_update.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" style="color:black">แก้ไขข้อมูล</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <input type="hidden" name="gen_id" id="genid" required autocomplete="off">
                            <div class="modal-body">
                            <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="body_temp" class="col-sm-12 form-control-label" style="color:black" >Body Temperature - อุณหภูมิ</label></br>
                                        <input type="text" required name="body_temp" id="bodytemp" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="heart_rate" class="col-sm-12 form-control-label" style="color:black" >Heart Rate - อัตราการเต้นของหัวใจ</label></br>
                                        <input type="number" required name="heart_rate" id="heartrate" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="bp_top" class="col-sm-12 form-control-label" style="color:black" >Blood Pressure(Top) - ความดันตัวบน</label></br>
                                        <input type="number" required name="bp_top" id="bptop" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="bp_low" class="col-sm-12 form-control-label" style="color:black" >Blood Pressure(low) - ความดันตัวล่าง</label></br>
                                        <input type="number" required name="bp_low" id="bplow" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="spo2" class="col-sm-12 form-control-label" style="color:black" >Oxygen Saturation - ความอิ่มตัวของออกซิเจน</label></br>
                                        <input type="number" required name="spo2" id="spo" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="note_gen" id="notegen" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
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
                    <a class="btn btn-primary" href="Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <!--<script src="http:////cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>-->
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
            $('.addAttr').click(function() {
            var genid = $(this).data('genid');
            var bodytemp = $(this).data('bodytemp');
            var heartrate = $(this).data('heartrate');
            var bptop = $(this).data('bptop');
            var bplow = $(this).data('bplow');
            var spo = $(this).data('spo');
            var notegen = $(this).data('notegen');

            $('#genid').val(genid);  
            $('#bodytemp').val(bodytemp);  
            $('#heartrate').val(heartrate);  
            $('#bptop').val(bptop);
            $('#bplow').val(bplow);
            $('#spo').val(spo);
            $('#notegen').val(notegen);
            } );
    </script>
    
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
<?php } ?>
</html>
