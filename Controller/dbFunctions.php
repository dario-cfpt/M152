<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 24.01.2018
 * Time: 14:47
 */
include_once 'mysql.inc.php';
include_once 'pdoController.php';
include_once '../Model/Media.php';
include_once '../Model/Post.php';

class DbFunctions {
    /**
     * Établie la connection à la base de données
     * @return null|PDO
     */
    private function ConnectToDatabase() {
        $dbc = null;

        if ($dbc == null) {
            try {
                $dbc = pdoController::GetInstance(
                    MySqlC::DB_HOST,
                    MySqlC::DB_NAME,
                    MySqlC::DB_USER,
                    MySqlC::DB_PASSWORD
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
    public function GetPosts() {
        $post = null;
        try {
            $dbc = $this->ConnectToDatabase();
            $sql = $dbc->prepare("SELECT idPost, commentaire, datePost FROM posts");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $post = array();
            foreach ($result as $item) {
                array_push($post, new Post($item['idPost'], $item['commentaire'], $item['datePost']));
            }
        }
        catch (Exception $e) {
            printf($e);
        }
        return $post;
    }

    /**
     * Obtient tous les médias en lien avec l'id d'un post
     * @param $idPost
     * @return array|null
     */
    public function GetMediaFromIdPost($idPost) {
        $media = null;
        try {
            $dbc = $this->ConnectToDatabase();
            $sql = $dbc->prepare("SELECT idMedia, nomFichierMedia, idPost FROM media WHERE idPost = :idPost");
            $sql->bindParam(':idPost', $idPost, PDO::PARAM_STR);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $media = array();
            foreach ($result as $item) {
                array_push($media, new Media($item['idMedia'], $item['nomFichierMedia'], $item['idPost']));
            }
        }
        catch (Exception $e) {
            printf($e);
        }
        return $media;
    }

    /**
     * Envoie les données d'un media à la base de données
     * @param $nameMedia
     * @param $typeMedia
     * @param $idPost
     * @return bool
     */
    public function UploadMedia($nameMedia, $typeMedia, $idPost) {
        try {
            $dbc = $this->ConnectToDatabase();
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
    public function UploadPost($comment, $datePost) {
        try {
            $dbc = $this->ConnectToDatabase();
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
}

