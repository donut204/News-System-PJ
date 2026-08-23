<?php
session_start();
include('condb.php');

// รับค่าตัวแปรจากการกรอกฟอร์ม
if (isset($_POST['signup'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $urole = 'user';

    // ข้างล่างเอาไว้เช็คเรื่องการกรอกข้อมูล ครบถ้วนรึป่าว
    if (empty($firstname)) {
        $_SESSION['error'] = 'กรุณาใส่ชื่อ';
        header("location: index.php");
    } elseif (empty($lastname)) {
        $_SESSION['error'] = 'กรุณาใส่นามสกุล';
        header("location: index.php");
    } elseif (empty($username)) {
        $_SESSION['error'] = 'กรุณาใส่ username';
        header("location: index.php");
    } elseif (empty($password)) {
        $_SESSION['error'] = 'กรุณาใส่ password';
        header("location: index.php");
    } elseif (empty($c_password)) {
        $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
        header("location: index.php");
    } elseif ($password != $c_password) {
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header("location: index.php");
    } else {
        
        try {
            $check_username = $conn->prepare("SELECT username FROM users WHERE username = :username");
            $check_username->bindParam(":username", $username);
            $check_username->execute();
            
            // เช็คว่า username ที่กรอกมาซ้ำรึป่าว
            if ($check_username->rowCount() > 0) {
                $_SESSION['error'] = "มี Username อยู่ในระบบแล้ว <a href='signin.php'>กดตรงนี้</a> เพื่อเข้าสู่ระบบ";
                header("location: index.php");
            } elseif (!isset($_SESSION['error'])) {

                // ข้างล่างคือการนำข้อมูลที่กรอกลง Database
                $passwordhash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, username, password, urole) VALUES(:firstname, :lastname, :username, :password, :urole)");
                // bindparam ต้องผูกข้อมูลกับ database
                $stmt->bindParam(":firstname", $firstname);
                $stmt->bindParam(":lastname", $lastname);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $passwordhash);
                $stmt->bindParam(":urole", $urole);
                $stmt->execute();
                $_SESSION['success'] = "สมัครสมาชิกเรียบร้อย <a href='signin.php' class='alert-link'>กดที่นี่</a> เพื่อเข้าสู่ระบบ";
                header("location: index.php");
            } else {
                $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                header("location: index.php");
            }
        //  จับ error
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
