<?php 

namespace Exception;

class ServiceNotFoundException extends \Exception {
    
    public function __construct(string $service) {
        parent::__construct("Service with name '". $service . "' is not found!");
    }

}