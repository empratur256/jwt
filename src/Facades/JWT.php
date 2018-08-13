<?php

namespace empratur256\JWT\Facades;

use Illuminate\Support\Facades\Facade;

class JWT extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'JWT';
    }
}
