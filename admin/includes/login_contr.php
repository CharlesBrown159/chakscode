<?php

declare(strict_types=1);

function is_input_empty(string $uname, string $pswd) 
{
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


?>