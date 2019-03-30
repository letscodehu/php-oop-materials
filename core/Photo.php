<?php 

class Photo {

    public $id;
    public $title;
    public $url;
    public $thumbnail;

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

}