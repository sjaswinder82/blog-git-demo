<?php

require_once __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Blog\Models\Post;

if(array_key_exists('submit', $_POST)) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_POST['user_id'];

    // create object of post 
    $post = new Post();
    $post->title = $title;
    $post->content = $content;
    $post->userId = $userId;
    $post->save();

    // response
    echo "Created successfully.";
}
   
?>

<form action="" method="post">
    Title <input type="text" name="title"><br>
    Content <textarea name="content" rows=10 cols=15></textarea><br>
    <input type="hidden" name="user_id" value="2">
    <input type="submit" name="submit">
</form>

<a href='index.php'>Home</a>

