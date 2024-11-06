<?php

namespace App\Services;

use ImageKit\ImageKit;


class ImagekitService
{
    public function __construct(
        private readonly ImageKit $imagekit
    ) {
    }
    function uploadImage($image)
    {
        $currentTime = round(microtime(true) * 1000);
        $uploaded = $this->imagekit->upload([
            "file" => fopen($image, "r"),
            "folder" => "/cook-recipe/user_profile",
            "fileName" => "IMG" . $currentTime . "." . $image->extension(),
        ]);
        return $uploaded;
    }
}
