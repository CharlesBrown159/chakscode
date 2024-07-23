<?php

require_once '../includes/config_session.php';


if (!isset($_SESSION['user_id'])) {
    header('location:index');
}

if ($_SESSION['approval'] != "APPROVED") {
    echo "<script>alert('Your account needs to be approved by the admin.')</script>";

    echo "<script>
    window.history.go(-1);
</script>";
}

if ($_SESSION['userlevel'] != "kitchen") {

    echo "<script>alert('Your account is not kitchen.')</script>";

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

<body onload="table();">

    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard">
                <img src="../assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">Processing Orders</h1>


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
            <div class="col-sm">
                <h1 class="text-bg-light my-4">Processing Orders</h1>
            </div>
        </div>
        <div class="card text-center shadow p-1 mb-3 rounded">
                <div class="row">
                    <div class="col-sm">
                        <h5>ID</h5>
                    </div>
                    <div class="col-sm">
                        <h5>Waiter/Waitress</h5>
                    </div>
                    <div class="col-sm">
                        <h5>Table No.</h5>
                    </div>
                    <div class="col-sm">
                        <h5>Quantity</h5>
                    </div>
                  
                </div>
            </div>
        <div id="table">

        </div>

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
    <script>
        // function fetchRealtimeData() {
        //     fetch('orders')
        //         .then(response => response.text())
        //         .then(data => {
        //             document.getElementById('updatedata').innerHTML = data;
        //         });
        // }

        // // Fetch data every 5 seconds
        // setInterval(fetchRealtimeData, 5000);

        function table() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("table").innerHTML = this.responseText;
            }
            xhttp.open("GET", "serving");
            xhttp.send();
        }

        setInterval(function() {
            table();
        }, 3000);
    </script>

</body>

</html>