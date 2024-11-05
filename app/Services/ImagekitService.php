<?php

namespace App\Services;

use ImageKit\ImageKit;


class ImagekitService
{

    function uploadImage($image)
    {
        $imagekit = new ImageKit(env("IMAGEKIT_PUBLIC_KEY"), env("IMAGEKIT_PRIVATE_KEY"), env("IMAGEKIT_URL_ENDPOINT"));
        $currentTime = round(microtime(true) * 1000);
        $uploaded = $imagekit->upload([
            "file" => $image,
            "folder" => "/cook-recipe/user_profile",
            "fileName" => "IMG" . $currentTime . "." . $image->extension(),
        ]);

        var_dump($uploaded);
        return $uploaded;
    }
}
