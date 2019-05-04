<?php
namespace Controllers;

class NotFoundController {

    public function __invoke() {
        return [
            "404", [
                "title" => "The page you are looking for is not found."
            ]
        ];
    }

}