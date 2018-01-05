<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../gy_styles.css" />
        <title>YJ page</title>
    </head>
    <body>
        <form method="get" action="./">
            <button type="submit" name="page" value="<?php echo($page + 1); ?>">Next page</button>
            <button type="submit" name="page" value="<?php echo($page - 1 ); ?>">Previous page</button>
            <span class="radio">
                <input id="ed1" type="radio" name="edition" class="radio" value="yj" 
                       <?php if($edition == "yj") { echo("checked"); } ?> />
                <label for="ed1">韻鏡 (1656)</label>
            </span>
            <span class="radio">
                <input id="ed2" type="radio" name="edition" class="radio" value="jzyj"
                       <?php if($edition == "jzyj") { echo("checked"); } ?> />
                <label for="ed2">校正韻鏡 (1682)</label>
            </span>
            <span class="radio">
                <input id="ed3" type="radio" name="edition" class="radio" value="qyl" 
                       <?php if($edition == "qyl") { echo("checked"); } ?> />
                <label for="ed3">七音略 (四庫)</label>
            </span>
            <button type="submit" name="page" value="<?php echo($page); ?>" >Refresh edition</button>
        </form>
        <div class="image">
            <img src='<?php echo($repo_path . $img_file) ?>' />
        </div>
        <?php echo($html_table) ?>
    </body>
</html>


