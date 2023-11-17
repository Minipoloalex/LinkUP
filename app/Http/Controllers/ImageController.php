<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    static protected $path = "images/";
    public static function store($media, string $fileName)
    {
        $media->storeAs(ImageController::$path, $fileName);
    }
    public static function imagesPath()
    {
        return storage_path('/app/' . ImageController::$path);
    }
    public static function delete(string $fileName)
    {
        Storage::delete(storage_path(ImageController::$path . $fileName));
    }
    public static function existsPath(string $filePath) : bool
    {
        return file_exists($filePath);
    }
    public static function getFile(string $filePath)
    {
        if (!ImageController::existsPath($filePath)) {
            abort(404);
        }
        return response()->file($filePath);
    }
}
