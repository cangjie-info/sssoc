<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8" />    
        <link rel="stylesheet" type="text/css" href="./articles_styles.css" />
    </head>
    <body>
        
        <!-- navigation -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="new.php">New</a>
            </ul>
        </nav>
        
        <!-- article is viewable by all users -->
        <article>
            <h1><?php echo $title ?></h1>
            <?php echo $article_text ?>
        </article>
        <?php echo $bib ?>
        <?php echo "<br />Zotero tag: $zot_tag"; ?>
        
        
        
        <!-- edit button should be shown only to editors -->
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="submit" value="EDIT" />
        </form>
        
    </body>
</html>
