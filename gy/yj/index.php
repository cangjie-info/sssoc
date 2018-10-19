<?php

function arab2cjk($n) {
    if($n > 99 || $n < 1) {
        return "##";
    }
    $tens = intdiv($n, 10);
    $units = $n - $tens * 10;
    $cjk_nums = array('〇', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    $cjk = '';
    if($tens > 0) {
        if($tens > 1) {
            $cjk .= $cjk_nums[$tens];
        }
        $cjk .= '十';
    }
    if($units > 0) {
        $cjk .= $cjk_nums[$units];
    }
    return $cjk;
}

$edition = filter_input(INPUT_GET, 'edition', FILTER_SANITIZE_STRING);
if($edition == NULL) {
    $edition = "jzyj";
}

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
if($page == NULL) {
    $page = 1;
}

if($page < 1) {
    $page = 1;
}
if($page > 43) {
    $page = 43;
}

include '../../includes/all.php';
include $includes . 'db_connect.php';

$sql = "SELECT gy_finals.hu AS hu, yj_pages.hu AS yj_hu, deng, "
        . " gy_rhymes.rhyme_name, "
        . "yj_pages.she AS she, final_name, gy_initials.id AS initial, "
        . "yj_pages.zhuan AS zhuan, yj_qu_as_ru, chongniu, "
        . "gy_niu.graph AS graph, gy_niu.tone, yj_col, "
        . "gy_niu.id AS niuid "
        . "FROM gy_finals "
        . "JOIN gy_niu ON final_id = gy_finals.id "
        . "JOIN gy_initials ON initial_id = gy_initials.id "
        . "JOIN yj_pages ON yj_pages.page = gy_finals.yj_page "
        . "JOIN gy_rhymes ON gy_niu.rhyme_id = gy_rhymes.id "
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
    $col = 24 - $niu['yj_col']; // initial uniquely determines column
    $row = $niu['deng'] - 1;    // table row is basically determined by the deng of the final
    $row += ($niu['tone'] - 1) * 4; // move to right tone 
    $deng = $niu['deng'];
    $yj_col = $niu['yj_col'];
    $initial = $niu['initial'];
    if($niu['yj_qu_as_ru'] == 1) {  
        $row += 4; // some qusheng finals are placed like rusheng
    }
    if($deng==3) {
        if($niu['chongniu'] == 4 && 
                ( ($yj_col <= 4 && $yj_col >= 1) ||
                  ($yj_col <= 12 && $yj_col >= 9) ||
                  ($yj_col <= 21 && $yj_col >= 18) ) ) {
            $row++; //chongniu final with grave initial bump down to row 4
        }
        else if($initial >= 19 && $initial <= 23) {
            $row--; // tsr- etc. bump up to row 2
        }
        else if($initial >=14 && $initial <=18) {
            $row++; // ts- etc. bump down to row 4
        }
        else if($initial == 38) {
            $row++; // 喻四
        }
    }
    $yj_array[$row][$col][0] .= $niu['graph'];
    $yj_array[$row][$col][1] = $niu['niuid'];
    $yj_array[$row][0][0] = $niu['rhyme_name'];
}
$she = $result[0]['she'];
$hu = $result[0]['yj_hu'];
$zhuan = $result[0]['zhuan'];
$cjk_page = arab2cjk($page);
$html_table = '<table>'
    . ' <tr><th colspan="1" rowspan = "2">' . $she . '</th>'
    . ' <th colspan="2">舌齒音</th>'
    . ' <th colspan="4">喉音</th>'
    . ' <th colspan="5">齒音</th>'
    . ' <th colspan="4">牙音</th>'
    . ' <th colspan="4">舌音</th>'
    . ' <th colspan="4">脣音</th>' 
    . ' <th rowspan="18">' . $zhuan . '轉弟' . $cjk_page . $hu . '</th></tr>'
    . "\n";

$html_table .= '<tr title="ny"><th>清濁</th>'
        . '<th title="l">清濁</th>'
        . '<th title="h(j), y">清濁</th>'
        . '<th title="h">濁</th>'
        . '<th title="x">清</th>'
        . '<th title="\'">清</th>'
        . '<th title="zr, zy, z">濁</th>'
        . '<th title="sr, sy, s">清</th>'
        . '<th title="dzr, dzy, dz">濁</th>'
        . '<th title="tshr, tsyh, tsh">次清</th>'
        . '<th title="tsr, tsy, ts">清</th>'
        . '<th title="ng">清濁</th>'
        . '<th title="g">濁</th>'
        . '<th title="kh">次清</th>'
        . '<th  title="k">清</th>'
        . '<th  title="n">清濁</th>'
        . '<th title="d">濁</th>'
        . '<th title="th">次清</th>'
        . '<th title="t">清</th>'
        . '<th title="m">清濁</th>'
        . '<th title="b">濁</th>'
        . '<th title="ph">次清</th>'
        . '<th title="p">清</th>'
        . '</tr>' . "\n";    
    
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

// match database yj zhuan 轉 numbers to page images
// qyl has a different order 
$page_offset = ['yj' => 11, 'jzyj' => 13, 'qyl' => -1];
if($edition == 'qyl') {
    if($page >= 31 && $page <= 38) {
        $page_offset['qyl'] += 3;
    }
    if($page >= 39 && $page <= 41) {
        $page_offset['qyl'] -= 8;
    }
}
$padded_page = str_pad($page + $page_offset[$edition], 2, '0', STR_PAD_LEFT);
$img_file = $edition . '/' . $edition . $padded_page . '.jpg';
include 'yj.html.php';
?>