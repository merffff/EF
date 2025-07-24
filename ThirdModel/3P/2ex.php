<?php


require __DIR__ . '/database.php';

use App\Models\User;
use App\Models\Post;


$user = new User();
$user->name = "Анна";
$user->email = "anna@example.com";
$user->password = "password123";
$user->save();


$post = new Post();
$post->title = "Мой первый пост";
$post->content = "Содержание моего первого поста...";
$post->user_id = $user->id;
$post->save();


$foundPost = Post::find(1);
if ($foundPost) {
    echo "Автор поста: " . $foundPost->user->name;
}


