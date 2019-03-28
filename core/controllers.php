<?php 


function singleImageDeleteController($params) {
    $connection = getConnection();
    deleteImage($connection, $params["id"]);
    return [
        "redirect:/",
        [
        ]
        ];
}

function loginFormController() {
    $containsError = array_key_exists("containsError", $_SESSION);
    unset($_SESSION["containsError"]);
    return [
        "login", [
            "title" => "Login",
            "containsError" => $containsError
        ]
    ];    
}

function singleImageController($params) {
    $connection = getConnection();
    $picture = getImageById($connection, $params["id"]);
    return [
        "single",
        [
            "title" => $picture->title,
            "picture" => $picture
        ]
        ];
}


function homeController() {
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


function singleImageEditController($params) {
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

function logoutSubmitController() {
    unset($_SESSION["user"]);
    return [
        "redirect:/", [
        ]
    ];
}


function notFoundController() {
    return [
        "404", [
            "title" => "The page you are looking for is not found."
        ]
    ];
}


function loginSubmitController() {
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $user = loginUser(getConnection(), $email, $password);
    if ($user != null) {
        $_SESSION["user"] = [
            "name" => $user["name"]
        ];
        $view = "redirect:/";
    } else {
        $_SESSION["containsError"] = 1;
        $view = "redirect:/login";
    }
    return [
        $view, []
    ];    
}
