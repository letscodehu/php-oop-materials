<?php 

function logMessage($level, $message) {
    $file = fopen('application.log', "a");
    fwrite($file, "[$level] $message". PHP_EOL);
    fclose($file);
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
        throw new SqlException('Query error: '. mysqli_error($connection));
    }
}

function esc($string) {
    echo htmlspecialchars($string);
}

function createUser() {
    $loggedIn = array_key_exists("user", $_SESSION);
    return [
        "loggedIn" => $loggedIn,
        "name" => $loggedIn ? $_SESSION["user"]["name"] : null
    ];
}
