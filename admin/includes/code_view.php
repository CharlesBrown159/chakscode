<?php

declare(strict_types=1);

function check_product_errors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        $error = [];

        echo '<br>';

        foreach ($errors as $error) {
            echo '<p class="form-error text-danger text-center">' . $error . '</p>';
            echo "<script>alert(' $error ')</script>";
        }

        

        unset($_SESSION['errors_signup']);
        
    } 
    // else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
    //     echo '<br>';
    //     echo '<p class="form-success text-success text-center">Signup success!. You can <a href="index">Login</a> now </p> ';
    // }
}