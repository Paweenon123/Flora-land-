<?php include 'config.php';

if (isset($_POST['submit'])) {

    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));
    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));


    $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'user already exist!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'confirm password not matched!';
        } else {
            mysqli_query($conn, "INSERT INTO users(name, email, password, user_type) VALUES('$name', '$email', '$pass', 'user')") or die('query failed');
            $message[] = 'registered successfully!';
            header('location:login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style_login.css">
    <style>
        body {
            background-image: url(img/flower.png);
        }
    </style>

</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>



    <section class="form-container">

        <form action="" method="post">
            <h3>สมัครสมาชิก</h3>
            <input type="text" name="name" class="box" placeholder="กรอกชื่อผู้ใช้" pattern="^[a-zA-Zก-๏\s]+$" title="กรอกเป็นตัวอักษรเท่านั้น" required>
            <input type="email" name="email" class="box" placeholder="กรอกอีเมล" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.(com|ac\.th)" title="กรอกอีเมล xxxx123@gmail.com" required>
            <input type="password" name="pass" class="box" placeholder="กรอกรหัสผ่าน" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="ต้องมีอย่าง 1ตัวเลขและ 1ตัวพิมพ์ใหญ่และตัวพิมพ์เล็กและต้องมีอย่างน้อย 6ตัวอักษรขึ้นไป" required>
            <input type="password" name="cpass" class="box" placeholder="กรอกรหัสผ่านอีกครั้ง" title="กรอกรหัสผ่านให้ต้องกัน" required>
            <br><input type="submit" class="btn" name="submit" value="register now">
            <p>มีบัญชีอยู่แล้ว? <a href="login.php">login now</a></p>
        </form>

    </section>

</body>

</html>