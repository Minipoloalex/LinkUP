<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    static protected $path = "images/";
    public static function store($media, string $fileName)
    {
        if (self::existsFile($fileName)) {
            abort(400);
        }
        \Log::info("Storing file: $fileName in " . self::$path);
        Storage::putFileAs(self::$path, $media, $fileName);
    }
    public static function delete(string $fileName)
    {
        $filePath = self::getFilePath($fileName);
        if (self::existsFile($fileName)) {
            $deleted = Storage::delete($filePath);
            if ($deleted) {
                \Log::info("File deleted: $filePath");
            }
            else {
                \Log::info("File not found: $filePath");
            }
        }
    }
    private static function getFilePath(string $fileName) {
        return self::$path . $fileName;
    }
    public static function existsFile(string $fileName) : bool
    {
        return Storage::exists(self::getFilePath($fileName));
    }
    public static function getFile(string $fileName)
    {
        if (!self::existsFile($fileName)) {
            abort(404);
        }
        $filePath = self::getFilePath($fileName);        
        return Storage::response($filePath);
    }
}
