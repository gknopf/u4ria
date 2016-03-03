<?php
header('content-type: image/jpeg');

define('WATERMARK_OVERLAY_OPACITY', $_GET['o']);
define('WATERMARK_OUTPUT_QUALITY', 100);
$source_file_path = $_GET['image'];
$watermark = $_GET['mark'];

list($source_width, $source_height, $source_type) = getimagesize($source_file_path);
if ($source_type === NULL) {
    return false;
}
switch ($source_type) {
    case IMAGETYPE_GIF:
        $source_gd_image = imagecreatefromgif($source_file_path);
        break;
    case IMAGETYPE_JPEG:
        $source_gd_image = imagecreatefromjpeg($source_file_path);
//        echo $source_gd_image;die;
        break;
    case IMAGETYPE_PNG:
        $source_gd_image = imagecreatefrompng($source_file_path);
        break;
    default:
        return false;
}

list($overlay_width, $overlay_height, $watermark_type) = getimagesize($watermark);
if ($watermark_type === NULL) {
    return false;
}
switch ($watermark_type) {
    case IMAGETYPE_GIF:
        $overlay_gd_image = imagecreatefromgif($watermark);
        break;
    case IMAGETYPE_JPEG:
        $overlay_gd_image = imagecreatefromjpeg($watermark);
        break;
    case IMAGETYPE_PNG:
        $overlay_gd_image = imagecreatefrompng($watermark);
        break;
    default:
        return false;
}

$p = $_GET['p'];
if ($p == 5):
    $dest_x = $source_width / 2 - $overlay_width / 2;
    $dest_y = $source_height / 2 - $overlay_height / 2;
elseif ($p == 1):
    $dest_x = 10;
    $dest_y = 10;
elseif ($p == 2):
    $dest_x = $source_width - $overlay_width - 10;
    $dest_y = 10;
elseif ($p == 3):
    $dest_x = 10;
    $dest_y = $source_height - $overlay_height - 10;
elseif ($p == 4):
    $dest_x = $source_width - $overlay_width - 10;
    $dest_y = $source_height - $overlay_height - 10;
endif;
//
//    $image = new SimpleImage();
//    $image->load($source_gd_image);
//    $image->scale(50);
//    $image->save('picture2.jpg');


imagecopymerge(
        $source_gd_image, $overlay_gd_image, $dest_x, $dest_y, 0, 0, $overlay_width, $overlay_height, WATERMARK_OVERLAY_OPACITY
);
imagejpeg($source_gd_image,NULL,WATERMARK_OUTPUT_QUALITY);
imagedestroy($source_gd_image);
imagedestroy($overlay_gd_image);


/* Image Class */
class SimpleImage {

    var $image;
    var $image_type;

    function load($filename) {

        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {

            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {

            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {

            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {

        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {

            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {

            imagepng($this->image, $filename);
        }
        if ($permissions != null) {

            chmod($filename, $permissions);
        }
    }

    function output($image_type = IMAGETYPE_JPEG) {

        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {

            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {

            imagepng($this->image);
        }
    }

    function getWidth() {

        return imagesx($this->image);
    }

    function getHeight() {

        return imagesy($this->image);
    }

    function resizeToHeight($height) {

        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

}
?>
