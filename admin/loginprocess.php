<?php session_start(); ?>
<?php
if (isset($_POST['submit'])) {
    require 'dbconnection.php';
    $password = $_POST['password'];
    $username = $_POST['username'];
    if (mysqli_connect_errno()) {
        exit();
    } else {

        $selectStatement = "
SELECT *FROM dmpusers WHERE username=? AND password=?";

        if ($preparedquery = mysqli_prepare($dbcon, $selectStatement)) {
            mysqli_stmt_bind_param($preparedquery, "ss", $username, $password);
            mysqli_stmt_execute($preparedquery);
            mysqli_stmt_bind_result(
                $preparedquery,
                $user_id,
                $username,
                $fullname,
                $password,
                $access_level,
                $islocked
            );

            if (mysqli_stmt_fetch($preparedquery)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['password'] = $password;
                $_SESSION['islocked'] = $islocked;
                $_SESSION['access_level'] = $access_level;

                if ($islocked == false) {
                    switch ($access_level) {
                        case "1":
                            echo "<script>alert('WELCOME ADMIN!!')</script>";
?>
                            <meta http-equiv="refresh" content="0;URL='dashboard'" />
                        <?php
                            break;
                        case "2":
                            echo "<script>alert('WELCOME STAFF!!')</script>";
                        ?>
                            <meta http-equiv="refresh" content="0;URL='dashboard'" />
                <?php
                            break;
                    }
                } else {
                    echo "<script>alert('Your account is locked. Please contact the administrator.')</script>";
                    header("refresh:0;url=index");
                }
            } else {
                echo "<script>alert('password is incorrect.')</script>";
                ?>
                <meta http-equiv="refresh" content="0;URL='index'" />
<?php
            }
        }
    }
} else {
    header("refresh:0;url=index");
}

?>