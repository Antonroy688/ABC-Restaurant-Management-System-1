<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->putFileAs($dir, $image, $imageName);
        } else {
            $imageName = 'upload-img.png';
        }

        return $imageName;
    }
  public static function uploadBlob(string $dir, string $format, $blob = null)
    {
        if ($blob != null) {
            $folderPath = $dir;
            if(!File::isDirectory($folderPath)){
                File::makeDirectory($folderPath, 0777, true, true);
            } 
            $image_parts = explode(";base64,", $blob);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid().$format;
            $imageFullPath = $folderPath.$imageName;
            file_put_contents($imageFullPath, $image_base64);
            $profile_pic = "$imageName";
        } else {
            $imageName = 'upload-img.png';
        }
    
        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {

        if ($image == null) {
            return $old_image;
        }
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = Helper::upload($dir, $format, $image);
        return $imageName;
    }
    public static function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $oldValue = env($envKey);
        if (strpos($str, $envKey) !== false) {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "{$envKey}={$envValue}\n";
        }
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }
    public static function onerror_image_helper($data, $src, $error_src ,$path){
        $fullPath = $path . $data;

        if (isset($data) && strlen($data) > 1 && Storage::disk('public')->exists($fullPath)) {
            return $src;
        }

        return $error_src;
    }
}


