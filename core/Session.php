<?php


class Session implements Storage {

    function get($key)
    {
        return $_SESSION[$key];
    }

    function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    function remove($key)
    {
        unset($_SESSION[$key]);
    }

    function clear()
    {
        unset($_SESSION);
    }

    function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    function toArray() {
        return $_SESSION;
    }
}