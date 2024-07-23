<?php

declare(strict_types=1);

function signup_inputs()
{

    if (isset($_SESSION["uasignup_data"]["fname"])) {
        echo '<div class="col-sm">
        <div class="form-group mb-3">
            <label for="fname" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter Firstname" name="fname" value="' . $_SESSION["uasignup_data"]["fname"] . '">
        </div>
    </div>';
    } else {
        echo '<div class="col-sm">
        <div class="form-group mb-3">
            <label for="fname" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter Firstname" name="fname">
        </div>
    </div>';
    }

    if (isset($_SESSION["uasignup_data"]["lname"])) {
        echo '<div class="col-sm">
        <div class="form-group mb-3">
            <label for="fname" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lname" placeholder="Enter Lastname" name="lname" value="' . $_SESSION["uasignup_data"]["lname"] . '">
        </div>
    </div>';
    } else {
        echo '<div class="col-sm">
        <div class="form-group mb-3">
            <label for="fname" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lname" placeholder="Enter Lastname" name="lname">
        </div>
    </div>';
    }


    if (isset($_SESSION["uasignup_data"]["uname"]) && !isset($_SESSION["errors_uasignup"]["username_taken"])) {
        echo '<div class="form-group mb-3">
        <label for="uname" class="form-label">Username:</label>
        <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" value="' . $_SESSION["uasignup_data"]["uname"] . '" >
    </div>';
    } else {
        echo '<div class="form-group mb-3">
        <label for="uname" class="form-label">Username:</label>
        <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" >
    </div>';
    }

    if (isset($_SESSION["uasignup_data"]["email"]) && !isset($_SESSION["errors_uasignup"]["email_used"]) && !isset($_SESSION["errors_uasignup"]["invalid_email"])) {
        echo ' <div class="form-group mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" value="' . $_SESSION["uasignup_data"]["email"] . '" >

    </div>';
    } else {
        echo ' <div class="form-group mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" >

    </div>';
    }


    echo ' <div class="form-group mb-3">
    <label for="pwd" class="form-label">Password:</label>
    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" >
    </div>';
    echo ' <div class="form-group mb-3">
    <label for="pwd" class="form-label">Confirm Password:</label>
    <input type="password" class="form-control" placeholder="Confirm password" name="cpswd" >
    </div>';

}

function check_signup_errors()
{
    if (isset($_SESSION['errors_uasignup'])) {
        $errors = $_SESSION['errors_uasignup'];
        $error = [];

        echo '<br>';

        foreach ($errors as $error) {
            echo '<p class="form-error text-danger text-center">' . $error . '</p>';
        }

        unset($_SESSION['errors_uasignup']);
        
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<br>';
        echo '<p class="form-success text-success text-center">Signup success!. You can <a href="login">Login</a> now </p> ';
        echo "<script>alert('Signup success!')</script>";
    }

    // if (isset($_GET['signup']) == "success" ) {
    //     // echo '<p class="form-success text-success text-center">Signup success!. You can <a href="index">Login</a> now </p> ';
    // }
}
