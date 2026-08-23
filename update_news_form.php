<?php
    session_start();
    include 'condb.php';

    //รับมาจากหน้าedit
    $news_id = $_POST['nid'];
    $news_title = trim($_POST['news_title']);
    $news_intro = trim($_POST['news_intro']);
    $news_detail = trim($_POST['detail']);
    $news_img = $_POST['textimg'];

    // ตรวจว่ามีไฟล์ upload รึเปล่า
    if (!empty($_FILES['news_img']['name'])) {        
        $temp_file = $_FILES['news_img']['tmp_name'];
        
        $target_directory = 'upload_img/';
        $target_file = $target_directory . basename($_FILES['news_img']['name']);
        
        move_uploaded_file($temp_file, $target_file);
        
        $news_img = basename($_FILES['news_img']['name']);
    }

    try {
        $sql = "UPDATE tbl_news 
                SET news_title = :news_title,
                    news_intro = :news_intro,
                    news_detail = :news_detail,
                    news_img = :news_img
                WHERE news_id = :news_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':news_title', $news_title);
        $stmt->bindParam(':news_intro', $news_intro);
        $stmt->bindParam(':news_detail', $news_detail);
        $stmt->bindParam(':news_img', $news_img);
        $stmt->bindParam(':news_id', $news_id);

        $stmt->execute();

        $_SESSION['success'] = "แก้ไขข่าวสำเร็จ";
        header('location: admin.php');
    } catch (PDOException $e) {
        $_SESSION['success'] = "แก้ไขข่าวผิดพลาด: " . $e->getMessage();
        header('location: admin.php');
    }
?>
