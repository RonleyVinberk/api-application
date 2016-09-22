<?php
    $dsn  = "mysql:host=localhost;dbname=db_apiapplication";
    $pass = "valkrie";
    $user = "root";

    try {
        $con = new PDO ($dsn, $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection: " . $e->getMessage();
    }
    
    define("VALIDASI", TRUE);