<?php

require '../admin/includes/dbcon.php';

if (isset($_POST['delCart'])) {
    $delete_id = $_POST['cartId'];

    $query_delete = $pdo->prepare('DELETE FROM addtocart WHERE cart_id = :uid');
    $query_delete->bindParam(':uid', $delete_id);
    if ($query_delete->execute()) {
        echo "<script>alert('Successfully Deleted!')</script>";
        header('Location: ../cart');
    } else {
        echo "<script>alert('Error On Deleting the Product')</script>";
        header('Location: ../cart');
    }

    $pdo = null;
    die();
}

?>