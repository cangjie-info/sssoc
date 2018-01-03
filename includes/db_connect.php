<?php

// includes/all.php must have already have been included
// by the file that includes this one.
// That will set $config_path and $includes

// All php files that access MySQL need to get credentials from
// mysql.php found with $config_path variable.
// Place outside web root online for security

include $config_path;

$db_name = $db_prefix . "sssoc";

try {
   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pw);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $pdo->exec('SET NAMES "utf8mb4"');
}
catch (PDOException $e) {
   $output = 'Unable to connect to the database server.';
   include $includes . 'error.html.php';
   exit();
}

$link = mysqli_connect($db_host, $db_user, $db_pw);
if (!$link)
{
    $output = 'Unable to connect to MySQL.';
    include $includes . 'error.html.php';
    exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
    $output = 'Unable to set connection encoding.';
    include $includes . 'error.html.php';
    exit();
}

if (!mysqli_select_db($link, $db_name))   #DELETE $db_prefix . "ecdb"))
{
    $output = 'Unable to locate the ecdb database.';
    include $includes . 'error.html.php';
    exit();
}

?>
