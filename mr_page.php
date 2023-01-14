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
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>อารมณ์ & พักผ่อน</title>
    
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
                    <div class="text-center mb-4 mt-4">
                        <font size="8" style="color:black">อารมณ์ & พักผ่อน</font><br>
                    </div>

                    <div class="col-lg-12">
                    
                    <!-- Table -->
                    <div class="card shadow mb-4 mt-4 ">
                        <div class="card-header py-1">
                            <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">รายงานอารมณ์ & พักผ่อน</h6>
                                <!-- <a href="mr_add.php" class="btn btn-success btn-smll">เพิ่มข้อมูล<i class="bi bi-plus"></i></a>  -->
                                <button type="button" class="btn btn-success btn-smll" data-toggle="modal" data-target="#add_mr">เพิ่มข้อมูล<i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table width="100%" class="table thead-dark table-hover table-bordered text-center table-striped" id="myTable">
                                    <thead class="table-dark">
                                        <th>วันที่ส่งรายงาน</th>
                                        <th>ระดับอารมณ์</th>
                                        <th>ระดับความเครียด</th>
                                        <th>พักผ่อน</th>
                                        <th>บอกสิ่งที่เกิดขึ้นในใจคุณ*</th>
                                        <th>หมายเหตุ*</th>
                                        <th width="100px">คำสั่ง</th>
                                    </thead>	
                                    <tbody>
                                        <?php
                                        include "connect_db.php";
                                        $sql = "SELECT * FROM tb_mr WHERE userid_mr='" . $_SESSION['userid'] . "'";
                                        
                                        $q = mysqli_query($conn,$sql);
                                        while($row = mysqli_fetch_array($q)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row["date_time_mr"]; ?></td>
                                            <td><?php echo $row["mood_level"]; ?></td>
                                            <td><?php echo $row["stress_level"]." %"; ?></td>
                                            <td><?php echo $row["rest"]." ชม."; ?></td>
                                            <td><?php if($row['note_mood']==""){echo "-"; }else{echo $row['note_mood'];}; ?></td>
                                            <td><?php if($row['note_mr']==""){echo "-"; }else{echo $row['note_mr'];}; ?></td></td>
                                            <td>
                                                <button type="button" class="addAttr btn btn-warning btn-smll" data-toggle="modal" data-target="#edit_mr" data-mrid="<?=$row["mr_id"];?>" data-moodlevel="<?=$row["mood_level"];?>" data-stresslevel="<?=$row["stress_level"];?>" data-restt="<?=$row["rest"];?>" data-notemood="<?=$row["note_mood"];?>"><i class="bi bi-pencil-square"></i></button> |
                                                <a href="mr_delete.php?proid=<?=$row["mr_id"];?>" class="btn btn-danger btn-del"><i class="bi bi-trash-fill"></i></a> 
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
    
    <!-- Add MR Modal -->
    <div class="modal fade show" id="add_mr" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="mr_save.php">
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
                                    <label for="mood_level" class="col-sm-12 form-control-label" style="color:black" >Emotional Level - ระดับอารมณ์</label></br>
                                    <select id="mood_level" name="mood_level" class="form-control form-control-user">
                                        <option value="Very Happy - มีความสุขมาก">Very Happy - มีความสุขมาก</option>
                                        <option value="Happy - มีความสุข">Happy - มีความสุข</option>
                                        <option value="Normal - ปกติ">Normal - ปกติ</option>
                                        <option value="Bad - แย่">Bad - แย่</option>
                                        <option value="Terrible - แย่มาก">Terrible - แย่มาก</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="stress_level" class="col-sm-12 form-control-label" style="color:black" >ระดับความเครียด (0%-100%)</label></br>
									<input type="number" required name="stress_level" id="stress_level" class="form-control form-control-user" min="0" max="100" step="10" value="0" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="rest" class="col-sm-12 form-control-label" style="color:black" >เวลานอน (ช.ม.)</label></br>
									<input type="number" required name="rest" id="rest" class="form-control form-control-user" min="1" max="24" value="1" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="note_mood" class="col-sm-12 form-control-label" style="color:black" >Tell what is going on in your mind - บอกสิ่งที่เกิดขึ้นในใจคุณ</label></br>
									<textarea  type="text" name="note_mood" id="note_mood" class="form-control" maxlength="40" autocomplete="off" rows="3" placeholder="โปรดกรอก"></textarea>
								</div>
                            </div><br>
                            <div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">บันทึกข้อมูล Save Data</button>
                                <button type="button" class="btn btn-danger btn-user btn-block mt-3" data-dismiss="modal">ยกเลิก</button>
							</div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit MR Modal -->
    <div class="modal fade show" id="edit_mr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="mr_update.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:black">แก้ไขข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <input type="hidden" name="mr_id" id="mrid" required autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="mood_level" class="col-sm-12 form-control-label" style="color:black" >Emotional Level - ระดับอารมณ์</label></br>
                                <select id="moodlevel" name="mood_level" class="form-control form-control-user">
                                        <option value="Very Happy - มีความสุขมาก">Very Happy - มีความสุขมาก</option>
                                        <option value="Happy - มีความสุข">Happy - มีความสุข</option>
                                        <option value="Normal - ปกติ">Normal - ปกติ</option>
                                        <option value="Bad - แย่">Bad - แย่</option>
                                        <option value="Terrible - แย่มาก">Terrible - แย่มาก</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="stress_level" class="col-sm-12 form-control-label" style="color:black" >ระดับความเครียด (0%-100%)</label></br>
									<input type="number" required name="stress_level" id="stresslevel" class="form-control form-control-user" min="0" max="100" step="10" value="0" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                                <div class="col-sm-6">
                                    <label for="rest" class="col-sm-12 form-control-label" style="color:black" >เวลานอน (ช.ม.)</label></br>
									<input type="number" required name="rest" id="restt" class="form-control form-control-user" min="1" max="24" value="1" autocomplete="off" placeholder="โปรดกรอก">
								</div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="note_mood" class="col-sm-12 form-control-label" style="color:black" >Tell what is going on in your mind - บอกสิ่งที่เกิดขึ้นในใจคุณ</label></br>
									<textarea  type="text" name="note_mood" id="notemood" class="form-control" maxlength="40" autocomplete="off" rows="3" placeholder="โปรดกรอก"></textarea>
								</div>
                            </div><br>
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
            var mrid = $(this).data('mrid');    
            var moodlevel = $(this).data('moodlevel');    
            var stresslevel = $(this).data('stresslevel');    
            var restt = $(this).data('restt');    
            var notemood = $(this).data('notemood');    
  

            $('#mrid').val(mrid);  
            $('#moodlevel').val(moodlevel);  
            $('#stresslevel').val(stresslevel);  
            $('#restt').val(restt);  
            $('#notemood').val(notemood);  
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
