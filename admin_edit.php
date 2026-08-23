<?php
    session_start();
    include 'condb.php'; 

    // ดึงข้อมูล
    $query = $conn->query("SELECT * FROM tbl_news");
    $newsList = $query->fetchAll(PDO::FETCH_ASSOC);
    $row = count($newsList);

    // แก้ไขข่าวโดยรับค่าจากตัวแปร id ใน database
    $news_id = $_GET['id'];
    $query_news = $conn->prepare("SELECT * FROM tbl_news WHERE news_id = :news_id");
    $query_news->bindParam(':news_id', $news_id);
    $query_news->execute();
    $news_row = $query_news->fetch(PDO::FETCH_ASSOC);
    
    // ถ้า id ข้อมูลไม่ตรงกับ database ให้กลับไปที่หน้า admin.php 
    if($news_row == 0){
        header('location: admin.php');
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="assets/img/LOGO HEADER1.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;300;400;700&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/feather-icons"></script>

    <style>

        body {
            font-family: 'Prompt', sans-serif;
        } 
        .navbar {
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
        }                
        .custom-margin {
            scale: 120%;
            margin-bottom: 5px; 
        }
        .navbar-brand {
            margin-left: 30px; 
        }
        .navbar-brand i.custom-margin {
            margin-left: 5px; 
        }

        .navbar-brand span.m {
            margin-left: 8px; 
        }
        .custom-button {
            width: 14%;
            font-size: 1.1rem;
            margin-left: 16px; 
            margin-bottom: 25px; 
            margin-right: 2px; 
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light p-3" >
                <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-start mt-3 mt-md-0">
                    <a class="navbar-brand" href="admin.php">
                        <i class="custom-margin" data-feather="settings"></i>
                        <span class="m" style="font-size: 1.8rem;">Admin Page</span>
                    </a>
                    <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                
                <div class="col-12 col-md-5  d-flex justify-content-md-end mt-3 mt-md-0">
                    <!-- ปุ่มกลับหน้าหลัก -->
                    <a href="main_page.php" class="btn btn-success me-3">กลับสู่หน้าหลัก</a> 
                        
                    <!-- ปุ่ม Logout -->
                    <a href="logout.php" class="btn btn-danger me-5">Logout</a>
                </div>
    </nav>
    <div class="container" style="margin-top: 30px;">
    
        <!-- ข้างล่างคือการแจ้งเตือนต่างๆ error success -->
        <?php if(isset($_SESSION['error'])){?>
            <div class="alert alert-danger d-flex justify-content-between" role="alert">                
                <?php
                    echo $_SESSION['error'];
                    unset ($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                <?php }?>

        <?php if(isset($_SESSION['success'])){?>
            <div class="alert alert-success d-flex justify-content-between" role="alert">                
                <?php
                    echo $_SESSION['success'];
                    unset ($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }?>

        <!-- <h3>แก้ไขข่าว</h3> -->
        <br>        
        <div class="row g-5">
            <div class="col md-8 col-sm-12">
                <div class="row g-3 mb-4">
                    <form action="update_news_form.php" method="post"  enctype="multipart/form-data">
                            
                            <p class="fs-1"><strong>แก้ไขข่าวข่าวที่ <?php echo $news_row['news_id']?></strong></p>
                            
                            <input type="hidden" name="nid" class="from-control" readonly value="<?php echo $news_row['news_id']?>">
                                                         
                            <div class="col-sm-6 mb-4" >
                                <label class="form-label" style="font-size: 1.3rem;">ชื่อข่าว</label>
                                <input type="text" name="news_title" class="form-control"  value="<?php echo $news_row['news_title']?>">
                            </div>

                            <div class="col-sm-6 mb-4">
                                <label class="form-label" style="font-size: 1.3rem;">เนื้อข่าวย่อ</label>
                                <input type="text" name="news_intro" class="form-control" value="<?php echo $news_row['news_intro']?>">
                            </div>

                            <div class="col-sm-12 mb-4">
                                <label class="form-label" style="font-size: 1.3rem;">เนื้อข่าว</label>
                                <textarea name="detail" class="form-control" rows="8" cols="111"><?php echo $news_row['news_detail']?></textarea>
                            </div>
                            <div class="col-sm-6">
                            <label class="form-label" style="font-size: 1.3rem;">แก้ไขรูปภาพ</label>
                                <div class="col-sm-10">
                                <?php if(!empty($news_row['news_img'])): ?>
                                                    <img src="upload_img/<?php echo $news_row['news_img']; ?>"  width="500" >
                                                <?php else: ?>
                                                    <h2>ไม่มีรูปภาพที่แสดง</h2>
                                                <?php endif; ?>
                                </div><br>
                            <input type="file" name="news_img" class="form-control" accept="image/png, image/jpg, image/jpeg">
                            <input type="hidden" name="textimg" class="form-control" value="<?php echo $news_row['news_img']?>">
                        </div>
                        </div>
                        
                        <button class="btn btn-primary custom-button" type="submit">ยืนยัน</button>
                    </form>
                    <a href = "admin.php" button class="btn btn-danger custom-button" type="submit">ย้อนกลับ</a>
                </div>    
            </div>
        </div>
    </div>
    <!-- featther icon -->
    <script>
        feather.replace();
    </script>

    <footer style="margin-top: 100px; margin-bottom: 50px;" class="text-center"> Designed by Donut Puff Kaimook </footer>   
</body>
</html>