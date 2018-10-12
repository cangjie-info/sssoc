<?php

require "../includes/all.php";
require "../includes/db_connect.php";
require "../parsedown/Parsedown.php";
require "../parsedown-extra/ParsedownExtra.php";


if(!isset($_GET['id'])) {
    $query = "SELECT id, title, zot_tag FROM articles;";
    $statment = $pdo->prepare($query);
    $statment->execute();
    $articles = $statment->fetchAll(PDO::FETCH_ASSOC);
    $article_list_html = "<ul>\n";
    $tag_list = array();
    foreach($articles as $article) {
        $article_list_html .= "<li>" 
                . "<a href='index.php?id=" . $article["id"] . "'>"
                . $article['title']
                . "</a>"
                . " (" . $article['zot_tag'] 
                . ")</li>\n";
        $tag_list[] = $article['zot_tag'];
    }
    $article_list_html .= "</ul>";
    $lonely_tags = array_diff(getZotTags(), $tag_list);
    $lonely_tag_list_html = "<ul>\n";
    foreach ($lonely_tags as $tag) {
        $lonely_tag_list_html .= "<li>$tag</li>"
                . "<form action='new.php' method='post'>"
                . "<input type='hidden' name='zot_tag' value='$tag'>"
                . "<input type='submit' value='NEW'></form>";
    }
    $lonely_tag_list_html .= "\n</ul>";
    include 'article_list.html.php';
}
else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $query = 'SELECT * FROM articles WHERE id = :id;';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();    
    $row = $statement->fetch();
    $zot_tag = $row['zot_tag'];
    $title = $row['title'];
    $Parsedown = new ParsedownExtra();
    $Parsedown->setSafeMode(TRUE);
    $article_text = $Parsedown->text($row['article_text']);
    $bib = getZot('tags', array($zot_tag));
    include 'article.html.php';
}