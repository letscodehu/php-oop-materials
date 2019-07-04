<?php 



function getPhotosPaginated($connection, $size, $offset) {
    if ($statement = mysqli_prepare($connection, 'SELECT * FROM photos LIMIT ? OFFSET ?')) {
        mysqli_stmt_bind_param($statement, "ii", $size, $offset);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return array_map(function($row) {
            return new Photo($row["id"],  $row["title"], $row["url"], $row["thumbnail"]);
        }, $rows);
    } else {
        logMessage('ERROR','Query error: '. mysqli_error($connection));
        errorPage();
    }
}

function logMessage($level, $message) {
    $file = fopen('application.log', "a");
    fwrite($file, "[$level] $message". PHP_EOL);
    fclose($file);
}

function errorPage() {
    include "templates/error.php";
}

function getTotal($connection) {
    if ($result = mysqli_query($connection, "SELECT count(*) as count FROM photos")) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        throw new Exception('Query error: '. mysqli_error($connection));
    }
}

function paginate($total, $currentPage, $size) {
    $page = 0;
    $markup = "";
    if ($currentPage > 1) {
        $previousPage = $currentPage - 1;
        $markup .= 
        "<li class=\"page-item\">
            <a class=\"page-link\" href=\"?size=$size&page=$previousPage\">Previous</a>
        </li>";
    }
    for ($i = 0; $i < $total; $i += $size) {
        $page++;
        $activeClass = $currentPage == $page ? 'active' : '';
        $markup .= 
        "<li class=\"page-item $activeClass\">
            <a class=\"page-link\" href=\"?size=$size&page=$page\">$page</a>
        </li>"; 
    }
    if ($currentPage < $page) {
        $nextPage = $currentPage + 1;
        $markup .= 
        "<li class=\"page-item\">
            <a class=\"page-link\" href=\"?size=$size&page=$nextPage\">Next</a>
        </li>";
    }
    return $markup;
}

function getImageById($connection, $id) {
    if ($statement = mysqli_prepare($connection, 'SELECT * FROM photos WHERE id = ?')) {
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);
        return new Photo($row["id"],  $row["title"], $row["url"], $row["thumbnail"]);
    } else {
        logMessage('ERROR','Query error: '. mysqli_error($connection));
        errorPage();
    }
}

function getConnection() {
    global $config;
    $connection = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    if (!$connection) {
        logMessage('ERROR',"Connection error: ". mysqli_connect_error());
        errorPage();
    } 
    return $connection;
}

function updateImage($connection, $id, $title) {
    if ($statement = mysqli_prepare($connection, 'UPDATE photos SET title = ? WHERE id = ?')) {
        mysqli_stmt_bind_param($statement, "si", $title, $id);
        mysqli_stmt_execute($statement);
    } else {
        logMessage('ERROR','Query error: '. mysqli_error($connection));
        errorPage();
    }
}

function loginUser($connection, $email, $password) {
    if ($statement = mysqli_prepare($connection, 'SELECT name, password FROM photos_users WHERE email = ?')) {
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $record = mysqli_fetch_assoc($result);
        if ($record != null && password_verify($password, $record["password"])) {
            return $record;
        } else {
            return null;
        }
    } else {
        logMessage('ERROR','Query error: '. mysqli_error($connection));
        errorPage();
    }
}


function esc($string) {
    echo htmlspecialchars($string);
}

function deleteImage($connection, $id) {
    if ($statement = mysqli_prepare($connection, 'DELETE FROM photos WHERE id = ?')) {
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);
    } else {
        logMessage('ERROR','Query error: '. mysqli_error($connection));
        errorPage();
    }
}

function createUser() {
    $loggedIn = array_key_exists("user", $_SESSION);
    return [
        "loggedIn" => $loggedIn,
        "name" => $loggedIn ? $_SESSION["user"]["name"] : null
    ];
}
