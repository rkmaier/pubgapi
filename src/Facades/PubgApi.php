<?php
namespace Rkmaier\PubgApi\Facades;

use \Illuminate\Support\Facades\Facade;

class PubgApi extends Facade {
    
    protected static function getFacadeAccessor() {
        return 'PubgApi';
    }
}