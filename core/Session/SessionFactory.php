<?php


namespace Session;

class SessionFactory
{

    public static function build($driver, $config) {
        if ($driver == 'file') {
            return new FileSession($config);
        } else {
            return new BuiltInSession();
        }
    }

}