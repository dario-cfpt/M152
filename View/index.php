<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 24.01.2018
 * Time: 13:52
 */
include_once '../Controller/dbFunctions.php';
$dbFunctions = new DbFunctions();
$posts = $dbFunctions->GetPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
<nav>
    <a href="index.php">Accueil</a> |
    <a href="post.php">Post</a>
</nav>
<section>Bienvenue</section>
<section>
    <img src="../temp.png">
    <?php
    if (count($posts) > 0) {
        foreach ($posts as $post) {
            $mediaArray = $dbFunctions->GetMediaFromIdPost($post->GetIdPost());
            $comment = $post->GetComment();
            echo '<figure>';
            foreach ($mediaArray as $media) {
                $src = $media->GetName();
                echo '<img src=' . "../upload/$src" . ' />';
            }
            echo '<figcaption>' . $comment .'</figcaption></figure>';
        }
    }
    ?>
</section>
</body>
</html>
