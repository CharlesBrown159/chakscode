<?php

require_once '../includes/config_session.php';


if (!isset($_SESSION['user_id'])) {
    header('location:../index');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Accept Orders</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/image/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/adminstyle.css">

    <style>
        a.five:link {
            color: #ff0000;
            text-decoration: none;
        }

        a.five:visited {
            color: #0000ff;
            text-decoration: none;
        }

        a.five:hover {
            text-decoration: underline;
        }
    </style>


</head>

<body>

    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard">
                <img src="../assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">Accept Orders</h1>


            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" style="width: 300px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-header">

                    <img class="text-center" style="align-items: center;" src="../assets/image/chaks.png" alt="logo" height="200px" weight="200px">

                </div>

                <?php
                require_once 'navbar.php';
                ?>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top: 150px">


        <div class="row">
            <h1 class="text-bg-light my-4">Product/Item's Ordered</h1>

        </div>

        <?php

        $orderID = $_GET['id'];

        require_once '../includes/dbcon.php';
        $uname = $_SESSION['use_username'];

        $sql = "SELECT * FROM `order_prod` WHERE op_orderApproved = '' AND op_id=$orderID";
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        while ($row = array_shift($result)) {

            $user = $row['op_username'];


            $sqlUser = "SELECT * FROM `useraccount` WHERE ua_username = '$user'";
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute();
            $resultUser = $stmtUser->fetchAll();

            while ($rowUser = array_shift($resultUser)) {
                $fname = $rowUser['ua_fullname'];
            }

            $op_id = $row['op_id'];

            $date = $row['op_orderDate'];
        ?>


            <div class="card shadow p-3 mb-5 rounded">
                <div class="row text-end my-3">
                    <h3>Date: <?php echo date_format(date_create($date), 'F j, Y - g:i a'); ?></h3>
                </div>

                <div class="row">

                    <?php

                    $sqlimg = "SELECT * FROM `addtocart` WHERE cart_purchasedId = $orderID";
                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $stmt = $pdo->prepare($sqlimg);
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                    while ($rowimg = array_shift($result)) {

                        $prod_id = $rowimg['cart_productId'];
                    ?>



                        <input type="hidden" name="prodPrice" value="<?php echo ($rowimg['cart_productId']) ?>">


                        <div class="card text-center shadow p-3 mb-4 rounded">
                            <div class="row">

                                <?php

                                $sql = "SELECT * FROM `product` WHERE prod_id = $prod_id";
                                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                                $stmt1 = $pdo->prepare($sql);
                                $stmt1->execute();
                                $result1 = $stmt1->fetchAll();

                                while ($rowImage = array_shift($result1)) {


                                ?>
                                    <div class="col-sm">

                                        <img src="../assets/image/prodPhoto/<?php echo $rowImage['prod_image']; ?>" class="img-fluid rounded" alt="image" width="120px">
                                    </div>
                                    <div class="col-sm">
                                        <h3><?php echo $rowImage['prod_name']; ?></h3>
                                    </div>
                                <?php

                                }

                                ?>

                                <div class="col-sm text-center">
                                    <h3>Quantity:</h3>
                                    <span style="font-size: x-large;"><?php echo ($rowimg['cart_Quantity']) ?></span>
                                </div>
                                <div class="col-sm">
                                    <h3>Price:</h3>
                                    <h3 class="prodprice">₱
                                        <?php echo $rowimg['cart_Price']; ?>
                                    </h3>
                                </div>


                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>


                <div class="row my-4">

                    <div class="col-sm">
                        <h3>Waiter/Waitress: <?php echo $fname; ?></h3>
                    </div>
                    <div class="col-sm">
                        <h3>Table No.: <?php echo $row['op_tableNo']; ?></h3>
                    </div>
                    <div class="col-sm">
                        <h3>Total Quantity: <?php echo $row['op_quantity']; ?></h3>
                    </div>
                    <div class="col-sm">
                        <h3>Total Price: ₱<?php echo $row['op_price']; ?></h3>
                    </div>
                </div>
                <form action="update_codes" method="POST" enctype="multipart/form-data">
                    <div class="row text-end my-3">

                        <input type="hidden" name="opId" value="<?php echo $op_id ?>">
                        <input type="hidden" name="uname" value="<?php echo $uname ?>">
                        <div class="col-sm"></div>
                        <div class="col-sm">

                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Serving Time</label>
                                <select class="form-select" id="inputGroupSelect01" name="servingTime" required="">
                                    <option value="">Choose...</option>
                                    <option value="+1 minutes">Cancel</option>
                                    <option value="+5 minutes">5 minutes</option>
                                    <option value="+10 minutes">10 minutes</option>
                                    <option value="+15 minutes">15 minutes</option>
                                    <option value="+20 minutes">20 minutes</option>
                                    <option value="+25 minutes">25 minutes</option>
                                    <option value="+30 minutes">30 minutes</option>
                                    <option value="+35 minutes">35 minutes</option>
                                    <option value="+40 minutes">40 minutes</option>
                                    <option value="+45 minutes">45 minutes</option>
                                    <option value="+50 minutes">50 minutes</option>
                                    <option value="+55 minutes">55 minutes</option>
                                    <option value="+60 minutes">60 minutes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <button class="btn btn-success btn-lg" type="submit" name="acceptbtn">ACCEPT</button>
                            <button class="btn btn-danger btn-lg" type="submit" name="cancelbtn">CANCEL</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php
        }
        ?>

        <div class="row text-center">
            <a href="javascript:history.go(-1)">Go Back</a>
        </div>

        <div class="row my-5">
            <h1 style="font-size: large;">© 2024 Chaks Chills and Resto, Inc. All rights reserved. </h1>
        </div>

    </div>



    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>

</body>

</html>