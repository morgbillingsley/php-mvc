<?php
class Page_Not_Found extends Controller {
    
    public function index() {
        $this->view('templates/404', ['page_title' => 'Page Not Found']);
    }

}
?>