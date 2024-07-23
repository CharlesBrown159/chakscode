<?php

declare(strict_types=1);

function get_username(object $pdo, string $uname)
{
    $query = "SELECT username FROM empaccount WHERE username = :uname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname", $uname);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email)
{
    $query = "SELECT email FROM empaccount WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $uname, string $email, string $pswd, string $fname, string $lname, string $ulevel) {
    $query = "INSERT INTO empaccount (fullname, username, emppass, email, userlevel) VALUES
    (:fname ' ' :lname, :uname, :pswd, :email, :ulevel);";
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
    $stmt->bindParam(":ulevel", $ulevel);
    $stmt->execute();
}

?>