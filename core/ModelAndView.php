<?php 

class ModelAndView {

    private $model;
    private $viewName;

    public function __construct(string $viewName, array $model = []) {
        $this->viewName = $viewName;
        $this->model = $model;
    }

    public function getViewName() {
        return $this->viewName;
    }

    public function getModel() {
        return $this->model;
    }

}