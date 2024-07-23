<?php

session_name('user');
require_once 'uaincludes/auconfig_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:login');
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Menu</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .bodybg {
            background-image: url("assets/img/chaks bg2.jpg");
        }
    </style>

</head>

<body class="bodybg">
    <script src="https://kit.fontawesome.com/4ea76d750b.js" crossorigin="anonymous"></script>

    <nav class="navbar navbar-danger fixed-top" style="background-color: #ff8a22;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <img src="assets/img/chaks.png" alt="logo" height="100px" weight="100px">

            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel" style="width: 300px;">
                <div class="offcanvas-header">

                    <img class="text-center" src="assets/img/chaks.png" alt="logo" height="200px" weight="200px">

                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>


                </div>

                <div class="offcanvas-body">
                    <h3 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Your everyday choice</h3>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item my-3">

                            <i class="fa-sharp fa-solid fa-user"></i><span class="my-3"> <?php echo $_SESSION['use_fullname']; ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu/">Menu</a>
                        </li>
                       
                        <br>
                        <li class="nav-item">
                            <a class="btn btn-danger" href="uaincludes/logout" type="button">Logout</a>
                        </li>
                    </ul>
                    <!-- <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success" type="submit">Search</button>
                    </form> -->
                </div>
            </div>
        </div>
    </nav>


    <div class="container-xl" style="padding-top: 150px; background-color: white">
        <div class="row">

            <div class="col-sm-3">
                <nav class="nav flex-column">
                    <div class="sidenavbar" id="sidenavbar">
                        <?php
                        require_once 'admin/includes/dbcon.php';
                        $sql = "SELECT * FROM `product_category` ORDER BY cat_id";
                        $query = $pdo->prepare($sql);
                        $query->execute();

                        while ($row = $query->fetch()) {
                        ?>
                            <div class="list-group">

                                <!-- <form action="<?php echo $row['link_name']; ?>" method="POST">
                               
                                    
                                    <button type="submit" class="list-group-item list-group-item-action ">
                                        <?php echo $row['category']; ?>
                                    </button>
                                </form> -->

                                <a href="menu/<?php echo $row['link_name']; ?>" class="list-group-item list-group-item-action ">
                                    <?php echo $row['category']; ?>
                                </a>

                            </div>
                        <?php

                        }

                        ?>

                    </div>
                </nav>


            </div>

            <div class="col-sm">
                <div class="container">


                    <div class="row">
                        <h1 class="text-bg-light my-4">Your cart</h1>
                    </div>

                    <div id="myCart">
                        <?php

                        $uname = $_SESSION['use_username'];
                        $tableNo = $_SESSION['tableNo'];
                        require_once 'admin/includes/dbcon.php';
                        $sqlimg = "SELECT * FROM `addtocart` WHERE cart_username = '$uname' AND cart_purchasedId = '0' AND cart_tableNo = '$tableNo'";
                        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        $stmt = $pdo->prepare($sqlimg);
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        while ($rowimg = array_shift($result)) {

                            $prod_id = $rowimg['cart_productId'];
                        ?>



                            <input type="hidden" name="prodPrice" value="<?php echo ($rowimg['cart_productId']) ?>">


                            <div class="card text-center shadow p-3 mb-5 rounded">
                                <div class="row">

                                    <?php

                                    $sql = "SELECT * FROM `product` WHERE prod_id = $prod_id";
                                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                                    $stmt1 = $pdo->prepare($sql);
                                    $stmt1->execute();
                                    $result1 = $stmt1->fetchAll();

                                    while ($row = array_shift($result1)) {


                                    ?>
                                        <div class="col-sm">

                                            <img src="admin/assets/image/prodPhoto/<?php echo $row['prod_image']; ?>" class="img-fluid rounded" alt="image" width="150px">
                                        </div>
                                        <div class="col-sm">

                                            <h3><?php echo $row['prod_name']; ?></h3>

                                        </div>

                                    <?php

                                    }

                                    ?>

                                    <div class="col-sm text-center">
                                        <h3>Quantity:</h3>
                                        <form id="addquant">
                                            <!-- action="uaincludes/user_editcode" method="POST" enctype="multipart/form-data"  -->
                                            <input type="hidden" name="add_cartId" id="add_cartId" value="<?php echo ($rowimg['cart_id']) ?>">
                                            <button type="submit" class="btn btn-secondary btn-sm">+</button>
                                        </form>

                                        <span style="font-size: x-large;"><?php echo ($rowimg['cart_Quantity']) ?></span>
                                        <form id="subquant">
                                            <input type="hidden" name="sub_cartId" id="sub_cartId" value="<?php echo ($rowimg['cart_id']) ?>">
                                            <button type="submit" id="subbtn" class="btn btn-secondary btn-sm">-</button>

                                        </form>

                                    </div>
                                    <div class="col-sm">
                                        <h3>Price:</h3>
                                        <h1 class="prodprice">₱
                                            <?php echo $rowimg['cart_Price']; ?>
                                        </h1>
                                    </div>

                                    <div class="col-sm-1">
                                        <form action="uaincludes/user_deletecode" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="cartId" value="<?php echo ($rowimg['cart_id']) ?>">
                                            <button type="submit" name="delCart" class="btn-close btn-close-dark" aria-label="Close" onclick="return confirm('Are you sure you want to Remove this?')"></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>

                    <form action="uaincludes/user_addcode" method="POST" enctype="multipart/form-data">
                        <?php
                        $uname = $_SESSION['use_username'];
                        $tableNo = $_SESSION['tableNo'];
                        $statement = $pdo->prepare("SELECT COUNT(cart_id) FROM addtocart WHERE cart_username = '$uname' AND cart_purchasedId = '0' AND cart_tableNo = '$tableNo'");
                        $statement->execute();
                        $count = $statement->fetchColumn();


                        if ($count != '0') {
                        ?>

                            <div class="row" id="total">

                                <div class="col-sm"></div>
                                <div class="col-sm text-center">

                                    <?php

                                    $unamequant = $_SESSION['use_username'];
                                    $sqlquant = "SELECT sum(cart_Quantity) FROM `addtocart` WHERE cart_username = '$unamequant' AND cart_purchasedId = '0' AND cart_tableNo = '$tableNo'";
                                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                                    $stmtquant = $pdo->prepare($sqlquant);
                                    $stmtquant->execute();
                                    $resultquant = $stmtquant->fetchAll();

                                    while ($rowquant = array_shift($resultquant)) {

                                    ?>
                                        <input type="hidden" name="totalqty" value="<?php echo $rowquant['sum(cart_Quantity)']; ?>">
                                        <h3>Total Quantity: <?php echo $rowquant['sum(cart_Quantity)']; ?></h3>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-sm text-center">

                                    <?php

                                    $unamequant = $_SESSION['use_username'];
                                    $sqlquant = "SELECT sum(cart_Price) FROM `addtocart` WHERE cart_username = '$unamequant' AND cart_purchasedId = '0' AND cart_tableNo = '$tableNo'";
                                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                                    $stmtquant = $pdo->prepare($sqlquant);
                                    $stmtquant->execute();
                                    $resultquant = $stmtquant->fetchAll();

                                    while ($rowquant = array_shift($resultquant)) {

                                    ?>
                                        <input type="hidden" name="totalprice" value="<?php echo $rowquant['sum(cart_Price)']; ?>">
                                        <h3>Total Price: <p class="text-danger"> ₱ <?php echo $rowquant['sum(cart_Price)']; ?></p>
                                        </h3>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm text-center">
                                    <input type="hidden" name="username" value="<?php echo $_SESSION['use_username']; ?>">
                                    <button type="submit" name="btnOrder" class="btn btn-warning btn-block" style="width: 200px;height: 50px;font-size:x-large" onclick="return confirm('Are you sure you want to Order Now?')">Order now!</button>
                                </div>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="row">
                                <h1 class="text-secondary">Your Cart is Empty!!</h1>
                            </div>
                        <?php
                        }
                        ?>

                    </form>

                </div>
            </div>

        </div>
        <?php include('menu/footer.php'); ?>
    </div>




    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script>
        $(document).on('submit', '#addquant', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("add_quantity", true);

            $.ajax({
                type: "POST",
                url: "uaincludes/user_editcode",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {

                    } else if (res.status == 200) {

                        $('#myCart').load(location.href + " #myCart");
                        $('#total').load(location.href + " #total");

                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });


        });

        $(document).on('submit', '#subquant', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("sub_quantity", true);

            $.ajax({
                type: "POST",
                url: "uaincludes/user_editcode",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {

                    } else if (res.status == 200) {

                        $('#myCart').load(location.href + " #myCart");
                        $('#total').load(location.href + " #total");

                    } else if (res.status == 500) {
                        alert(res.message);
                    }
                }
            });


        });



        // function subtractQuantity() {
        //     let quantityElement = document.getElementById('quantity');
        //     let currentQuantity = parseInt(quantityElement.innerText);
        //     if (currentQuantity > 1) {
        //         quantityElement.innerText = currentQuantity - 1;
        //     }
        // }

        // function addQuantity() {
        //     let quantityElement = document.getElementById('quantity');
        //     let currentQuantity = parseInt(quantityElement.innerText);
        //     quantityElement.innerText = currentQuantity + 1;
        // }
    </script>
</body>

</html>