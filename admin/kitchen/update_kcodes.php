<?php

require_once '../includes/dbcon.php';

if (isset($_POST['btnCheck'])) {
    $cartId = $_POST['cartId'];
    $orderID = $_POST['orderID'];

    $query = "UPDATE addtocart SET cart_sold='1' WHERE cart_id = $cartId";
    $pdo->exec($query);

    ?>
    <meta http-equiv="refresh" content="0;URL='checklist?id=<?php echo $orderID; ?>'" />
<?php
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
            header('Location: processing');
        } else {

            $query = "UPDATE order_prod SET op_foodprocess='SERVED' WHERE op_id = $opId";
            $pdo->exec($query);
            echo "<script>alert('Success!')</script>";
        ?>
            <meta http-equiv="refresh" content="0;URL='processing'" />
        <?php

        }
    } else {
        echo "<script>alert('Please Check all ')</script>";
        ?>
        <meta http-equiv="refresh" content="0;URL='../serving?id=<?php echo $opId; ?>'" />
    <?php

    }
}
?>