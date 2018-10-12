<!DOCTYPE html>
<html>
    <head>
        <title>NEW</title>
        <meta charset="utf-8" />    
        <link rel="stylesheet" type="text/css" href="articles_styles.css" />
    </head>
    <body>
        <h1>NEW ARTICLE</h1>
        <form action="new.php" method="post">
            <label for="title">Title:</label>
            <input id="title" type="text" name="title" value="<?php echo $title; ?>" />
            <label for="zot_tag">Zotero tag: </label>
            <input id="zot_tag" type="text" name="zot_tag" value="<?php echo $zot_tag; ?>" />
            <textarea name="article_text"><?php echo $article_text; ?></textarea>
            <input type="submit" value="DONE" />
        </form>
        <form action="index.php">
            <input type="submit" value="CANCEL" />
        </form>
        <hr />
        <?php echo $bib ?>
    </body>
</html>
