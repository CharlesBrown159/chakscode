<?php 
session_name('user');
require_once '../uaincludes/auconfig_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:../login');
}

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
                            $sql = "SELECT * FROM `product_category` ORDER BY cat_id";
                            $query = $pdo->prepare($sql);
                            $query->execute();

                            while ($row = $query->fetch()) {

                                if ($row['category'] == 'Wow Seafood') {
                                    $act = 'active';
                                } else {
                                    $act = '';
                                }

                            ?>
                            <div class="list-group">
                                <a href="<?php echo $row['link_name']; ?>"
                                    class="list-group-item list-group-item-action <?php echo $act; ?>">
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
                            <h1 >Wow Seafood</h1>
                        </div>

                        <?php
                        require_once '../admin/includes/dbcon.php';
                        $sqlimg = "SELECT * FROM `product` WHERE prod_category = 'Wow Seafood' ORDER BY prod_datecreated";
                        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        $stmt = $pdo->prepare($sqlimg);
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        while ($rowimg = array_shift($result)) {

                        ?>
                        <?php include('dataDisplay.php'); ?>

                        <?php

                        }

                        ?>
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