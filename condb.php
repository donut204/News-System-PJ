<?php

  // เขียนเพื่อเชื่อมต่อข้อมูลกับ Database
  $servername = "localhost";
  $username = "root";
  $password = "";

  try {
      $conn = new PDO("mysql:host=$servername;dbname=web_news", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // ถ้าต้องการเช็คว่าเชื่อมต่อกับ Database สำเร็จรึป่าวให้เอา comment echo ข้างล่างออก 
      // echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    
?>