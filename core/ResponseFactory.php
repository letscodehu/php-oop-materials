<?php 

class ResponseFactory {

    private $viewRenderer;

    public function __construct(ViewRenderer $viewRenderer) {
        $this->viewRenderer = $viewRenderer;
    }

    public function createResponse($controllerResult) {
        if (is_array($controllerResult)) {
            if($matches = preg_match("%^redirect\:%", $controllerResult[0])) {
                return new Response("",[
                    "Location" => substr($controllerResult[0], 9)
                ],  302, "Found");
            } else {
                $modelAndView = new ModelAndView($controllerResult[0], $controllerResult[1]);
                return new Response($this->viewRenderer->render($modelAndView), [], 200, "OK");
            }
        }
    }

}