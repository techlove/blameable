<?php

namespace AppKit\Blameable\Tests;

use AppKit\Blameable\Tests\Models\Article;
use Illuminate\Support\Facades\Schema;

class BlameableTest extends TestCase
{
    /** @test */
    public function migrationsCanContainBlameableColumns()
    {
        // when blameable is created on a migration

        // the table contains a created_by and updated_by column
        $this->assertTrue(Schema::hasColumn('articles', 'created_by'));
        $this->assertTrue(Schema::hasColumn('articles', 'updated_by'));
    }
}
