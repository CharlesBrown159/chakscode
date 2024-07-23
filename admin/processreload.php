<?php

require_once 'includes/config_session.php';


if (!isset($_SESSION['user_id'])) {
    header('location:index');
}
?>

<?php
require_once 'includes/dbcon.php';
$statement = $pdo->prepare("SELECT COUNT(op_id) FROM order_prod WHERE op_orderApproved = 'Accepted' AND op_foodprocess = ''");
$statement->execute();
$count = $statement->fetchColumn();

if ($count != '0') {


    $uname = $_SESSION['use_username'];

    $sql = "SELECT * FROM `order_prod` WHERE op_orderApproved = 'Accepted' AND op_foodprocess = ''";
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    while ($row = array_shift($result)) {

        $op_user = $row['op_username'];

        $sql_user = "SELECT * FROM `useraccount` WHERE ua_username = '$op_user' ";
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->execute();
        $result_user = $stmt_user->fetchAll();

        while ($row_user = array_shift($result_user)) {
            $fname = $row_user['ua_fullname'];

        }

        $op_id = $row['op_id'];
?>

        <a href="serving?id=<?php echo $row['op_id']; ?>" class="five">
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
                </div>
            </div>
        </a>
    <?php
    }
} else {
    ?>
    <div class="row">
        <h5>No Food to Process!</h5>
    </div>
<?php
}
?>