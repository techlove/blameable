<?php

namespace AppKit\Blameable\Traits;

use AppKit\Blameable\Facades\Blameable as BlameableFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable()
    {
        $columns = config('blameable.columns');

        static::creating(function (Model $model) use ($columns) {
            $model->setAttribute($columns['created_by'], Auth::id());
            $model->setAttribute($columns['updated_by'], Auth::id());
        });

        static::updating(function (Model $model) use ($columns) {
            $model->setAttribute($columns['updated_by'], Auth::id());
        });

        static::deleting(function (Model $model) use ($columns) {
            $model->setAttribute($columns['deleted_by'], Auth::id());

            // we need to call the save ourselves when deleting
            $model->save();
        });
    }

    public function creator()
    {
        return $this->belongsTo(BlameableFacade::userModel(), config('blameable.columns.created_by'));
    }

    public function editor()
    {
        return $this->belongsTo(BlameableFacade::userModel(), config('blameable.columns.updated_by'));
    }
}
