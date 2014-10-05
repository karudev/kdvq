<?php

namespace Sf\AdminBundle\Service;

class FileManager {

    public static function resize($filename, $extension, $newHeight = null, $newWidth = null) {

// Calcul des nouvelles dimensions
        list($width, $height) = getimagesize($filename);

        if($newHeight != null) {
            $pHeight = $newHeight / $height;
            $newWidth = $width * $pHeight;
        } elseif($newWidth != null) {
            $pWidth = $newWidth / $width;
            $newHeight = $height * $pWidth;
        }


// Chargement
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        if ($extension == 'png') {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $source = imagecreatefrompng($filename);
        } elseif ($extension == 'jpeg' || $extension == 'jpg') {

            $source = imagecreatefromjpeg($filename);
        } elseif ($extension == 'gif') {

            $source = imagecreatefromgif($filename);
        }




// Redimensionnement
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);


// Affichage

        if ($extension == 'png') {
            return imagepng($thumb, $filename, 9);
        } elseif ($extension == 'jpeg' || $extension == 'jpg') {
            return imagejpeg($thumb, $filename, 100);
        } elseif ($extension == 'gif') {
            return imagegif($thumb, $filename);
        }
    }

}
