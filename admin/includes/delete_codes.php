<?php

require_once 'dbcon.php';

session_start();

// Taking current system Time 
$_SESSION['start'] = time();

// Destroying session after 1 minute 
$_SESSION['expire'] = $_SESSION['start'] + (1 * 10);


if (isset($_POST['delete_btn_product'])) {
    $delete_id = $_POST['delete_id_product'];

    $query = $pdo->prepare('SELECT * FROM product WHERE prod_id = :uid');
    $query->execute(array(':uid' => $delete_id));
    $imgRow = $query->fetch(PDO::FETCH_ASSOC);
    unlink("../assets/image/prodPhoto/" . $imgRow['prod_image']);

    $query_delete = $pdo->prepare('DELETE FROM product WHERE prod_id = :uid');
    $query_delete->bindParam(':uid', $delete_id);
    if ($query_delete->execute()) {
        echo "<script>alert('Successful Deleted!')</script>";
        $_SESSION['validateerrors'] = '<h1 class="text-success text-center">Successful Deleted!</h1>';
        header('Location: ../addproduct');
    } else {
        echo "<script>alert('Error On Deleting the Product')</script>";
        header('Location: ../addproduct');
    }

    $pdo = null;
    die();
}



if (isset($_POST['deletecat_btn'])) {
    $delete_id = $_POST['daletecat_id'];

    $query_delete = $pdo->prepare('DELETE FROM product_category WHERE cat_id = :uid');
    $query_delete->bindParam(':uid', $delete_id);
    if ($query_delete->execute()) {
        echo "<script>alert('Deleted!')</script>";
        $_SESSION['validateerrors'] = '<h1 class="text-success text-center">Successful Deleted!</h1>';
        header('Location: ../addproduct');
    } else {
        echo "<script>alert('Error On Deleting the Product')</script>";
        header('Location: ../addproduct');
    }

    $pdo = null;
    die();
}

if (isset($_POST['delete_btn_user'])) {
    $delete_id_user = $_POST['delete_id_user'];

    $query_delete = $pdo->prepare('DELETE FROM empaccount WHERE userId = :uid');
    $query_delete->bindParam(':uid', $delete_id_user);
    if ($query_delete->execute()) {
        echo "<script>alert('Deleted!!')</script>";
    ?>
        <meta http-equiv="refresh" content="0;URL='../empapproval'" />
    <?php
    } else {
        echo "<script>alert('Error On Deleting the Product')</script>";
    ?>
        <meta http-equiv="refresh" content="0;URL='../empapproval'" />
    <?php
    }

    $pdo = null;
    die();
}

if (isset($_POST['delete_btn_foruser'])) {
    $delete_id = $_POST['delete_id'];

    $query_delete = $pdo->prepare('DELETE FROM useraccount WHERE ua_id = :uid');
    $query_delete->bindParam(':uid', $delete_id);
    if ($query_delete->execute()) {
        echo "<script>alert('Deleted!!')</script>";
    ?>
        <meta http-equiv="refresh" content="0;URL='../usersapproval'" />
    <?php
    } else {
        echo "<script>alert('Error On Deleting the Product')</script>";
    ?>
        <meta http-equiv="refresh" content="0;URL='../usersapproval'" />
    <?php
    }

    $pdo = null;
    die();
}

?>