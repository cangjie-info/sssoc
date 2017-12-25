<?php

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
if($page == NULL) {
    $page = "1";
}
if(intval($page) < 1) {
    $page = "1";
}
if(intval($page) > 43) {
    $page = "43";
}

include '../../includes/all.php';
include $includes . 'db_connect.php';

$sql = "SELECT hu, deng, final_name, gy_initials.id AS initial, yj_qu_as_ru, chongniu, "
        . "gy_niu.graph AS graph, gy_niu.tone, yj_initial_id, "
        . "gy_niu.id AS niuid "
        . "FROM gy_finals "
        . "JOIN gy_niu ON final_id = gy_finals.id "
        . "JOIN gy_initials ON initial_id = gy_initials.id "
        . "WHERE gy_finals.yj_page = :page ;";
try {
    $s = $pdo->prepare($sql);
    $s->bindvalue("page", $page);
    $s->execute();
} 
catch (Exception $ex) {
    $error = "Error finding YJ data by page: " .$ex->getMessage();
    include $includes . 'error.html.php';
    exit();
}
$result = $s->fetchAll(PDO::FETCH_ASSOC);
$yj_array = array_fill(0, 16, array_fill(0, 24, array_fill(0, 2, '')));
foreach($result as $niu) {
    $col = 24 - $niu['yj_initial_id'];
    $row = $niu['deng'] - 1;
    $row += ($niu['tone'] - 1) * 4;
    $deng = $niu['deng'];
    $yj_initial_id = $niu['yj_initial_id'];
    $initial = $niu['initial'];
    if($niu['yj_qu_as_ru'] == 1) {
        $row += 4;
    }
    if($deng==3) {
        if($niu['chongniu'] == 4 && 
                ( ($yj_initial_id <= 4 && $yj_initial_id >= 1) ||
                  ($yj_initial_id <= 12 && $yj_initial_id >= 9) ||
                  ($yj_initial_id <= 21 && $yj_initial_id >= 18) ) ) {
            $row++;
        }
        else if($initial >= 19 && $initial <= 23) {
            $row--;
        }
        else if($initial >=14 && $initial <=18) {
            $row++;
        }
    }
    $yj_array[$row][$col][0] .= $niu['graph'];
    $yj_array[$row][$col][1] = $niu['niuid'];
    $yj_array[$row][0][0] = $niu['final_name'] . $niu['hu'] . $deng;
}
$html_table = "<table>";
for($r = 0; $r < 16; $r++) {
    $html_table .= '<tr>';
    for($c = 0; $c < 24; $c++) {
        $html_table .= '<td><a href="../gy_niu/?id=' . $yj_array[$r][$c][1] 
                . '">'
                . $yj_array[$r][$c][0] . '</a></td>';
    }
    $html_table .= '</tr>';
}
$html_table .= '</table>';
$img_file = 'yj/yj' . (intval($page) + 11) . '.jpg';
include 'yj.html.php';
?>