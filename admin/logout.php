<?php
// เริ่ม session
session_start();

// ลบ session ทั้งหมด
session_unset();

// ทำลาย session
session_destroy();

header("Location: ../index.php");
