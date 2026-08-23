<?php
session_start();
include('condb.php');

// รับค่าจากฟอร์ม signin
if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // เช็คค่าจากฟอร์มที่ส่งมา ถ้าไม่ได้ใส่ก็จะขึ้น "กรุณาใส่ username" หรือ "กรุณาใส่ password"
    if (empty($username)) {
        $_SESSION['error'] = 'กรุณาใส่ username';
        header("location: signin.php");
    } elseif (empty($password)) {
        $_SESSION['error'] = 'กรุณาใส่ password';
        header("location: signin.php");

    } else {
        // เช็ค username กับ password ว่าตรงกับ Database รึป่าว
        try {
            $check_data = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {

                if($username == $row['username']){
                    if(password_verify($password, $row['password'])){
                        if($row['urole'] == 'admin'){
                            $_SESSION['admin_login'] = $row['id'];
                            header("location: admin.php");
                        }else{
                            $_SESSION['user_login'] = $row['id'];
                            header("location: main_page.php");
                        }
                    }else{
                        $_SESSION['error'] = 'รหัสผ่านผิด';
                        header("location: signin.php");
                    }
                }else{
                    $_SESSION['error'] = 'username ผิด';
                    header("location: signin.php");
                }
            
            } else {
                $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                header("location: index.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
