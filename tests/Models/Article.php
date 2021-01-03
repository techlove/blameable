<?php

namespace AppKit\Blameable\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Fillable attributes
     */
    protected $fillable = [
        'title',
        'body'
    ];
}
