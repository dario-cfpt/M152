<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 21.02.2018
 * Time: 15:59
 */

class Media
{
    private $IdMedia;
    private $Name;
    private $IdPost;

    public function __construct($idMedia, $name, $idPost)
    {
        $this->SetIdMedia($idMedia);
        $this->SetIdMedia($name);
        $this->SetIdMedia($idPost);
    }

    public function GetIdMedia() {
        return $this->IdMedia;
    }
    private function SetIdMedia($id) {
        $this->IdMedia = $id;
    }

    public function GetName() {
        return $this->Name;
    }
    private function SetName($name) {
        $this->IdMedia = $name;
    }

    public function GetIdPost() {
        return $this->IdPost;
    }
    private function SetIdPost($id) {
        $this->IdMedia = $id;
    }
}