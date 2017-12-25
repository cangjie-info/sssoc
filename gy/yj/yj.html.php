<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../gy_styles.css" />
        <title>YJ page</title>
    </head>
    <body>
        <form class="button" method="get" action="./">
            <input type="submit" class="button" value="Back" />
            <input type="hidden" name="page" value="<?php echo(intval($page) - 1) ?>">
        </form>
        <form class="button" method="get" action="./">
            <input class="button" type="submit" value="Next" />
            <input type="hidden" name="page" value="<?php echo(intval($page) + 1) ?>">
        </form>
        <div class="image">
            <img src='<?php echo($repo_path . $img_file) ?>' />
        </div>
        <?php echo($html_table) ?>
    </body>
</html>


