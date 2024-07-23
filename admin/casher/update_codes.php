<?php


require_once '../includes/dbcon.php';

session_start();

// Taking current system Time 
$_SESSION['start'] = time();

// Destroying session after 1 minute 
$_SESSION['expire'] = $_SESSION['start'] + (1 * 10);


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
        header('Location: orders');
    } else {

        $query = "UPDATE order_prod SET op_orderApproved='Accepted', op_approvedby='$uname', op_approvedDate='$currentDate', op_processingTIme='$serving' WHERE op_id = $opId";
        $pdo->exec($query);
        echo "<script>alert('Successfull!')</script>";
?>
        <meta http-equiv="refresh" content="0;URL='orders'" />
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
        header('Location: orders');
    } else {

        $query = "UPDATE order_prod SET op_orderApproved='Cancelled', op_approvedby='$uname', op_approvedDate='$currentDate' WHERE op_id = $opId";
        $pdo->exec($query);
        echo "<script>alert('Successfull!')</script>";
    ?>
        <meta http-equiv="refresh" content="0;URL='orders'" />
        <?php

    }
}

if (isset($_POST['btnCheck'])) {
    $cartId = $_POST['cartId'];
    $orderID = $_POST['orderID'];

    $query = "UPDATE addtocart SET cart_sold='1' WHERE cart_id = $cartId";
    $pdo->exec($query);

    ?>
    <meta http-equiv="refresh" content="0;URL='preparing?id=<?php echo $orderID; ?>'" />
<?php
}