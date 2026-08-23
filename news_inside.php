<?php
    session_start();
    include 'condb.php'; 

    // ดึงข้อมูล
$news_id = $_GET['id'];
$query_news = $conn->prepare("SELECT * FROM tbl_news WHERE news_id = :news_id");
$query_news->bindParam(':news_id', $news_id);
$query_news->execute();
$newsList = $query_news->fetch(PDO::FETCH_ASSOC);

?>


<html>
<head>
    <title>ข่าว<?php echo $newsList['news_title']; ?></title>
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
        <a class="nav-link text-danger" href="main_page.php">หน้าหลัก <span class="sr-only">(current)</span></a>
      </li>      

        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle text-danger" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            หมวดหมู่
          </a>
          <div class="dropdown-menu text-danger" aria-labelledby="navbarDropdown">
            <a class="dropdown-item text-danger" href="">ในมหาลัย</a>
            <a class="dropdown-item text-danger" href="">นอกมหาลัย</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="">กิจกรรมค่าย</a>
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

<div class="album py-5 bg-light" style="background-color: white !important;">
<div class="container">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="main_page.php" style="color: black;">หน้าหลัก</a></li>
          <li class="breadcrumb-item active" aria-current="page"><a href="#" style="color: black;">ข่าวทั่วไป</a></li>
      </ol>
  </nav>
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card mb-4">
              <center>
                <?php if(!empty($newsList['news_img'])): ?>
                  <img src="upload_img/<?php echo $newsList['news_img']; ?>" class="img-fluid" alt="News Image">
                <?php else: ?>
                  <img src="assets/img/no-img.png" class="img-fluid mx-auto d-block" alt="News Image">
                <?php endif; ?>
              </center>
            </div>
          </div>
        </div>



      
      <section class="post-content">
        <div class="header-content">
          <h1 class="header-title"> <?php echo $newsList['news_title']; ?></h1>
        </div>
      </section>
      <section class="post-content post-container">
        <p class="post-text text-justify"><?php echo $newsList['news_detail']; ?></p>
      </section>
      <div class="footer container">
        <p>Share</p>
        <div class="social">
          <a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAPZJREFUSEvtV9ENglAMPDbRSdRJdBPdRJ1EN9FNNJdQctaH4UFfQEITEj6gx12vfaXCSFGNhItJAa8A8IqMu0+WYvyKRKxzPQGsNa8H3gK4FQBmyh2AhvnfA1PKa82I9+aTs6gXzvirfjWYL1s48EdCYVgcWH1CiQ8ANiK3fUsoY7qUCS1YUwKnoigwW5ESzw/YphAdraGjlsxD26mtfby8JwDHyD7uCuyNNthcNqVIhvcXYUVHm9x7d8oNBlZJfTvN19XGemG81Fg74Gc7sQcfGTtXjrk4ZpsRm9oyc9ZbJtJ53XYydVpvMwj3f3RSfxL9aWS8+QaJnlkfwLrRIQAAAABJRU5ErkJggg=="/></a>
          <a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAb1JREFUSEvllktOBDEMRGtuAicBDgICLgKchM9F+GzZsgdOAnojG5m000l3Fi1EpFHP9MRVdtlxvNNGa7cRr/4E8YEkPq311NrA/62IryUdSTruAbM9H/a8l4R9umrEEN2GCB3Mn3N+RCfZfyJpYlcjfjdSZLuR1CWfeePpwHGcgPSw9DQjxuDcyPB26Tq1FL6YapDfSbqIQBmxR4uXPdJGPEgf7AVE2D9mUWfEX2ZYSwNSoghFB/CnRcT3M0kUFevSSAlkIncJDigbyWkmM1V6lWgPsFcxToH7JunV8MAF76dWSmLygTQZcSSl4DwNRA4Zi/flEQIP3FXErgTgvwCM0B3GGXIbT8EQsUc7qc4gu5+GMuohYgclGsizVUvTEHFqXLCTZxwsVRki3kzqWFyZ3C5zVnxDEQPoUvIdOZ9Db/aznR0n74Szx2mugXjHyhpI7QzzPm3Btc6V3ighQqSlceAMkaNAra+nLTjrxz0V3HtjeXqavRpAr+Bav+4lZZ8H0XUtIh8GPNcMAhBiu3gQcEMn5/fI6FP27r1ic8NevHeXDHvu6Kphr8xj72iLXdd81hpvlxTSor3/j/gbIXGOHxGm6M4AAAAASUVORK5CYII="/></a>
          <a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAWlJREFUSEvtlultAjEQhR+VJFSSUEmgEpJKApUkVAKloA95kDFje/YQ/GEktGJ9vGPG413oSbF4Eq5ewA9zfi6rvyV9SXqX9C9pn56npGRd/Hdz/CdpI8kWtVwA6FfSpzMJAodEiOFlPqdUzEbHxC4CDkkPNMdAwE8SAplLlMBYggKCSS1wI9mrC3OuqRj2qMgDtjvHevK67aGmdQi4qvUU8w6rUVMGC80yVESBWcPcm/CqOq/QliDAPYLlmhAwObZjEdk04PSlTkhVU7GX48jmrTmrMr9DczyGAOm4qWbbxMsxFlPZc1hNQaL4Lmot0zoSzykEXJtrVvOeIuOMTgGt2twCnsPuqtoWMGNTwN2zmyc6ci1yxDjb2B+JakENBebSiILSKGgY3SgVo84q+W0AIEBuh6ox8ICx1Qh0mad2GFIZsRpgu+A/Mhc4Ivbj6+KuB0eY9qo6useoeZGqHrVxb9ELuOfQbONnwZRDH2CSJhsAAAAASUVORK5CYII="/></a>
          <a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAalJREFUSEvtlr1NBDEQhd+1QAXQADnZkZMCKWR0AXRBBjGk5JCR0wBUcC2A3smD3s3O2GYNOgkx0mrv1j+f598LbEkWW+LiT4CXAHbL8wzgvTyhUX9CY8JuARDs5RrAXXSAUTBhT404ofbnHj4C9lDVjmOXYgWOXekB54I99BAANfPyVnzO73uq9RxwDboP4FXoOpfmpr/XMgfMYKJf+VZNjwHcADgC8CLwj/J7GMx9NG34n9D7AliVA1FzzqO5KRt+nqOx96NCOXYqh2BAMcgoG3HQA6afsmJQg6p/uZ7B9SUtsC3mQp6Yb5Ne6CSiW8FVi97vQMNUyzT+VWimsUaiD4qaphbtUar5gAzzmAut4Ps8tZThRicAHiY7TlMtmDItIFneeU0zaAiJPnofa97ZGMsgrbBTNlBoLdWqh6iBtagfAHgEcCHmraVaU3MPPitNPco9bQC93Sk9QJRO1srY5hhcXoahWTqpn+32wLmsWjo2qb9N+3aUTG3g2X5Z8+/i12q1XeCYYiq0AltcdOPogrZqtVUigi1t7NraDcgmtrrTMOAfbBb4BN6ecR8MEwuKAAAAAElFTkSuQmCC"/></a>      
        </div>
      </div>
    </div>
  </div>

<footer class="blog-footer text-center" style="padding: 15px; background-color: lightgrey;">
  <p style="margin : 0 ;">มศวนิวส์ ทันข่าวสารก่อนใคร SWU NEWS </p> 
</footer>


</body>
</html>