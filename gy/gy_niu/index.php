<?php

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if(is_null($id)) {    
    exit();
}
include '../../includes/all.php';
include $includes . 'db_connect.php';

$sql = "SELECT gy_entries.graph AS graph, "
        . "gy_entries.id AS id, "
        . "entry, page, number, "
        . "gy_finals.yj_page AS yjpage, "
        . "fanqie_1, fanqie_2, tone, "
        . "initial_name, gy_initials.ipa_pan AS initial_ipa_pan, "
        . "she, hu, deng, gy_finals.ipa_pan AS final_ipa_pan "
        . "FROM gy_entries "
        . "INNER JOIN gy_niu ON niu_id = gy_niu.id "
        . "INNER JOIN  gy_initials ON initial_id = gy_initials.id "
        . "INNER JOIN gy_finals ON final_id=gy_finals.id "
        . "WHERE gy_niu.id = :id "
        . "ORDER BY page, number;";

try {
    $s = $pdo->prepare($sql);
    $s->bindvalue("id", $id);
    $s->execute();
} 
catch (Exception $ex) {
    $error = "Error finding GY data by graph: " .$ex->getMessage();
    include $includes . 'error.html.php';
    exit();
}
$result = $s->fetchAll(PDO::FETCH_ASSOC);

include 'gy_niu.html.php';

?>
