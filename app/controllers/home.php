<?php
class Home extends Controller {
    
    public function index() {
        $this->view('templates/front', ['page_title' => 'Home']);
    }

}
?>