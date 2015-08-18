<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    var $image_type;
    var $image_width;
    var $image_height;
    var $image;
    var $upload_dir;
    var $image_name;

    function load($image_path) {
        $image_info = getimagesize($image_path);
        $this->image_type = $image_info[2];
        $this->image_width = $image_info[0];
        $this->image_height = $image_info[1];

        $path_pieces = explode('/', $image_path);
        $this->image_name = array_pop($path_pieces);

        if ($this->image_type == IMAGETYPE_JPEG) {

            $this->image = imagecreatefromjpeg($image_path);
        } elseif ($this->image_type == IMAGETYPE_GIF) {

            $this->image = imagecreatefromgif($image_path);
        } elseif ($this->image_type == IMAGETYPE_PNG) {

            $this->image = imagecreatefrompng($image_path);
        }
    }

    function save($path) {
        $input = fopen("php://input", "r");
        $this->temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $this->temp);
        fclose($input);

        if ($realSize != $this->getSize()) {
            return false;
        }

        $target = fopen($path, "w");
        fseek($this->temp, 0, SEEK_SET);
        stream_copy_to_stream($this->temp, $target);

        fclose($target);

        return $this->resize($path);
    }

    function getName() {
        return $_GET['qqfile'];
    }

    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])) {
            return (int) $_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
    }

    function setUpload_dir($dir) {
        $this->upload_dir = $dir;
    }

    function resize($path) {
        // first let's load the picture and get some info
        $this->load($path);

        $original_width = $this->image_width;
        $original_height = $this->image_height;

        $src = $this->image;
        if ($original_width > 400)
            return false;
        // setting the new widths
        $new_width = 900;
        // calculating the new heights and keep the ratio
        $new_height = ($new_width * $original_height) / $original_width;

        // thumbnail (squared) size
        $thumb_width = 156;
        $thumb_height = 156;

        if ($original_width < 900) {
            $new_width = $original_width;
            $new_height = $original_height;
        }

        $tmp_1 = imagecreatetruecolor($new_width, $new_height);

        $tmp_square = imagecreatetruecolor($thumb_width, $thumb_height);

        imagecopyresampled($tmp_1, $src, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        imagecopyresampled($tmp_square, $src, 0, 0, 0, 0, $thumb_width, $thumb_height, $original_width, $original_height);

        $filename = $this->image_name;
        $upload_dir = $this->upload_dir;

        $ext = strtolower(end(explode('.', $filename)));

        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($tmp_1, $upload_dir . $filename, 100);
                imagejpeg($tmp_square, $upload_dir . 'thumb_' . $filename, 100);
                break;

            case 'png':
                imagepng($tmp_1, $upload_dir . $filename);
                imagepng($tmp_square, $upload_dir . 'thumb_' . $filename);
                break;

            case 'gif':
                imagegif($tmp_1, $upload_dir . $filename);
                imagegif($tmp_square, $upload_dir . 'thumb_' . $filename);
                break;
        }

        // we don't need those anymore
        imagedestroy($tmp_1);
        return imagedestroy($tmp_square);
    }

}

class qqFileUploader {

    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings() {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

    private function toBytes($str) {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE) {
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777);
            chmod($uploadDirectory, 0777);
        }

        if (!$this->file) {
            return array('error' => 'No files were uploaded.');
        }

        $this->file->setUpload_dir($uploadDirectory);

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename = str_replace(' ', '_', $pathinfo['filename']);
        $filename = strtolower($filename);
        //$filename = md5(uniqid());
        $ext = strtolower($pathinfo['extension']);

        if ($this->allowedExtensions && !in_array($ext, $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of ' . $these . '.');
        }

        if (!$replaceOldFile) {
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)) {
            return array('success' => true, 'filename' => $filename . '.' . $ext);
        } else {
            return array('error' => 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
    }

}
