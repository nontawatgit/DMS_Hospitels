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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>น้ำตาล & ไขมันในเลือด</title>
    
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
                        <font size="8" style="color:black">รายงาน น้ำตาล & ไขมันในเลือด</font><br>
                    </div>

                    <div class="col-lg-12">                 

                    <!-- Table -->
                    <div class="card shadow mb-4 mt-4">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">รายงานน้ำตาล & ไขมันในเลือด</h6>
                                <!-- <a href="blood_add.php" class="btn btn-success btn-smll">เพิ่มข้อมูล<i class="bi bi-plus"></i></a>    -->
                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_blood">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">                         
                                <table width="100%" class="table thead-dark table-hover table-bordered text-center table-striped" id="myTable">
                                    <thead class="table-dark">
                                        <th>วันที่ส่งรายงาน</th>
                                        <th>ระดับน้ำตาลในเลือด</th>
                                        <th>ไขมันในเลือด</th>
                                        <th>หมายเหตุ*</th>
                                        <th width="100px">คำสั่ง</th>
                                    </thead>	
                                    <tbody>
                                        <?php
                                        include "connect_db.php";
                                        $sql = "SELECT * FROM tb_blood WHERE userid_b='" . $_SESSION['userid'] . "'";
                                    
                                        $q = mysqli_query($conn,$sql);
                                        while($row = mysqli_fetch_array($q)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row["date_time_b"]; ?></td>
                                            <td><?php if ($row["blood_sugar"] <= 69) {
                                                    echo $row["blood_sugar"]." mg/dL"."<font color='#27AE60'> (ปกติ)";

                                                    } else if ($row["blood_sugar"] >= 70 AND $row["blood_sugar"] <= 100) {
                                                    echo $row["blood_sugar"]." mg/dL"."<font color='#27AE60'> (ปกติ)";
                                                                                                                        
                                                    } else if ($row["blood_sugar"] >= 101 AND $row["blood_sugar"] <= 125) {
                                                    echo $row["blood_sugar"]." mg/dL"."<font color='#F2BF00'> (มีภาวะความเสี่ยง)";
                                                                                                                        
                                                    } else if ($row["blood_sugar"] >= 126) {
                                                    echo $row["blood_sugar"]." mg/dL"."<font color='#E40000'> (เสี่ยงเป็นโรคเบาหวาน)";
                                                    }; ?></td>

                                            <td><?php if ($row["blood_fat"] <= 199) {
                                                    echo $row["blood_fat"]." mg/dL"."<font color='#27AE60'> (ปกติ)";

                                                    } else if ($row["blood_fat"] >= 200 AND $row["blood_fat"] <= 239) {
                                                    echo $row["blood_fat"]." mg/dL"."<font color='#F2BF00'> (ค่อนข้างสูง)";
              
                                                    } else if ($row["blood_fat"] >= 240) {
                                                    echo $row["blood_fat"]." mg/dL"."<font color='#E40000'> (อันตราย)";
                                                    }; ?></td>
                                            
                                            <td><?php if($row['note_b']==""){echo "-"; }else{echo $row['note_b'];}; ?></td>
                                            <td>
                                                <button type="button" class="addAttr btn btn-warning btn-smll" data-toggle="modal" data-target="#edit_blood" data-bid="<?=$row["b_id"];?>" data-bloodsugar="<?=$row["blood_sugar"];?>" data-bloodfat="<?=$row["blood_fat"];?>" data-noteb="<?=$row["note_b"];?>"><i class="bi bi-pencil-square"></i></button> |
                                                <a href="blood_delete.php?proid=<?=$row["b_id"];?>" class="btn btn-danger btn-del"><i class="bi bi-trash-fill"></i></a> 
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                        <!-- Graph -->
                        <?php 
                            require_once 'connect_db.php';
                            $sqlQuery = "SELECT * FROM tb_blood WHERE userid_b='$userid'";
                            $result = mysqli_query($conn, $sqlQuery);
                                $data = array();
                                    foreach ($result as $row) {
                                        $G_blood_sugar[] = $row['blood_sugar'];
                                        $G_blood_fat[] = $row['blood_fat'];
                                        $G_date_time_b[] = $row['date_time_b'];
                                    }
                            mysqli_close($conn);
                        ?>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6"> 
                                            <div class="card shadow mb-4 ">
                                                <div class="card-header py-1">
                                                    <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                                        <h6 class="m-0 font-weight-bold text-primary">ระดับน้ำตาลในเลือด</h6>
                                                        </div>
                                                </div>
                                                    <div class="card-body">
                                                        <div class="chart-container">
                                                            <canvas id="graphCanvas_sugar"></canvas>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6"> 
                                            <div class="card shadow mb-4 ">
                                                <div class="card-header py-1">
                                                    <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                                        <h6 class="m-0 font-weight-bold text-primary">ไขมันในเลือด</h6>
                                                        </div>
                                                </div>
                                                    <div class="card-body">
                                                        <div class="chart-container">
                                                            <canvas id="graphCanvas_fat"></canvas>
                                                        </div>
                                                    </div>
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
    
    <!-- Add Blood Modal -->
    <div class="modal fade show" id="add_blood" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="blood_save.php">
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
                <form method="post" action="blood_update.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:black">แก้ไขข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <input type="hidden" name="b_id" id="bid" required autocomplete="off">
                        <div class="modal-body">
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
            var bid = $(this).data('bid');      
            var bloodsugar = $(this).data('bloodsugar');  
            var bloodfat = $(this).data('bloodfat');     
            var noteb = $(this).data('noteb');     

            $('#bid').val(bid);  
            $('#bloodsugar').val(bloodsugar);  
            $('#bloodfat').val(bloodfat);  
            $('#noteb').val(noteb);  
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

        <script>
                                        $(document).ready(function() {
                                            showGraph_sugar();
                                        });

                                        function showGraph_sugar(){
                                            {
                                                $.post("", function(data) {
                                                    console.log(data);
                                                    let name = [];
                                                    let score = [];

                                                    for (let i in data) {

                                                    }

                                                    let chartdatasugar = {
                                                        labels: <?php echo json_encode($G_date_time_b);?>,
                                                        datasets: [{
                                                                label: 'ระดับน้ำตาลในเลือด',
                                                                lineTension: 0.3,
                                                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                                                borderColor: "rgba(78, 115, 223, 1)",
                                                                pointRadius: 3,
                                                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                                                pointHoverRadius: 3,
                                                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                                                pointHitRadius: 10,
                                                                pointBorderWidth: 2,
                                                                data: <?php echo json_encode($G_blood_sugar);?>
                                                        }],
                                                    };

                                                    let graphTargetsugar = $('#graphCanvas_sugar');
                                                    let barGraphsugar = new Chart(graphTargetsugar, {
                                                        type: 'line',
                                                        data: chartdatasugar
                                                    })
                                                    let chartdatafat = {
                                                        labels: <?php echo json_encode($G_date_time_b);?>,
                                                        datasets: [{
                                                                label: 'ไขมันในเลือด',
                                                                lineTension: 0.3,
                                                                backgroundColor: "rgba(249, 0, 0, 0.05)",
                                                                borderColor: "rgba(249, 0, 0, 1)",
                                                                pointRadius: 3,
                                                                pointBackgroundColor: "rgba(249, 0, 0, 1)",
                                                                pointBorderColor: "rgba(249, 0, 0, 1)",
                                                                pointHoverRadius: 3,
                                                                pointHoverBackgroundColor: "rgba(249, 0, 0, 1)",
                                                                pointHoverBorderColor: "rgba(249, 0, 0, 1)",
                                                                pointHitRadius: 10,
                                                                pointBorderWidth: 2,
                                                                data: <?php echo json_encode($G_blood_fat);?>
                                                        }],
                                                    };

                                                    let graphTargetfat = $('#graphCanvas_fat');
                                                    let barGraphfat = new Chart(graphTargetfat, {
                                                        type: 'line',
                                                        data: chartdatafat
                                                    })

                                                })
                                            }
                                        }
                                    </script>
    
</body>
<?php } ?>
</html>


