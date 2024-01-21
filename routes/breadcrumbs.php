<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > トレーニング一覧
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('トレーニング一覧', route('training_result.index'));
});

// トレーニング一覧 > トレーニング詳細
Breadcrumbs::for('show', function (BreadcrumbTrail $trail,$training_results) {
    $trail->parent('index');
    $trail->push($training_results['title'], route('training_result.show',$training_results['id']));
});

// トレーニング一覧 > レシピ投稿
Breadcrumbs::for('create', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('トレーニング投稿', route('training_result.create'));
});

