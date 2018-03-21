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
        $indexMediaArray = 0;
        foreach ($posts as $post) {
            $mediaArray = $dbFunctions->GetMediaFromIdPost($post->GetIdPost());
            $comment = $post->GetComment();
            echo '<figure>';
            foreach ($mediaArray as $media) {
                $src = $media->GetName();
                $typeMedia = $media->GetTypeMedia();
                $directory = "";
                switch ($typeMedia) {
                    case "image/jpeg":
                    case "image/gif":
                        $directory = $dbFunctions::DIRECTORY_IMAGES;
                        break;
                    case "video/mp4":
                    case "video/webm":
                    case "video/ogg":
                        $directory = $dbFunctions::DIRECTORY_VIDEOS;
                        break;
                    case "audio/mpeg":
                    case "audio/ogg":
                    case "audio/wav":
                    case "audio/mp3":
                        $directory = $dbFunctions::DIRECTORY_AUDIOS;
                        break;
                    default:
                        break;
                }
                $src = "../upload/$directory/$src";

                if ($directory == $dbFunctions::DIRECTORY_IMAGES) {
                    echo '<img src=' . $src . ' />';
                }
                else if ($directory == $dbFunctions::DIRECTORY_VIDEOS) {
                    echo '<video controls autoplay loop> <source src="'. $src . '" type="' . $typeMedia . '"></video>';
                }
                else if ($directory == $dbFunctions::DIRECTORY_AUDIOS) {
                    echo '<audio controls> <source src="'. $src . '" type="' . $typeMedia . '"></audio>';
                }

                // Add the comment of the post if all media were displayed
                if ($indexMediaArray == count($mediaArray) - 1) {
                    echo '<figcaption>' . $comment .'</figcaption></figure>';
                    $indexMediaArray = 0;
                }
                else {
                    $indexMediaArray++;
                }
            }

        }
    }
    ?>
</section>
</body>
</html>
