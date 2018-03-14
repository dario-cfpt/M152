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
    private $TypeMedia;
    private $IdPost;

    public function __construct($idMedia, $name, $typeMedia, $idPost)
    {
        $this->SetIdMedia($idMedia);
        $this->SetName($name);
        $this->SetTypeMedia($typeMedia);
        $this->SetIdPost($idPost);
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
        $this->Name = $name;
    }

    public function GetTypeMedia() {
        return $this->TypeMedia;
    }
    private function SetTypeMedia($typeMedia) {
        $this->TypeMedia = $typeMedia;
    }

    public function GetIdPost() {
        return $this->IdPost;
    }
    private function SetIdPost($id) {
        $this->IdPost = $id;
    }
}