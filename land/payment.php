<?php include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

// ถ้าไม่ได้ login เข้าสู่ระบบ
if (!isset($user_id)) {
    header('location:login.php');
};

// add ข้อมูลเข้าตาราง orders
if (isset($_POST['add_order'])) {

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

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

    <section class="display-order">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $total_price;
        ?>
                <p><?php echo $fetch_cart['pname'] ?> 
                <span>(<?php echo $fetch_cart['price'] . '฿' . ' จำนวน ' . $fetch_cart['quantity'] . ' รายการ' ?>)</span>
            </p>
        <?php
            }
        } else {
            echo '<p class="empty">ไม่มีสินค้าในตะกร้า</p>';
        }
        ?>
        
        <div class="grand-total">
            ราคารวมทั้งหมด : <span><?php echo $grand_total; ?>฿</span>
        </div>
        

        <div class="bank">
            <h3>ช่องทางการชำระเงิน</h3>
            <p><img src="img/qr-code.png"><span><img src="img/bank.png" ></span></p>
        </div>
    </section>

    <section class="box-conti">
        <div class="continue">
            <a href="home.php#event" class="option-btn">ซื้อสินค้าต่อ</a>
            <a href="checkout.php" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">ดำเนินการต่อ</a>
            
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>


</body>

</html>