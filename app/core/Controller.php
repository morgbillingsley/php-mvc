<?php
class Controller {

    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data=[]) {
        require_once '../app/config.php';
        $data['site_title'] = SITE_TITLE;
        $public_dir = MAINDIR;
        require_once '../app/views/' . $view . '.php';
    }

    public function error() {
        require_once '../app/config.php';
        $data['site_title'] = SITE_TITLE;
        $public_dir = MAINDIR;
        require_once '../app/views/templates/404.php';
    }
    
}
?>