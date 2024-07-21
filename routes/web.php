<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => "Home Page"]);
});

Route::get('/about', function () {
    return view('about', ['title' => "About"]);
});

Route::get('/posts', function () {
    return view('posts', ['title' => "Halaman Artikel", 'posts' => Post::all()]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    // $post = Post::find($id);

    if ($post) {
        return view('post', ['title' => 'Single Post', 'post' => $post]);
    } else {
        return abort(404, 'Post not found');
    }
});
Route::get('/authors/{user:username}', function (User $user) {
    return view('posts', ['title' => 'Article By ' . $user->name, 'posts' => $user->posts]);
});
Route::get('/categories/{category:slug}', function (Category $category) {
    return view('posts', ['title' => 'Category : ' . $category->name, 'posts' => $category->posts]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => "Contact"]);
});
