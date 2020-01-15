<?php

namespace Session;

use Exception;

class FileSession implements Session {

    private $id;
    private $folder;
    private $filename;
    private $data = null;

    public function __construct(array $config)
    {
        $this->id = session_id();
        $this->folder = $config['folder'];
        $this->filename = $this->folder.DIRECTORY_SEPARATOR.$this->id;
    }

    function get($key)
    {
        return $this->getData()[$key];
    }

    function put($key, $value)
    {
        $this->getData();
        $this->data[$key] = $value;
        $this->persist();
    }

    function remove($key)
    {
        $this->getData();
        unset($this->data[$key]);
        $this->persist();
    }

    function clear()
    {
        $this->data = [];
        $this->persist();
    }

    function has($key)
    {
        return array_key_exists($key, $this->getData());
    }

    function toArray() {
        return $this->getData();
    }

    private function getData() {
        if ($this->data == null) {
            if (file_exists($this->filename)) {
                $this->data = unserialize(file_get_contents($this->filename));
            } else $this->data = [];
        }
        return $this->data;
    }

    private function persist() {
        if (!file_put_contents($this->filename, serialize($this->data))) {
            throw new \Exception("Cant write file: ". $this->filename);
        }
    }
}