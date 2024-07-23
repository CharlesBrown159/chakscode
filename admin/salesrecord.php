<?php

require_once 'includes/config_session.php';


if (!isset($_SESSION['user_id'])) {
    header('location:index');
}

if ($_SESSION['approval'] != "APPROVED") {
    echo "<script>alert('Your account needs to be approved by the admin.')</script>";

    echo "<script>
    window.history.go(-1);
</script>";
}

if ($_SESSION['userlevel'] != "admin") {

    echo "<script>alert('Your account is not admin.')</script>";

    echo "<script>
    
    window.history.go(-1);
</script>";
}

if (isset($_POST['filterDate'])) {

    $_SESSION['fromdate'] = $_POST['fromdate'];
    $_SESSION['todate'] = $_POST['todate'];
}

if (isset($_POST['clearfilter'])) {

    $_SESSION['fromdate'] = '';
    $_SESSION['todate'] = '';
}

if (!isset($_SESSION['fromdate'])) {
    $_SESSION['fromdate'] = '';
}

if (!isset($_SESSION['todate'])) {
    $_SESSION['todate'] = '';
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Accept Orders</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/image/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/adminstyle.css">

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
                <img src="assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">Sales Record</h1>


            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" style="width: 300px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-header">

                    <img class="text-center" style="align-items: center;" src="assets/image/chaks.png" alt="logo" height="200px" weight="200px">

                </div>

                <?php
                require_once 'navbar.php';
                ?>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top: 150px">
        <div class="row">
            <div class="col-sm">
                <h1 class="text-bg-light my-4">Sales</h1>
            </div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm text-left form-group">
                    <label>From Date:</label>
                    <input type="date" name="fromdate" class="form-control" value="<?php echo $_SESSION['fromdate']; ?>" required>
                    <br>

                </div>
                <div class="col-sm text-left form-group">
                    <label>To Date:</label>
                    <input type="date" name="todate" class="form-control" value="<?php echo $_SESSION['todate']; ?>" required><br>

                </div>
                <div class="col-sm-8">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="filterDate">Click to filter date</button>
                </div>
            </div>
        </form>

        <div class="row">
            <form action="" method="POST" enctype="multipart/form-data">
                
                <input type="submit" class="btn btn-secondary btn-block" name="clearfilter" value="Click to clear filter">

            </form>
        </div>




        <div class="row text-end">

            <?php

            $fromdates = $_SESSION['fromdate'];
            $todates = $_SESSION['todate'];

            if ($fromdates != '') {
                require_once 'includes/dbcon.php';
                $unamequant = $_SESSION['use_username'];
                $sqlquant = "SELECT sum(op_price) FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED' AND op_orderDate BETWEEN '$fromdates' AND '$todates'";
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $stmtquant = $pdo->prepare($sqlquant);
                $stmtquant->execute();
                $resultquant = $stmtquant->fetchAll();

                while ($rowquant = array_shift($resultquant)) {

            ?>
                    <input type="hidden" name="totalprice" value="<?php echo $rowquant['sum(op_price)']; ?>">
                    <h3>Total Sales: <span class="text-danger"> ₱ <?php echo number_format($rowquant['sum(op_price)'], 2, '.', ','); ?></span>
                    </h3>
                <?php
                }
            } else {
                require_once 'includes/dbcon.php';
                $unamequant = $_SESSION['use_username'];
                $sqlquant = "SELECT sum(op_price) FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED'";
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $stmtquant = $pdo->prepare($sqlquant);
                $stmtquant->execute();
                $resultquant = $stmtquant->fetchAll();

                while ($rowquant = array_shift($resultquant)) {

                ?>
                    <input type="hidden" name="totalprice" value="<?php echo $rowquant['sum(op_price)']; ?>">
                    <h3>Total Sales: <span class="text-danger"> ₱ <?php echo number_format($rowquant['sum(op_price)'], 2, '.', ','); ?></span>
                    </h3>
            <?php
                }
            }
            ?>

        </div>

        <div class="card text-center shadow p-1 mb-3 rounded">
            <div class="row">
                <div class="col-sm">
                    <h5>ID</h5>
                </div>
                <div class="col-sm">
                    <h5>Waiter/tress</h5>
                </div>
                <div class="col-sm">
                    <h5>Quantity</h5>
                </div>
                <div class="col-sm">
                    <h5>Price</h5>
                </div>
                <div class="col-sm">
                    <h5>Date</h5>
                </div>
            </div>
        </div>

        <?php
        $fromdates = $_SESSION['fromdate'];
        $todates = $_SESSION['todate'];

        if ($fromdates != '') {

            if ($fromdates > $todates) {
                echo "<script>alert('Please Select \"To Date\" as Greater Than \"From Date\"!')</script>";
                // include('filterDatapb.php');
            } else {

                // Enter your Host, username, password, database below.
                $con = mysqli_connect("localhost", "root", "", "chaksdata");
                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    die();
                }

                if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                    $page_no = $_GET['page_no'];
                } else {
                    $page_no = 1;
                }
                $total_records_per_page = 10;

                $offset = ($page_no - 1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;
                $adjacents = "2";

                $result_count = mysqli_query(
                    $con,
                    "SELECT COUNT(*) As total_records FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED' AND op_orderDate BETWEEN '$fromdates' AND '$todates' "
                );
                $total_records = mysqli_fetch_array($result_count);
                $total_records = $total_records['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                $second_last = $total_no_of_pages - 1; // total pages minus 1

                $result = mysqli_query(
                    $con,
                    "SELECT * FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED' AND op_orderDate BETWEEN '$fromdates' AND '$todates' LIMIT $offset, $total_records_per_page"
                );
                while ($row = mysqli_fetch_array($result)) {
                    $op_id = $row['op_id'];
                    echo "<a href='purchasedata?id=$op_id' class='five'>
            <div class='card text-center shadow p-1 mb-3 rounded'>
            <div class='row'>
            <div class='col-sm'>
             <h5>" . $row['op_id'] . "</h5>
             </div>
             <div class='col-sm'>
             <h5>" . $row['op_username'] . "</h5>
                 </div>
              <div class='col-sm'>
             <h5>" . $row['op_quantity'] . "</h5>
              </div>
              <div class='col-sm'>
             <h5>" . $row['op_price'] . "</h5>
              </div>                            
               <div class='col-sm'>
             <h5>" . date('M d, Y', strtotime($row['op_orderDate'])) . "</h5>
             </div>
             </div>
             </div></a>";
                }
                mysqli_close($con);

        ?>
                <div>

                </div>


                <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                    <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                </div>


                <div class="row">
                    <ul class="pagination">
                        <?php if ($page_no > 1) {
                            echo "<li class='page-item'><a class='page-link' href='?page_no=1'>First Page</a></li>";
                        } ?>

                        <li class='page-item <?php if ($page_no <= 1) {
                                                    echo "disabled";
                                                } ?>'>
                            <a class='page-link' <?php if ($page_no > 1) {
                                                        echo "href='?page_no=$previous_page'";
                                                    } ?>>Previous</a>
                        </li>
                        <?php
                        if ($total_no_of_pages <= 10) {
                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                        } elseif ($total_no_of_pages > 10) {
                            // Here we will add further conditions
                        }

                        ?>
                        <li class='page-item <?php if ($page_no >= $total_no_of_pages) {
                                                    echo " disabled";
                                                } ?>'>
                            <a class='page-link' <?php if ($page_no < $total_no_of_pages) {
                                                        echo "href='?page_no=$next_page'";
                                                    } ?>>Next</a>
                        </li>

                        <?php if ($page_no < $total_no_of_pages) {
                            echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                        } ?>

                    </ul>
                </div>

            <?php


            }
        } else {

            // Enter your Host, username, password, database below.
            $con = mysqli_connect("localhost", "root", "", "chaksdata");
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                die();
            }

            if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                $page_no = $_GET['page_no'];
            } else {
                $page_no = 1;
            }
            $total_records_per_page = 25;

            $offset = ($page_no - 1) * $total_records_per_page;
            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;
            $adjacents = "2";

            $result_count = mysqli_query(
                $con,
                "SELECT COUNT(*) As total_records FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED' "
            );
            $total_records = mysqli_fetch_array($result_count);
            $total_records = $total_records['total_records'];
            $total_no_of_pages = ceil($total_records / $total_records_per_page);
            $second_last = $total_no_of_pages - 1; // total pages minus 1

            $result = mysqli_query(
                $con,
                "SELECT * FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED' LIMIT $offset, $total_records_per_page"
            );
            while ($row = mysqli_fetch_array($result)) {
                $op_id = $row['op_id'];
                echo "<a href='purchasedata?id=$op_id' class='five'>
        <div class='card text-center shadow p-1 mb-3 rounded'>
        <div class='row'>
        <div class='col-sm'>
         <h5>" . $row['op_id'] . "</h5>
         </div>
         <div class='col-sm'>
         <h5>" . $row['op_username'] . "</h5>
             </div>
          <div class='col-sm'>
         <h5>" . $row['op_quantity'] . "</h5>
          </div>
          <div class='col-sm'>
         <h5>" . $row['op_price'] . "</h5>
          </div>                            
           <div class='col-sm'>
         <h5>" . date('M d, Y', strtotime($row['op_orderDate'])) . "</h5>
         </div>
         </div>
         </div></a>";
            }
            mysqli_close($con);

            ?>

            <div>
                <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
            </div>



            <div class="row">
                <ul class="pagination">
                    <?php if ($page_no > 1) {
                        echo "<li class='page-item'><a class='page-link' href='?page_no=1'>First Page</a></li>";
                    } ?>

                    <li class='page-item <?php if ($page_no <= 1) {
                                                echo "disabled";
                                            } ?>'>
                        <a class='page-link' <?php if ($page_no > 1) {
                                                    echo "href='?page_no=$previous_page'";
                                                } ?>>Previous</a>
                    </li>
                    <?php
                    if ($total_no_of_pages <= 10) {
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                            if ($counter == $page_no) {
                                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                            }
                        }
                    } elseif ($total_no_of_pages > 10) {
                        // Here we will add further conditions
                    }

                    ?>
                    <li class='page-item <?php if ($page_no >= $total_no_of_pages) {
                                                echo " disabled";
                                            } ?>'>
                        <a class='page-link' <?php if ($page_no < $total_no_of_pages) {
                                                    echo "href='?page_no=$next_page'";
                                                } ?>>Next</a>
                    </li>

                    <?php if ($page_no < $total_no_of_pages) {
                        echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                    } ?>



                </ul>
            </div>

        <?php


        }


        ?>



        <div class="row text-end">

            <?php

            $fromdates = $_SESSION['fromdate'];
            $todates = $_SESSION['todate'];

            if ($fromdates != '') {
                require_once 'includes/dbcon.php';
                $unamequant = $_SESSION['use_username'];
                $sqlquant = "SELECT sum(op_price) FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED' AND op_orderDate BETWEEN '$fromdates' AND '$todates'";
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $stmtquant = $pdo->prepare($sqlquant);
                $stmtquant->execute();
                $resultquant = $stmtquant->fetchAll();

                while ($rowquant = array_shift($resultquant)) {

            ?>
                    <input type="hidden" name="totalprice" value="<?php echo $rowquant['sum(op_price)']; ?>">
                    <h3>Total Sales: <span class="text-danger"> ₱ <?php echo number_format($rowquant['sum(op_price)'], 2, '.', ','); ?></span>
                    </h3>
                <?php
                }
            } else {
                require_once 'includes/dbcon.php';
                $unamequant = $_SESSION['use_username'];
                $sqlquant = "SELECT sum(op_price) FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = 'SERVED'";
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $stmtquant = $pdo->prepare($sqlquant);
                $stmtquant->execute();
                $resultquant = $stmtquant->fetchAll();

                while ($rowquant = array_shift($resultquant)) {

                ?>
                    <input type="hidden" name="totalprice" value="<?php echo $rowquant['sum(op_price)']; ?>">
                    <h3>Total Sales: <span class="text-danger"> ₱ <?php echo number_format($rowquant['sum(op_price)'], 2, '.', ','); ?></span>
                    </h3>
            <?php
                }
            }
            ?>

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