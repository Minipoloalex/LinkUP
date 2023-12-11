<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    static protected $default = 'def.jpg';
    static protected $pathUsers = "public/images/users/";
    static protected $pathGroups = "public/images/groups/";
    static protected $pathPosts = "images/";    // private
    static protected int $profilePictureSize = 100;
    static protected int $postPictureSize = 500;
    protected string $path = "";
    protected int $size = 0;
    public string $extension = ".jpg";
    public function __construct(string $type)
    {
        if ($type == 'users') {
            $this->path = self::$pathUsers;
            $this->size = self::$profilePictureSize;
        } else if ($type == 'groups') {
            $this->path = self::$pathGroups;
            $this->size = self::$profilePictureSize;
        } else if ($type == 'posts') {
            $this->path = self::$pathPosts;
            $this->size = self::$postPictureSize;
        } else {
            abort(400);
        }
    }
    private function getFilePath(string $fileName)
    {
        return $this->path . $fileName;
    }
    public function getFileNameWithExtension(string $fileName)
    {
        return $fileName . $this->extension;
    }
    public function store($media, string $fileName, ?int $x, ?int $y, ?int $width, ?int $height)
    {
        if ($this->existsFile($fileName)) {
            abort(400);
        }
        if ($x === null || $y === null || $width === null || $height === null) {
            $media = Image::make($media)->resize(self::$profilePictureSize, self::$profilePictureSize)
                ->encode('jpg', 75);
        } else {
            $media = Image::make($media)->crop($width, $height, $x, $y)
                ->resize(self::$profilePictureSize, self::$profilePictureSize)
                ->encode('jpg', 75);
        }
        $media->save(storage_path('app/' . $this->path . $fileName));
    }
    public function delete(string $fileName)
    {
        $filePath = $this->getFilePath($fileName);
        if ($this->existsFile($fileName)) {
            $deleted = Storage::delete($filePath);
            if ($deleted) {
                Log::info("File deleted: $filePath");
            } else {
                Log::info("File not found: $filePath");
            }
        }
    }
    public function existsFile(string $fileName): bool
    {
        return Storage::exists($this->getFilePath($fileName));
    }
    public function getFile(?string $fileName)
    {
        $fileName ??= self::$default;
        if (!$this->existsFile($fileName)) {
            if ($fileName == self::$default) {
                abort(404);
            } else {
                return $this->getFile(self::$default);
            }
        }
        $filePath = Storage::url($this->getFilePath($fileName));

        return asset($filePath);
    }
    public function getFileResponse(string $fileName)
    {
        $fileName ??= self::$default;
        if (!$this->existsFile($fileName)) {
            if ($fileName == self::$default) {
                abort(404);
            } else {
                return $this->getFileResponse(self::$default);
            }
        }
        $filePath = $this->getFilePath($fileName);
        return Storage::response($filePath);
    }
}
