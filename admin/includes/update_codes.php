<?php

require_once 'dbcon.php';

session_start();

// Taking current system Time 
$_SESSION['start'] = time();

// Destroying session after 1 minute 
$_SESSION['expire'] = $_SESSION['start'] + (1 * 10);


if (isset($_POST['updateproduct'])) {
    $prod_id = $_POST['prod_id'];
    $updatepname = $_POST['updatepname'];
    $updatedesc = $_POST['updatedesc'];
    $updatecategory = $_POST['updatecategory'];
    $updateprice = $_POST['updateprice'];


    $sqlupdate = "SELECT * FROM `product` WHERE prod_id = :prod_id";
    $queryupdate = $pdo->prepare($sqlupdate);
    $queryupdate->bindParam(':prod_id', $prod_id);
    $queryupdate->execute();

    while ($row1 = $queryupdate->fetch()) {

        $pname = $row1['prod_name'];
    }

    if ($updatepname == $pname) {

        try {
            $query = "UPDATE product SET prod_desc='$updatedesc', prod_category='$updatecategory', prod_price=$updateprice WHERE prod_id = $prod_id";
            $pdo->exec($query);
            echo "<script>alert('Successfully Updated!')</script>";
            $_SESSION['validateerrors'] = '<h1 class="text-success text-center">Successfully Updated!</h1>';
            header('Location: ../addproduct');
        } catch (PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
            header('Location: ../addproduct');
        }
    } else {
        $duplicate = $pdo->prepare("SELECT prod_id FROM product WHERE prod_name = :prod_name");
        $duplicate->bindParam(':prod_name', $updatepname);
        $duplicate->execute();
        if ($duplicate->rowCount() > 0) {

            echo "<script>alert('I'm sorry. That Category name already exists!')</script>";
            $_SESSION['validateerrors'] = '<h1 class="text-danger text-center">Im sorry. (' . $updatepname . ') Product name already exists! </h1>';
            header('Location: ../addproduct');
        } else {

            try {
                $query = "UPDATE product SET prod_name='$updatepname', prod_desc='$updatedesc', prod_category='$updatecategory', prod_price=$updateprice WHERE prod_id = $prod_id";
                $pdo->exec($query);
                echo "<script>alert('Successfully Updated!')</script>";
                $_SESSION['validateerrors'] = '<h1 class="text-success text-center">Successfully Updated!</h1>';
                header('Location: ../addproduct');
            } catch (PDOException $e) {
                echo $query . "<br>" . $e->getMessage();
                header('Location: ../addproduct');
            }
        }
    }
}


if (isset($_POST['updateimage'])) {

    $id_update = $_POST['id_update'];
    $fileupload = $_FILES["fileUploadupdate"]["name"];


    function is_imagefile_format()
    {

        // Set image placement folder
        $target_dir = "../assets/image/prodPhoto/";
        // Get file path
        $target_file = $target_dir . basename($_FILES["fileUploadupdate"]['name']);
        // Get file extension
        $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allowed file types
        $allowd_file_ext = array("jpg", "jpeg", "png");

        if (!in_array($imageExt, $allowd_file_ext)) {
            return true;
        } else {
            return false;
        }
    }

    function is_imagefile_size()
    {

        if ($_FILES["fileUploadupdate"]["size"] > 2097152) {
            return true;
        } else {
            return false;
        }
    }

    if (is_imagefile_format()) {

        echo "<script>alert('Allowed file formats .jpg, .jpeg and .png')</script>";
        $_SESSION['validateerrors'] = '<h1 class="text-danger text-center">Allowed file formats .jpg, .jpeg and .png</h1>';
        header('Location: ../addproduct');
    } elseif (is_imagefile_size()) {

        echo "<script>alert('File is too large. File size should be less than 2 megabytes.')</script>";
        $_SESSION['validateerrors'] = '<h1 class="text-danger text-center">File is too large. File size should be less than 2 megabytes.</h1>';
        header('Location: ../addproduct');
    } else {

        $query = $pdo->prepare('SELECT * FROM product WHERE prod_id = :uid');
        $query->execute(array(':uid' => $id_update));
        $imgRow = $query->fetch(PDO::FETCH_ASSOC);
        unlink("../assets/image/prodPhoto/" . $imgRow['prod_image']);

        $randomfilename = bin2hex(openssl_random_pseudo_bytes(16));
        $extension = explode("/", $_FILES['fileUploadupdate']['type']);
        $name = $randomfilename . "." . $extension[1];

        // Set image placement folder
        $target_dir = "../assets/image/prodPhoto/";
        // Get file path
        $target_file = $target_dir . basename($name);
        // Get file extension


        if (move_uploaded_file($_FILES["fileUploadupdate"]["tmp_name"], $target_file)) {
            try {
                $query = "UPDATE product SET prod_image='$name' WHERE prod_id = $id_update";
                $pdo->exec($query);
                echo "<script>alert('Successfully Change the image!')</script>";
                $_SESSION['validateerrors'] = '<h1 class="text-success text-center">Successfully Change the image!</h1>';
                header('Location: ../addproduct');
            } catch (PDOException $e) {
                echo $query . "<br>" . $e->getMessage();
                header('Location: ../addproduct');
            }
        }
    }
}

if (isset($_POST['acceptbtn'])) {
    date_default_timezone_set('Asia/Manila');
    $opId = $_POST['opId'];
    $uname = $_POST['uname'];
    $servingTime = $_POST['servingTime'];

    $currentDate =  date("Y-m-d");

    $serving = date('F j, Y H:i:s', strtotime($servingTime));



    $sql = "SELECT * FROM `order_prod` WHERE op_id = :opId";
    $query = $pdo->prepare($sql);
    $query->bindParam(':opId', $opId);
    $query->execute();

    while ($row = $query->fetch()) {

        $approval = $row['op_orderApproved'];
    }

    if ($approval != '') {

        echo "<script>alert('I'm sorry. This order is already taken!')</script>";
        header('Location: ../orders');
    } else {

        $query = "UPDATE order_prod SET op_orderApproved='Accepted', op_approvedby='$uname', op_approvedDate='$currentDate', op_processingTIme='$serving' WHERE op_id = $opId";
        $pdo->exec($query);
        echo "<script>alert('Successfull!')</script>";
?>
        <meta http-equiv="refresh" content="0;URL='../orders'" />
    <?php

    }
}

if (isset($_POST['cancelbtn'])) {

    date_default_timezone_set('Asia/Manila');
    $opId = $_POST['opId'];
    $uname = $_POST['uname'];
    $currentDate =  date("Y-m-d");



    $sql = "SELECT * FROM `order_prod` WHERE op_id = :opId";
    $query = $pdo->prepare($sql);
    $query->bindParam(':opId', $opId);
    $query->execute();

    while ($row = $query->fetch()) {

        $approval = $row['op_orderApproved'];
    }

    if ($approval != '') {

        echo "<script>alert('I'm sorry. This order is already taken!')</script>";
        header('Location: ../orders');
    } else {

        $query = "UPDATE order_prod SET op_orderApproved='Cancelled', op_approvedby='$uname', op_approvedDate='$currentDate' WHERE op_id = $opId";
        $pdo->exec($query);
        echo "<script>alert('Successfull!')</script>";
    ?>
        <meta http-equiv="refresh" content="0;URL='../orders'" />
        <?php

    }
}


if (isset($_POST['btnProcess'])) {
    date_default_timezone_set('Asia/Manila');
    $opId = $_POST['opId'];
    $uname = $_POST['uname'];

    $currentDate =  date("Y-m-d");

    $sqlcount = "SELECT COUNT(cart_id) as total FROM `addtocart` WHERE cart_sold = '0' AND cart_purchasedId='$opId'";
    $queryCount = $pdo->prepare($sqlcount);
    $queryCount->execute();
    $fetch = $queryCount->fetch();

    if ($fetch['total'] == '0') {
        $sql = "SELECT * FROM `order_prod` WHERE op_id = :opId";
        $query = $pdo->prepare($sql);
        $query->bindParam(':opId', $opId);
        $query->execute();

        while ($row = $query->fetch()) {

            $approval = $row['op_orderApproved'];
            $foodProcess = $row['op_foodprocess'];
        }

        if ($foodProcess != '') {

            echo "<script>alert('I'm sorry. This order is already taken!')</script>";
            header('Location: ../foodprocess');
        } else {

            $query = "UPDATE order_prod SET op_foodprocess='SERVED' WHERE op_id = $opId";
            $pdo->exec($query);
            echo "<script>alert('Success!')</script>";
        ?>
            <meta http-equiv="refresh" content="0;URL='../foodprocess'" />
        <?php

        }
    } else {
        echo "<script>alert('Please Check all ')</script>";
        ?>
        <meta http-equiv="refresh" content="0;URL='../serving?id=<?php echo $opId; ?>'" />
    <?php

    }
}


if (isset($_POST['btnCheck'])) {
    $cartId = $_POST['cartId'];
    $orderID = $_POST['orderID'];

    $query = "UPDATE addtocart SET cart_sold='1' WHERE cart_id = $cartId";
    $pdo->exec($query);

    ?>
    <meta http-equiv="refresh" content="0;URL='../serving?id=<?php echo $orderID; ?>'" />
<?php
}

if (isset($_POST['updateuser'])) {
    $user_id = $_POST['user_id'];
    $approval = $_POST['approval'];

    $query = "UPDATE empaccount SET approval='$approval' WHERE userId  = $user_id";
    $pdo->exec($query);

    echo "<script>alert('Updated!!')</script>";
    ?>
    <meta http-equiv="refresh" content="0;URL='../empapproval'" />
<?php
}


if (isset($_POST['updateUA'])) {
    $user_id = $_POST['user_id'];
    $approval = $_POST['approval'];

    $query = "UPDATE useraccount SET ua_approval='$approval' WHERE 	ua_id = $user_id";
    $pdo->exec($query);

    echo "<script>alert('Updated!!')</script>";
    ?>
    <meta http-equiv="refresh" content="0;URL='../usersapproval'" />
<?php
}
