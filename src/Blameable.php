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

    /**
     * The name of the default guard that is being used
     *
     * @return string
     */
    public function guard(): string
    {
        return $this->app['config']->get('auth.defaults.guard');
    }

    /**
     * The name of the default user provider
     *
     * @return string
     */
    public function provider(): string
    {
        $guard = $this->guard();

        return $this->app['config']->get("auth.guards.$guard.provider");
    }

    /**
     * The class name of the default user model
     *
     * @return string
     */
    public function userModel(): string
    {
        $provider = $this->provider();

        return $this->app['config']->get("auth.providers.$provider.model");
    }

    /**
     * Get the value that will be stored in the database, defaults to the users id
     *
     * @return int
     */
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

    /**
     * Set a custom user callback closure
     *
     * @param closure $callback
     * @return void
     * @throws ErrorException
     */
    public function userCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new ErrorException('The user callback must be callable');
        }

        $this->userCallback = $callback;
    }
}
