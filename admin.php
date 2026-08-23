<?php
    // เอาไว้แก้ "Sessions have already been started" 
    if(isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
    include 'condb.php';
    include 'signin_db.php';

    if (!isset($_SESSION['admin_login'])) {        
        $_SESSION['error'] = "กรุณาเข้าสู่ระบบ";
        header('location: signin.php');        
    }

    // ดึงข้อมูล
    $query = $conn->query("SELECT * FROM tbl_news");
    $newsList = $query->fetchAll(PDO::FETCH_ASSOC);
    $row = count($newsList);   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="assets/img/LOGO HEADER1.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
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
            width: 12%;
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
            <main class="px-md-4 py-4 ">                
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

                <br>

                <div class="col-12 col-xl mb-lg-0 px-md-5 ">
                    <div class="card ">
                      <h5 class="card-header" style="font-size: 1.7rem;">เพิ่มข้อมูลข่าว</h5>
                        <div class="card-body">
                    <form action ="up_news_form.php" method="post" enctype="multipart/form-data">                                            
                            <div class="row g-3 mb-3 fs-4 ml-6">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" style="font-size: 1.2rem;">ชื่อข่าว</label>
                                    <input type="text" name="news_title" class="form-control">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" style="font-size: 1.2rem;">เนื้อข่าวย่อ</label>
                                    <input type="text" name="news_intro" class="form-control">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" style="font-size: 1.2rem;">เนื้อข่าว</label>
                                    <textarea name="detail" class="form_control" rows="8" cols="100" ></textarea>
                                </div>
                            </div>
                              <div class="col-sm-6">
                                  <label class="form label mb-4" style="font-size: 1.2rem;">อัพรูป</label>
                                  <input type="file" name="news_img" class="form_control" accept="image/png, image/jpg, image/jpeg">
                              </div>
                        </div>                        
                        <div class="col-12">
                            <button class="btn btn-primary custom-button" type="submit">ยืนยัน</button>
                        </div>                       
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>                
            <!-- รายการข่าวต่างๆ -->
                <div class="row">
                    <div class="col-12 col-xl mb-4 mb-lg-0 px-md-5 py-5" >
                        <div class="card">
                          <h5 class="card-header" style="font-size: 1.7rem;">รายการข่าว</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>                                          
                                            <tr style="font-size: 1.3rem;">
                                                <th scope="col" style="text-align: center;">รูปข่าว</th>
                                                <th scope="col">ชื่อข่าว</th>
                                                <th scope="col">เนื้อข่าวย่อ</th>
                                                <th scope="col">เนื้อข่าว</th>
                                                <th scope="col" style="text-align: center;">จัดการข่าว</th>                                            
                                            </tr>
                                        </thead>
                                <tbody>
                                  <?php if ($row > 0): ?>
                                    <?php foreach ($newsList as $news): ?>
                                        <tr>
                                            <td style="width: 350px; text-align: center; padding-left: 60px; padding-right: 65px;">
                                                <?php if (!empty($news['news_img'])): ?>
                                                    <img src="upload_img/<?php echo $news['news_img']; ?>" width="100%" alt="news_img">
                                                <?php else: ?>
                                                    <img src="assets/img/no-img.png <?php echo $news['news_img']; ?>" width="100%" alt="news_img">
                                                <?php endif; ?>
                                            </td>
                                            <td style="width: 350px; font-size: 20px;">                                                
                                                <div>
                                                    <small class="text-muted"><?php echo nl2br($news['news_title']); ?></small>
                                                </div>
                                            </td>
                                            <td style="width: 350px; font-size: 20px;">
                                            <?php $news['news_intro']; ?>
                                                <div>
                                                    <small class="text-muted"><?php echo nl2br($news['news_intro']); ?></small>
                                                </div>
                                            </td>
                                            <td style="width: 350px; font-size: 20px;">
                                            <?php $news['news_detail']; ?>
                                                <div >
                                                    <small class="text-muted"><?php echo nl2br($news['news_detail']); ?></small>
                                                </div>
                                            </td>
                                            </td>
                                            <td align="center">
                                            <a role="button" href="admin_edit.php?id=<?php echo $news['news_id'];?>" class="btn btn-dark">แก้ไข</a>
                                            <a onclick="return confirm('ต้องการที่จะลบ'); "role="button" href="news_delete.php?id=<?php echo $news['news_id'];?>" class="btn btn-danger">ลบ</a>                            
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                  <?php else: ?>
                                      <tr>
                                          <td colspan="4">
                                          <h4 class="text-center text-danger" style="font-size: 1.rem; font-weight: bold;">ไม่มีรายการข่าว</h4>
                                          </td>
                                      </tr>
                                  <?php endif; ?>
                                      </tbody>
                                  </table>
                              </div>                                
                          </div>
                      </div>
                  </div>                    
              </div>                
          </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <!-- featther icon -->
    <script>
    feather.replace();
    </script>

    <footer style="margin-top: 100px; margin-bottom: 50px;" class="text-center"> Designed by Donut Puff Kaimook </footer>   
  </body>
</html>