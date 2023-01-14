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

    <title>รับเข้า - Verify</title>
    
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
                        <font size="8" style="color:black">รับเข้า / Verify</font><br>
                    </div>

                    <div class="card shadow mb-4 ">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลผู้ใช้</h6>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table width="100%" class="table thead-dark table-hover table-bordered table-striped dt-responsive nowrap" id="myTable">
                                    <thead class="table-dark">
                                        <th width="110">คำสั่ง</th>
                                        <th>สถานะ</th>
                                        <th>HN</th>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>อีเมล</th>
                                        <th>เลขบัตรประชาชน</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>เพศ</th>
                                        <th>ระดับผู้ใช้</th>
                                    </thead>	
                                    <tbody>
                                        <?php
                                        include "../connect_db.php";
                                        $sql = "SELECT * FROM tb_user ORDER BY userid ASC";
                                        $q = mysqli_query($conn,$sql);
                                        while($r = mysqli_fetch_array($q)){
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="am_verify_approve.php?proid=<?=$r["userid"];?>" class="btn btn-success btn-del ml-2"><i class="bi bi-check-lg mr-2"></i>รับเข้า</a> | 
                                                <button type="button" class="addAttr btn btn-warning btn-smll" data-toggle="modal" data-target="#edit_user" data-euserid="<?=$r["userid"];?>" data-efname="<?=$r["fname"];?>" data-elname="<?=$r["lname"];?>" data-eemail="<?=$r["email"];?>" data-eidcard="<?=$r["idcard"];?>" data-etel="<?=$r["tel"];?>" data-ebirthday="<?=$r["birthday"];?>" data-esex="<?=$r["sex"];?>" data-eweight="<?=$r["weight"];?>" data-eheight="<?=$r["height"];?>" data-eprovince="<?=$r["province"];?>" data-ehi="<?=$r["hi"];?>" data-elevle="<?php if ($r["user_leve"] == "a") {
                                                        echo "ผู้ดูแลระบบ";                                          
                                                    } else if ($r["user_leve"] == "u") {
                                                        echo "ผู้ใช้ทั่วไป";
                                                    }; ?>"><i class="bi bi-file-earmark-text mr-2"></i>รายละเอียด</button>
                                            </td>
                                            <td><?php if ($r["verify_status"] == "verify") {
                                                        echo "<font color='#27AE60'> รับเข้า";                                          
                                                    } else if ($r["verify_status"] == "unverified") {
                                                        echo "<font color='#E40000'> ยังไม่ได้รับเข้า";
                                                    }; ?></td>
                                            <td><?php echo "HN".str_pad($r["userid"],8, "0", STR_PAD_LEFT); ?></td>
                                            <td><?php echo $r["fullname"]; ?></td>
                                            <td><?php echo $r["email"]; ?></td>
                                            <td><?php echo $r["idcard"]; ?></td>
                                            <td><?php echo $r["tel"]; ?></td>
                                            <td><?php echo $r["sex"]; ?></td>
                                            <td><?php if ($r["user_leve"] == "a") {
                                                        echo "<font color='#27AE60'> ผู้ดูแลระบบ";                                          
                                                    } else if ($r["user_leve"] == "u") {
                                                        echo "<font color='#F2BF00'> ผู้ใช้ทั่วไป";
                                                    }; ?></td>
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


    <!-- Edit User Modal -->
    <div class="modal fade show" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="am_user_update.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:black">รายละเอียดผู้ใช้</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <input type="hidden" name="user_id" id="euserid" required autocomplete="off">
                        <div class="modal-body">
                        <div class="form-group row">
								<div class="col-sm-6">
                                    <label for="fname" class="col-sm-12 form-control-label" style="color:black" >First name - ชื่อ</label></br>
									<input type="text" readonly required name="fname" id="efname" class="form-control form-control-user" placeholder="First name - ชื่อ" autocomplete="off">
								</div>
                                <div class="col-sm-6">
                                    <label for="lname" class="col-sm-12 form-control-label" style="color:black" >Last name - นามสกุล</label></br>
									<input type="text" readonly required name="lname" id="elname" class="form-control form-control-user" placeholder="Last name - นามสกุล" autocomplete="off">
								</div>
							</div>

                            <div class="form-group row">
								<div class="col-sm-12">
                                    <label for="email" class="col-sm-8 form-control-label" style="color:black" >Email address - อีเมล</label></br>
									<input type="email" readonly required name="email" id="eemail" class="form-control form-control-user"  placeholder="Email address - อีเมล">
								</div>
							</div>

                            <div class="form-group row">
								
								<div class="col-sm-6">
                                    <label for="idcard" class="col-sm-10 form-control-label" style="color:black" >เลขบัตรประชาชน</label></br>
									<input type="int" readonly required name="idcard" id="eidcard" class="form-control form-control-user"  placeholder="Citizen ID - เลขบัตรประชาชน" maxlength="13" autocomplete="off">
								</div>
                                <div class="col-sm-6">
                                    <label for="tel" class="col-sm-12 form-control-label" style="color:black" >เบอร์โทรศัพท์</label></br>
									<input type="text" readonly required name="tel" id="etel" class="form-control form-control-user"  placeholder="Phone Number - เบอร์โทรศัพท์" maxlength="10" autocomplete="off">
								</div>
							</div>

                            <div class="form-group row">
								
								<div class="col-sm-6">
                                    <label for="birthday" class="col-sm-8 form-control-label" style="color:black" >Birthday - วันเกิด</label></br>
									<input type="date" readonly required name="birthday" id="ebirthday" class="form-control form-control-user">
								</div>

                            <div class="col-sm-6">
                                <label for="sex" class="col-sm-8 form-control-label" style="color:black" >Sex - เพศ</label></br>
                            <input type="text" readonly required name="sex" list="sex" id="esex" class="form-control form-control-user" placeholder="Sex - เพศ" autocomplete="off">
                                <datalist id="sex">
                                    <option value="Male - ชาย">
                                    <option value="Female - หญิง">
                                    <option value="Not stated - ไม่ระบุ">
                                </datalist>
                            </div>
                            </div>
                            
                            <div class="form-group row">
								
								<div class="col-sm-3">
                                    <label for="weight" class="col-sm-12 form-control-label" style="color:black" >น้ำหนัก</label></br>
									<input type="number" readonly required name="weight" id="eweight" class="form-control form-control-user" placeholder="Weight - น้ำหนัก" autocomplete="off" min="1" max="300">
								</div>
                                <div class="col-sm-3">
                                    <label for="height" class="col-sm-12 form-control-label" style="color:black" >ส่วนสูง</label></br>
									<input type="number" readonly required name="height" id="eheight" class="form-control form-control-user" placeholder="Height - ส่วนสูง" autocomplete="off" min="1" max="300">
								</div>

                                <div class="col-sm-6">
                                    <label for="user_leve" class="col-sm-12 form-control-label" style="color:black" >ระดับผู้ใช้</label></br>
									<input type="text" readonly required name="user_leve" id="elevle" class="form-control form-control-user"autocomplete="off">

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="province" class="col-sm-8 form-control-label" style="color:black" >Province - จังหวัด</label></br>
									<input type="text" readonly required name="province" list="province" id="eprovince" class="form-control form-control-user" placeholder="Province - จังหวัด" autocomplete="off">
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
                                    <label for="hi" class="col-sm-12 form-control-label" style="color:black" >Health Insurance - สิทธิประกันสุขภาพ</label></br>
									<input type="text" readonly required name="hi" list="hi" id="ehi" class="form-control form-control-user" placeholder="Health Insurance - สิทธิประกันสุขภาพ" autocomplete="off">
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
							</div></br>
                            <div>
                                <button type="button" class="btn btn-danger btn-user btn-block" data-dismiss="modal">ออก</button>
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript"  src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript"  src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable({
                responsive: true,
                order: [[2, 'asc']],
            });

        } );
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- ระบข้อมูล Edit -->
    <script>
            $('.addAttr').click(function() {
            var euserid = $(this).data('euserid');      
            var efname = $(this).data('efname');  
            var elname = $(this).data('elname');     
            var eemail = $(this).data('eemail');     
            var eidcard = $(this).data('eidcard');     
            var etel = $(this).data('etel');     
            var ebirthday = $(this).data('ebirthday');     
            var esex = $(this).data('esex');     
            var eweight = $(this).data('eweight');     
            var eheight = $(this).data('eheight');     
            var eprovince = $(this).data('eprovince');     
            var ehi = $(this).data('ehi');
            var elevle = $(this).data('elevle');     


            $('#euserid').val(euserid);  
            $('#efname').val(efname);  
            $('#elname').val(elname);  
            $('#eemail').val(eemail);  
            $('#eidcard').val(eidcard);  
            $('#etel').val(etel);  
            $('#ebirthday').val(ebirthday);  
            $('#esex').val(esex);  
            $('#eweight').val(eweight);  
            $('#eheight').val(eheight);  
            $('#eprovince').val(eprovince);  
            $('#ehi').val(ehi);  
            $('#elevle').val(elevle);  
            } );
    </script>

    <!-- แจ้งเตือน -->
    <script>
        $('.btn-del').on('click',function(e){
            e.preventDefault();
            const href = $(this).attr('href')

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่ ?',
                text: 'คุณต้องการรับเข้า(Verify) ผู้ใช้นี้ใช่หรือไม่ ?!',
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
                title: 'รับเข้า(Verify) ผู้ใช้สำเร็จ',
                text: 'รับเข้า(Verify) ผู้ใช้เรียบร้อยแล้ว!',
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

