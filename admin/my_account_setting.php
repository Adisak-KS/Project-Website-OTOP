<?php
require_once ("../db/connect.php");
$titlePage = "บัญชีของฉัน";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <?php //require_once("includes/preloader.php");
        ?>
        <!-- Navbar -->
        <?php require_once("includes/navbar.php"); ?>
        <!-- Main Sidebar Container -->
        <?php require_once("includes/main_sidebar.php"); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php require_once("includes/content_header.php"); ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <div class="col-md-3 col-sm-6 col-12 mx-4">
                            <a href="my_acc_profile_edit_form.php">
                                <div class="info-box shadow-lg">
                                    <span class="info-box-icon bg-primary">
                                        <i class="fa-solid fa-user-gear"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-number text-black">จัดการข้อมูลส่วนตัว</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 mx-4">
                            <a href="my_acc_account_edit_form.php">
                                <div class="info-box shadow-lg">
                                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-number text-black">จัดการข้อมูลบัญชี</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 mx-4">
                            <a href="my_acc_password_edit_form.php">
                                <div class="info-box shadow-lg">
                                    <span class="info-box-icon bg-warning">
                                        <i class="fa-solid fa-key text-white"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-number text-black">จัดการรหัสผ่าน</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                        </section>
                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Footer -->
        <?php require_once("includes/footer.php"); ?>
    </div>
    <!-- ./wrapper -->

    <!-- vendor  -->
    <?php require_once("includes/vendor.php"); ?>
</body>

</html>

<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php");