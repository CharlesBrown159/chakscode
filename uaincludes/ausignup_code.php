<?php

if ($_SERVER["REQUEST_METHOD"] = "POST") {

    $uname = $_POST["uname"];
    $email = $_POST["email"];
    $pswd = $_POST["pswd"];
    $cpswd = $_POST["cpswd"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];


    try {

        require_once '../admin/includes/dbcon.php';



        // require_once 'signup_model.php';
        function get_username(object $pdo, string $uname)
        {
            $query = "SELECT ua_username FROM useraccount WHERE ua_username = :uname;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":uname", $uname);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        function get_email(object $pdo, string $email)
        {
            $query = "SELECT ua_email FROM useraccount WHERE ua_email = :email;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        function set_user(object $pdo, string $uname, string $email, string $pswd, string $fname, string $lname)
        {
            $query = "INSERT INTO useraccount (ua_fullname, ua_username, ua_pass, ua_email) VALUES
    (:fname ' ' :lname, :uname, :pswd, :email);";
            $stmt = $pdo->prepare($query);

            $options = [
                'cost' => 12
            ];
            $hashedPwd = password_hash($pswd, PASSWORD_BCRYPT, $options);

            $stmt->bindParam(":uname", $uname);
            $stmt->bindParam(":pswd", $hashedPwd);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->execute();
        }

        //// signup model end///



        // require_once 'signup_contr.php';
        function is_input_empty(string $uname, string $email, string $pswd, string $cpswd, string $fname, string $lname)
        {
            if (empty($uname) || empty($email) || empty($pswd) || empty($cpswd) || empty($fname) || empty($lname)) {
                return true;
            } else {
                return false;
            }
        }

        function is_email_invalid(string $email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }

        function is_username_taken(object $pdo, string $uname)
        {
            if (get_username($pdo, $uname)) {
                return true;
            } else {
                return false;
            }
        }

        function is_email_registered(object $pdo, string $email)
        {
            if (get_email($pdo, $email)) {
                return true;
            } else {
                return false;
            }
        }

        function is_pass_confirm(string $pswd, string $cpswd)
        {
            if ($pswd != $cpswd) {
                return true;
            } else {
                return false;
            }
        }

        function create_user(object $pdo, string $uname, string $email, string $pswd, string $fname, string $lname)
        {
            set_user($pdo, $uname, $email, $pswd, $fname, $lname);
        }
        /////////////////////////////////////////


        //ERROR HANDLERS

        $errors = [];

        if (is_input_empty($uname, $email, $pswd, $cpswd, $fname, $lname)) {
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
            $_SESSION["errors_uasignup"] = $errors;

            $signupData = [
                "uname" => $uname,
                "email" => $email,
                "fname" => $fname,
                "lname" => $lname,
            ];
            $_SESSION["uasignup_data"] = $signupData;

            header("location: ../signup");
            die();
        }

        create_user($pdo, $uname, $email, $pswd, $fname, $lname);

        header("location: ../signup?signup=success");
        unset($_SESSION['uasignup_data']);
        unset($_SESSION['errors_uasignup']);
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
