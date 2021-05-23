<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;


class FileService
{
    function __construct()
    {
    }

    /**
     * ローカル環境 storage/app/public/imgにファイルアップロード
     *
     * @param $file
     * @return string $uploadedFilePath
     */
    public function uploadFileForLocal($file): string
    {
        $originalFileName = $file->getClientOriginalName();
        $extension = \File::extension($originalFileName);
        $convertedFileName = "image_" . date('YmdHis') . '_' . rand(1000, 9999) . '.' . $extension;
        $tempPath = $file->storeAs('public/img',  $convertedFileName);
        $uploadedFilePath = str_replace('public/', '/storage/', $tempPath);
        return  $uploadedFilePath;
    }

    /**
     * 本番環境 s3ファイルアップロード
     *
     * @param $file
     * @return string $uploadedFilePath
     */
    public function uploadFile($file): string
    {
        $originalFileName = $file->getClientOriginalName();
        $extension = \File::extension($originalFileName);
        $convertedFileName = "image_" . date('YmdHis') . '_' . rand(1000, 9999) . '.' . $extension;
        // バケットの`gizface`フォルダへアップロード
        $path = Storage::disk('s3')->putFile('gizface', $convertedFileName, 'public');

        $uploadedFilePath = Storage::disk('s3')->url($path);
        return  $uploadedFilePath;
    }
}
