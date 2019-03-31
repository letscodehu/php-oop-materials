<?php


class Application {

    public function start() {
        ob_start();
        $uri = $_SERVER["REQUEST_URI"];
        $cleaned = explode("?", $uri)[0];
        $dispatcher = new Dispatcher('notFoundController');
        $dispatcher->addRoute('/', 'homeController');
        $dispatcher->addRoute('/about', 'aboutController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)', 'singleImageController');
        $dispatcher->addRoute('/image/(?<id>[\d]+)/edit', 'singleImageEditController', "POST");
        $dispatcher->addRoute('/image/(?<id>[\d]+)/delete', 'singleImageDeleteController', "POST");
        
        $dispatcher->addRoute('/login', 'loginFormController');
        $dispatcher->addRoute('/logout', 'logoutSubmitController');
        $dispatcher->addRoute('/login', 'loginSubmitController', "POST");
        
        list($view, $data) = $dispatcher->dispatch($cleaned);
        
        if(preg_match("%^redirect\:%", $view)) {
            $redirectTarget = substr($view, 9);
            header("Location:".$redirectTarget);
            die;
        }
        extract($data);
        $user = createUser();
        ob_clean();
        require_once "templates/layout.php";
        
    }


}