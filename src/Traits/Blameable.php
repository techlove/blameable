<?php

namespace AppKit\Blameable\Traits;

use AppKit\Blameable\Facades\Blameable as BlameableFacade;
use ErrorException;
use Illuminate\Database\Eloquent\Model;

trait Blameable
{
    /**
     * Boot method of the trait
     * This is run when the model is booted
     *
     * @return void
     */
    public static function bootBlameable()
    {
        // add the listener for when we are creating
        static::creating(function (Model $model) {
            $model->setAttribute($model->getBlameableColumn('created_by'), BlameableFacade::getUser());
            $model->setAttribute($model->getBlameableColumn('updated_by'), BlameableFacade::getUser());
        });

        // add the listener for when we are updating
        static::updating(function (Model $model) {
            $model->setAttribute($model->getBlameableColumn('updated_by'), BlameableFacade::getUser());
        });

        // add the listener for when we are deleting
        static::deleting(function (Model $model) {
            $model->setAttribute($model->getBlameableColumn('deleted_by'), BlameableFacade::getUser());

            // we need to call the save ourselves when deleting
            $model->save();
        });
    }

    /**
     * Get the name of the columns used in the trait
     * This can be overridden in the model to provide custom columns
     *
     * @return array
     */
    public function blameableColumns(): array
    {
        return config('blameable.columns');
    }

    /**
     * Get the column name for a specific function
     *
     * @param string $column
     * @return string
     * @throws ErrorException
     */
    private function getBlameableColumn(string $column): string
    {
        $columns = $this->blameableColumns();

        if (!array_key_exists($column, $columns)) {
            throw new ErrorException("Blameable does not contain a $column column.");
        }

        return $columns[$column];
    }

    /**
     * Creator Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function creator()
    {
        return $this->belongsTo(BlameableFacade::userModel(), $this->getBlameableColumn('created_by'));
    }

    /**
     * Editor Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function editor()
    {
        return $this->belongsTo(BlameableFacade::userModel(), $this->getBlameableColumn('updated_by'));
    }

    /**
     * Deleter Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function deleter()
    {
        return $this->belongsTo(BlameableFacade::userModel(), $this->getBlameableColumn('deleted_by'));
    }
}
