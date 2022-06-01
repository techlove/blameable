<?php

namespace AppKit\Blameable\Tests\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCustomColumns extends Model
{
    use Blameable;
    use SoftDeletes;

    protected $table = 'articles_custom_columns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
    ];

    public function blameableColumns(): array
    {
        return [
            'created_by' => 'user_who_created',
            'updated_by' => 'user_who_updated',
            'deleted_by' => 'user_who_deleted',
        ];
    }
}
