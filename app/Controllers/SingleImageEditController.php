<?php 

namespace Controllers;

use Services\PhotoService;

class SingleImageEditController {

    private $photoService;

    public function __construct(PhotoService $photoService) {
        $this->photoService = $photoService;
    }

    function edit($params) {
        $title = $_POST["title"];
        $id = $params["id"];
        $this->photoService->updateImage($id, $title);
        return [
            "redirect:/image/$id",
            [
            ]
        ];
    }

}