<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../gy_styles.css" />
        <title>GY graph</title>
    </head>
    <body> 
        <form action="." method="post">
            <span><label for="graph">Graph:</label></span>
                <input type="text" name="graph" id="graph" />
            <input  type="submit" value="Search" />
        </form>
        <?php if(count($result) == 0) {
 exit(); } ?>
        <h1 class="head_graph"><span><?php echo($result[0]['graph']) ?></span></h1>
        <?php 
            foreach($result as $row) {
                $entry = $row['entry'];
                $niu = $row['niu'];
                $niu_id = $row['niuid'];
                $page = $row['page'];
                $yj_page = $row['yj_page'];
                $img_file = page_img($page);
                $number = $row['number'];
                $fanqie_1 = $row['fanqie_1'];
                $fanqie_2 = $row['fanqie_2'];
                $tones = array('平', '上', '去', '入');
                $tone = $tones[intval($row['tone']) - 1];
                $initial_name = $row['initial_name'];
                $initial_ipa_pan = $row['initial_ipa_pan'];
                $she = $row['she'];
                $hu = $row['hu'];
                $deng = $row['deng'];
                $final_ipa_pan = $row['final_ipa_pan'];
                $rhyme_name = $row['rhyme_name'];
                include 'output_form.html.php';
            }
        ?>
    </body>
</html>