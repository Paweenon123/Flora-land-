<?php include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดดอกไม้</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"" rel=" nofollow">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->

    <style>
        .This {
            padding: 2rem;
            padding-left: 8rem;
        }

        .table {
            border: #000 2px solid;
            font-size: 20px;
            padding: 2rem;

        }

        .pagination {
            display: inline-flex;
            font-size: large;
            text-align: center;
            border: 2px solid black;

        }
    </style>
</head>

<body>
    <?php include 'admin_header.php'; ?>
    <?php
    $con = mysqli_connect('localhost', 'root', '', 'Floraland');

    $perpage = 10;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }/*กำหนดตัวแปร จำนวนแถวข้อมูลต่อหน้าคือ 10 และเช็คว่าหากมีค่าตัวแปร GET[‘page’] ให้เท่ากับตัวแปร GET 
    ไม่มีให้เท่ากับ 1 โดยค่านี้เป็นค่าตัวแปรที่กำหนดว่า เราอยู่หน้าที่เท่าไหร*/

    $start = ($page - 1) * $perpage;
    /*ค่าตัวแปร $start เป็นการกำหนดจุดเริ่มต้นในการค้นหา(select) ข้อมูล โดยเริ่มต้นตำแหน่งแถวที่ 0 เช่น มีทั้งหมด 10 แถว 
    จะนับได้ดังนี้ 0,1,2,3,4 เป็นต้น ดังนั้นตัวแปร start จะคำนวณจาก หน้าที่เราอยู่(หน้าที่เท่าไหร) – 1 * จำนวนแถวข้อมูลต่อหน้า 
    ผมสมมุติว่าอยู่หน้า ที่ 3 แถวข้อมูล แบ่งหน้าละ 10 ดังนั้น จะคำนวณได้ดังนี้ (3-1) * 10 = 20 ฉะนั้นแล้ว ตัวแปร start จะเริ่มที่ 20 */

    $sql = "select id,name,details,price,event from product limit {$start} , {$perpage} ";
    $query = mysqli_query($con, $sql);/*ป็นคำสั่งในการค้นหาข้อมูลเฉพาะหน้าที่เราคลิกนั้นเอง 
    สังเกตุได้จากคำสั่ง litmit $start, $perpage หมายถึง เลือกข้อมูลโดยเริ่มที่ $start ถึง $perpage 
    โดยในตัวอย่างนี้อยู่หน้า 3 ดังนั้นจะมีข้อมูลตำแหน่งแถวที่ 10,11,12,13,14*/ 
    ?>
    <h1 class="title">ข้อมูลสินค้า</h1>
    <div class="This">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($result = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $result['id']; ?></td>
                                <td><?php echo $result['name']; ?></td>
                                <td><?php echo $result['details']; ?></td>
                                <td><?php echo $result['price']; ?></td>
                                <td><?php echo $result['event']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                $sql2 = "select id,name,details,price,event from product ";
                $query2 = mysqli_query($con, $sql2);
                $total_record = mysqli_num_rows($query2);
                $total_page = ceil($total_record / $perpage);
                /*ป็นการ select ข้อมูลทั้งหมดเพื่อ ให้ตัวแปร $total_page เก็บค่าจำนวนหน้า 
                โดยใช้หลักการ หารปัดเศษโดย เอาจำนวนแถวข้อมูลทั้งหมดหารจำนวนหน้า จากตัวอย่างบทความนี้ จะได้เป็น 23/5 
                ปัดหารเศษจะได้จำนวนหน้าทั้งหมดคือ 5 หน้าครับ*/
                ?>

                <nav>
                    <ul class="pagination">
                        <li>
                            <a href="index.php?page=1" aria-label="Previous"> 
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                            <li><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li>
                            <a href="index.php?page=<?php echo $total_page; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div> <!-- /container -->
    <script src="js/javascript.js"></script>
</body>

</html>