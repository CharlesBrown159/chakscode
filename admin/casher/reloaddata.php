<div class="container" style="padding-top: 150px">


        <div class="row">
            <h1 class="text-bg-light my-4">Product/Item's Ordered</h1>
        </div>

        <?php

        $orderID = $_GET['id'];

        require_once '../includes/dbcon.php';
        $uname = $_SESSION['use_username'];

        $sql = "SELECT * FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_id=$orderID";
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        while ($row = array_shift($result)) {

            $op_id = $row['op_id'];

            $date = $row['op_orderDate'];

            $processDate = $row['op_processingTIme'];

            $Username = $row['op_username'];

            $sql_user = "SELECT * FROM `useraccount` WHERE ua_username = '$Username'";
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $stmt_user = $pdo->prepare($sql_user);
            $stmt_user->execute();
            $result_user = $stmt_user->fetchAll();

            while ($row_user = array_shift($result_user)) {

                $Fname = $row_user['ua_fullname'];
            }
        ?>


            <div class="card shadow p-3 mb-5 rounded">

                <div class="row my-3">
                    <span>Serving Time:</span>
                    <h3 class="text-start" id="countdown"></h3>

                    <h4 class="text-end">Date: <?php echo date_format(date_create($date), 'F j, Y - g:i a'); ?></h4>
                </div>

                <div class="row">

                    <?php

                    $sqlimg = "SELECT * FROM `addtocart` WHERE cart_purchasedId = $orderID";
                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $stmt = $pdo->prepare($sqlimg);
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                    while ($rowimg = array_shift($result)) {

                        if ($rowimg['cart_sold'] == '1') {
                            $check = 'checked';
                        } else {
                            $check = '';
                        }



                        $prod_id = $rowimg['cart_productId'];
                    ?>



                        <input type="hidden" name="prodPrice" value="<?php echo ($rowimg['cart_productId']) ?>">


                        <div class="card text-center shadow p-3 mb-4 rounded">
                            <div class="row" id="refreshDiv">

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
                                <div class="col-sm" style="margin: auto;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" style="width: 40px; height: 40px; background-color: green" disabled <?php echo $check; ?>>

                                    </div>
                                </div>
                                



                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>


                <div class="row text-center my-4">
                    <div class="col-sm">
                        <h3>Waiter/Waitress: <?php echo $Fname; ?></h3>
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