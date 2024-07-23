<?php

require_once 'uaincludes/auconfig_session.php';

function check_login_errors()
{
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error text-danger text-center">' . $error . '</p>';
        }

        unset($_SESSION['errors_login']);
    } elseif (isset($_GET['login']) && $_GET['login'] === "success") {
        echo '<br>';
        echo '<p class="form-success text-success text-center">Login Success </p> ';
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/chaks.png">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">


</head>

<body>
<nav class="navbar navbar-danger fixed-top text-center" style="background-color: #ff8a22;">
        <div class="container-fluid text-center">
            <a class="navbar-brand" href="">
                <img src="assets/img/chaks.png" alt="logo" height="100px" weight="100px">
            </a>
            <h1 class="text-light text-center">Log-In</h1>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-header">

                    <img class="mx-auto d-block" src="assets/img/chaks hi.png" alt="logo" width="250px">

                </div>

                <div class="offcanvas-body">
                    <h2 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Your everyday choice</h2>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">

                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login">Log-In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="signup">Sign-Up</a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </nav>

    <div class="container-md" style="padding-top: 200px; max-width: 600px" >
        <form action="uaincludes/loginua_code" method="post" >
                
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Username:</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="ua_uname" >
            </div>

            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="ua_pswd" >                
            </div>

            <div class="mb-3">
                <label for="table" class="form-label">Table Number</label>
                <input type="number" class="form-control" id="tableNo" placeholder="Enter Table Number" min="1" max="100" name="tableNo" style="width: 200px;" required>   
                              
            </div>

            <!-- <p>Don't have an account? <a href="signup">Signup</a></p> -->

            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </form>
        
        

        <?php
        check_login_errors();
        ?>

    </div>


    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminscripts.js"></script>

</body>

</html>