<?php

namespace AppKit\Blameable\Traits;

use AppKit\Blameable\Facades\Blameable as BlameableFacade;
use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable()
    {
        static::creating(function (Model $model) {
            $model->setAttribute($model->getBlameableColumn('created_by'), Auth::id());
            $model->setAttribute($model->getBlameableColumn('updated_by'), Auth::id());
        });

        static::updating(function (Model $model) {
            $model->setAttribute($model->getBlameableColumn('updated_by'), Auth::id());
        });

        static::deleting(function (Model $model) {
            $model->setAttribute($model->getBlameableColumn('deleted_by'), Auth::id());

            // we need to call the save ourselves when deleting
            $model->save();
        });
    }

    public function blameableColumns(): array
    {
        return config('blameable.columns');
    }

    private function getBlameableColumn($column)
    {
        $columns = $this->blameableColumns();

        if (!array_key_exists($column, $columns)) {
            throw new ErrorException("Blameable does not contain a $column column.");
        }

        return $columns[$column];
    }

    public function creator()
    {
        return $this->belongsTo(BlameableFacade::userModel(), $this->getBlameableColumn('created_by'));
    }

    public function editor()
    {
        return $this->belongsTo(BlameableFacade::userModel(), $this->getBlameableColumn('updated_by'));
    }

    public function deleter()
    {
        return $this->belongsTo(BlameableFacade::userModel(), $this->getBlameableColumn('deleted_by'));
    }
}
