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

       

        <div class="search-panel">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="keywords" placeholder="Type keywords..." onkeyup="searchFilter();">
                </div>
                <!-- <div class="form-group col-md-4">
                    <select class="form-control" id="filterBy" onchange="searchFilter();">
                        <option value="">Filter by Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div> -->
            </div>
        </div>

        <?php
        // Include pagination library file 
        include_once 'Pagination.class.php';

        // Include database configuration file 
        require_once 'dbConfig.php';

        // Set some useful configuration 
        $baseURL = 'getData.php';
        $limit = 10;

        // Count of all records 
        $query   = $db->query("SELECT COUNT(*) as rowNum FROM order_prod");
        $result  = $query->fetch_assoc();
        $rowCount = $result['rowNum'];

        // Initialize pagination class 
        $pagConfig = array(
            'baseURL' => $baseURL,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'contentDiv' => 'dataContainer',
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);

        // Fetch records based on the limit 
        $query = $db->query("SELECT * FROM order_prod ORDER BY op_id LIMIT $limit");
        ?>

        <div class="datalist-wrapper">
            <!-- Loading overlay -->
            <div class="loading-overlay">
                <div class="overlay-content">Loading...</div>
            </div>

            <!-- Data list container -->
            <div id="dataContainer">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query->num_rows > 0) {

                            while ($row = $query->fetch_assoc()) {

                        ?>
                                <tr>
                                    <th scope="row"><?php echo $row["op_id"]; ?></th>
                                    <td><?php echo $row["op_username"]; ?></td>
                                    <td><?php echo $row["op_quantity"]; ?></td>
                                    <td><?php echo $row["op_price"]; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['op_orderDate'])); ?></td>

                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6">No records found...</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Display pagination links -->
                <?php echo $pagination->createLinks(); ?>
            </div>
        </div>





        <div class="row my-5">
            <h1 style="font-size: large;">© 2024 Chaks Chills and Resto, Inc. All rights reserved. </h1>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Javascript -->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        function searchFilter(page_num) {
            page_num = page_num ? page_num : 0;
            var keywords = $('#keywords').val();
            // var filterBy = $('#filterBy').val();
            $.ajax({
                type: 'POST',
                url: 'getData.php',
                data: 'page=' + page_num + '&keywords=' + keywords  ,
                beforeSend: function() {
                    $('.loading-overlay').show();
                },
                success: function(html) {
                    $('#dataContainer').html(html);
                    $('.loading-overlay').fadeOut("slow");
                }
            });
        }
    </script>



</body>

</html>