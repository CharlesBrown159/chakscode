<?php
session_name('user');
require_once 'auconfig_session.php';

if (!isset($_SESSION['user_id'])) {
    header('location:../login');
}

require '../admin/includes/dbcon.php';

if (isset($_POST['addtocartbtn'])) {

    $prodId = $_POST['prodId'];
    $useruname = $_POST['useruname'];
    $prodPrice = $_POST['prodPrice'];
    $tableNo = $_SESSION['tableNo'];
    $addons = $_SESSION['addons'];

    $duplicate = $pdo->prepare("SELECT * FROM addtocart WHERE cart_productId = :prodId AND cart_username = :useruname AND cart_purchasedId = '0' AND cart_tableNo = '$tableNo'");
    $duplicate->bindParam(':prodId', $prodId);
    $duplicate->bindParam(':useruname', $useruname);
    $duplicate->execute();
    if ($duplicate->rowCount() > 0) {

        echo "<script>alert('This Product is Already On Your Cart. Please Check!')</script>";

    ?>
        <meta http-equiv="refresh" content="0;URL='../cart'" />
    <?php

    } else {

        $query = "INSERT INTO addtocart (cart_productId, cart_username, cart_Quantity, cart_Price, cart_tableNo, cart_addons) VALUES (:prodId, :useruname, '1', :prodPrice, :tableNo, :addons);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":prodId", $prodId);
        $stmt->bindParam(":useruname", $useruname);
        $stmt->bindParam(":prodPrice", $prodPrice);
        $stmt->bindParam(":tableNo", $tableNo);
        $stmt->bindParam(":addons", $addons);
        if ($stmt->execute()) {
            // echo "<script>alert('Successfully Added!')</script>";
        ?>
            <meta http-equiv="refresh" content="0;URL='../cart'" />
        <?php

        } else {
            echo "<script>alert('Error!')</script>";
        ?>
            <meta http-equiv="refresh" content="0;URL='../cart'" />
        <?php
        }
    }
    $pdo = null;
    die();
}



// start of purchase area ----------------------------------------------------------------------------------------------------------
if (isset($_POST['btnOrder'])) {


    $totalqty = $_POST['totalqty'];
    $totalprice = $_POST['totalprice'];
    $username = $_POST['username'];
    $tableNo = $_SESSION['tableNo'];
    $addons = $_SESSION['addons'];

    $statement = $pdo->prepare("SELECT COUNT(op_id) FROM order_prod");
    $statement->execute();
    $count = $statement->fetchColumn();

    // $sqlcount   = $dbcon->query("SELECT count(pb_id) as rowNum FROM purchasebook"); 
    // $resultcount = $sqlcount->fetch_assoc(); 
    // $rowCount= $resultcount['rowNum']; 

    $plusOne = $count + 1;

    $sqlcount = $pdo->prepare("SELECT COUNT(op_id) FROM order_prod WHERE op_orderApproved = '' AND 	op_username = '$username' AND op_tableNo = '$tableNo'");
    $sqlcount->execute();
    $rowCount = $sqlcount->fetchColumn();

    // $sqlcount1 = $dbcon->query("SELECT count(pb_id) as rowNum FROM purchasebook WHERE pb_purchaseapproved = '' AND pb_username = '$username'"); 
    // $resultcount1 = $sqlcount1->fetch_assoc(); 
    // $rowCount1= $resultcount1['rowNum']; 


    if ($rowCount > "5") {

        echo "<script>alert('You cannot add more Purchase!')</script>";
        ?>
        <meta http-equiv="refresh" content="0;URL='../user/cart'" />
        <?php

    } else {

        $query = "INSERT INTO order_prod (op_quantity, op_price, op_username, op_tableNo, op_addons) VALUES (:totalqty, :totalprice, :username, :tableNo, :addons);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":totalqty", $totalqty);
        $stmt->bindParam(":totalprice", $totalprice);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":tableNo", $tableNo);
        $stmt->bindParam(":addons", $addons);

        if ($stmt->execute()) {

            $query_update = "UPDATE addtocart SET cart_purchasedId='$plusOne' WHERE cart_purchasedId='0' AND cart_username='$username' AND cart_tableNo = '$tableNo'";
            $pdo->exec($query_update);
            echo "<script>alert('Successfully Added!')</script>";
        ?>
            <meta http-equiv="refresh" content="0;URL='../cart'" />
        <?php

        } else {
            echo "<script>alert('Error!')</script>";
        ?>
            <meta http-equiv="refresh" content="0;URL='../cart'" />
        <?php

        }
    }
}

// End of purchase area --------------------------------------------------------------------------------------------------------------


?>