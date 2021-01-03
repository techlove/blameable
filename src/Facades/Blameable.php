<?php

namespace AppKit\Blameable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\Blameable\Blameable
 */
class Blameable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'blameable';
    }
}
