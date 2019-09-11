<?php

require 'model/model.php';

function listPosts() {
    $posts = getPosts();

    require 'view/listPostsView.php';
}

function post() {
    $post = getPost($_GET['id']);
    $comments = getComments($_GET['id']);

    require 'view/postView.php';
}