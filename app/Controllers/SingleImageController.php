<?php


class SingleImageController {
        
    function display($params) {
        $connection = getConnection();
        $picture = getImageById($connection, $params["id"]);
        return [
            "single",
            [
                "title" => $picture->getTitle(),
                "picture" => $picture
            ]
            ];
    }
}