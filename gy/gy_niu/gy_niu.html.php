<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../gy_styles.css" />
        <title>GY niu</title>
    </head>
    <body>
        <h1 class="head_graph"><span>Homophone group: <?php echo($result[0]['graph']) ?></span></h1>
        <p>
            <span><i>Fanqie</i>: <em><?php echo($result[0]['fanqie_1'] 
                . $result[0]['fanqie_2'] . "切"); ?></em></span>
            <span><i>Yun jing</i> 韻鏡 page: <em><?php echo($result[0]['yjpage']); ?> </em>
                <a href='../yj/?page=<?php echo($result[0]['yjpage']); ?>'>(link)</a></span>
        </p>
        <?php 
            foreach($result as $row) {
                $id = $row['id'];
                $entry = $row['entry'];
                $graph = $row['graph'];
                include 'output_form.html.php';
            }
        ?>
    </body>
</html>
