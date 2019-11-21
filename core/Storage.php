<?php


interface Storage {

    function has($key);
    function get($key);
    function put($key, $value);
    function remove($key);
    function clear();

}