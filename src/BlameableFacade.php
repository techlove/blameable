<?php

namespace AppKit\Blameable;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\Package\Skeleton\SkeletonClass
 */
class BlameableFacade extends Facade
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
