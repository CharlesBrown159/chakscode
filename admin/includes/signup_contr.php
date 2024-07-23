<?php

declare(strict_types=1);
  

function is_input_empty(string $uname, string $email, string $pswd, string $cpswd, string $fname, string $lname, string $ulevel) 
{
    if (empty($uname) || empty($email) || empty($pswd) || empty($cpswd) || empty($fname) || empty($lname) || empty($ulevel)) {
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

function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function is_pass_confirm(string $pswd, string $cpswd){
    if ($pswd != $cpswd){
        return true;
    } else {
        return false;
    }

}

function create_user(object $pdo, string $uname, string $email, string $pswd, string $fname, string $lname, string $ulevel) {
   set_user($pdo, $uname, $email, $pswd, $fname, $lname, $ulevel);
}


?>