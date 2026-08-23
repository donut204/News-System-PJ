<?php

    session_start();
    include 'condb.php';

    $news_title = trim($_POST['news_title']);
    $news_intro = trim($_POST['news_intro']);
    $detail = trim($_POST['detail']);
    $news_img = $_FILES['news_img']['name'];

    $img_tmp = $_FILES['news_img']['tmp_name'];
    $folder = 'upload_img/';
    $img_location = $folder . $news_img;

    // Prepare the SQL statement
    $sql = "INSERT INTO tbl_news(news_title, news_intro, news_detail, news_img) VALUES (:title, :intro, :detail, :img)";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $news_title);
    $stmt->bindParam(':intro', $news_intro);
    $stmt->bindParam(':detail', $detail);
    $stmt->bindParam(':img', $news_img);

    try {
        $stmt->execute();

        // ย้ายไฟล์ไปยังโฟเดอร์ที่สร้างไว้
        move_uploaded_file($img_tmp, $img_location);

        $_SESSION['success'] = "อัพโหลดข่าวสำเร็จ";
        header('location: ' .'admin.php');
    } catch (PDOException $e) {
        $_SESSION['success'] = "อัพโหลดข่าวผิดพลาด: " . $e->getMessage();
        header('location: ' .'admin.php');
    }
?>
