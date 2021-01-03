<?php

namespace AppKit\Blameable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable()
    {
        static::creating(function (Model $model) {
            $model->setAttribute('created_by', Auth::id());
            $model->setAttribute('updated_by', Auth::id());
        });
    }
}
