<?php

require "../includes/all.php";
require "../includes/db_connect.php";

$zot_tag = filter_input(INPUT_POST,'zot_tag', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
$article_text = filter_input(INPUT_POST,'article_text', FILTER_UNSAFE_RAW);

if (!$article_text) { // use form to get data
    if(!$zot_tag) {
        $zot_tag = "zot_tag";
        $title = "title";
    }
    else {
        $title = $zot_tag;
    }
    $article_text = "# h1 \n *emphasis* **strong** \n"
        . "> blockquote \n"
        . "1. First item \n2. Second item\n3. Third item \n"
        . "- First item \n"
        . "- Second item \n"
        . "- Third item \n"
        . "`code`\n"
        . "--- \n"
        . "[title](https://www.example.com) \n"
        . "![alt text](image.jpg)";
    include 'new_form.html.php';
} 
else { // user clicked "DONE" in new_form.html.php form
    $query = 'INSERT INTO articles '
           . '(title, zot_tag, article_text) '
           . 'VALUES (:title, :zot_tag, :article_text);';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':zot_tag', $zot_tag);
    $statement->bindValue(':article_text', $article_text);
    $statement->execute();
    $id = $pdo->lastInsertId();
    header("Location: .?id=$id");
}