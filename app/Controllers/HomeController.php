<?php

namespace Controllers;

use Services\PhotoService;

class HomeController {

    private $photoService;

    public function __construct(PhotoService $photoService) {
        $this->photoService = $photoService;
    }

    function handle() {
        $size = $_GET["size"] ?? 15;
        $page = $_GET["page"] ?? 1;    
        $total = $this->photoService->getTotal();
        $offset = ($page - 1) * $size;
        $content = $this->photoService->getPhotosPaginated($size, $offset);
        $possiblePageSizes = [10, 25, 30, 40, 50];
      
        return [
            "home",
            [
                "title" => "Home",
                "content" => $content,
                "total" => $total,
                "size" => $size,
                "page" => $page,
                "offset" => $offset,
                "possiblePageSizes" => $possiblePageSizes
            ]
        ];
    }
    

}