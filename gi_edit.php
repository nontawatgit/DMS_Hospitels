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
        $userid = $_GET['proid'];
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

    <title>แก้ไขข้อมูลของคุณ</title>
    
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="us_page.php">
                <div class="sidebar-brand-icon rotate-n-">
                    <!--<i class="bi bi-hospital-fill"></i>-->
                </div>
                <div class="sidebar-brand-text mx-3" ><font size="4" >DMS Hospital</font></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="us_page.php">
                <i class="bi bi-clipboard-data-fill mr-2 text-gray-400"></i>
                    <span>แบบรายงาน</span></a>
            </li>	

            <li class="nav-item ">
                <a class="nav-link" href="gen_page.php">
                    <i class="bi bi-file-earmark-medical-fill mr-2 text-gray-400"></i>
                    <span>รายงานที่ผ่านมา</span></a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="blood_page.php">
                    <i class="bi bi-droplet-fill mr-2 text-gray-400"></i>
                    <span>น้ำตาล & ไขมันในเลือด</span></a>
            </li>

            <li class="nav-item ">
                <a class="nav-link " href="mr_page.php">
                    <i class="bi bi-emoji-smile-fill mr-2 text-gray-400"></i>
                    <span>อารมณ์ & พักผ่อน</span></a>
            </li>
			
            <li class="nav-item">
                <a class="nav-link" href="appoint_page.php" >
                    <i class="bi bi-calendar-fill mr-2 text-gray-400"></i>
                    <span>นัดหมาย</span>
                </a>
            </li>
            
			<li class="nav-item">
                <a class="nav-link" href="Logout.php" data-toggle="modal" data-target="#logoutModal">
				 <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    <span>ออกจากระบบ</span>
				</a>
            </li>
        </ul>
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row['fullname']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="us_page.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>


                                <a class="dropdown-item" href="gi_edit.php?proid=<?=$row["userid"];?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

            <!-- Content Row -->
                <div class="row">
                    <div class="col-lg-2 d-none d-lg-block"></div>
                    <div class="col-lg-8">
                        <div class="p-10">
                            <div class="text-center mt-4 mb-2">
                                <font size="16" style="color:black"> แก้ไขข้อมูลของคุณ </font>
                            </div><br />
							
							<div class="col-lg-12"> 
							<form action="gi_update.php" method="post" class="user" name="updateuser" id="updateuser" role="form"> 
                           
                            <input type="hidden" required name="userid" id="userid" value="<?=$row{'userid'};?>" autocomplete="off" placeholder="โปรดกรอก">
							<input type="hidden" required name="idcard" id="idcard" value="<?=$row{'idcard'};?>" autocomplete="off" placeholder="โปรดกรอก">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="carname" class="col-sm-6 form-control-label" style="color:black" >First name - ชื่อ</label></br>
									<input type="text" required name="fname" id="fname" class="form-control form-control-user" value="<?=$row{'fname'};?>" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="carname" class="col-sm-8 form-control-label" style="color:black" >Last name - นามสกุล</label></br>
									<input type="text" required name="lname" id="lname" class="form-control form-control-user" value="<?=$row{'lname'};?>" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>
                            
                            <div class="form-group row">
								
								<div class="col-sm-6">
                                    <label for="carname" class="col-sm-8 form-control-label" style="color:black" >Birthday - วันเกิด</label></br>
									<input type="date" required name="birthday" id="birthday" class="form-control form-control-user" value="<?=$row{'birthday'};?>">
								</div>

                            <div class="col-sm-6">
                            <label for="carname" class="col-sm-8 form-control-label" style="color:black" >Sex - เพศ</label></br>
                            <input type="text" name="sex" list="sex" class="form-control form-control-user" value="<?=$row{'sex'};?>" placeholder="โปรดกรอก" autocomplete="off">
                                <datalist id="sex">
                                    <option value="Male - ชาย">
                                    <option value="Female - หญิง">
                                    <option value="Not stated - ไม่ระบุ">
                                </datalist>
                            </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="carname" class="col-sm-6 form-control-label" style="color:black" >Province - จังหวัด</label></br>
									<input type="text" name="province" list="province" class="form-control form-control-user" value="<?=$row{'province'};?>" placeholder="โปรดกรอก" autocomplete="off">
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
                                    <label for="carname" class="col-sm-6 form-control-label" style="color:black" >Health Insurance - สิทธิประกันสุขภาพ</label></br>
									<input type="text" name="hi" list="hi" class="form-control form-control-user" value="<?=$row{'hi'};?>" placeholder="โปรดกรอก" autocomplete="off">
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
                                    <label for="carname" class="col-sm-6 form-control-label" style="color:black" >Weight - น้ำหนัก</label></br>
									<input type="number" required name="weight" id="weight" class="form-control form-control-user" value="<?=$row{'weight'};?>" placeholder="โปรดกรอก" autocomplete="off" min="1" max="300">
								</div>
                                <div class="col-sm-6">
                                    <label for="carname" class="col-sm-6 form-control-label" style="color:black" >Height - ส่วนสูง</label></br>
									<input type="number" required name="height" id="height" class="form-control form-control-user" value="<?=$row{'height'};?>" placeholder="โปรดกรอก" autocomplete="off" min="1" max="300">
								</div>
							</div><br/>
                            
							<div class="text-center">
							<button type="submit" required name="save" class="btn btn-primary btn-user btn-block" >บันทึกข้อมูล Save Data</button>
							</div></br>
							
							<div class="text-center">
                            <a class="submit" href="us_page.php" >กลับ Go Back</a>
							</div>
							
							</form>
							
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


</body>
<?php } ?>
</html>
