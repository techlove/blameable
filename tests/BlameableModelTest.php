<?php

namespace AppKit\Blameable\Tests;

use AppKit\Blameable\Facades\Blameable;
use AppKit\Blameable\Tests\Models\Article;
use AppKit\Blameable\Tests\Models\ArticleSoftDeletes;
use AppKit\Blameable\Tests\Models\User;
use Illuminate\Support\Facades\Auth;

class BlameableModelTest extends TestCase
{
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

    /** @test */
    public function whenAModelIsSoftDeletedTheDeletedByColumnIsSet()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(ArticleSoftDeletes::class)->create();

        // the deleted_by column will be null
        $this->assertNull($article->deleted_by);

        // when the article is deleted
        $article->delete();

        $article = ArticleSoftDeletes::withTrashed()->first();

        // the article should have a deleted_by set to the user
        $this->assertEquals($user->id, $article->deleted_by);
    }

    /* @test */
    public function testTheModelWillContainARelationshipToTheCreator()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(Article::class)->create();

        // the article should have a created_by set to the user
        $this->assertTrue($article->creator->is($user));
    }

    /* @test */
    public function testTheModelWillContainARelationshipToTheEditor()
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

        // the article should have a created_by set to the user
        $this->assertTrue($article->editor->is($editor));
    }

    /** @test */
    public function testTheModelWillContainARelationshipToTheDeleter()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(ArticleSoftDeletes::class)->create();

        // when the article is deleted
        $article->delete();

        $article = ArticleSoftDeletes::withTrashed()->first();

        // the article should have a deleted_by set to the user
        $this->assertTrue($article->deleter->is($user));
    }

    /* @test */
    public function testACustomMethodCanBeUsedToGetTheUserId()
    {
        // we specify a custom closure to provide the user id
        Blameable::userCallback(function () {
            return Auth::id() * 10;
        });

        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(Article::class)->create();

        // the article should have a created_by set to the user
        $this->assertEquals($user->id * 10, $article->created_by);
    }
}
