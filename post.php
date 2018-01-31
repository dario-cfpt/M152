<?php
require_once 'dbFunctions.php';

if (isset($_FILES['img'])) {
    // Création d'un nouveau post
    $fileName = $_FILES['img']['name'];
    $tmpName = $_FILES['img']['tmp_name'];
    $fileType = $_FILES['img']['type'];
    $comment = $_POST['comment'];

    $date = date("Y-m-d H:i:s");

    $success = UploadPost($comment, $fileType, $fileName, $date);

    if($success){
        move_uploaded_file($tmpName, "upload/$fileName");
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
    <a href="./index.html">Accueil</a> |
    <a href="./post.html">Edition</a> |
</nav>
<section>
    <form method="post" action="./post.php" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Choisir une image : <input type="file" name="img"></td>
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