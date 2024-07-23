<?php

require_once '../includes/config_session.php';


if (!isset($_SESSION['user_id'])) {
    header('location:../index');
}

if ($_SESSION['approval'] != "APPROVED") {
    echo "<script>alert('Your account needs to be approved by the admin.')</script>";

    echo "<script>
    window.history.go(-1);
</script>";
}

if ($_SESSION['userlevel'] != "casher") {

    echo "<script>alert('Your account is not for casher .')</script>";

    echo "<script>
    
    window.history.go(-1);
</script>";
}
?>

<div class="container" id="updatedata">
    <div class="card text-center shadow p-1 mb-3 rounded">
        <div class="row">
            <div class="col-sm">
                <h5>ID</h5>
            </div>
            <div class="col-sm">
                <h5>Waiter/Waitress</h5>
            </div>
            <div class="col-sm">
                <h5>Table No.</h5>
            </div>
            <div class="col-sm">
                <h5>Quantity</h5>
            </div>
            <div class="col-sm">
                <h5>Price</h5>
            </div>
            <div class="col-sm">
                <h5>Date</h5>
            </div>
        </div>
    </div>

    <?php

    require_once '../includes/dbcon.php';
    $uname = $_SESSION['use_username'];

    $sql = "SELECT * FROM `order_prod` WHERE op_orderApproved = '' AND op_addons = 'ON'";
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    while ($row = array_shift($result)) {

        $op_id = $row['op_id'];
        $user = $row['op_username'];

        $sqlUser = "SELECT * FROM `useraccount` WHERE ua_username = '$user'";
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute();
        $resultUser = $stmtUser->fetchAll();

        while ($rowUser = array_shift($resultUser)) {
            $fname = $rowUser['ua_fullname'];
        }
    ?>

        <a href="orders_list?id=<?php echo $row['op_id']; ?>" class="five">
            <div class="card text-center shadow p-1 mb-3 rounded">
                <div class="row">
                    <div class="col-sm">
                        <h5><?php echo $row['op_id']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5><?php echo $fname; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5><?php echo $row['op_tableNo']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5><?php echo $row['op_quantity']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5>₱<?php echo $row['op_price']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5><?php echo date('M d, Y ', strtotime($row['op_orderDate'])); ?> <br><?php echo date('h:i a', strtotime($row['op_orderDate'])); ?></h5>
                    </div>

                    <!-- <div class="col-sm">
                        <h5>ID : <?php echo $row['op_id']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5>Name: <?php echo $row['op_username']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5>Quantity: <?php echo $row['op_quantity']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5>Price: ₱<?php echo $row['op_price']; ?></h5>
                    </div>
                    <div class="col-sm">
                        <h5>Date: <?php echo date('M d, Y h:ia', strtotime($row['op_orderDate'])); ?></h5>
                    </div> -->
                </div>
            </div>
        </a>

    <?php
    }
    ?>
</div>