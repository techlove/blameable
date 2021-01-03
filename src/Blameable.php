<?php

namespace AppKit\Blameable;

use Illuminate\Support\Facades\Auth;

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

    public function getUser()
    {
        if (!Auth::check()) {
            // we don't have a user
            return null;
        }

        return Auth::id();
    }
}
