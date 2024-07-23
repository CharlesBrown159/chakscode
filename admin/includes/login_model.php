<?php

declare(strict_types=1);

function get_user(object $pdo, string $uname)
{
    $query = "SELECT * FROM empaccount WHERE username = :uname";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname", $uname);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
?>