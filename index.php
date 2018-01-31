<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 24.01.2018
 * Time: 13:52
 */


require_once 'dbFunctions.php';

$fileName = $_FILES['img']['tmp_name'];
$fileType = $_FILES['img']['type'];
$comment = $_POST['comment'];

$date = date("Y-m-d H:i:s");

UploadPost($comment, $fileType, $fileName, $date);