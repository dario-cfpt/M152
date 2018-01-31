<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 24.01.2018
 * Time: 13:52
 */
require_once 'dbFunctions.php';
$posts = GetPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
<nav>
    <a href="./index.html">Accueil</a> |
    <a href="post.php">Post</a>
</nav>
<section>Bienvenue</section>
<section>
    <img src="temp.png">
    <?php
    if (count($posts) > 0) {
        foreach ($posts as $post) {
            $src = $post['nomMedia'];
            $comment = $post['commentaire'];
            echo '<figure>
                    <img src=' . "upload/$src" . ' />
                    <figcaption>' . $comment .'</figcaption>
                 </figure>';
        }
    }
    ?>
</section>
</body>
</html>
