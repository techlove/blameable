<?php

namespace AppKit\Blameable\Traits;

use AppKit\Blameable\Facades\Blameable as BlameableFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable()
    {
        $config = config('blameable');

        static::creating(function (Model $model) use ($config) {
            $model->setAttribute($config['created_by_column'], Auth::id());
            $model->setAttribute($config['updated_by_column'], Auth::id());
        });

        static::updating(function (Model $model) use ($config) {
            $model->setAttribute($config['updated_by_column'], Auth::id());
        });

        static::deleting(function (Model $model) use ($config) {
            $model->setAttribute($config['deleted_by_column'], Auth::id());

            // we need to call the save ourselves when deleting
            $model->save();
        });
    }

    public function creator()
    {
        return $this->belongsTo(BlameableFacade::userModel(), config('blameable.created_by_column'));
    }

    public function editor()
    {
        return $this->belongsTo(BlameableFacade::userModel(), config('blameable.updated_by_column'));
    }
}
