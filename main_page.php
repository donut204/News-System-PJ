<?php

session_start();
include('condb.php');
// เช็คว่าทำการ login แล้วหรือยัง?
if(!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])){
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
  header('location: signin.php');
}
$i = 1;


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>SWU NEWS</title>
<link href="assets/img/LOGO HEADER1.png" rel="icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" 
integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mitr">
<style>
body {
    font-family: 'Mitr', serif;
}

</style>
<link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <!-- แถบด้านบน -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #D8D9DA !important;">
      <!-- ใส่ไอคอนแถบด้านบน -->
        <a class="navbar-brand text-danger" href="main_page.php">
          <img src="assets/img/LOGO HEADER1.png" width="35"  alt="SWU NEWS Logo" class="mr-1">
        </a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active text-danger">
        <a class="nav-link text-danger" href="">หน้าหลัก <span class="sr-only">(current)</span></a>
      </li>      

        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle text-danger" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            หมวดหมู่
          </a>
          <div class="dropdown-menu text-danger" aria-labelledby="navbarDropdown">
            <a class="dropdown-item text-danger" href="">ในมหาลัย</a>
            <a class="dropdown-item text-danger" href="">นอกมหาลัย</a>            
          </div>
    </li>


  <!-- แสดงบัญชีที่กำลัง login อยู่ -->
  <li class="nav-item">
      <?php            
        if(isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])){
          // ถ้ามีผู้ใช้ทั่วไปล็อกอิน ค่าของ $user_id จะเป็น $_SESSION['user_login'] แต่ถ้าไม่มี (เช่น มีแอดมินล็อกอิน) ค่าของ $user_id จะเป็น $_SESSION['admin_login'] 
            $user_id = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : $_SESSION['admin_login'];       
            $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
            
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
      ?>  
        <a class="nav-link text-danger" tabindex="-1" aria-disabled="true"><?php echo $row['firstname'];?></a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-danger" href="logout.php" tabindex="-1" aria-disabled="true">Logout</a>
  </li>
</ul>
<form  action="search.php" method="get" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="ค้นหา" aria-label="Search">
      <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">ค้นหา</button>
</form>
</div>
</nav>
      </div>                   

  <!-- Banner -->
  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/img/HEADER 1.jpg" class="d-block w-100 h-50" alt="...">
      </div>
      <div class="carousel-item">
        <img src="assets/img/HEADER 2.jpg" class="d-block w-100 h-50" alt="...">
      </div>
      <div class="carousel-item">
        <img src="assets/img/HEADER 3.jpg" class="d-block w-100 h-50" alt="...">
      </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>                       
                      

<div class="album py-5 bg-light" style="background-color: white !important;">
<div class="container">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="main_page.php" style="color: black;">หน้าหลัก</a></li>
          <li class="breadcrumb-item active" aria-current="page"><a href="main_page.php" style="color: black;">ข่าวทั่วไป</a></li>
      </ol>
  </nav>
        
<!-- ดึงข้อมูลข่าวมาแสดงจาก database -->
<div class="row">
<?php
$currentPage = isset($_GET['currentPage']) ? (int) $_GET['currentPage'] : 1;
$perPage = 9;

$totalNewsItems = $conn->query("SELECT COUNT(*) FROM tbl_news")->fetchColumn();
$totalPages = ceil($totalNewsItems / $perPage);

$offset = ($currentPage - 1) * $perPage;

$query = $conn->query("SELECT * FROM tbl_news ORDER BY news_id DESC LIMIT $offset, $perPage");
while ($newsList = $query->fetch(PDO::FETCH_ASSOC)) {
?>
<div class="col-md-4">
    <div class="card mb-4 shadow-sm">
    <?php if (!empty($newsList['news_img'])) { ?>
        <a href="news_inside.php?id=<?= $newsList['news_id'] ?>">
            <img src="upload_img/<?php echo $newsList['news_img'] ?>" width="348" />
        </a>
    <?php } else { ?>
        <img src="assets/img/no-img.png <?php echo $newsList['news_img']; ?>"  width="348" alt="news_img">
    <?php } ?>

        <div class="card-body">
            <p class="text"><h4><?php echo $newsList['news_title'] ?></h4></p>
            <p class="text-card"><h9><?php echo $newsList['news_intro'] ?></h9></p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="news_inside.php?id=<?= $newsList['news_id'] ?>" button type="button" class="btn btn-sm btn-outline-secondary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
</div>
  <?php
    if ($totalPages > 1) {
        echo '<nav aria-label="Page navigation example">';
        echo '<ul class="pagination justify-content-center">';

        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="?currentPage=' . ($currentPage - 1) . '">Previous</a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?currentPage=' . $i . '">' . $i . '</a></li>';
            }
        }

        if ($currentPage < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?currentPage=' . ($currentPage + 1) . '">Next</a></li>';
        }
  }?>
      </nav>
      </div>
      </div>
<footer class="blog-footer text-center" style="padding: 30px; bottom:auto; background-color: #D8D9DA; font-size: 25px; margin-top: auto;">
        <p style="margin: 0;">SWU NEWS ทันข่าวสารก่อนใครที่นี่เท่านั้น </p>
</footer>
</body>
</html>
