<?php

namespace AppKit\Blameable;

use AppKit\Blameable\Facades\Blameable as BlameableFacade;

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
        $guard = $this->guard();

        return $this->app['config']->get("auth.guards.$guard.provider");
    }

    public function userModel()
    {
        $provider = $this->provider();

        return $this->app['config']->get("auth.providers.$provider.model");
    }
}
