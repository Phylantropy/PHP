<?php

require_once 'Router.php';

$Router = new Router();

$action =  ( !isset($_GET['action']) || empty( $_GET['action'] )) ? 'listPosts' : $_GET['action'];

$start = ( method_exists( $Router, $action )) ? $Router->$action() : $Router->listPosts();