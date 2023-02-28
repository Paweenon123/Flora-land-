<?php include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $image = $_FILES['image']['name'];
   $event = mysqli_real_escape_string($conn, $_POST['event']);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM product WHERE name = '$name'") or die('query failed');


   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO product(name, details, price, image, event) VALUES('$name', '$details',
       '$price', '$image', '$event')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'product added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM product WHERE id = '$delete_id'") or die('query failed');

   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM product WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>เพิ่มสินค้า</h3>
      <input type="text" class="box" required placeholder="ป้อนชื่อสินค้า" name="name">
      <input type="number" min="0" class="box" required placeholder="ใส่ราคาสินค้า" name="price">
      <textarea name="details" class="box" required placeholder="ใส่รายละเอียดสินค้า" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <!-- เก็บตามเลือกตามโอกาส -->
      <div class="events">
         <p>เลือกตามโอกาส</p>
         <input type="radio" id="wedding" name="event" value="p_wedding">
         <label for="p_wedding">สำหรับงานแต่ง</label><br>
         <input type="radio" id="p_birthday" name="event" value="p_birthday">
         <label for="p_birthday">สำหรับวันเกิด</label><br>
         <input type="radio" id="p_special" name="event" value="p_special">
         <label for="p_special">สำหรับคนพิเศษ</label><br>
         <input type="radio" id="p_congrats" name="event" value="p_congrats">
         <label for="p_congrats">สำหรับรับปริญญา</label><br>
      </div>
      

      <input type="submit" value="เพิ่มสินค้า" name="add_product" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM product") or die('query failed');

         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>  
      <div class="box">
         <div class="price"><?php echo $fetch_products['price']; ?>฿</div>
         <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="details"><?php echo $fetch_products['details']; ?></div>
         <a href="admin_update_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" 
         onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   

</section>

<script src="js/javascript.js"></script>

</body>
</html>