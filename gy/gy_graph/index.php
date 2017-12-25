<?php

function page_img($sbgy_page) {
    if($sbgy_page < 132) {
	$page_number = intdiv($sbgy_page - 22, 2)  + 16;
    }
    else if($sbgy_page < 235) {
	$page_number = intdiv($sbgy_page - 132, 2) + 76;
    }
    else if($sbgy_page < 342) {
	$page_number = intdiv($sbgy_page - 235, 2) + 132;
    }
    else if($sbgy_page < 448) {
        $page_number = intdiv($sbgy_page - 342, 2) + 192;
    }
    else {$page_number = intdiv($sbgy_page - 448, 2) + 250;
    }
    $page_str = str_pad(strval($page_number), 3, '0', STR_PAD_LEFT);
    return 'sbgy/sbgy' . $page_str . '.jpg';
}

$graph = filter_input(INPUT_POST, 'graph', FILTER_SANITIZE_STRING);

include '../../includes/all.php';
include $includes . 'db_connect.php';

$sql = "SELECT gy_entries.graph AS graph, "
        . "entry, page, number, "
        . "fanqie_1, fanqie_2, tone, "
        . "initial_name, gy_initials.ipa_pan AS initial_ipa_pan, "
        . "she, hu, deng, gy_finals.ipa_pan AS final_ipa_pan "
        . "FROM gy_entries "
        . "INNER JOIN gy_niu ON niu_id = gy_niu.id "
        . "INNER JOIN  gy_initials ON initial_id = gy_initials.id "
        . "INNER JOIN gy_finals ON final_id=gy_finals.id "
        . "WHERE gy_entries.graph = :graph";
try {
    $s = $pdo->prepare($sql);
    $s->bindvalue("graph", $graph);
    $s->execute();
} 
catch (Exception $ex) {
    $error = "Error finding GY data by graph: " .$ex->getMessage();
    include $includes . 'error.html.php';
    exit();
}
$result = $s->fetchAll(PDO::FETCH_ASSOC);

$row_number = 0;
foreach($result as $row) {
    $sql = "SELECT rhyme_name "
            . "FROM gy_rhymes "
            . "WHERE page < :page OR (page = :page AND number <= :number) "
            . "ORDER BY page DESC, number DESC "
            . "LIMIT 1;";
    try {
        $s = $pdo->prepare($sql);
        $s->bindvalue("page", $row['page']);
        $s->bindvalue("number", $row['number']);
        $s->execute();
    }
    catch (Exception $ex) {
        $error = "Error finding rhyme by page and number" . $ex->getMessage();
        include $includes . 'error.html.php';
        exit();
    }
    $rhyme_result = $s->fetch();
    $result[$row_number]['rhyme_name'] = $rhyme_result['rhyme_name'];
    $row_number++;
}


include 'gy_graph.html.php';

?>