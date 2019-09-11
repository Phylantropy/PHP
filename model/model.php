<?php

function getPosts() {
    $db = dbConnect();
    $req = $db->query('SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM articles ORDER BY date_creation DESC LIMIT 0, 5');

    return $req;
}


function getPost($postId) {

    $db = dbConnect();
    $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM articles WHERE id = ?');
    $req->execute(array($postId) );
    $post = $req->fetch();

    // var_dump($req->fetchAll() );
   
    return $post;
}


function getComments($postId) {

    $db = dbConnect();
    $comments = $db->prepare('SELECT id, author, content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
    $comments->execute(array($postId) );
    //$comments = $req->fetch();

    // var_dump($comments->fetchAll() );

    return $comments;
}


function dbConnect() {
    try {
        $db = new PDO('mysql:host=localhost;dbname=P4blog;charset=utf8', 'blog', 'toto1234');
        return $db;
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage() );
    }
}








// function showLastArticle() {
//     $article = array(
//         'title' => 'Mon article',
//         'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Et leo duis ut diam quam nulla. Congue quisque egestas diam in. Turpis tincidunt id aliquet risus feugiat in ante metus dictum. A scelerisque purus semper eget. Eu tincidunt tortor aliquam nulla facilisi cras fermentum odio. Penatibus et magnis dis parturient montes nascetur ridiculus. Nam aliquam sem et tortor consequat id porta nibh. Pellentesque pulvinar pellentesque habitant morbi. Sit amet nulla facilisi morbi tempus iaculis. Lobortis scelerisque fermentum dui faucibus in ornare quam viverra. Massa id neque aliquam vestibulum morbi blandit cursus risus. Eget mi proin sed libero enim sed. Tempus urna et pharetra pharetra massa massa ultricies mi quis. In nulla posuere sollicitudin aliquam ultrices. Senectus et netus et malesuada fames ac turpis egestas.'
//     );

//     return $article;
// }