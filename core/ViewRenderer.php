<?php 

class ViewRenderer {

    private $basePath;

    public function __construct(string $basePath) {
        $this->basePath = $basePath;
    }

    public function render(ModelAndView $modelAndView) {
        extract($modelAndView->getModel());
        ob_clean();
        $view = $modelAndView->getViewName();
        require_once $this->basePath."/templates/layout.php";
        return ob_get_clean();
    }

}