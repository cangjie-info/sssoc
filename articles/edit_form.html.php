<!DOCTYPE html>
<html>
    <head>
        <title>EDIT: <?php echo $title; ?></title>
        <meta charset="utf-8" />    
        <link rel="stylesheet" type="text/css" href="articles_styles.css" />
    </head>
    <body>
        <h1>EDIT: <?php echo $title ?></h1>
        <form action="edit.php" method="post">
            <label for="title">Title:</label>
            <input id="title" type="text" name="title" value="<?php echo $title; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <label for="zot_tag">Zotero tag: <label>
            <input id="zot_tag" type="text" name="zot_tag" value="<?php echo $zot_tag; ?>" />
            <textarea name="article_text"><?php echo $article_text; ?></textarea>
            <input type="submit" value="DONE" />
        </form>
        <form action="edit.php">
            <input type="submit" value="CANCEL" />
        </form>
        <hr />
        <?php echo $bib ?>
    </body>
</html>
