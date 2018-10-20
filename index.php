<?php
include 'includes/all.php';
include $includes . 'db_connect.php';
echo "HOME<br />";
$php_ver = phpversion();
try {
    $sql = 'SELECT version()';
    $result = $pdo->query($sql);
} 
catch (PDOException $e) {
    $output = "Error" . $e->getMessage();
    include $includes . 'error.html.php';
    exit();
}
$row = $result->fetch();
$mysql_ver = $row[0];

include 'home.html.php';

?>