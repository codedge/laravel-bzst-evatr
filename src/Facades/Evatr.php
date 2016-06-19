<?php

namespace Codedge\Evatr\Facades;

use Illuminate\Support\Facades\Facade;

class Evatr extends Facade
{
    /**
     * Get the registered component name.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'evatr';
    }

}