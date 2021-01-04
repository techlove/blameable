<?php

namespace AppKit\Blameable;

use ErrorException;
use Illuminate\Support\Facades\Auth;

class Blameable
{
    private $app;
    private $userCallback;

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

        if (is_callable($this->userCallback)) {
            return call_user_func($this->userCallback);
        }

        return Auth::id();
    }

    public function userCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new ErrorException('The user callback must be callable');
        }

        $this->userCallback = $callback;
    }
}
