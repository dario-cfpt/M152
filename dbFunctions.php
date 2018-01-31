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
 * Envoie les données d'un post à la base de données
 * @param $comment
 * @param $typeMedia
 * @param $nameMedia
 * @param $datePost
 * @return bool
 */
function UploadPost($comment, $typeMedia, $nameMedia, $datePost) {
    try {
        $db = ConnectToDatabase();
        $sql = $db->prepare("INSERT INTO posts (commentaire, typeMedia, nomMedia, datePost) VALUES (:comment, :typeMedia, :nameMedia, :datePost)");
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':typeMedia', $typeMedia, PDO::PARAM_STR);
        $sql->bindParam(':nameMedia', $nameMedia, PDO::PARAM_STR);
        $sql->bindParam(':datePost', $datePost, PDO::PARAM_STR);
        $sql->execute();
        return true;
    } catch (Exception $e) {
        printf($e);
        return false;
   }
}