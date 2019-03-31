<?php 

class Photo {

    private $id;
    private $title;
    private $url;
    private $thumbnail;

    public function __construct($id, $title, $url, $thumbnail) {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->thumbnail = $thumbnail;
        if ($this->id == null) {
            logMessage("WARN", "id field is null");
        }
        if ($this->title == null) {
            logMessage("WARN", "title field is null");
        }
        if ($this->url == null) {
            logMessage("WARN", "url field is null");
        }
        if ($this->thumbnail == null) {
            logMessage("WARN", "thumbnail field is null");
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }
    
}