<?php

require_once 'model/PostManager.php';
require_once 'model/CommentManager.php';
require_once 'model/Pagination.php';

function listPosts($page) {
    $postManager = new PostManager();
    $pagination = new Pagination();

    $postManager->setPostView(3);
    $posts = $postManager->getPosts($page);
    $pagination->setPostView(3);
    $pagesNumber = $pagination->getArticlesCount();

    require 'view/frontend/listPostsView.php';
}


function post($id, $page) {
    $postManager = new PostManager();
    $commentManager = new CommentManager();
    $pagination = new Pagination();

    $post = $postManager->getPost($id);
    $commentManager->setPostView(4);
    $comments = $commentManager->getComments($id, $page);
    $pagination->setPostView(4);
    $pagesNumber = $pagination->getCommentsCount($id);

    require 'view/frontend/postView.php';
}


function addComment($postId, $author, $comment) {
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire!');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}