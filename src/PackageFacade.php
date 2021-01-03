<?php

namespace AppKit\:package_name_php;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AppKit\Package\Skeleton\SkeletonClass
 */
class :package_name_phpFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ':package_name';
    }
}
