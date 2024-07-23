<?php

if ($_SERVER["REQUEST_METHOD"] = "POST") {
   
    $uname = $_POST["uname"];
    $email = $_POST["email"];
    $pswd = $_POST["pswd"];
    $cpswd = $_POST["cpswd"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $ulevel = $_POST["ulevel"];
  

    try {

        require_once 'dbcon.php';
        require_once 'signup_model.php';
        require_once 'signup_contr.php';
    

        //ERROR HANDLERS

        $errors = [];

        if (is_input_empty($uname, $email, $pswd, $cpswd, $fname, $lname, $ulevel)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used!";
        }
        if (is_username_taken($pdo, $uname)) {
            $errors["username_taken"] = "Username already taken!";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }
        if (is_pass_confirm($pswd, $cpswd)) {
            $errors["match_pass"] = "Password & Confirm Password is not match!";
        }
        

        
        // require_once 'config_session.php';
        session_start();
        
        

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "uname" => $uname,
                "email" => $email,
                "fname" => $fname,
                "lname" => $lname,
                "ulevel" => $ulevel
            ];
            $_SESSION["signup_data"] = $signupData;

            header("location: ../signup");
            die();
        }
        
        create_user($pdo, $uname, $email, $pswd, $fname, $lname, $ulevel);

        header("location: ../signup?signup=success");
        
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    header("location: ../signup");
    die();
}

?>
