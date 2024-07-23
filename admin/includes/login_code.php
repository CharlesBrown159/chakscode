<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = $_POST["uname"];
    $pswd = $_POST["pswd"];

    try {
        require_once 'dbcon.php';
        require_once 'login_model.php';
        require_once 'login_contr.php';


        //ERROR HANDLERS

        $errors = [];

        if (is_input_empty($uname, $pswd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $uname);

        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Inputed Username is not Registered!";
        }
        if (!is_username_wrong($result) && is_password_wrong($pswd, $result["emppass"])) {
            $errors["login_incorrect"] = "Incorrect Password!";
        }
        // if (!is_username_wrong($result) && is_password_wrong($pswd, $result["emppass"])) {
        //     $errors["login_incorrect"] = "Incorrect login info!";
        // }
        

        // require_once 'config_session.php';
        session_start();

        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            $signupData = [
                "uname" => $uname,
            ];
            $_SESSION["login_data"] = $signupData;

            header('location: ../index');
            die();
        }


        

        $newSessionID = session_create_id();
        $sessionId = $newSessionID . "_" . $result["userId"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["userId"];
        $_SESSION["use_username"] = htmlspecialchars($result["username"]);
        $_SESSION["approval"] = htmlspecialchars($result["approval"]);
        $_SESSION["userlevel"] = htmlspecialchars($result["userlevel"]);

        $_SESSION['last_regeneration'] = time();

        if ($result["userlevel"] == "admin") {
            header("location: ../dashboard?login=success");
        }elseif ($result["userlevel"] == "casher") {
            header("location: ../casher/dashboard?login=success");
        }elseif ($result["userlevel"] == "kitchen") {
            header("location: ../kitchen/dashboard?login=success");
        }

        $pdo = null;
        $statement = null;
        die();
    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    header("location: ../index");
    die();
}
