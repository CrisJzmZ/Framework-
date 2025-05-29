<?php
class ErrorController {
    private $view;
    
    public function __construct() {
        $this->view = new View();
    }
    
    public function notFound() {
        http_response_code(404);
        $this->view->render('error/404');
    }
    
    public function serverError() {
        http_response_code(500);
        $this->view->render('error/500');
    }
    
    public function forbidden() {
        http_response_code(403);
        $this->view->render('error/403');
    }
}
