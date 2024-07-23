<?php



// require_once 'includes/config_session.php';

require_once 'includes/dbcon.php';



function check_product_errors()
{
    if (isset($_SESSION['errors_product'])) {
        $errors = $_SESSION['errors_product'];
        $error = [];

        echo '<br>';

        foreach ($errors as $error) {
            echo '<p class="form-error text-danger text-center">' . $error . '</p>';
            echo "<script>alert(' $error ')</script>";
        }



        unset($_SESSION['errors_product']);
    } else if (isset($_GET["addproduct"]) && $_GET["addproduct"] === "success") {

        echo '<br>';
        echo "<script>alert(' Successfully Added! ')</script>";
    }
}

session_start();
if (!isset($_SESSION['expire'])) {
    $_SESSION['expire'] = null;
}


$now = time();


if ($now > $_SESSION['expire']) {

    unset($_SESSION['validateerrors']);

    if (empty($_SESSION['validateerrors'])) {
    } else {
        echo '<meta http-equiv="refresh" content="1">';
    }
}




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
    <title>Chaks | List of Product</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/image/chaks.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/adminstyle.css">
    <script>

    </script>


</head>

<body>
    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard">
                <img src="assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">List of Product/Items</h1>


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
                require 'navbar.php';
                ?>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="padding-top: 150px">

        <div class="row my-5">
            <?php
            if (isset($_SESSION['validateerrors'])) {
                $validateTxt = $_SESSION['validateerrors'];
            } else {
                $validateTxt = '';
            }
            echo $validateTxt;
            ?>
            <div class="col-sm">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add Product</button>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalCat">Add Category</button>

            </div>
            <div class="col-sm"></div>

        </div>

        <div class="row">
            <table class="table table-dark table-striped table-bordered" id="dataTable" width="100%" cellspacing="0%">
                <thead>
                    <tr>
                        <th style="width: 8%; text-align:center;">Product ID</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'includes/dbcon.php';
                    $sql = "SELECT * FROM `product` ORDER BY prod_id DESC";
                    $query = $pdo->prepare($sql);
                    $query->execute();

                    while ($row = $query->fetch()) {


                    ?>

                        <tr class="table" style="max-height: 200px;">
                            <td><?php echo $row['prod_id']; ?></td>
                            <td><?php echo $row['prod_name']; ?></td>
                            <td><img src="assets/image/prodPhoto/<?php echo $row['prod_image']; ?>" style="max-width:200px;"></td>
                            <td><?php echo $row['prod_desc']; ?></td>
                            <td><?php echo $row['prod_category']; ?></td>
                            <td>₱<?php echo $row['prod_price']; ?></td>

                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatemyModal<?php echo $row['prod_id']; ?>">Update</button>

                                <br>
                                <form action="includes/delete_codes" method="POST">
                                    <input type="hidden" name="delete_id_product" value="<?php echo $row['prod_id']; ?>">
                                    <button type="submit" name="delete_btn_product" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to Delete this Product?')">DELETE</button>
                                </form>
                                <br>

                            </td>
                        </tr>

                        <!-- UPDATE Modal xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->
                        <div class="modal" id="updatemyModal<?php echo $row['prod_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update Product</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group mb-3">

                                                <div class="mb-3 text-center">
                                                    <h3>Old Photo</h3>
                                                    <div style="width: 200px; max-height: 200px; overflow: hidden; background: #cccccc; margin: 0 auto">
                                                        <img src="assets/image/prodPhoto/<?php echo $row['prod_image']; ?>" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                                <br>
                                                <form action="includes/update_codes" method="post" enctype="multipart/form-data" class="mb-3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="text-center">Change Image</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="custom-file">
                                                                <div class="input-group mb-3">
                                                                    <input type="hidden" name="id_update" value="<?php echo $row['prod_id']; ?>">
                                                                    <input type="file" name="fileUploadupdate" class="form-control" id="chooseFilenew" required>
                                                                    <label class="input-group-text" for="chooseFile">Select file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" name="updateimage">Change</button>
                                                    </div>
                                                </form>

                                            </div>

                                            <form action="includes/update_codes" method="post" enctype="multipart/form-data" class="mb-3">
                                                <div class="form-group mb-3">
                                                    <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>" id="uid">
                                                    <label for="pname" class="form-label">Product Name:</label>
                                                    <input type="text" class="form-control" name="updatepname" value="<?php echo $row['prod_name']; ?>" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="comment" class="form-label">Description:</label>
                                                    <textarea class="form-control" rows="5" id="comment" name="updatedesc" required><?php echo $row['prod_desc']; ?></textarea>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="category" class="form-label">Categories:</label>
                                                    <select class="form-control form-select form-select-md mt-3" id="category" name="updatecategory">


                                                        <option value="<?php echo $row['prod_category']; ?>"> <?php echo $row['prod_category']; ?> </option>
                                                        <?php
                                                        require_once 'includes/dbcon.php';
                                                        $sqlupdate = "SELECT * FROM `product_category` ORDER BY cat_id DESC";
                                                        $queryupdate = $pdo->prepare($sqlupdate);
                                                        $queryupdate->execute();

                                                        while ($row1 = $queryupdate->fetch()) {
                                                        ?>

                                                            <option value="<?php echo $row1['category']; ?>"><?php echo $row1['category']; ?></option>

                                                        <?php

                                                        }

                                                        ?>
                                                    </select>

                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="price" class="form-label">Price:</label>
                                                    <input type="text" class="form-control" id="price" name="updateprice" value="<?php echo $row['prod_price']; ?>" required>
                                                </div>
                                        </div>
                                    </div>


                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="updateproduct">Update</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>



                        <!-- End of update modal xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->

                    <?php

                    }

                    ?>

                </tbody>
            </table>
        </div>

        <div class="row my-5">
            <h1 style="font-size: large;">© 2024 Chaks Chills and Resto, Inc. All rights reserved. </h1>
        </div>

    </div>
    <div class="row">
        <!-- Modal for Categories -->

        <div class="modal fade" id="myModalCat" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="includes/codes" method="post" enctype="multipart/form-data" class="mb-3">
                            <!-- Modal Header -->
                            <div class="row">
                                <div class="form-group mb-3">
                                    <label for="catname" class="form-label">Category Name:</label>
                                    <input type="text" class="form-control" name="catname" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" style="width: 25%;" name="submitcat">Submit</button>
                                </div>

                            </div>
                        </form>
                        <br>
                        <div class="row">

                            <h5>List of Categories</h5>

                            <table class="table table-dark table-striped table-bordered" width="100%" cellspacing="0%">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once 'includes/dbcon.php';
                                    $sql = "SELECT * FROM `product_category` ORDER BY cat_id DESC";
                                    $query = $pdo->prepare($sql);
                                    $query->execute();

                                    while ($row = $query->fetch()) {
                                    ?>
                                        <tr class="table">
                                            <td><?php echo $row['category']; ?></td>

                                            <td>
                                                <form action="includes/delete_codes" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="daletecat_id" value="<?php echo $row['cat_id']; ?>">
                                                    <button type="submit" name="deletecat_btn" class="btn" onclick="return confirm('Are you sure you want to Delete this Category?')"><i class="material-icons">&#xe872;</i></button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php

                                    }

                                    ?>

                                </tbody>
                            </table>


                        </div>


                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>


                </div>
            </div>
        </div>
        <!-- End Modal for Categories -->
    </div>




    <!-- The Modal -->
    <div class="modal fade" id="myModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="includes/product_code" method="post" enctype="multipart/form-data" class="mb-3">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Product</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="pname" class="form-label">Product Name:</label>
                                <input type="text" class="form-control" name="pname" value="<?php if (isset($_SESSION["product_data"]["pname"]) && !isset($_SESSION["errors_signup"]["product_taken"])) {
                                                                                                $pnamedata = $_SESSION["product_data"]["pname"];
                                                                                            } else {
                                                                                                $pnamedata = '';
                                                                                            }
                                                                                            echo $pnamedata;
                                                                                            ?>">
                            </div>
                            <div class="form-group mb-3">

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="text-center">Upload Image</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="user-image mb-3 text-center">
                                            <div style="width: 200px; height: 200px; overflow: hidden; background: #cccccc; margin: 0 auto">
                                                <img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
                                            </div>
                                        </div>
                                        <div class="custom-file">
                                            <div class="input-group mb-3">
                                                <input type="file" name="fileUpload" class="form-control" id="chooseFile">
                                                <label class="input-group-text" for="chooseFile">Select file</label>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="comment" class="form-label">Description:</label>
                                <textarea class="form-control" rows="5" id="comment" name="description"><?php
                                                                                                        if (isset($_SESSION["product_data"]["description"])) {
                                                                                                            $desc = $_SESSION["product_data"]["description"];
                                                                                                        } else {
                                                                                                            $desc = '';
                                                                                                        }
                                                                                                        echo $desc; ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Categories:</label>
                                <select class="form-control form-select form-select-md mt-3" id="category" name="category">


                                    <option value=""> -- SELECT CATEGORIES -- </option>
                                    <?php
                                    require_once 'includes/dbcon.php';
                                    $sql = "SELECT * FROM `product_category` ORDER BY cat_id DESC";
                                    $query = $pdo->prepare($sql);
                                    $query->execute();

                                    while ($row = $query->fetch()) {
                                    ?>

                                        <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>

                                    <?php

                                    }

                                    ?>
                                </select>

                            </div>
                            <div class="form-group mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input type="text" class="form-control" id="price" name="price" value="<?php if (isset($_SESSION["product_data"]["price"])) {
                                                                                                            $price = $_SESSION["product_data"]["price"];
                                                                                                        } else {
                                                                                                            $price = '';
                                                                                                        }
                                                                                                        echo $price; ?>">
                            </div>
                        </div>


                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                </form>
                <?php
                check_product_errors();
                ?>
            </div>
        </div>


    </div>








    <!-- Javascript -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPlaceholder').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
        $("#chooseFile").change(function() {
            readURL(this);
        });




        $(document).ready(function() {

            $('#dataTable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                reponsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Your Data",
                }
            });
        });
    </script>
    <script src="assets/js/scripts.js"></script>

</body>

</html>