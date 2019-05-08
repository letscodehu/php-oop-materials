<?php

class HomeController {

    function handle() {
        $size = $_GET["size"] ?? 15;
        $page = $_GET["page"] ?? 1;    
        $connection = getConnection();
        $total = getTotal($connection);
        $offset = ($page - 1) * $size;
        $content = getPhotosPaginated($connection, $size, $offset);
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