<?php
include_once '../Controller/dbFunctions.php';
$dbFunctions = new DbFunctions();

if (isset($_FILES['img'])) {
    $success = false;

    // Création d'un nouveau post
    $length = count($_FILES['img']['name']);

    $comment = $_POST['comment'];
    $date = date("Y-m-d H:i:s");
    $idPost = $dbFunctions->UploadPost($comment, $date);

    for ($i = 0; $i < $length ; $i++)
    {
        $fileName = $_FILES['img']['name'][$i];
        $fileType = $_FILES['img']['type'][$i];
        $fileTmpName = $_FILES['img']['tmp_name'][$i];
        $success = $dbFunctions->UploadMedia($fileName, $fileType, $idPost);
        move_uploaded_file($fileTmpName, "upload/$fileName");
    }

    if($success){
        header("location: index.php");
        exit();
    }
    else {
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
        <table>
            <tr>
                <td>Choisir une image : <input type="file" name="img[]" accept="image/*" multiple></td>
            </tr>
            <tr>
                <td>Commentaire : <textarea name="comment"></textarea>
            </tr>
            <tr>
                <td><input type="submit" value="Envoyer" name="submit"></td>
            </tr>
        </table>
    </form>
</section>
</body>
</html>