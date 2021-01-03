<?php

namespace AppKit\Blameable\Tests;

use AppKit\Blameable\Tests\Models\Article;
use AppKit\Blameable\Tests\Models\User;
use Illuminate\Support\Facades\Auth;
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
    public function whenAModelIsCreatedTheCreatedByFieldIsSet()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(Article::class)->create();

        // the article should have a created_by set to the user
        $this->assertEquals($user->id, $article->created_by);
    }
}
