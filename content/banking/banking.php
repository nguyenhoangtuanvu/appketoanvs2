<?php session_start(); 
if(!isset($_SESSION["logged"])) {
    header("location:/AppketoanVS2/login.php");
}
?>
<?php 
include '../../connect_db.php';
// tổng thu cả năm
    $queryRevenuYear = mysqli_query($con, "SELECT YEAR(dateTime), `totalMoney`  FROM `sales` ORDER BY `sales`.`dateTime` ASC");
    $revenuYear = 0;
    $now = getdate();
    while($row = mysqli_fetch_array($queryRevenuYear)) {
        if($row['YEAR(dateTime)'] == $now['year']) {
            $revenuYear += $row['totalMoney'];
        }
    }
    // tổng chi cả năm
    $queryCostYear = mysqli_query($con, "SELECT YEAR(dateTime), `quantity`, `price`  FROM `purchase` ORDER BY `purchase`.`dateTime` ASC");
    $CostYear = 0;
    while($row = mysqli_fetch_array($queryCostYear)) {
        $totalMoney = $row['quantity'] * $row['price'];
        if($row['YEAR(dateTime)'] == $now['year'])
        $CostYear += $totalMoney;
    }
    // tồn tiền cả năm
    $queryExistYear = mysqli_query($con, "SELECT YEAR(dateTime), `budget`  FROM `budget` ORDER BY `budget`.`dateTime` ASC");
    $ExistYear = 0;
    while($row = mysqli_fetch_array($queryExistYear)) {
        if($row['YEAR(dateTime)'] == $now['year']) {
            $ExistYear += $row['budget'];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.0.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500&family=Roboto&display=swap" rel="stylesheet">
    <title>Kế Toán</title>
</head>
<body>
    <div class="grid">
        <?php include '../../sidebar.php' ?>
        <div class="container">
            <!-- header -->
            <?php include '../../header.php'; ?>
            <!-- navigation start -->
            <div class="navigation">
                <div class="nav-banking nav-function nav--open-sidebar">
                    <ul class="nav-list">
                        <a href="?bankingNav=bankingFirst" class="nav-link">
                            <li class="nav-items banking-nav nav-items--active"><?= $main['Quy trình'] ?> </li></a>
                        <a href="?bankingNav=bankingSecond" class="nav-link">
                            <li class="nav-items banking-nav"><?= $main['Thu, chi tiền'] ?> </li></a>
                        <a href="?bankingNav=bankingThird" class="nav-link">
                            <li class="nav-items banking-nav"><?= $main['Báo cáo'] ?></li></a>
                    </ul>
                </div>
            </div>
            <!-- navigation end -->

            <!-- content -->
            <div class="content">
                <div class="content-wrapper banking sidebar--open">
                <?php
                        if(isset($_GET['bankingNav'])&&($_GET['bankingNav'])!=''){
                            $tam= $_GET['bankingNav'];
                        }else {
                            $tam = 'bankingFirst';
                        }if($tam == 'bankingFirst'){
                            include('first_function.php');
                        }elseif($tam == 'bankingSecond'){
                            include('second_function.php');
                        }elseif($tam == 'bankingThird'){
                            include('third_function.php');
                        }
                    ?>
                </div>
    <script type="text/javascript" src="../../assets/JS/script.js"></script>
    <!-- <script type="text/javascript">
        var costMonth = <?php json_encode($CostMonth); ?>;
        console.log(costMonth);
    </script> -->

    <script>
var boxFunction = document.getElementsByClassName("open--box-function");

var overlay2 = document.querySelector('.overlay-not-color');
var boxFunctionDropdownList = document.querySelectorAll(".third-table-function-list");

for(let i = 0; i < boxFunction.length; i++) {
    boxFunction[i].addEventListener('click', function() {
        overlay2.classList.remove('overlay--active');
        for(let j = 0; j < boxFunctionDropdownList.length; j++) {
            boxFunctionDropdownList[j].classList.remove("dropdown-list--active");
            if(i == j) {
                boxFunctionDropdownList[j].classList.add("dropdown-list--active");
                overlay2.classList.add('overlay--active');
            }
        }
    })
    overlay2.addEventListener('click', function() {
        for(let a = 0; a < boxFunctionDropdownList.length; a++) {
            console.log('over2')
            boxFunctionDropdownList[i].classList.remove("dropdown-list--active");
            overlay2.classList.remove('overlay--active');
        }
    });
}


    </script>
</body>
</html>