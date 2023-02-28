<?php include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>
<html>

<head>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <script>
        async function getDataFromAPI() {
            let response = await fetch('http://localhost/LAND/json-file.json')
            let rawData = await response.text()
            let objectData = JSON.parse(rawData)
            let result = document.getElementById('result')
            for (let i = 0; i < objectData.length; i++) {
                let content = 'ชื่อสินค้า : ' + objectData[i].name + '<br>'
                content += ' ราคา : ' + objectData[i].price + ' <br>'
                content += 'รายละเอียด : ' + objectData[i].detail + '<br>'
                content += 'ใช้ในโอกาส : ' + objectData[i].event + '<br>'

                let li = document.createElement('li')
                li.innerHTML = content
                result.appendChild(li)
            }
        }
        getDataFromAPI()
    </script>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="recom">
        <h1 class="title">สินค้าแนะนำ</h1>

        <div class="box-container">
            <ol id="result"></ol>
        </div>
    </section>
    <section class="box-con">
        <div class="continue">
            <a href="home.php#event" class="option-btn">ซื้อสินค้า</a>
        </div>
    </section>
</body>

</html>