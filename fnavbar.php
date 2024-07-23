<script src="https://kit.fontawesome.com/4ea76d750b.js" crossorigin="anonymous"></script>

<nav class="navbar navbar-danger fixed-top" style="background-color: #ff8a22;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index">
            <img src="assets/img/chaks.png" alt="logo" height="100px" weight="100px">

        </a>


        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel" style="width: 300px;">
            <div class="offcanvas-header">

                <img class="text-center" src="assets/img/chaks.png" alt="logo" height="200px" weight="200px">

                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>


            </div>

            <div class="offcanvas-body">
                <h3 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Your everyday choice</h3>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item my-3">

                        <i class="fa-sharp fa-solid fa-user"></i><span class="my-3"> <?php echo $_SESSION['use_fullname']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu/">Menu</a>
                    </li>
                    <li class="nav-item">

                        <form action="index" method="post" class="was-validated">


                            <?php
                            if ($_SESSION['addons'] == 'ON') {

                            ?>
                                <input type="text" class="form-control" placeholder="Enter password" name="addonsOFF" value="" hidden>
                                <span>Additional Order: </span><button type="submit" name="update_addonsOff" class="btn btn-danger">OFF</button>

                            <?php
                            } else {
                            ?>
                                <input type="text" class="form-control" placeholder="Enter password" name="addons" value="ON" hidden>
                                <span>Additional Order: </span><button type="submit" name="update_addons" class="btn btn-success">ON</button>

                            <?php
                            }
                            ?>


                        </form>
                    </li>
                    <br>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="uaincludes/logout" type="button">Logout</a>
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