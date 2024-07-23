<?php
require_once 'includes/config_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:index');
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Diamond Media Press - User Approval</title>
    <!-- Bootstrap CSS -->

    <link rel="shortcut icon" type="image/x-icon" href="assets/image/chaks.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/adminstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

</head>

<body>
    <nav class="navbar navbar-danger bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard">
                <img src="assets/image/chaks.png" alt="logo" height="100px" weight="100px">

            </a>
            <h1 class="text-light">Account Approval</h1>


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
    <main>

        <div class="container-fluid" style="padding-top: 150px">
            <h1 class="mt-4">Users Approval</h1>
            
            <!-- PRESS MODAL ADD BOOK -->
        </div>
        <div class="container-fluid my-3">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0%">
                <thead>
                    <tr>
                        <th>ID No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>email</th>
                        <th>Date Created</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'includes/dbcon.php';

                    $sql = "SELECT * FROM `useraccount` ";
                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $stmt1 = $pdo->prepare($sql);
                    $stmt1->execute();
                    $result1 = $stmt1->fetchAll();

                    while ($row = array_shift($result1)) {

                    ?>

                        <tr class="table">
                            <td><?php echo $row['ua_id']; ?></td>
                            <td><?php echo $row['ua_fullname']; ?></td>
                            <td><?php echo $row['ua_username']; ?></td>
                            <td><?php echo $row['ua_email']; ?></td>
                            <td><?php echo $row['ua_datecreated']; ?></td>
                            <td><?php echo $row['ua_approval']; ?></td>
                            <td width="200px">
                             
                                <!-- <button type="button" class="btn btn-primary btn-block editbtn">UPDATE</button> -->
                                <!--Add Book Modal -->
                                <button class="btn btn-primary btn-block" data-toggle="modal" type="button" data-target="#update_modal<?php echo $row['ua_id'] ?>">UPDATE</button>
                               
                                
                                
                            <span>
                                <form action="includes/delete_codes" method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['ua_id']; ?>">
                                    <button name="delete_btn_foruser" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to Delete this Book?')">DELETE</button>
                                    <!--  <a type="button" name="edit_btn"  class="btn btn-primary " >
            <i class="fa fa-edit"></i> UPDATE </a> -->
                                </form>
                            </span>


                            </td>
                        </tr>

                        <div class="modal fade" id="update_modal<?php echo $row['ua_id'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">UPDATE USER APPROVAL</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="includes/update_codes" enctype="multipart/form-data">

                                            <div class="form-group my-3" >
                                                <input type="hidden" name="user_id" id="uid" value="<?php echo $row['ua_id'] ?>">
                                                <label>Full Name:</label>
                                                <input type="text" name="" class="form-control" value="<?php echo $row['ua_fullname'] ?>" disabled>
                                            </div>
                                            <div class="form-group my-3">
                                                <label>Username:</label>
                                                <input type="text" name="" class="form-control" value="<?php echo $row['ua_username'] ?>" disabled>
                                            </div>
                                  

                                            <div class="row">
                                                <div class="col-sm">
                                                    <div class="form-group">
                                                        <label for="name">FOR APPROVAL</label>
                                                        <select class="form-control" name="approval" style="height: 35px" required>
                                                            <option value="">--SELECT APPROVAL--</option>
                                                            <option value="APPROVED">APPROVED</option>
                                                            <option value="DENIED">DENIED</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <input type="submit" name="updateUA" id="submit" value="SUBMIT" class="btn btn-success btn-sm" style="width: 200px;font-size: 20px;">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    }

                    ?>

                </tbody>
            </table>
        </div>
    </main>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script>
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

        //  $(document).ready(function() {

        //    $('.editbtn').on('click', function() {
        //        $('#updatemodal').modal('show');

        //          $tr = $(this).closest('tr');

        //          var data = $tr.children("td").map(function() {
        //              return $(this).text();
        //          }).get();

        //          console.log(data);

        //          $('#uid').val(data[0]);
        //          $('#fullname').val(data[1]+' '+ data[2]);
        //          $('#uname').val(data[3]);
        //    });
        //  });
    </script>

    <div class="row my-5">
        <h1 style="font-size: large;">© 2024 Chaks Chills and Resto, Inc. All rights reserved. </h1>
    </div>

</body>

</html>