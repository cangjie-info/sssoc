<?php

require "../includes/all.php";
require "../includes/db_connect.php";

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$zot_tag = filter_input(INPUT_POST,'zot_tag', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
$article_text = filter_input(INPUT_POST,'article_text', FILTER_UNSAFE_RAW);

if(!$id) {
    header('Location: .');
}
else if (!($zot_tag && $title && $article_text)) {
    $query = 'SELECT * FROM articles WHERE id = :id;';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();    
    $row = $statement->fetch();
    if(!$row) {
       header('Location: .');
    }
    $zot_tag = $row['zot_tag'];
    $title = $row['title'];
    $article_text = $row['article_text'];    
    $bib = getZot('tags', array($zot_tag));
    include 'edit_form.html.php';
}
else {
    $query = 'UPDATE articles SET zot_tag = :zot_tag, title = :title, article_text = :article_text WHERE id = :id;';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':zot_tag', $zot_tag);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':article_text', $article_text);
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("Location: index.php?id=$id");
}