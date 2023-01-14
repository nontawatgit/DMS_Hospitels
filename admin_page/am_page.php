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
        
        //HN
        $hn_id = "HN".str_pad($_SESSION["userid"],8, "0", STR_PAD_LEFT);
        $sql_hn = ("UPDATE tb_user SET hn_id='$hn_id' 
                WHERE userid=$userid");	
        $q_hn = mysqli_query($conn,$sql_hn);

        $sql_us = ("UPDATE tb_wh SET userid_wh='$userid' 
                WHERE idcard=$idcard");	
        $q_us = mysqli_query($conn,$sql_us);

        $sql_wh_up = ("UPDATE tb_wh SET userid_wh='$userid' 
        WHERE idcard=$idcard");	
        $q_us = mysqli_query($conn,$sql_wh_up);

        $fullcalendar_path = "fullcalendar-4.4.2/packages/";
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

    <title>ข้อมูล User</title>
    
    <link rel="icon" type="image/png" href="../img/dns-icon.png">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.11.2/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.11.2/main.min.js"></script>

    <!-- Fullcalendar -->
    <link href='<?=$fullcalendar_path?>/core/main.css' rel='stylesheet' />
    <link href='<?=$fullcalendar_path?>/daygrid/main.css' rel='stylesheet' />
    <script src='<?=$fullcalendar_path?>/core/main.js'></script>
    <script src='<?=$fullcalendar_path?>/daygrid/main.js'></script>
    <link href='<?=$fullcalendar_path?>/timegrid/main.css' rel='stylesheet' />
    <link href='<?=$fullcalendar_path?>/list/main.css' rel='stylesheet' />
    <script src='<?=$fullcalendar_path?>/core/locales/th.js'></script>
    <script src='<?=$fullcalendar_path?>/timegrid/main.js'></script>
    <script src='<?=$fullcalendar_path?>/interaction/main.js'></script>
    <script src='<?=$fullcalendar_path?>/list/main.js'></script>  

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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    
                        <?php
                            include "../connect_db.php";

                            $sql_usernum = " SELECT * FROM tb_user";
                            $q_usernum = mysqli_query( $conn, $sql_usernum );
                            $num_user = mysqli_num_rows( $q_usernum );

                            $sql_verify = " SELECT * FROM tb_user WHERE verify_status = 'verify'";
                            $q_verify = mysqli_query( $conn, $sql_verify );
                            $num_verify = mysqli_num_rows( $q_verify );

                            $sql_unverified = " SELECT * FROM tb_user WHERE verify_status = 'unverified'";
                            $q_unverified = mysqli_query( $conn, $sql_unverified );
                            $num_unverified = mysqli_num_rows( $q_unverified );

                            $sql_ap1   = " SELECT * FROM tb_ap WHERE status_ap = 'อนุมัติ'";
                            $q_ap1 = mysqli_query( $conn, $sql_ap1 );
                            $num_ap1 = mysqli_num_rows( $q_ap1 );

                            $sql_ap2   = " SELECT * FROM tb_ap WHERE status_ap = 'รออนุมัติ'";
                            $q_ap2 = mysqli_query( $conn, $sql_ap2 );
                            $num_ap2 = mysqli_num_rows( $q_ap2 );
                            
                            $sql_ap3   = " SELECT * FROM tb_ap WHERE status_ap = 'ยกเลิก'";
                            $q_ap3 = mysqli_query( $conn, $sql_ap3 );
                            $num_ap3 = mysqli_num_rows( $q_ap3 );

                            // echo $num_user;
                        ?>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <font size="4" >นัดหมายที่อนุมัติ</font></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$num_ap1;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-check-circle fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                <font size="4" >นัดหมายที่รออนุมัติ</font></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$num_ap2;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-question-circle fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                <font size="4" >นัดหมายที่ถูกยกเลิก</font></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$num_ap3;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-x-circle fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <font size="4" >ผู้ใช้ (Verify)</font></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$num_verify;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-bookmark-check fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <font size="4" >ผู้ใช้ (unverified)</font></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$num_unverified;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-bookmark-x fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <font size="4" >ผู้ใช้ทั้งหมด</font></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$num_user;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-person-circle fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        
                        <div class="col-xl-6 col-lg-7"> 
                            <div class="card shadow mb-4 ">
                                <div class="card-header py-1">
                                    <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">ปฏิทินการนัดหมาย</h6>

                                        <!-- <h6 class="m-0 font-weight-bold text-primary mt-3 mb-3">ปฏิทินการนัดหมาย</h6 -->
                                        <a href="am_appoint_page.php" class="btn btn-info btn-smll">รายงาน</a>
                                        <!-- <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_ap">เพิ่มการนัดหมาย<i class="bi bi-plus"></i></button>  -->
                                    </div>
                                </div>
                                    <div class="card-body" id='calendar'></div>
                            </div>
                        </div>

                        
                        <?php 

                            require_once '../connect_db.php';

                            $sql_usermale  = " SELECT * FROM tb_user WHERE sex = 'Male - ชาย'";
                            $q_usermale = mysqli_query( $conn, $sql_usermale );
                            $num_male = mysqli_num_rows( $q_usermale );

                            $sql_userfemale   = " SELECT * FROM tb_user WHERE sex = 'Female - หญิง'";
                            $q_userfemale = mysqli_query( $conn, $sql_userfemale );
                            $num_female = mysqli_num_rows( $q_userfemale );

                            $sql_usernot   = " SELECT * FROM tb_user WHERE sex = 'Not stated - ไม่ระบุ'";
                            $q_usernot = mysqli_query( $conn, $sql_usernot );
                            $num_not = mysqli_num_rows( $q_usernot );

                            $sqlQuery = "SELECT * FROM tb_user WHERE sex = 'Male - ชาย'";
                            $result = mysqli_query($conn, $sqlQuery);
                            $num_male1 = mysqli_num_rows( $result );

                            $data = array();
                            
                                $sex_male[] = $num_male;
                                $sex_female[] = $num_female;
                                $sex_not[] = $num_not;

                            mysqli_close($conn);

                            // echo json_encode($sex_male);
                            // echo json_encode($sex_female);
                            // echo json_encode($sex_not);

                            $dataPoints = array( 
                                array("label"=>"Male - ชาย", "symbol" => "Male - ชาย","y"=>$num_male),
                                array("label"=>"Female - หญิง", "symbol" => "Female - หญิง","y"=>$num_female),
                                array("label"=>"Not stated - ไม่ระบุ", "symbol" => "Not stated - ไม่ระบุ","y"=>$num_not),
                            )
                             
                            ?>

                            
                        <!-- Pie Chart -->
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-1">
                                    <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">ผู้ใช้งาน</h6>
                                        <a href="am_user_page.php" class="btn btn-info btn-smll">รายงาน</a>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body" style="height: 450px;">
                                    <div class="chart-pie pt-1 pb-1">
                                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>  

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

    <!-- Modal -->
    <div class="modal fade" id="calendarmodal" tabindex="-1" role="dialog" > <!--กำหนด id ให้กับ modal-->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarmodal-title">Modal title</h5> <!--กำหนด id ให้ส่วนหัวข้อ-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  id="calendarmodal-detail"> ก<!--ำหนด id ให้ส่วนรายละเอียด-->
                Modal detail
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

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
    
    <!-- DataTable -->
    <?php include '../include/datatable.php'; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                                    
    <!-- กราฟ -->
    <script>
        window.onload = function() {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
             data: [{
                type: "doughnut",
                indexLabel: "{symbol} - {y}",
                yValueFormatString: "#,##\"\"",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        }
    </script>

    <!-- ปฏิทิน -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">
            var calendar; // สร้างตัวแปรไว้ด้านนอก เพื่อให้สามารถอ้างอิงแบบ global ได้
            $(function(){
                // กำหนด element ที่จะแสดงปฏิทิน
                var calendarEl = $("#calendar")[0];
        
                // กำหนดการตั้งค่า
                calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'interaction','dayGrid', 'timeGrid', 'list' ], // plugin ที่เราจะใช้งาน
                    defaultView: 'dayGridMonth', // ค้าเริ่มร้นเมื่อโหลดแสดงปฏิทิน
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },  
                    events: { // เรียกใช้งาน event จาก json ไฟล์ ที่สร้างด้วย php
                        url: 'am_appoint.php?gData=1',
                        error: function() {
        
                        }
                    },              
                    eventLimit: true, // allow "more" link when too many events
                    locale: 'th',    // กำหนดให้แสดงภาษาไทย
                    firstDay: 0, // กำหนดวันแรกในปฏิทินเป็นวันอาทิตย์ 0 เป็นวันจันทร์ 1
                    showNonCurrentDates: false, // แสดงที่ของเดือนอื่นหรือไม่
                    eventTimeFormat: { // รูปแบบการแสดงของเวลา เช่น '14:30' 
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false
                    }
                });
                
                // แสดงปฏิทิน 
                calendar.render();  
                
            });
        </script> 
        <script type="text/javascript">
        function viewdetail(id){
            // ก่อนที่ modal จะแสดง
                $('#calendarmodal').on('show.bs.modal', function (e) {
                    var event = calendar.getEventById(id) // ดึงข้อมูล ผ่าน api
                $("#calendarmodal-title").html(event.title);
                $("#calendarmodal-detail").html(event.extendedProps.detail);// ข้อมูลเพิ่มเติมจะเรียกผ่าน extendedProps
                });              
                $("#calendarmodal").modal();// แสดง modal
        }
        </script>

</body>
<?php } 
?>
</html>