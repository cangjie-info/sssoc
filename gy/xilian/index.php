<?php

$initial_id = filter_input(INPUT_GET, 'initial_id', FILTER_VALIDATE_INT);
if(is_null($initial_id)) {    
    exit();
}

include '../../includes/all.php';
include $includes . 'db_connect.php';

$sql = "SELECT initial_name, baxter_mc "
        . "FROM gy_initials "
        . "WHERE id = :initial_id;";

try {
    $s = $pdo->prepare($sql);
    $s->bindvalue("initial_id", $initial_id);
    $s->execute();
} 
catch (Exception $ex) {
    $error = "Error finding GY data by graph: " .$ex->getMessage();
    include $includes . 'error.html.php';
    exit();
}

$result = $s->fetch();
$initial_name = $result["initial_name"];
$initial_baxter = $result["baxter_mc"];

$sql = "SELECT gy_niu.id AS from_id, gy_niu.graph AS from_graph, "
        . "gy_niu.fanqie_1 AS fanqie, target_niu.id AS to_id, target_niu.graph AS to_graph "
        . "FROM gy_niu INNER JOIN gy_entries ON fanqie_1 = gy_entries.graph "
        . "INNER JOIN gy_niu AS target_niu ON gy_entries.niu_id = target_niu.id "
        . "WHERE gy_niu.initial_id = :initial_id "
        . "AND target_niu.initial_id = :initial_id;";

try {
    $s = $pdo->prepare($sql);
    $s->bindvalue("initial_id", $initial_id);
    $s->execute();
} 
catch (Exception $ex) {
    $error = "Error finding GY data by graph: " .$ex->getMessage();
    include $includes . 'error.html.php';
    exit();
}

$results = $s->fetchAll(PDO::FETCH_ASSOC);
$node_set = array();
$edges = array();

foreach ($results as $result) {
    $from_id = intval($result["from_id"]);
    $from_graph = $result["from_graph"];
    $to_id = intval($result["to_id"]);
    $to_graph = $result["to_graph"];
    $fanqie = $result["fanqie"];
    $node_set[$from_id] = $from_graph;
    $node_set[$to_id] = $to_graph;
    $edges[] = array("from" => $from_id,
        "to" => $to_id,
        "label" => $fanqie);
}
$nodes = array();
foreach ($node_set as $id => $graph) {
    $nodes[] = array("id" => $id, "label" => $graph);
}
/*
$nodes = array(
    array("id" => 1, "label" => '東'),
    array("id" => 2, "label" => '德'),
    array("id" => 3, "label" => '多')
);

$edges = array(
    array("from" => 1, "to" => 2, "label" => '德'),
    array("from" => 2, "to" => 3, "label" => '多'),
    array("from" => 3, "to" => 2, "label" => '得')
);
*/
include 'xilian.html.php';

?>
