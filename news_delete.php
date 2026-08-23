<?php
    session_start();
    include ('condb.php');

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = $_GET['id'];

        // ตรวจสอบก่อนว่ามีข้อมูลที่ต้องการลบรึป่าว
        $checkSql = "SELECT * FROM tbl_news WHERE news_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->execute([$id]);
        $row = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $_SESSION['success'] = "ไม่พบข้อมูลที่ต้องการลบ";
            header('location: ' .'admin.php');
            exit; 
        }

        // ลบข้อมูล
        $deleteSql = "DELETE FROM tbl_news WHERE news_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->execute([$id]);

        // ลบไฟล์รูปภาพ
        unlink("upload_img/".$row['news_img']);
        
        $_SESSION['success'] = "ลบข่าวสำเร็จ";
        header('location: ' .'admin.php');        
    }
?>
