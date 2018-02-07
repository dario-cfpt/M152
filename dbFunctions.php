<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 24.01.2018
 * Time: 14:47
 */

require_once 'mysql.inc.php';


/**
 * Établie la connection à la base de données
 * @return null|PDO
 */
function ConnectToDatabase() {
    $dbc = null;

    if ($dbc == null) {
        try {
            $dbc = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true)
            );
        }
        catch (Exception $e) {
            exit('Could not connect to MySQL');
        }
    }
    return $dbc;
}


/**
 * Récupère le nom d'un post et son commentaire
 * @return array|null
 */
function GetPosts() {
    try {
        $dbc = ConnectToDatabase();
        $sql = $dbc->prepare("SELECT nomMedia, commentaire FROM posts");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    catch (Exception $e) {
        printf($e);
        return null;
    }
}

/**
 * Envoie les données d'un media à la base de données
 * @param $nameMedia
 * @param $typeMedia
 * @return bool
 */
function UploadMedia($nameMedia, $typeMedia, $idPost) {
    try {
        $dbc = ConnectToDatabase();
        $sql = $dbc->prepare("INSERT INTO media (nomFichierMedia, typeMedia, idPost) VALUES (:nameMedia, :typeMedia, :idPost)");
        $sql->bindParam(':nameMedia', $nameMedia, PDO::PARAM_STR);
        $sql->bindParam(':typeMedia', $typeMedia, PDO::PARAM_STR);
        $sql->bindParam(':idPost', $idPost, PDO::PARAM_STR);
        $sql->execute();
        return true;
    } catch (Exception $e) {
        printf($e);
        return false;
   }
}

/**
 * Envoie les données d'un post à la base de données
 * @param $comment
 * @param $datePost
 * @return bool
 */
function UploadPost($comment, $datePost) {
    try {
        $dbc = ConnectToDatabase();
        $sql = $dbc->prepare("INSERT INTO posts (commentaire, datePost) VALUES (:comment, :datePost)");
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':datePost', $datePost, PDO::PARAM_STR);
        $sql->execute();
        return $dbc->lastInsertId();
    } catch (Exception $e) {
        printf($e);
        return false;
    }
}