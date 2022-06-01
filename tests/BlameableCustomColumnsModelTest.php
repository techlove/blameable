<?php

namespace AppKit\Blameable\Tests;

use AppKit\Blameable\Tests\Models\Article;
use AppKit\Blameable\Tests\Models\ArticleCustomColumns;
use AppKit\Blameable\Tests\Models\User;
use Illuminate\Support\Facades\Auth;

class BlameableCustomColumnsModelTest extends TestCase
{
    /** @test */
    public function whenAModelIsCreatedTheCreatedByFieldIsSet()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(ArticleCustomColumns::class)->create();

        // the article should have a user_who_created set to the user
        $this->assertEquals($user->id, $article->user_who_created);
    }

    /** @test */
    public function whenAModelIsCreatedTheUpdatedByFieldIsSet()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(ArticleCustomColumns::class)->create();

        // the article should have a user_who_updated set to the user
        $this->assertEquals($user->id, $article->user_who_updated);
    }

    /** @test */
    public function whenAModelIsUpdatedTheUpdatedByFieldIsSetCorrectly()
    {
        // when a user logins
        $creator = factory(User::class)->create();
        Auth::login($creator);

        // and created an article
        $article = factory(ArticleCustomColumns::class)->create();

        // and another user, who is logged in
        $editor = factory(User::class)->create();
        Auth::login($editor);

        // makes a change
        $article->update([
            'title' => 'My new title',
        ]);

        $article = $article->fresh();

        // the article should have a user_who_updated set to the user
        $this->assertEquals($editor->id, $article->user_who_updated);
    }

    /** @test */
    public function whenAModelIsSoftDeletedTheDeletedByColumnIsSet()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(ArticleCustomColumns::class)->create();

        // the deleted_by column will be null
        $this->assertNull($article->user_who_deleted);

        // when the article is deleted
        $article->delete();

        $article = ArticleCustomColumns::withTrashed()->first();

        // the article should have a deleted_by set to the user
        $this->assertEquals($user->id, $article->user_who_deleted);
    }

    /* @test */
    public function testTheModelWillContainARelationshipToTheCreator()
    {
        // when a user logins
        $user = factory(User::class)->create();
        Auth::login($user);

        // and created an article
        $article = factory(ArticleCustomColumns::class)->create();

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
        $article = factory(ArticleCustomColumns::class)->create();

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
        $article = factory(ArticleCustomColumns::class)->create();

        // when the article is deleted
        $article->delete();

        $article = ArticleCustomColumns::withTrashed()->first();

        // the article should have a deleted_by set to the user
        $this->assertTrue($article->deleter->is($user));
    }
}
