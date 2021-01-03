<?php

namespace AppKit\Blameable;

use AppKit\Blameable\Facades\Blameable as FacadesBlameable;

class Blameable
{
    private $app;

    public function __construct()
    {
        $this->app = app();
    }

    public function guard()
    {
        return $this->app['config']->get('auth.defaults.guard');
    }

    public function provider()
    {
        $guard = FacadesBlameable::guard();

        return $this->app['config']->get("auth.guards.$guard.provider");
    }

    public function userModel()
    {
        $provider = FacadesBlameable::provider();

        return $this->app['config']->get("auth.providers.$provider.model");
    }
}
