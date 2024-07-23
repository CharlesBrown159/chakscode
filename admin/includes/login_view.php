<?php

declare(strict_types=1);


function check_login_errors()
{
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error text-danger text-center">' . $error . '</p>';
        }

        unset($_SESSION['errors_login']);
    } elseif (isset($_GET['login']) && $_GET['login'] === "success") {
        echo '<br>';
        echo '<p class="form-success text-success text-center">Login Success </p> ';
    }
}