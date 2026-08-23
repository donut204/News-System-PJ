<?php
    // เมื่อกดปุ่ม logout ระบบจะออกจาก session user_login และ admin_login แล้วเด้งกลับไปหน้า index
    session_start();
    unset($_SESSION['user_login']);
    unset($_SESSION['admin_login']);
    header('location: index.php');

?>    
