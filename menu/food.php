<?php

session_name('user');
require_once '../uaincludes/auconfig_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:../login');
}

$id = $_GET['id'];

// Store the cipher method
$ciphering = "AES-128-CTR";

// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';
$options = 0;

// Store the decryption key
$decryption_key = "chaks";

// Use openssl_decrypt() function to decrypt the data
$decryption = openssl_decrypt(
    $id,
    $ciphering,
    $decryption_key,
    $options,
    $decryption_iv
);


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Menu</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .bodybg {
            background-image: url("../assets/img/chaks bg2.jpg");
        }
    </style>

</head>

<body class="bodybg">
    <?php include('navbar.php'); ?>

    <div class="container-xl" style="padding-top: 150px; background-color: white">
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <nav class="nav flex-column">
                        <div class="sidenavbar" id="sidenavbar">
                            <?php
                            require_once '../admin/includes/dbcon.php';

                            $sqlimg = "SELECT * FROM `product` WHERE prod_id = $decryption";
                            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                            $stmt = $pdo->prepare($sqlimg);
                            $stmt->execute();
                            $result = $stmt->fetchAll();

                            while ($rowimg = array_shift($result)) {

                                $category = $rowimg['prod_category'];
                            }

                            $sql = "SELECT * FROM `product_category` ORDER BY cat_id";
                            $query = $pdo->prepare($sql);
                            $query->execute();

                            while ($row = $query->fetch()) {

                                if ($row['category'] == $category) {
                                    $act = 'active';
                                } else {
                                    $act = '';
                                }

                            ?>
                                <div class="list-group">
                                    <a href="<?php echo $row['link_name']; ?>" class="list-group-item list-group-item-action <?php echo $act; ?>">
                                        <?php echo $row['category']; ?>
                                    </a>
                                </div>
                            <?php

                            }

                            ?>

                        </div>
                    </nav>
                </div>


            </div>

            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="text-bg-light my-4">
                            <h1><?php echo $category; ?></h1>
                        </div>
                        <?php
                        require_once '../admin/includes/dbcon.php';
                        $sqlimg = "SELECT * FROM `product` WHERE prod_id = $decryption";
                        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        $stmt = $pdo->prepare($sqlimg);
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        while ($rowimg = array_shift($result)) {


                        ?>

                           

                            <form action="../uaincludes/user_addcode" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="prodId" value="<?php echo ($rowimg['prod_id']) ?>">
                                <input type="hidden" name="prodPrice" value="<?php echo ($rowimg['prod_price']) ?>">
                                <input type="hidden" name="useruname" value="<?php echo ($_SESSION['use_username']) ?>">

                                <div class="card text-center shadow p-3 mb-5 rounded" style=" margin-left: auto; margin-right: auto;">
                                    <div class="row">
                                        <div class="col-sm">
                                            <!-- <input type="hidden" name="prod_id" value="<?php echo $rowimg['prod_id']; ?>"> -->

                                            <img src="../admin/assets/image/prodPhoto/<?php echo $rowimg['prod_image']; ?>" class="img-fluid rounded" alt="image" width="500px">

                                        </div>

                                        <div class="col-sm my-4" style="text-align: left;">
                                            <h1 style="font-size: xxx-large; font-weight: bold;"><?php echo $rowimg['prod_name']; ?></h1>

                                            <h1 style="font-size: x-large;font-weight: bold;">Product Description:</h1>
                                            <h1 style="font-size: 18px;font-weight: normal;"><?php echo $rowimg['prod_desc']; ?></h1>
                                            <h1 class="prodprice">₱
                                                <?php echo $rowimg['prod_price']; ?>
                                            </h1>
                                            <br><br><br><br>
                                            <button name="addtocartbtn" type="submit" class="btn btn-warning" style="width: 100%;">ADD TO CART</button>
                                        </div>
                                    </div>


                                </div>
                            </form>



                        <?php

                        }

                        ?>
                    </div>
                    <div class="row text-center">
                    <a href="javascript:history.go(-1)">Go Back</a>
                    </div>
                </div>
            </div>

        </div>
        <?php include('footer.php'); ?>
    </div>




    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>

</body>

</html>