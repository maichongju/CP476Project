<?php
require_once "lib/phpFlickr/phpFlickr.php";
class flickrUtil{
    private static $key = "f397a153b8d81946ad0e7578035ddf9c";
    private static $photoid = "48706797328";
    public static function getPhoto(){
        $url = null;
        $f = new phpFlickr(flickrUtil::$key);
        $photo = $f->photos_getInfo(flickrUtil::$photoid);
        if ($photo){
            $url = $f->buildPhotoURL($photo["photo"]);
        }
        return $url;
    }
}