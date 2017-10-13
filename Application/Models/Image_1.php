<?php

namespace Application\Models;

use Application\Model;
use Application\Db;
use Application\Core\MultiException;

class Image
    extends \Application\Model
{
    public $name;
    public $title;
    public $alt;
    public $id_gallery;
    
    public function load($tmp, $path) {
        $ext = $this->getExt($this->name);
        $this->name = $this->getUniqueName($this->name) . "." . $ext;
        if (!file_exists($path)){
            mkdir($path);
        }
        move_uploaded_file($tmp, $path . $this->name);
    }
    
    private function getExt($name)
    {
        return substr($name, -3);
    }
    
    public static function getUniqueName($name)
    {
        $name = substr(md5($name),0,6);
        $name .= time();
        return $name;
    }
    
    public function createThumbnail($pathToImage, $pathToThumb, $image, $width_thumb, $height_thumb) {
        $info = getimagesize($pathToImage . $image); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив
        
        //В зависимости от расширения картинки вызываем соответствующую функцию
        if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($pathToImage . $image); //создаём новое изображение из файла
        } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($pathToImage . $image);
        } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($pathToImage . $image);
        } else {
            return false;
        }
        
        $k = min (($size[0]/$width_thumb), ($size[1]/$height_thumb));
        
        $new_width = $k * $width_thumb;
        $new_height = $k * $height_thumb;
        $new_x = (int)(($size[0] - $new_width)/2);
        $new_y = (int)(($size[1] - $new_height)/2);
        $thumb = imagecreatetruecolor($width_thumb, $height_thumb); //возвращает идентификатор изображения, представляющий черное изображение заданного размера

        imagecopyresampled($thumb, $src, 0, 0, $new_x, $new_y, $width_thumb, $height_thumb, $new_width, $new_height);
        
        if (!file_exists($pathToThumb)){
            //echo $pathToThumb . "<br>";
            mkdir($pathToThumb);
        }
        //Копирование и изменение размера изображения с ресемплированием
        
        $path = $pathToThumb . $image;
        
        if ($info['mime'] == 'image/png') {
           return imagepng($thumb, $path);
        } else if ($info['mime'] == 'image/jpeg') {
            return imagejpeg($thumb, $path);
        } else if ($info['mime'] == 'image/gif') {
            return imagegif($thumb, $path);
        } else {
            return false;
        }
    }
}