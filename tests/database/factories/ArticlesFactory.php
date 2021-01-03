<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use AppKit\Blameable\Tests\Models\Article;
use AppKit\Blameable\Tests\Models\ArticleCustomColumns;
use AppKit\Blameable\Tests\Models\ArticleSoftDeletes;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});

$factory->define(ArticleSoftDeletes::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});

$factory->define(ArticleCustomColumns::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
