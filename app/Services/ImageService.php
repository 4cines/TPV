<?php

namespace app\Services;

class ImageService {

	public function storeFile($file, $folder)
    {

        $check = getimagesize($file["tmp_name"]);

        if($check !== false) {

            $target_path = "/upload/". $folder ."/".basename($file["name"]);
            move_uploaded_file($file["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_path);

        } else {

            $target_path = "";
        }

        return $target_path;

	}
}

?>