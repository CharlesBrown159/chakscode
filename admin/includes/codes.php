<?php

require_once 'dbcon.php';

session_start();

// Taking current system Time 
$_SESSION['start'] = time();  
  
// Destroying session after 1 minute 
$_SESSION['expire'] = $_SESSION['start'] + (1 * 10) ; 


if (isset($_POST['submitcat'])) {
    $catname = $_POST['catname'];

    $duplicate = $pdo->prepare("SELECT cat_id FROM product_category WHERE category = :catname");
    $duplicate->bindParam(':catname', $catname);
    $duplicate->execute();
    if ($duplicate->rowCount() > 0) {

        echo "<script>alert('I'm sorry. That Category name already exists!')</script>";
        $_SESSION['validateerrors'] = '<h1 class="text-danger text-center">Im sorry. That Category name already exists!</h1>';
        header('Location: ../addproduct');
    } else {
        $query = "INSERT INTO product_category (category) VALUES (:catname);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":catname", $catname);
        if ($stmt->execute()) {
            echo "<script>alert('Successfully Added!')</script>";
            $_SESSION['validateerrors'] = '<h1 class="text-success text-center">Successfully Added!</h1>';
            header('Location: ../addproduct');
        } else {
            echo "<script>alert('Error!')</script>";
            header('Location: ../addproduct');
        }
    }

    $pdo = null;
    die();
}
