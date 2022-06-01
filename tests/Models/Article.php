<?php

namespace AppKit\Blameable\Tests\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Blameable;

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
