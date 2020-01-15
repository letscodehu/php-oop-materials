<?php 
namespace Controllers;

class NotFoundController {

    public function handle() {
        return [
            "404", [
                "title" => "The page you are looking for is not found."
            ]
        ];
    }

}