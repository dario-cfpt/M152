<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 24.01.2018
 * Time: 14:47
 */
include_once 'pdoController.php';
include_once '../Model/Media.php';
include_once '../Model/Post.php';

class DbFunctions {
    private $supportedFiles = array(
        "image/jpeg",
        "image/gif",
        "video/mp4",
        "video/webm",
        "video/ogg",
        "audio/mpeg",
        "audio/ogg",
        "audio/wav",
        "audio/mp3",
    );

    const DIRECTORY_IMAGES = "images";
    const DIRECTORY_VIDEOS = "videos";
    const DIRECTORY_AUDIOS = "audios";

    /**
     * Récupère le nom d'un post et son commentaire
     * @return array|null
     */
    public function GetPosts() {
        $post = null;
        try {
            $dbc = pdoController::GetInstance();
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
            $dbc = pdoController::GetInstance();
            $sql = $dbc->prepare("SELECT idMedia, nomFichierMedia, typeMedia, idPost FROM media WHERE idPost = :idPost");
            $sql->bindParam(':idPost', $idPost, PDO::PARAM_STR);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $media = array();
            foreach ($result as $item) {
                array_push($media, new Media($item['idMedia'], $item['nomFichierMedia'], $item['typeMedia'] ,$item['idPost']));
            }
        }
        catch (Exception $e) {
            printf($e);
        }
        return $media;
    }

    /**
     * Ajoute un post (commentaire + date) dans la base de données
     * @param $comment
     * @param $datePost
     * @return string
     * @throws Exception
     */
    private function UploadPost($comment, $datePost) {
        try {
            $dbc = pdoController::GetInstance();
            $sql = $dbc->prepare("INSERT INTO posts (commentaire, datePost) VALUES (:comment, :datePost)");
            $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql->bindParam(':datePost', $datePost, PDO::PARAM_STR);
            $sql->execute();
            $idPost = $dbc->lastInsertId();
            return $idPost;
        } catch (Exception $e) {
            throw new Exception("Error with the upload of the post");
        }
    }

    private function UploadMedia($fileName, $fileType, $idPost) {
        try {
            $dbc = pdoController::GetInstance();
            $sql = $dbc->prepare("INSERT INTO media (nomFichierMedia, typeMedia, idPost) VALUES (:nameMedia, :typeMedia, :idPost)");
            $sql->bindParam(':nameMedia', $fileName, PDO::PARAM_STR);
            $sql->bindParam(':typeMedia', $fileType, PDO::PARAM_STR);
            $sql->bindParam(':idPost', $idPost, PDO::PARAM_STR);
            $sql->execute();
        } catch (Exception $e) {
            throw new Exception("Error with the upload of the media");
        }
    }

    /**
     * Envoie les données d'un post et les medias associés à la base de données
     * @param $comment
     * @param $datePost
     * @param $fileMediaArray
     * @return bool
     */
    public function UploadPostWithMedia($comment, $datePost, $fileMediaArray) {
        try {
            $dbc = pdoController::GetInstance();
            $dbc->beginTransaction();
            $idPost = $this->UploadPost($comment, $datePost);

            $length = count($fileMediaArray['name']);
            for ($i = 0; $i < $length; $i++) {
                $fileName = $fileMediaArray['name'][$i];
                $fileName = uniqid()  . $idPost . '.' . explode('.', $fileName)[count($fileName - 1)];
                $fileType = $fileMediaArray['type'][$i];
                $fileTmpName = $fileMediaArray['tmp_name'][$i];

                if(array_search($fileType, $this->supportedFiles)) {
                    switch ($fileType) {
                        case "image/jpeg":
                        case "image/gif":
                            $typeMedia = self::DIRECTORY_IMAGES;
                            break;
                        case "video/mp4":
                        case "video/webm":
                        case "video/ogg":
                            $typeMedia = self::DIRECTORY_VIDEOS;
                            break;
                        case "audio/mpeg":
                        case "audio/ogg":
                        case "audio/wav":
                        case "audio/mp3":
                            $typeMedia = self::DIRECTORY_AUDIOS;
                            break;
                        default:
                            throw new Exception("Unsupported file");
                            break;
                    }
                    $this->UploadMedia($fileName, $fileType, $idPost);
                    $fileMovedSuccessfully = move_uploaded_file($fileTmpName, "../upload/$typeMedia/$fileName");

                    if (!$fileMovedSuccessfully) {
                        throw new Exception("An error has occurend when moving the file to the repository");
                    }
                }
                else {
                    throw new Exception("Unsupported file");
                }
            }

            $dbc->commit();
            return true;

        } catch (Exception $e) {
            printf($e);
            $dbc->rollBack();
            return false;
        }
    }
}

