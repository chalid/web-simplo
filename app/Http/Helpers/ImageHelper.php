<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageHelper{

    protected static $defaultSizes = [
        ['width' => 96, 'height' => 54, 'path' => 'small-thumb'],
        ['width' => 50, 'height' => 80, 'path' => 'thumb2'],
        ['width' => 181, 'height' => 70, 'path' => 'brand'],
        ['width' => 22, 'height' => 18, 'path' => 'icon'],
        ['width' => 165, 'height' => 125, 'path' => 'thumb'],
        ['width' => 257, 'height' => 171, 'path' => 'category'],
        ['width' => 360, 'height' => 240, 'path' => 'smaller'],
        ['width' => 475, 'height' => 316, 'path' => 'web-smaller'],
        ['width' => 760, 'height' => 505, 'path' => 'small'],
        ['width' => 1074, 'height' => 805, 'path' => 'normal'],
        ['width' => 1200, 'height' => 630, 'path' => 'meta'],
        ['width' => 1720, 'height' => 1143, 'path' => 'large'],
    ];

    public static function getDefaultSizes()
    {
        return self::$defaultSizes;
    }

    protected static function resolveSizes($requested = null)
    {
        if ($requested === null) {
            return self::$defaultSizes;
        }

        // Filter based on provided 'path' keys
        return collect(self::$defaultSizes)
            ->whereIn('path', $requested)
            ->values()
            ->all();
    }

    public static function uploadImage($file, $dir, $paths = null)
    {
        $sizes = self::resolveSizes($paths);
        $imageName = $file->hashName();
        $extension = $file->getClientOriginalExtension();
        $basePath = 'storage/upload_files/images/' . $dir;

        if (!File::exists(public_path($basePath))) {
            File::makeDirectory(public_path($basePath), 0777, true);
        }

        foreach ($sizes as $size) {
            $folder = $size['path'];
            $width = $size['width'];
            $height = $size['height'];
            $resizePath = public_path("$basePath/$folder");

            if (!File::exists($resizePath)) {
                File::makeDirectory($resizePath, 0777, true);
            }

            $resizedImage = Image::make($file)
                ->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($extension);

            File::put("$resizePath/$imageName", $resizedImage);
        }

        // Save original
        $oriPath = public_path("$basePath/ori");
        if (!File::exists($oriPath)) {
            File::makeDirectory($oriPath, 0777, true);
        }

        $imageOri = Image::make($file)->encode($extension);
        File::put("$oriPath/$imageName", $imageOri);

        return $imageName;
    }

    public static function deleteFileExists($file, $dir, $paths = null)
    {
        $sizes = self::resolveSizes($paths);
        $basePath = 'storage/upload_files/images/' . $dir;

        foreach ($sizes as $size) {
            $folder = $size['path'];
            $filePath = public_path("$basePath/$folder/$file");

            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $oriPath = public_path("$basePath/ori/$file");
        if (File::exists($oriPath)) {
            File::delete($oriPath);
        }
    }

}