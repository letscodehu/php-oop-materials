<?php

namespace Controllers;

use Services\PhotoService;

class SingleImageController {
    
    private $photoService;

    public function __construct(PhotoService $photoService) {
        $this->photoService = $photoService;
    }

    function display($params) {
        $picture = $this->photoService->getImageById($params["id"]);
        return [
            "single",
            [
                "title" => $picture->getTitle(),
                "picture" => $picture
            ]
            ];
    }
}