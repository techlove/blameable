<?php

namespace AppKit\Blameable\Tests\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleSoftDeletes extends Model
{
    use Blameable;
    use SoftDeletes;

    protected $table = 'articles_sd';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
    ];
}
