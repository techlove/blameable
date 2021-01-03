<?php

namespace AppKit\Blameable\Tests;

use AppKit\Blameable\Facades\Blameable;
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

    /** @test */
    public function whenAModelIsCreatedTheUpdatedByFieldIsSet()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(Article::class)->create();

        // the article should have a updated_by set to the user
        $this->assertEquals($user->id, $article->updated_by);
    }

    /** @test */
    public function whenAModelIsUpdatedTheUpdatedByFieldIsSetCorrectly()
    {
        // when a user logins
        $creator = factory(User::class)->create();
        Auth::login($creator);

        // and created an article
        $article = factory(Article::class)->create();

        // and another user, who is logged in
        $editor = factory(User::class)->create();
        Auth::login($editor);

        // makes a change
        $article->update([
            'title' => 'My new title',
        ]);

        $article = $article->fresh();

        // the article should have a updated_by set to the user
        $this->assertEquals($editor->id, $article->updated_by);
    }

    public function testTheFacadeCanGetTheDefaultGuard()
    {
        return $this->assertEquals('web', Blameable::guard());
    }

    public function testTheFacadeCanGetTheDefaultAuthProvider()
    {
        return $this->assertEquals('users', Blameable::provider());
    }

    public function testTheFacadeCanGetTheDefaultUserModel()
    {
        return $this->assertEquals(User::class, Blameable::userModel());
    }
}
