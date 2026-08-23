<?php
    session_start();    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="assets/img/LOGO HEADER1.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mitr">
    <style>
        body {
        font-family: 'Mitr', serif;
        }
        .featured-image{
            width: 60%;
            height: 60%;
            object-fit: cover;
        }

        .left-box{
            background: linear-gradient(90deg,rgb(13 110 253)0%,
            #2196F3 35%,
            #2196F3 100%);
            height: 100%;
            border-radius: 25px 155px 155px 25px !important;
            padding: 40px;
        }        

        .right-box{
            padding: 40px 30px 40px 40px;
        }
        
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">                
                <div class="featured-image mb-3">
                    <img src="image_news/logo_icon.png" class="img-fluid" alt="">
                </div>
                <p class="text-white fs-1" >SWU NEWS</p>
                <div class="text-center">
                    <small class="text-white fs-10">เว็บข่าวคุณภาพ เผยแพร่ความจริง นำเสนอทุกประเด็นข่าวให้คุณได้รับชม </small>
                </div>               
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-item-center">
                    <form action = "signin_db.php" method="post">                       
                        <!-- ข้างล่างคือการแจ้งเตือนต่างๆ error success -->
                        <?php if(isset($_SESSION['error'])){?>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                        echo $_SESSION['error'];
                                        unset ($_SESSION['error']);
                                    ?>
                                </div>
                            <?php }?>

                            <?php if(isset($_SESSION['success'])){?>
                                <div class="alert alert-success" role="alert">
                                    <?php
                                        echo $_SESSION['success'];
                                        unset ($_SESSION['success']);
                                    ?>
                                </div>
                            <?php }?>
                        <div class="header-text  mb-3">
                            <h1 >เข้าสู่ระบบ</h1>
                            <p>กรุณากรอกข้อมูลเพื่อเข้าสู่ระบบ</p>
                        </div>
                        <div class="input-group mb-3">
                            <input class="form-control" name="username" type="text" placeholder="username" aria-label="default input example">
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control" name="password" type="password" placeholder="password" aria-label="default input example">
                        </div>

                        <div>
                            <button type="submit" name = "signin" class="w-100 fs-6 btn btn-primary">Sign In</button>
                        </div>

                       <br>
                        <div class="mb-6">
                            <small>ยังไม่เป็นสมาชิก? <a href="index.php">สมัครสมาชิก</a></small>
                        </div>
                        
                    </form>
                </div>
            </div>            
        </div>
    </div>    
</body>
</html>