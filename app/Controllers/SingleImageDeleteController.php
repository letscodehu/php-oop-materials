<?php

class SingleImageDeleteController {
    
    function delete($params) {
        $connection = getConnection();
        deleteImage($connection, $params["id"]);
        return [
            "redirect:/",
            [
            ]
            ];
    }
}