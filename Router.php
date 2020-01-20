<?php

require_once 'controller/Backend.php';
require_once 'controller/Frontend.php';
require_once 'controller/InscriptionManager.php';
require_once 'controller/ConnectionManager.php';

class Router {

    private $Backend = '';
    private $Frontend = '';
    private $InscriptionManager = '';
    private $ConnectionManager = '';

    public function __construct() {
        session_start();
        $this->Backend = new Backend();
        $this->Frontend = new Frontend();
        $this->InscriptionManager = new InscriptionManager();
        $this->ConnectionManager = new ConnectionManager();
    }

    public function listPosts() {
        $result = $this->Frontend->listPosts();
    }
    
    public function postView() {
        $result = $this->Frontend->postView();
    }

    public function addComment() {
        $result = $this->Frontend->addComment();
    }

    public function subscribe() {
        require_once 'view/backend/inscriptionView.php';
    }

    public function subscription() {
        $result = $this->InscriptionManager->addUser();
    }

    public function connectionView() {
        require_once 'view/backend/connectionView.php';
    }

    public function connection() {
        $result = $this->ConnectionManager->connectUser();
    }

    public function disconnection() {
        $result = $this->ConnectionManager->disconnection();
    }
    
    public function administration() {
        $result = $this->Backend->adminPanel();
    }

    public function newPostPanel() {
        $result = $this->Backend->newPostPanel();
    }

    public function addPost() {
        $result = $this->Backend->addPost();
    }

    public function editPost() {
        $result = $this->Backend->editPostPanel();
    }

    public function updatePost() {
        $result = $this->Backend->updatePost();
    }

    public function deletePost() {
        $result = $this->Backend->deletePost();
    }

    public function reportComment() {
        $result = $this->Backend->reportComment();
    }

    public function commentsModeration() {
        $result = $this->Backend->reportedComments();
    }

    public function moderateComment() {
        $result = $this->Backend->moderateComment();
    }

    public function deleteReportedComment() {
        $result = $this->Backend->deleteReportedComment();
    }
}