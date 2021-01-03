<?php

namespace AppKit\Blameable\Traits;

use AppKit\Blameable\Facades\Blameable as BlameableFacade;
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

        static::updating(function (Model $model) {
            $model->setAttribute('updated_by', Auth::id());
        });
    }

    public function creator()
    {
        return $this->belongsTo(BlameableFacade::userModel(), 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(BlameableFacade::userModel(), 'updated_by');
    }
}
