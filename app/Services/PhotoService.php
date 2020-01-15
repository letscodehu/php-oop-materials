<?php 

namespace Services;

use Exception\SqlException;
use Photo;

class PhotoService {

    /**
     * @var mysqli
     */
    private $connection;

    public function __construct(\mysqli $connection) {
        $this->connection = $connection;
    }

    function getPhotosPaginated($size, $offset) {
        if ($statement = mysqli_prepare($this->connection, 'SELECT * FROM photos LIMIT ? OFFSET ?')) {
            mysqli_stmt_bind_param($statement, "ii", $size, $offset);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return array_map(function($row) {
                return new Photo($row["id"],  $row["title"], $row["url"], $row["thumbnail"]);
            }, $rows);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    function getTotal() {
        if ($result = mysqli_query($this->connection, "SELECT count(*) as count FROM photos")) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'];
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    function getImageById($id) {
        if ($statement = mysqli_prepare($this->connection, 'SELECT * FROM photos WHERE id = ?')) {
            mysqli_stmt_bind_param($statement, "i", $id);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $row = mysqli_fetch_assoc($result);
            return new Photo($row["id"],  $row["title"], $row["url"], $row["thumbnail"]);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    function deleteImage($id) {
        if ($statement = mysqli_prepare($this->connection, 'DELETE FROM photos WHERE id = ?')) {
            mysqli_stmt_bind_param($statement, "i", $id);
            mysqli_stmt_execute($statement);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    function updateImage($id, $title) {
        if ($statement = mysqli_prepare($this->connection, 'UPDATE photos SET title = ? WHERE id = ?')) {
            mysqli_stmt_bind_param($statement, "si", $title, $id);
            mysqli_stmt_execute($statement);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

}