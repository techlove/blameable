<?php

namespace AppKit\:package_name_php\Tests\Models;

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
