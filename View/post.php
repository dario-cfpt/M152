<?php
include_once '../Controller/dbFunctions.php';
$dbFunctions = new DbFunctions();

if (isset($_FILES['media'])) {
    $success = false;
    $typeMedia = $_POST['typeMedia'];

    // Création d'un nouveau post
    $length = count($_FILES['media']['name']);

    $comment = $_POST['comment'];
    $date = date("Y-m-d H:i:s");
    $idPost = $dbFunctions->UploadPost($comment, $date);

    for ($i = 0; $i < $length; $i++) {
        $fileName = $_FILES['media']['name'][$i];
        $fileType = $_FILES['media']['type'][$i];
        $fileTmpName = $_FILES['media']['tmp_name'][$i];
        $success = $dbFunctions->UploadMedia($fileName, $fileType, $idPost);
        move_uploaded_file($fileTmpName, "../upload/$typeMedia/$fileName");
    }

    if ($success) {
        header("location: index.php");
        exit();
    } else {
        echo 'An error has occurred';
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post</title>
</head>
<body>
<nav>
    <a href="index.php">Accueil</a> |
    <a href="post.php">Edition</a> |
</nav>
<section>
    <form method="post" action="post.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Images</legend>
            <table>
                <tr>
                    <td>Choisir une image : <input type="file" name="media[]" accept="image/*" multiple></td>
                </tr>
                <tr>
                    <td>Commentaire : <textarea name="comment"></textarea>
                </tr>
                <tr>
                    <td><input type="submit" value="Envoyer" name="submit"></td>
                </tr>
            </table>
            <input type="hidden" name="typeMedia" value="images">
        </fieldset>
    </form>
    <form method="post" action="post.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Vidéos</legend>
            <table>
                <tr>
                    <td>Choisir une vidéo : <input type="file" name="media[]" accept="video/*" multiple></td>
                </tr>
                <tr>
                    <td>Commentaire : <textarea name="comment"></textarea>
                </tr>
                <tr>
                    <td><input type="submit" value="Envoyer" name="submit"></td>
                </tr>
            </table>
            <input type="hidden" name="typeMedia" value="videos">
        </fieldset>
    </form>
</section>
</body>
</html>