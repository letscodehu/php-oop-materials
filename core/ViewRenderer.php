<?php 

class ViewRenderer {

    public function render(ModelAndView $modelAndView) {
        extract($modelAndView->getModel());
        ob_clean();
        $view = $modelAndView->getViewName();
        require_once "templates/layout.php";
        return ob_get_clean();
    }

}