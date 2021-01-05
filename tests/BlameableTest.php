<?php

namespace AppKit\Blameable\Tests;

use AppKit\Blameable\Facades\Blameable;
use AppKit\Blameable\Tests\Models\User;
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

    /** @test */
    public function migrationsCanContainDeletedAtColumn()
    {
        // when blameable is created on a migration

        // the table contains a created_by and updated_by column
        $this->assertTrue(Schema::hasColumn('articles_sd', 'created_by'));
        $this->assertTrue(Schema::hasColumn('articles_sd', 'updated_by'));
        $this->assertTrue(Schema::hasColumn('articles_sd', 'deleted_by'));
    }

    /** @test */
    public function migrationsCanHaveCustomColumns()
    {
        // when blameable is created on a migration

        // the table contains a created_by and updated_by column
        $this->assertTrue(Schema::hasColumn('articles_custom_columns', 'user_who_created'));
        $this->assertTrue(Schema::hasColumn('articles_custom_columns', 'user_who_updated'));
        $this->assertTrue(Schema::hasColumn('articles_custom_columns', 'user_who_deleted'));
    }

    /* @test */
    public function testTheFacadeCanGetTheDefaultGuard()
    {
        return $this->assertEquals('web', Blameable::guard());
    }

    /* @test */
    public function testTheFacadeCanGetTheDefaultAuthProvider()
    {
        return $this->assertEquals('users', Blameable::provider());
    }

    /* @test */
    public function testTheFacadeCanGetTheDefaultUserModel()
    {
        return $this->assertEquals(User::class, Blameable::userModel());
    }
}
