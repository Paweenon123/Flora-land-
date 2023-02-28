<?php include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

// ถ้าไม่ได้ login เข้าสู่ระบบ
if (!isset($user_id)) {
    header('location:login.php');
};

// add ข้อมูลเข้าตาราง orders
if (isset($_POST['add_order'])) {

    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folter = 'payments/' . $image;
    $address = mysqli_real_escape_string($conn, 'บ้านเลขที่ ' . $_POST['flat'] . ' ถนน ' . $_POST['street'] . ' ตำบล ' .
        $_POST['city'] . ' อำเภอ ' . $_POST['state'] . ' จังหวัด ' . $_POST['country'] . ' รหัสไปรษณีย์ ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    // ราคา
    $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['pname'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE pname = '$name' AND number = '$number' 
        AND email = '$email' AND image = '$image' AND address = '$address' AND total_products = '$total_products' 
        AND total_price = '$cart_total'") or die('query failed');

    // เช็คเงื่อนไข insert,delete เข้า database
    if ($cart_total == 0) {
        $message[] = 'your cart is empty!';
    } elseif (mysqli_num_rows($order_query) > 0) {
        $message[] = 'order placed already!';
    } else {
        $insert_orders = mysqli_query($conn, "INSERT INTO orders(user_id, pname, number, email, image, address, 
            total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$image', 
            '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');

        $delete_orders = mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'order placed successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <!-- head -->
    <?php include 'header.php'; ?>

    <!-- form กรอกที่อยู่ -->
    <section class="checkout">

        <form action="" method="POST" enctype="multipart/form-data">

            <h3>ที่อยู่ในการจัดส่ง</h3>

            <div class="flex">
                <div class="inputBox">
                    <span>ชื่อ-นามสกุล :</span>
                    <input type="text" name="pname" placeholder="กรุณากรอกชื่อ-นามสกุล" pattern="^[a-zA-Zก-๏\s]+$" title="กรอกชื่อ-นามสกุล ภาษาไทย/ภาษาอังกฤษ" required>
                </div>
                <div class="inputBox">
                    <span>เบอร์โทรศัพท์ :</span>
                    <input type="text" name="number" placeholder="กรุณากรอกเบอร์โทร" pattern="\d{10}" title="กรอกตัวเลขเบอร์โทร 10 ตัว" required>
                </div>
                <div class="inputBox">
                    <span>อีเมล :</span>
                    <input type="email" name="email" placeholder="กรุณากรอกอีเมล" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.(com|ac\.th)" title="กรอกอีเมล xxxx123@gmail.com" required>
                </div>
                <div class="inputBox">
                    <span>สลิปหลักฐานการโอนเงิน</span>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" name="image">
                </div>
                <div class="inputBox">
                    <span>บ้านเลขที่ :</span>
                    <input type="text" name="flat" placeholder="เช่น 122/2, 123" pattern="([0-9]+[\/][0-9]+[0-9] | [0-9]+" required>
                </div>
                <div class="inputBox">
                    <span>ถนน(ถ้าไม่มีใส่ -) :</span>
                    <input type="text" name="street" placeholder="เช่น ข้าวสาร" pattern="(^[a-zA-Zก-๏\s]+$ | \- )" required>
                </div>
                <div class="inputBox">
                    <span>ตำบล/แขวง :</span>
                    <input type="text" name="city" placeholder="เช่น ลาดใหญ่" pattern="^[a-zA-Zก-๏\s]+$" required>
                </div>
                <div class="inputBox">
                    <span>อำเภอ/เขต :</span>
                    <input type="text" name="state" placeholder="เช่น เมือง" pattern="^[a-zA-Zก-๏\s]+$" required>
                </div>
                <div class="inputBox">
                    <span>จังหวัด :</span>
                    <input type="text" name="country" placeholder="เช่น กรุงเทพ" pattern="^[a-zA-Zก-๏\s]+$" required>
                </div>
                <div class="inputBox">
                    <span>รหัสไปรษณีย์ :</span>
                    <input type="text" min="0" name="pin_code" placeholder="เช่น 75110" pattern="[0-9]{5}" title="กรอกเลขไปรษณีย์ 5 ตัว" required>
                </div>
            </div>

            <input type="submit" name="add_order" value="เสร็จสิ้น" class="btn">

        </form>

    </section>



    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>


</body>

</html>