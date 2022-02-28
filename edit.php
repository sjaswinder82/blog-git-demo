<?php

require_once __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Blog\Models\Post;

if(array_key_exists('update', $_POST)) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_POST['user_id'];

    //
    $post = Post::show($_GET['id']);
    // update attibute in  object of post 
    
    $post->title = $title;
    $post->content = $content;
    $post->update();

    // response
    header('Location: http://localhost:3000/day5/blog/posts.php');
}
    $post = null;
    if(isset($_GET['id'])) {
        $post = Post::show($_GET['id']);
    }
    
?>

<form action="" method="post">
    <input type="hidden" name="id" value='<?php echo $post->id;?>'>
    Title <input type="text" name="title" value='<?php echo $post->title;?>'><br>
    Content <textarea name="content" rows=10 cols=15><?php echo $post->content;?></textarea><br>
    <input type="hidden" name="user_id" value="<?php echo $post->user_id;?>">
    <input type="submit" name="update">
</form>

<a href='index.php'>Home</a>

