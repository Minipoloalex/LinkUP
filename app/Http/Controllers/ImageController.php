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
    static protected $pathPosts = "images/";
    static protected $profilePictureSize = 100;
    static protected $postPictureSize = 500;
    protected string $path = "";
    public function __construct(string $type)
    {
        if ($type == 'users')
            $this->path = self::$pathUsers;
        else if ($type == 'posts')
            $this->path = self::$pathPosts;
        else
            abort(400);
    }
    private function getFilePath(string $fileName) {
        return $this->path . $fileName;
    }
    public function store($media, string $fileName, ?int $x, ?int $y, ?int $width, ?int $height)
    {
        if ($this->existsFile($fileName)) {
            abort(400);
        }
        if ($x == null || $y == null || $width == null || $height == null) {
            $media = Image::make($media)->resize(self::$profilePictureSize, self::$profilePictureSize)
                ->encode('jpg', 75);
        }
        else {
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
            }
            else {
                Log::info("File not found: $filePath");
            }
        }
    }
    public function existsFile(string $fileName) : bool
    {
        return Storage::exists($this->getFilePath($fileName));
    }
    public function getFile(?string $fileName)
    {
        $fileName ??= self::$default;
        if (!$this->existsFile($fileName)) {
            if ($fileName == self::$default) {
                abort(404);
            }
            else {
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
            }
            else {
                return $this->getFileResponse(self::$default);
            }
        }
        $filePath = $this->getFilePath($fileName);
        return Storage::response($filePath);
    }
}
