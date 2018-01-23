<?php

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

include 'xilian.html.php';

?>
