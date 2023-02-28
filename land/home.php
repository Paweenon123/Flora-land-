<?php include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>

    <!-- header -->
    <?php include 'header.php'; ?>

    <!-- home -->
    <section class="home" id="home">

        <div class="content">
            <h1>Welcome</h1>
            <h3>Flora Land</h3>
            <span> natural & beautiful flowers </span><br>
            <p class="text">A land where you can enjoy shopping for various kinds of flowers.</p>
        </div>

    </section>

    <!-- process -->

    <section class="process" id="process">

        <h1 class="heading"> <span> วิธีการ </span> สั่งซื้อ </h1>
        <div class="row">
            <div class="video_container">
                <video src="img/flower_video.mp4" width="80" loop autoplay muted></video>
                <h3>best flower sellers</h3>
            </div>
            <div class="content">
                <h3>how to?</h3>
                <p>1.ลงทะเบียน/เข้าสู่ระบบ</p>
                <p>2.เลือกดอกไม้ตามโอกาสที่ต้องการ</p>
                <p>3.กดเพิ่มดอกไม้เข้าใส่ตะกร้า</p>
                <p>4.เลือกช่องทางการชำระเงิน</p>
            </div>
        </div>

    </section>

    <!-- event -->
    <section class="event" id="event">

        <h1 class="heading">E<span>vent</span> </h1>

        <div class="box-container">

            <div class="box">
                <div class="img">
                    <img src="img/wedding.jpg">
                    <div class="icons">
                        <a href="wedding_detail.php" class="cart-btn">เลือก</a>
                    </div>
                </div>
                <div class="content">
                    <h3>สำหรับงานแต่ง</h3>
                </div>
            </div>

            <div class="box">
                <div class="img">
                    <img src="img/get_degree.png">
                    <div class="icons">
                        <a href="congrat_detail.php" class="cart-btn">เลือก</a>
                    </div>
                </div>
                <div class="content">
                    <h3>สำหรับรับปริญญา</h3>
                </div>
            </div>

            <div class="box">
                <div class="img">
                    <img src="img/birthday.png">
                    <div class="icons">
                        <a href="birthday_detail.php" class="cart-btn">เลือก</a>
                    </div>
                </div>
                <div class="content">
                    <h3>สำหรับวันเกิด</h3>
                </div>
            </div>

            <div class="box">
                <div class="img">
                    <img src="img/valentine.jpg">
                    <div class="icons">
                        <a href="special_detail.php" class="cart-btn">เลือก</a>
                    </div>
                </div>
                <div class="content">
                    <h3>สำหรับคนพิเศษ</h3>
                </div>
            </div>
        </div>

    </section>

    <!-- footer -->

    <?php include 'footer.php'; ?>

    <script src="js/javascript.js"></script>
</body>

</html>