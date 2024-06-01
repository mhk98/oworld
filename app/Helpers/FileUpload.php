<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\Facades\Image  as Image;

class FileUpload
{

    // Upload Original File
    public static function uploadOriginalFile($fileRequest)
    {
        $file = $fileRequest;
        $fileExtension = $file->getClientOriginalExtension();

        $folder = Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day;
        if (!file_exists(storage_path('app/public/') . $folder)) {
            mkdir(storage_path('app/public/') . $folder, 0755, true);
        }

        $randomName = Str::random(20);
        $fileName = $randomName . '.' . $fileExtension;
        $originalFilePath = storage_path('app/public/') . $folder . '/' . $fileName;

        if ($fileExtension === 'gif') {
            $file->move(storage_path('app/public/') . $folder, $fileName);
        } else {
            $image = Image::make($file);
            $image->save($originalFilePath);
        }

        return $folder . '/' . $fileName;
    }


    // Genarate Preview Image
    public static function generatePreviewImage($fileRequest, $previewWidth = null, $previewHeight = null)
    {
        $file = $fileRequest;
        $fileExtension = $file->getClientOriginalExtension();

        $folder = Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day;
        if (!file_exists(storage_path('app/public/') . $folder)) {
            mkdir(storage_path('app/public/') . $folder, 0755, true);
        }

        // File name
        $randomName = Str::random(20);
        $fileName = $randomName . '.' . $fileExtension;
        $originalFilePath = storage_path('app/public/') . $folder . '/' . $fileName;

        if ($fileExtension === 'gif') {
            $gif = new \Imagick($file->getRealPath());
            foreach ($gif as $frame) {
                $frame->resizeImage($previewWidth, $previewHeight, \Imagick::FILTER_LANCZOS, 1);
            }
            $gif->writeImages(storage_path('app/public/') . $folder . '/' . $fileName, true);
        } else {
            $image = Image::make($file);

            if ($previewWidth && $previewHeight) {
                $originalWidth = $image->width();
                $originalHeight = $image->height();

                $resizeRatio = max(
                    $previewWidth / $originalWidth,
                    $previewHeight / $originalHeight
                );

                $image->resize(
                    intval($originalWidth * $resizeRatio),
                    intval($originalHeight * $resizeRatio),
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }
                );

                $image->crop($previewWidth, $previewHeight);
            }

            $image->save($originalFilePath);
        }

        return $folder . '/' . $fileName;
    }

    // Resize and Center Image
    public static function uploadResizeAndCenterImage($fileRequest, $desiredWidth = null, $desiredHeight = null)
    {
        $file = $fileRequest;
        $fileExtension = $file->getClientOriginalExtension();

        $folder = Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day;
        if (!file_exists(storage_path('app/public/') . $folder)) {
            mkdir(storage_path('app/public/') . $folder, 0755, true);
        }

        $randomName = Str::random(20);
        $fileName = $randomName . '.' . $fileExtension;
        $originalFilePath = storage_path('app/public/') . $folder . '/' . $fileName;
        $image = Image::make($file);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        $resizeRatio = min($desiredWidth / $originalWidth, $desiredHeight / $originalHeight);
        $image->resize(
            round($originalWidth * $resizeRatio),
            round($originalHeight * $resizeRatio),
            function ($constraint) {
                $constraint->aspectRatio();
            }
        );

        $resizedWidth = $image->width();
        $resizedHeight = $image->height();
        $background = Image::canvas($desiredWidth, $desiredHeight, '#CCCCCC');
        $xPos = round(($desiredWidth - $resizedWidth) / 2);
        $yPos = round(($desiredHeight - $resizedHeight) / 2);
        $background->insert($image, 'top-left', $xPos, $yPos);
        $background->save($originalFilePath);

        return $folder . '/' . $fileName;
    }
}
