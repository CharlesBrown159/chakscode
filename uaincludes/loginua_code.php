<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = $_POST["ua_uname"];
    $pswd = $_POST["ua_pswd"];
    $tableNo = $_POST["tableNo"];

    try {
        require_once '../admin/includes/dbcon.php';

        // require_once 'login_model.php';
        function get_user(object $pdo, string $uname)
        {
            $query = "SELECT * FROM useraccount WHERE ua_username = :uname";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":uname", $uname);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }



        // require_once 'login_contr.php';
        function is_input_empty(string $uname, string $pswd) {
            if (empty($uname) || empty($pswd)) {
                return true;
            } else {
                return false;
            }
        }
        
        
        function is_username_wrong($result) 
        {
            if (!$result) {
                return true;
            } else {
                return false;
            }
        }
        
        function is_password_wrong(string $pswd, string $hashedPwd)
        {
            if (!password_verify($pswd, $hashedPwd)) {
                return true;
            } else {
                return false;
            }
        }

        function is_table_limit(string $tableNo)
        {
            if ($tableNo > 100) {
                return true;
            } else {
                return false;
            }
        }


        //ERROR HANDLERS

        $errors = [];

        if (is_input_empty($uname, $pswd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $uname);

        if (is_username_wrong($result)) {
            $errors["username_incorrect"] = "Inputed Username is not Registered!";
        }
        if (!is_username_wrong($result) && is_password_wrong($pswd, $result["ua_pass"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        if (is_password_wrong($pswd, $result["ua_pass"])) {
            $errors["password_incorrect"] = "Password is Incorrect!";
        }

        if (is_table_limit($tableNo)) {
            $errors["table_limit"] = "Table number is exceed the limit!";
        }


        // require_once 'config_session.php';
        session_name('user');
        session_start();

        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            header('location: ../login');
            die();
        }

        $newSessionID = session_create_id();
        $sessionId = $newSessionID . "_" . $result["ua_id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["ua_id"];
        $_SESSION["use_username"] = htmlspecialchars($result["ua_username"]);
        $_SESSION["use_fullname"] = htmlspecialchars($result["ua_fullname"]);
        $_SESSION["use_email"] = htmlspecialchars($result["ua_email"]);
        $_SESSION["tableNo"] = htmlspecialchars($tableNo);

        $_SESSION['last_regeneration'] = time();

        header("location: ../index?login=success");
        $pdo = null;
        $statement = null;
        die();
    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    header("location: ../login");
    die();
}
