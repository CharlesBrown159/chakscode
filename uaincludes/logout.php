<?php
session_name('user');
session_start();
session_unset();
session_destroy();

error_reporting(0);

header("location: ../login");
die();