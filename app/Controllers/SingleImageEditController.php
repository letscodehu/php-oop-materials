<?php 

namespace Controllers;

class SingleImageEditController {

    function edit($params) {
        $title = $_POST["title"];
        $id = $params["id"];
        $connection = getConnection();
        updateImage($connection, $id, $title);
        return [
            "redirect:/image/$id",
            [
            ]
        ];
    }

}