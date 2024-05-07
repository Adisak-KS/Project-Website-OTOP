 <?php
    require_once("../db/connect.php");
    require_once("includes/verify_admin.php");

    // ตรวจสอบว่ามี Admin Id ส่งมาหรือไม่
    if (isset($_SESSION['admin_id'])) {
        $admId =  $_SESSION['admin_id'];

        // แสดงข้อมูล Admin ที่ใช้งาน
        try {
            $sql = "SELECT adm_profile, adm_fname, adm_lname, adm_username
                    FROM ot_admin 
                    WHERE adm_id = :adm_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":adm_id", $admId);
            $stmt->execute();
            $result_use = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    ?>

 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">OTOP</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image mt-6">
                 <img class="rounded-circle border" style="width: 40px; height: 40px;" src="../uploads/profile_admin/<?php echo $result_use["adm_profile"]; ?>">
             </div>
             <div class="info">
                 <a class="d-block"><?php echo $result_use["adm_fname"] . " " . $result_use["adm_lname"] ?></a>
                 <a class="d-block"><?php echo "@" . $result_use["adm_username"]; ?></a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <li class="nav-header">หน้าแรก</li>
                 <li class="nav-item">
                     <a href="index.php" class="nav-link">
                         <i class="fa-solid fa-house"></i>
                         <p>หน้าหลัก</p>
                     </a>
                 </li>

                 <li class="nav-header">จัดการผู้ใช้</li>
                 <li class="nav-item">
                     <a href="admin_show.php" class="nav-link">
                         <i class="fa-solid fa-user-shield"></i>
                         <p>ผู้ดูแลระบบ</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="member_show.php" class="nav-link">
                         <i class="fa-solid fa-user-check"></i>
                         <p>สมาชิก</p>
                     </a>
                 </li>

                 <li class="nav-header">จัดการสินค้า</li>
                 <li class="nav-item">
                     <a href="product_type_show.php" class="nav-link">
                         <i class="fa-solid fa-boxes-stacked"></i>
                         <p>ประเภทสินค้า</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="product_show.php" class="nav-link">
                         <i class="fa-solid fa-box-archive"></i>
                         <p>สินค้า</p>
                     </a>
                 </li>
                 <li class="nav-header">ชำระเงิน</li>
                 <li class="nav-item">
                     <a href="payment_show.php" class="nav-link">
                         <i class="fa-solid fa-credit-card"></i>
                         <p>ช่องทางชำระเงิน</p>
                     </a>
                 </li>
                 <li class="nav-header">อื่น ๆ </li>
                 <li class="nav-item">
                     <a href="logout.php" class="nav-link">
                         <i class="fa-solid fa-right-from-bracket rotate-icon" style="transform:rotate(180deg)"></i>
                         <p>ออกจากระบบ</p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>