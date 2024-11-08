<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use ImageKit\ImageKit;


class ImagekitService
{
    public function __construct(
        private readonly ImageKit $imagekit
    ) {
    }
    function uploadImage(UploadedFile $image, ?string $path)
    {
        $currentTime = round(microtime(true) * 1000);
        $uploaded = $this->imagekit->upload([
            "file" => fopen($image, "r"),
            "folder" => "/cook-recipe/{$path}",
            "fileName" => "IMG" . $currentTime . "." . $image->extension(),
        ]);
        return $uploaded;
    }
    function updateImage(UploadedFile $image, ?string $fileId, ?string $path)
    {
        if ($fileId) {
            $this->imagekit->deleteFile($fileId);
        }
        $uploaded = $this->uploadImage($image, $path);
        return $uploaded;
    }
    function uploadProfilePict(UploadedFile $imagepath)
    {
        $path = "profiles";
        return $this->uploadImage($imagepath, $path);
    }
    function updateProfilePict(UploadedFile $imagepath, ?string $fileId)
    {
        $path = "profiles";
        return $this->updateImage($imagepath, $fileId, $path);
    }
    function uploadRecipePict(UploadedFile $imagepath)
    {
        $path = "recipes";
        return $this->uploadImage($imagepath, $path);
    }
    function updateRecipePict(UploadedFile $imagepath, ?string $fileId)
    {
        $path = "recipes";
        return $this->updateImage($imagepath, $fileId, $path);
    }
    function uploadStepPict(UploadedFile $imagepath)
    {
        $path = "steps";
        return $this->uploadImage($imagepath, $path);
    }
    function updateStepPict(UploadedFile $imagepath, ?string $fileId)
    {
        $path = "steps";
        return $this->updateImage($imagepath, $fileId, $path);
    }
}
