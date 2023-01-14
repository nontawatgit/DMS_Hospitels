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

        //HN_up
        $hn_id = "HN".str_pad($_SESSION["userid"],8, "0", STR_PAD_LEFT);
        $sql_hn = ("UPDATE tb_user SET hn_id='$hn_id' 
                WHERE userid=$userid");	
        $q_hn = mysqli_query($conn,$sql_hn);

        //userid_wh_up
        $sql_wh_up = ("UPDATE tb_wh SET userid_wh='$userid' 
                WHERE idcard=$idcard");	
        $q_us = mysqli_query($conn,$sql_wh_up);

        //header ("refresh:1; url=us_page.php");
        //header("Location:us_page.php");
        //echo $userid;
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


    <title>แบบรายงาน</title>
    
    <link rel="icon" type="image/png" href="img/dns-icon.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <br /><img class="col-lg-12" src="img/undraw_profile.svg " width="200" height="200">
                            
                            <div class="text-center">
                                <font size="16" style="color:black"> <?php echo $row["fullname"]; ?></font><br>
                                <b><font size="5" style="color:black"> <?php echo "HN".str_pad($_SESSION["userid"],8, "0", STR_PAD_LEFT); ?></font><br></b>
                                
                                <font size="4" style="color:black"> <?php 
                                                                        $today = date("Y-m-d");
                                                                        $diff = date_diff(date_create($row["birthday"]), date_create($today));
                                                                        echo "<b>อายุ </b>".$diff->format('%y')." ปี ".$diff->format('%m')." เดือน"." | ";
                                                                    ?></font>
                                <font size="4" style="color:black"> <?php echo "<b> เพศ </b>".$row["sex"]." | "; ?></font>
                                <font size="4" style="color:black"> <?php echo "<b> น้ำหนัก/ส่วนสูง </b>".$row["weight"]." กก. ".$row["height"]." ซม. "." | "; ?></font>
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
                                <font size="4" style="color:black"> <?php echo $row["province"]." | "; ?></font>
                                <font size="4" style="color:black"> <?php echo "<b>สิทธิ </b>".$row["hi"]; ?></font><br>                                       
                                        
                                    
                                        <button type="button" class="addAttr btn btn-warning btn-smll mt-3" data-toggle="modal" data-target="#edit_gi" data-euserid="<?=$row["userid"];?>" data-eidcard="<?=$row["idcard"];?>" data-efname="<?=$row["fname"];?>" data-elname="<?=$row["lname"];?>" data-ebirthday="<?=$row["birthday"];?>" data-esex="<?=$row["sex"];?>" data-eprovince="<?=$row["province"];?>" data-ehi="<?=$row["hi"];?>" data-eweight="<?=$row["weight"];?>" data-eheight="<?=$row["height"];?>"><i class="bi bi-pencil-square mr-2"></i>แก้ไข</button>

                            </div><br />



                                    <?php 

                                    require_once 'connect_db.php';

                                    $sqlQuery = "SELECT * FROM tb_gen WHERE userid_gen='" . $_SESSION['userid'] . "'";
                                    $result = mysqli_query($conn, $sqlQuery);

                                    $sqlQuery_wh = "SELECT * FROM tb_wh WHERE userid_wh='" . $_SESSION['userid'] . "'";
                                    $result_wh = mysqli_query($conn, $sqlQuery_wh);

                                    $data = array();
                                    foreach ($result as $row) {
                                        $date_time_gen1[] = $row['date_time_gen'];
                                        $body_temp1[] = $row['body_temp'];
                                        $heart_rate1[] = $row['heart_rate'];
                                        $bp_top1[] = $row['bp_top'];
                                        $bp_low1[] = $row['bp_low'];
                                        $spo21[] = $row['spo2'];
                                    }
                                    $data_wh = array();
                                    foreach ($result_wh as $row1) {
                                        $weight_wh[] = $row1['weight_wh'];
                                        $height_wh[] = $row1['height_wh'];
                                        $BMI_wh[] = $row1['BMI_wh'];
                                        $date_time_wh[] = $row1['date_time_wh'];
                                    }

                                    mysqli_close($conn);

                                    //echo json_encode($data_wh);

                                    ?>

                                        <br><div class="container">
                                                <div class="row justify-content-md-center">
                                                    <div class="col col-lg-10 col-lg-5">
                                                        <div class="card shadow mb-4">
                                                            <!-- Card Header - Dropdown -->
                                                            <div
                                                                class="card-header py-12 d-flex flex-row align-items-center justify-content-between">
                                                                <h6 class="m-0 font-weight-bold text-primary">น้ำหนัก ส่วนสูง และ BMI</h6>
                                                                <!-- <a href="gen_add.php" class="btn btn-success btn-smll">เพิ่มข้อมูล</a> -->
                                                                <a href="wh_page.php" class="btn btn-info btn-smll">รายงาน</a>
                                                            </div>
                                                            <!-- Card Body -->
                                                            <div class="card-body">
                                                                <div class="chart-container">
                                                                    <canvas id="graphCanvas_WH"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div><br>


                                        <br><div class="container">
                                                <div class="row justify-content-md-center">
                                                    <div class="col col-lg-10 col-lg-5">
                                                        <div class="card shadow mb-4">
                                                            <!-- Card Header - Dropdown -->
                                                            <div
                                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                                <h6 class="m-0 font-weight-bold text-primary">อุณหภูมิ และ อัตราการเต้นของหัวใจ</h6>
                                                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_gen">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>  
                                                            </div>
                                                            <!-- Card Body -->
                                                            <div class="card-body">
                                                                <div class="chart-container">
                                                                    <canvas id="graphCanvas"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div><br>

                                            <br><div class="container">
                                                <div class="row justify-content-md-center">
                                                    <div class="col col-lg-10 col-lg-5">
                                                        <div class="card shadow mb-4">
                                                            <!-- Card Header - Dropdown -->
                                                            <div
                                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                                <h6 class="m-0 font-weight-bold text-primary">ความดันโลหิต</h6>
                                                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_gen">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>  
                                                            </div>
                                                            <!-- Card Body -->
                                                            <div class="card-body">
                                                                <div class="chart-container">
                                                                    <canvas id="graphCanvasBP"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div><br>

                                            <br><div class="container">
                                                <div class="row justify-content-md-center">
                                                    <div class="col col-lg-10 col-lg-5">
                                                        <div class="card shadow mb-4">
                                                            <!-- Card Header - Dropdown -->
                                                            <div
                                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                                <h6 class="m-0 font-weight-bold text-primary">ความอิ่มตัวของออกซิเจนในเลือด</h6>
                                                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_gen">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>  
                                                            </div>
                                                            <!-- Card Body -->
                                                            <div class="card-body">
                                                                <div class="chart-container">
                                                                    <canvas id="graphCanvasspo2"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div><br><br><br><br>

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
                    <form method="post" action="us_gen_save.php">
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

        <!-- Edit Gi Modal -->
        <div class="modal fade show" id="edit_gi" tabindex="-1" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form method="post" action="gi_update.php">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color:black">แก้ไขข้อมูลของคุณ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <input type="hidden" name="userid" id="euserid" required autocomplete="off">
                            <input type="hidden" name="idcard" id="eidcard" required autocomplete="off">

                        <div class="modal-body">

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="carname" class="col-sm-12 form-control-label" style="color:black" >First name - ชื่อ</label></br>
                                        <input type="text" required name="fname" id="efname" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="carname" class="col-sm-12 form-control-label" style="color:black" >Last name - นามสกุล</label></br>
                                        <input type="text" required name="lname" id="elname" class="form-control form-control-user" autocomplete="off" placeholder="โปรดกรอก">
                                    </div>
                                </div>

                                <div class="form-group row">			
                                    <div class="col-sm-6">
                                        <label for="carname" class="col-sm-12 form-control-label" style="color:black" >Birthday - วันเกิด</label></br>
                                        <input type="date" required name="birthday" id="ebirthday" class="form-control form-control-user">
                                    </div>
                                    <div class="col-sm-6">
                                    <label for="sex" class="col-sm-8 form-control-label" style="color:black" >Sex - เพศ</label></br>
                                    <select id="esex" name="sex" class="form-control form-control-user">
                                        <option value="Not stated - ไม่ระบุ">Not stated - ไม่ระบุ</option>
                                        <option value="Male - ชาย">Male - ชาย</option>
                                        <option value="Female - หญิง">Female - หญิง</option>
                                    </select>
                            </div>
                                </div>

                                <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="carname" class="col-sm-12 form-control-label" style="color:black" >Province - จังหวัด</label></br>
									<input type="text" name="province" list="province" id="eprovince" class="form-control form-control-user" placeholder="โปรดกรอก" autocomplete="off">
                                <datalist id="province">
                                        <option value='Bangkok - กรุงเทพมหานคร'>
                                        <option value='Kamphaeng Phet Province - จังหวัดกำแพงเพชร'>
                                        <option value='Chai Nat Province - จังหวัดชัยนาท'>
                                        <option value='Nakhon Nayok Province - จังหวัดนครนายก'>
                                        <option value='Nakhon Pathom Province - จังหวัดนครปฐม'>
                                        <option value='Nakhon Sawan Province - จังหวัดนครสวรรค์'>
                                        <option value='Nonthaburi Province - จังหวัดนนทบุรี'>
                                        <option value='Pathum Thani Province - จังหวัดปทุมธานี'>
                                        <option value='Phra Nakhon Si Ayutthaya Province - จังหวัดพระนครศรีอยุธยา'>
                                        <option value='Phichit Province - จังหวัดพิจิตร'>
                                        <option value='Phitsanulok Province - จังหวัดพิษณุโลก'>
                                        <option value='Phetchabun Province - จังหวัดเพชรบูรณ์'>
                                        <option value='Lopburi Province - จังหวัดลพบุรี'>
                                        <option value='Samut Prakan Province - จังหวัดสมุทรปราการ'>
                                        <option value='Samut Songkhram Province - จังหวัดสมุทรสงคราม'>
                                        <option value='Samut Sakhon Province - จังหวัดสมุทรสาคร'>
                                        <option value='Sing Buri Province - จังหวัดสิงห์บุรี'>
                                        <option value='Sukhothai Province - จังหวัดสุโขทัย'>
                                        <option value='Suphan Buri Province - จังหวัดสุพรรณบุรี'>
                                        <option value='Saraburi Province - จังหวัดสระบุรี'>
                                        <option value='Ang Thong Province - จังหวัดอ่างทอง'>
                                        <option value='Uthai Thani Province - จังหวัดอุทัยธานี'>
                                        <option value='Chanthaburi Province - จังหวัดจันทบุรี'>
                                        <option value='Chachoengsao Province - จังหวัดฉะเชิงเทรา'>
                                        <option value='Chonburi Province - จังหวัดชลบุรี'>
                                        <option value='Trat Province - จังหวัดตราด'>
                                        <option value='Prachinburi Province - จังหวัดปราจีนบุรี'>
                                        <option value='Rayong Province - จังหวัดระยอง'>
                                        <option value='Sa Kaeo Province - จังหวัดสระแก้ว'>
                                        <option value='Kanchanaburi Province - จังหวัดกาญจนบุรี'>
                                        <option value='Tak Province - จังหวัดตาก'>
                                        <option value='Prachuap Khiri Khan Province - จังหวัดประจวบคีรีขันธ์'>
                                        <option value='Phetchaburi Province - จังหวัดเพชรบุรี'>
                                        <option value='Ratchaburi Province - จังหวัดราชบุรี'>
                                        <option value='Krabi Province - จังหวัดกระบี่'>
                                        <option value='Chumphon Province - จังหวัดชุมพร'>
                                        <option value='Trang Province - จังหวัดตรัง'>
                                        <option value='Nakhon Si Thammarat Province - จังหวัดนครศรีธรรมราช'>
                                        <option value='Narathiwat Province - จังหวัดนราธิวาส'>
                                        <option value='Pattani Province - จังหวัดปัตตานี'>
                                        <option value='Phang Nga Province - จังหวัดพังงา'>
                                        <option value='Phatthalung Province - จังหวัดพัทลุง'>
                                        <option value='Phuket Province - จังหวัดภูเก็ต'>
                                        <option value='Ranong Province - จังหวัดระนอง'>
                                        <option value='Satun Province - จังหวัดสตูล'>
                                        <option value='Songkhla Province - จังหวัดสงขลา'>
                                        <option value='Surat Thani Province - จังหวัดสุราษฎร์ธานี'>
                                        <option value='Yala Province - จังหวัดยะลา'>
                                        <option value='Chiang Mai Province - จังหวัดเชียงใหม่'>
                                        <option value='Chiang Rai Province - จังหวัดเชียงราย'>
                                        <option value='Lampang Province - จังหวัดลำปาง'>
                                        <option value='Lamphun Province - จังหวัดลำพูน'>
                                        <option value='Mae Hong Son Province - จังหวัดแม่ฮ่องสอน'>
                                        <option value='Nan Province - จังหวัดน่าน'>
                                        <option value='Phayao Province - จังหวัดพะเยา'>
                                        <option value='Phrae Province - จังหวัดแพร่'>
                                        <option value='Uttaradit Province - จังหวัดอุตรดิตถ์'>
                                        <option value='Kalasin Province - จังหวัดกาฬสินธุ์'>
                                        <option value='Khon Kaen Province - จังหวัดขอนแก่น'>
                                        <option value='Chaiyaphum Province - จังหวัดชัยภูมิ'>
                                        <option value='Nakhon Phanom Province - จังหวัดนครพนม'>
                                        <option value='Nakhon Ratchasima Province - จังหวัดนครราชสีมา'>
                                        <option value='Bueng Kan Province - จังหวัดบึงกาฬ'>
                                        <option value='Buriram Province - จังหวัดบุรีรัมย์'>
                                        <option value='Maha Sarakham Province - จังหวัดมหาสารคาม'>
                                        <option value='Mukdahan Province - จังหวัดมุกดาหาร'>
                                        <option value='Yasothon Province - จังหวัดยโสธร'>
                                        <option value='Roi Et Province - จังหวัดร้อยเอ็ด'>
                                        <option value='Loei Province - จังหวัดเลย'>
                                        <option value='Sakon Nakhon Province - จังหวัดสกลนคร'>
                                        <option value='Surin Province - จังหวัดสุรินทร์'>
                                        <option value='Sisaket Province - จังหวัดศรีสะเกษ'>
                                        <option value='Nong Khai Province - จังหวัดหนองคาย'>
                                        <option value='Nong Bua Lamphu Province - จังหวัดหนองบัวลำภู'>
                                        <option value='Udon Thani Province - จังหวัดอุดรธานี'>
                                        <option value='Ubon Ratchathani Province - จังหวัดอุบลราชธานี'>
                                        <option value='Amnat Charoen Province - จังหวัดอำนาจเจริญ'>
                                </datalist>
								</div>
							</div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="carname" class="col-sm-12 form-control-label" style="color:black" >Health Insurance - สิทธิประกันสุขภาพ</label></br>
									<input type="text" name="hi" list="hi" id="ehi" class="form-control form-control-user" placeholder="โปรดกรอก" autocomplete="off">
                                <datalist id="hi">
                                    <option value='Not stated - ไม่ระบุ'> 
                                        <option value='WEL - สิทธิประกันสุขภาพถ้วนหน้า ประเภทมีสิทธิย่อย(WEL)'>
                                        <option value='UCS - สิทธิประกันสุขภาพถ้วนหน้า(UCS)'>
                                        <option value='SSS - สิทธิประกันสังคม'>
                                        <option value='OFC - สิทธิข้าราชการ/สิทธิรัฐวิสาหกิจ'>
                                        <option value='LGO - สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='SOF - สิทธิประกันสังคม/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='OFL - สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='SLG - สิทธิประกันสังคม/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='PVT - สิทธิครูเอกชน'>
                                        <option value='VSS - สิทธิประกันสังคม/สิทธิทหารผ่านศึก'>
                                        <option value='VOF - สิทธิทหารผ่านศึก/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='NRD - สถานะคนต่างด้าว'>
                                        <option value='STP - บุคคลผู้มีปัญหาสถานะและสิทธิ'>
                                        <option value='POF - สิทธิครูเอกชน/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='SOL - สิทธิประกันสังคม/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='FRG - สถานะคนไทยในต่างประเทศ'>
                                        <option value='SSI - สิทธิประกันสังคมกรณีทุพพลภาพ'>
                                        <option value='PSS - สิทธิประกันสังคม/สิทธิครูเอกชน'>
                                        <option value='005 - บุคคลที่ไม่อยู่ตามทะเบียนบ้าน(รอยืนยันสิทธิ)'>
                                        <option value='DIS - สิทธิประกันสุขภาพถ้วนหน้า (ผู้ประกันตนคนพิการ)'>
                                        <option value='VSO - สิทธิประกันสังคม/สิทธิทหารผ่านศึก/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='NRH - สิทธิบุคคลต่างด้าว (ซื้อประกันสุขภาพ)'>
                                        <option value='VLG - สิทธิทหารผ่านศึก/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='PLG - สิทธิครูเอกชน/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='DOF - สิทธิประกันสุขภาพถ้วนหน้า (ผู้ประกันตนคนพิการ)/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='SIF - สิทธิประกันสังคมกรณีทุพพลภาพ/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='PSL - สิทธิประกันสังคม/สิทธิครูเอกชน/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='PSO - สิทธิประกันสังคม/สิทธิครูเอกชน/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ'>
                                        <option value='VOL - สิทธิทหารผ่านศึก/สิทธิข้าราชการ/สิทธิรัฐวิสาหกิจ/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='VSL - สิทธิประกันสังคม/สิทธิทหารผ่านศึก/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='POL - สิทธิครูเอกชน/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='L08 - สิทธิประกันสังคม/สิทธิครูเอกชน/สิทธิข้าราชการ/สิทธิหน่วยงานรัฐ/สิทธิสวัสดิการพนักงานส่วนท้องถิ่น'>
                                        <option value='VPT - สิทธิครูเอกชน/สิทธิทหารผ่านศึก'>
                                        <option value='VSI - สิทธิประกันสังคมแบบทุพพลภาพ/สิทธิทหารผ่านศึก'>
                                </datalist>
								</div>
							</div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="carname" class="col-sm-12 form-control-label" style="color:black" >Weight - น้ำหนัก</label></br>
									<input type="number" required name="weight" id="eweight" class="form-control form-control-user" placeholder="โปรดกรอก" autocomplete="off" min="1" max="300">
								</div>
                                <div class="col-sm-6">
                                    <label for="carname" class="col-sm-12 form-control-label" style="color:black" >Height - ส่วนสูง</label></br>
									<input type="number" required name="height" id="eheight" class="form-control form-control-user" placeholder="โปรดกรอก" autocomplete="off" min="1" max="300">
								</div>
							</div><br/>

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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
            $('.addAttr').click(function() {
            var euserid = $(this).data('euserid');
            var eidcard = $(this).data('eidcard');     
            var efname = $(this).data('efname');  
            var elname = $(this).data('elname');     
            var ebirthday = $(this).data('ebirthday');     
            var esex = $(this).data('esex');     
            var eprovince = $(this).data('eprovince');     
            var ehi = $(this).data('ehi');     
            var eweight = $(this).data('eweight');     
            var eheight = $(this).data('eheight');
                 

            $('#euserid').val(euserid); 
            $('#eidcard').val(eidcard);  
            $('#efname').val(efname);  
            $('#elname').val(elname);  
            $('#ebirthday').val(ebirthday);  
            $('#esex').val(esex);  
            $('#eprovince').val(eprovince);  
            $('#ehi').val(ehi);  
            $('#eweight').val(eweight);  
            $('#eheight').val(eheight);  
            } );
    </script>

                                    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
                                    <script>
                                        $(document).ready(function() {
                                            showGraph();
                                        });

                                        function showGraph(){
                                            {
                                                $.post("", function(data) {
                                                    console.log(data);
                                                    let name = [];
                                                    let score = [];

                                                    for (let i in data) {

                                                    }

                                                    let chartdata = {
                                                        labels: <?php echo json_encode($date_time_gen1);?>,
                                                        datasets: [{
                                                                label: 'อุณหภูมิ',
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
                                                                data: <?php echo json_encode($body_temp1);?>
                                                        },{
                                                                label: 'อัตราการเต้นของหัวใจ',
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
                                                                data: <?php echo json_encode($heart_rate1);?>
                                                        }],
                                                    };

                                                    let graphTarget = $('#graphCanvas');
                                                    let barGraph = new Chart(graphTarget, {
                                                        type: 'line',
                                                        data: chartdata
                                                    })
                                                    let chartdataBP = {
                                                        labels: <?php echo json_encode($date_time_gen1);?>,
                                                        datasets: [{
                                                                label: 'ความดันตัวบน',
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
                                                                data: <?php echo json_encode($bp_top1);?>
                                                        },{
                                                                label: 'ความดันตัวล่าง',
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
                                                                data: <?php echo json_encode($bp_low1);?>
                                                        }],
                                                    };

                                                    let graphTargetBP = $('#graphCanvasBP');
                                                    let barGraphBP = new Chart(graphTargetBP, {
                                                        type: 'line',
                                                        data: chartdataBP
                                                    })
                                                    let chartdataspo2 = {
                                                        labels: <?php echo json_encode($date_time_gen1);?>,
                                                        datasets: [{
                                                                label: 'ออกซิเจน',
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
                                                                data: <?php echo json_encode($spo21);?>
                                                        }],
                                                    };

                                                    let graphTargetspo2 = $('#graphCanvasspo2');
                                                    let barGraphspo2 = new Chart(graphTargetspo2, {
                                                        type: 'line',
                                                        data: chartdataspo2
                                                    })
                                                })
                                            }
                                        }
                                        </script>

                                        <script>
                                        $(document).ready(function() {
                                            showGraph_WH();
                                        });

                                        function showGraph_WH(){
                                            {
                                                $.post("", function(data) {
                                                    console.log(data);
                                                    let name = [];
                                                    let score = [];

                                                    for (let i in data) {

                                                    }            

                                                    let chartdataWH = {
                                                        labels: <?php echo json_encode($date_time_wh);?>,
                                                        datasets: [{
                                                                label: 'ส่วนสูง',
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
                                                                data: <?php echo json_encode($height_wh);?>
                                                        },{
                                                                label: 'น้ำหนัก',
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
                                                                data: <?php echo json_encode($weight_wh);?>
                                                        },{
                                                                label: 'BMI',
                                                                lineTension: 0.3,
                                                                backgroundColor: "rgba(11, 255, 0, 0.05)",
                                                                borderColor: "rgba(11, 255, 0, 1)",
                                                                pointRadius: 3,
                                                                pointBackgroundColor: "rgba(11, 255, 0, 1)",
                                                                pointBorderColor: "rgba(11, 255, 0, 1)",
                                                                pointHoverRadius: 3,
                                                                pointHoverBackgroundColor: "rgba(11, 255, 0, 1)",
                                                                pointHoverBorderColor: "rgba(11, 255, 0, 1)",
                                                                pointHitRadius: 10,
                                                                pointBorderWidth: 2,
                                                                data: <?php echo json_encode($BMI_wh);?>
                                                        }],
                                                    };

                                                    let graphTargetWH = $('#graphCanvas_WH');
                                                    let barGraphWH = new Chart(graphTargetWH, {
                                                        type: 'line',
                                                        data: chartdataWH
                                                    })

                                                })
                                            }
                                        }
                                    </script>
    <script>
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
