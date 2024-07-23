<?php

require_once 'includes/config_session.php';
require_once 'includes/login_view.php';

if (isset($_SESSION["login_data"]["uname"])) {
    $uname = $_SESSION["login_data"]["uname"];
} else {
    $uname = "";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chaks | Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/image/chaks.png">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/adminstyle.css">


</head>

<body>
    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <img src="assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">Log-In</h1>


            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" style="width: 300px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">

                    <img class="text-center" src="assets/image/chaks.png" alt="logo" height="200px" weight="200px">

                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                </div>

                <div class="offcanvas-body">
                    <h3 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Your everyday choice</h3>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                        <li class="nav-item">
                            <a class="nav-link active text-light" aria-current="page" href="index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
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

    <div class="container-md" style="padding-top: 200px">
        <div class="row">
            <div class="col-sm">

            </div>

            <div class="col-sm-5">
                <form action="includes/login_code" method="post" class="was-validated">

                    <div class="mb-3 mt-3">
                        <label for="uname" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" value="<?php echo $uname; ?>">

                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">

                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <p>Don't have an account? <a href="signup">Signup</a></p>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <div class="col-sm">

            </div>

        </div>


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