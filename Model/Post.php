<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 21.02.2018
 * Time: 15:59
 */

class Post
{
    private $IdPost;
    private $Comment;
    private $DatePost;

    public function __construct($idPost, $comment, $datePost)
    {
        $this->SetIdPost($idPost);
        $this->SetComment($comment);
        $this->SetDatePost($datePost);
    }

    public function GetIdPost() {
        return $this->IdPost;
    }
    private function SetIdPost($id) {
        $this->IdPost = $id;
    }

    public function GetComment() {
        return $this->Comment;
    }
    private function SetComment($comment) {
        $this->Comment = $comment;
    }

    public function GetDatePost() {
        return $this->DatePost;
    }
    private function SetDatePost($datePost) {
        $this->DatePost = $datePost;
    }

}