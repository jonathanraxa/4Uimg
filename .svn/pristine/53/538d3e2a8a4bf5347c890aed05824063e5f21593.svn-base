<?php
function get_mime_type($path) {
    $fileInfo = new finfo(FILEINFO_MIME_TYPE);	
    return $fileInfo->file($path);
}

class ImageException extends Exception {}

class ImageMimeTypeException extends ImageException {
    public $mime;
    function __construct($mime) {
        parent::__construct("\"" . $mime . "\" is not an image MIME type");
        $this->mime = $mime;
    }
}

class ImageScaleException extends ImageException {}

class ImageReadException extends ImageException {
    public $path;
    function __construct($path) {
        parent::__construct("Failed to read from path \"" . $path);
        $this->path = $path;
    }
}

class ImageWriteException extends ImageException {
    public $path;
    function __construct($path) {
        parent::__construct("Failed to write to path \"" . $path);
        $this->path = $path;
    }
}

/**
 * Little more than something to keep resource and mime type information together
 */
class GDImage {
    private $resource;
    private $mime;

    function __construct($resource, $mime) {
        $this->resource = $resource;
        $this->mime = $mime;
    }

    public function write($path) {
        $result = false;
        switch ($this->mime) {
        case 'image/png':
            $result = imagepng($this->resource, $path);
            break;
        case 'image/jpg':
        case 'image/jpeg':
            $result =  imagejpeg($this->resource, $path);
            break;
        case 'image/gif':
            $result = imagegif($this->resource, $path);
            break;
        default:
            throw new ImageMimeTypeException($this->mime); // Bad mime type should be caught earlier
        }

        if (!$result) {
            throw new ImageWriteException($path);
        }
    }

    public static function read($path) {
        $mime = get_mime_type($path); 
        $resource = null;
        switch ($mime) {
        case 'image/png':
            $resource = imagecreatefrompng($path);
            break;
        case 'image/jpg':
        case 'image/jpeg':
            $resource = imagecreatefromjpeg($path);
            break;
        case 'image/gif':
            $resource = imagecreatefromgif($path);
            break;
        default:
            throw new ImageMimeTypeException($mime); // Bad mime type should be caught earlier
        }

        if ($resource) {
            return new GDImage($resource, $mime);
        } else {
            throw new ImageReadException($path);
        }
    }

    public function scale($scale) {
        $width = imagesx($this->resource);
        $height = imagesy($this->resource);

        $new_width = round($width * $scale);
        $new_height = round($height * $scale);

        $dest = imagecreatetruecolor($new_width, $new_height);
        $result = imagecopyresampled($dest, $this->resource,
            0, 0, 0, 0,
            $new_width, $new_height,
            $width, $height);

        if ($result) {
            return new GDImage($dest, $this->mime);
        } else {
            throw new ImageScaleException();;
        }
    } 

    public function getMime() { return $this->mime; } 

    public function getExtension() {
        switch ($this->mime) {
        case 'image/png':
            return 'png';
            break;
        case 'image/jpg':
        case 'image/jpeg':
            return 'jpg';
            break;
        case 'image/gif':
            return 'gif';
            break;
        default:
            throw new ImageMimeTypeException($mime); // Bad mime type should be caught earlier
        }
    }

    public function getWidth() { return imagesx($this->resource); }
    public function getHeight() { return imagesy($this->resource); }

    public function thumbnail($max_width, $max_height) {
        $hscale = $max_width / $this->getWidth();
        $vscale = $max_height / $this->getHeight();

        $scale = min($hscale, $vscale);

        return $this->scale($scale);
    }
}

/**
 * Scales a source image to be no larger than a fixed square size
 */
function thumbnail($source, $max_width, $max_height) {
    $thumbnail_root = "images/thumbnails/";

    $thumbnail_dir = $thumbnail_root . $max_width . 'x' . $max_height . '/';
    $thumbnail_path = $thumbnail_dir . basename($source);

    if (file_exists($thumbnail_path)) {
        return $thumbnail_path;
    }

    $image = GDImage::read($source);
    $thumbnail = $image->thumbnail($max_width, $max_height);

    if (!is_dir($thumbnail_dir)) {
        mkdir($thumbnail_dir, 0777);
        chmod($thumbnail_dir, 0777); // Force to 777 so we can remove it if we need
    }

    $thumbnail->write($thumbnail_path);

    return $thumbnail_path;
}

?>
