<?php

declare(strict_types=1);

function signup_inputs()
{

    if (isset($_SESSION["signup_data"]["fname"])) {
        echo '<div class="col-sm">
        <div class="form-group mb-3">
            <label for="fname" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter Firstname" name="fname" value="' . $_SESSION["signup_data"]["fname"] . '">
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

    if (isset($_SESSION["signup_data"]["lname"])) {
        echo '<div class="col-sm">
        <div class="form-group mb-3">
            <label for="fname" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lname" placeholder="Enter Lastname" name="lname" value="' . $_SESSION["signup_data"]["lname"] . '">
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


    if (isset($_SESSION["signup_data"]["uname"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<div class="form-group mb-3">
        <label for="uname" class="form-label">Username:</label>
        <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" value="' . $_SESSION["signup_data"]["uname"] . '" >
    </div>';
    } else {
        echo '<div class="form-group mb-3">
        <label for="uname" class="form-label">Username:</label>
        <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" >
    </div>';
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo ' <div class="form-group mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" value="' . $_SESSION["signup_data"]["email"] . '" >

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

    if (isset($_SESSION["signup_data"]["ulevel"]) == 'admin') {
        echo '  <div class="form-group mb-3">
        <label for="uname" class="form-label">User Access Level:</label>
        <select class="form-control" name="ulevel">
            <option value="' . $_SESSION["signup_data"]["ulevel"] . '"> ' . $_SESSION["signup_data"]["ulevel"] . '</option>
            <option value="admin">Admin</option>                       
            <option value="casher">Casher</option>
            <option value="kitchen">kitchen</option>
        </select>
    </div>';
    } else {
        echo ' <div class="form-group mb-3">
        <label for="uname" class="form-label">User Access Level:</label>
        <select class="form-control" name="ulevel">
            <option value="">-- SELECT --</option>
            <option value="admin">Admin</option>                       
            <option value="casher">Casher</option>
            <option value="kitchen">kitchen</option>
        </select>
    </div>';
    }
}

function check_signup_errors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        $error = [];

        echo '<br>';

        foreach ($errors as $error) {
            echo '<p class="form-error text-danger text-center">' . $error . '</p>';
        }

        unset($_SESSION['errors_signup']);
        
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<br>';
        echo '<p class="form-success text-success text-center">Signup success!. You can <a href="index">Login</a> now </p> ';
    }
}
