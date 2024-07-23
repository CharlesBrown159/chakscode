<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<nav class="navbar navbar-danger fixed-top" style="background-color: #ff8a22;">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index">
            <img src="../assets/img/chaks.png" alt="logo" height="100px" weight="100px">

        </a>
        <?php

        $uname = $_SESSION['use_username'];

        require_once '../admin/includes/dbcon.php';
        $tableNo = $_SESSION['tableNo'];
        $sql = "SELECT COUNT(cart_id) as total FROM `addtocart` WHERE cart_username = '$uname' AND cart_purchasedId = '0' AND cart_tableNo = '$tableNo'";
        $query = $pdo->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();



        ?>
        <a class="text-end btn text-light" type="button" style="font-size: 29px; background-color:#ff8a22; border: 1px solid black;" href="../cart">
            <i class="fa fa-shopping-cart" style="font-size:30px; color: black"></i> <span class="badge bg-danger"><?php echo $fetch['total']; ?></span>

        </a>




        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-light" style="width: 300px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">

            <div class="offcanvas-header">

                <img class="text-center" src="../assets/img/chaks.png" alt="logo" height="200px" weight="200px">

                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>


            </div>

            <div class="offcanvas-body">
                <h3 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Your everyday choice</h3>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">

                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="pork">Pork</a></li>
                            <li><a class="dropdown-item" href="chicken">Chicken</a></li>
                            <li><a class="dropdown-item" href="wow_seafood">Wow Seafood</a></li>
                            <li><a class="dropdown-item" href="pasta_noodles">Pasta/Noodles</a></li>
                            <li><a class="dropdown-item" href="soup">Soup</a></li>
                            <li><a class="dropdown-item" href="appetizers">Appetizers</a></li>
                            <li><a class="dropdown-item" href="vegetables">Vegetables</a></li>
                            <li><a class="dropdown-item" href="rice">Rice</a></li>
                            <li><a class="dropdown-item" href="drinks">Drinks</a></li>
                            <li><a class="dropdown-item" href="shake">Shake</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../uaincludes/logout">Logout</a>
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