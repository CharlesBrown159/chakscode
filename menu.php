<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">


</head>

<body>
    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <img src="assets/img/chaks.png" alt="logo" height="100px" weight="100px">
            
            </a> 
            
           
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">

                    <img class="text-center" src="assets/img/chaks.png" alt="logo" height="200px" weight="200px">

                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>


                </div>

                <div class="offcanvas-body">
                    <h2 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Your everyday choice</h2>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">

                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
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

    <div class="container">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; <img class="text-center"
                src="assets/img/chaks.png" alt="logo" height="80px" weight="80px"></span>
        <h2>Sidenav Push Example</h2>
        <p>Click on the element below to open the side navigation menu, and push this content to the right. Notice that
            we add a black see-through background-color to body when the sidenav is opened.</p>

        <div class="row my-5">
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
            <div class="col-sm-6">
                <img src="assets/img/gift.jpg" alt="" width="100%">
            </div>
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