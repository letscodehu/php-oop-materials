<?php

namespace Controllers;

use Services\PhotoService;

class SingleImageDeleteController {
    
    private $photoService;

    public function __construct(PhotoService $photoService) {
        $this->photoService = $photoService;
    }

    function delete($params) {
        $this->photoService->deleteImage($params["id"]);
        return [
            "redirect:/",
            [
            ]
            ];
    }
}