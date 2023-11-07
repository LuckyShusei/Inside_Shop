<?php


namespace App\Services;

use \Imagick;

class FileService
{

    public static function uploadFile($uploadedFile) :array
    {
        $Data = self::getFileInfo($uploadedFile);
        \Storage::disk('upload')->putFileAs(
            '',
            $uploadedFile,
            $Data['name']
        );
        return $Data;
    }

    public static function resizeImage($file_name, $resize_path)
    {
        $Image =  new Imagick(\Storage::disk('upload')->path($file_name));
        $Image->thumbnailImage(400, 300, true, false);
        $data = $Image->getImageBlob();
        \Storage::disk('upload')->put($resize_path, $data);
        return $data;
    }

    public static function getData($file_name)
    {
        return \Storage::disk('upload')->get($file_name);
    }

    /**
     * @param $uploadedFile
     * @return array
     */
    public static function getFileInfo($uploadedFile): array
    {
        $uniq_key = md5(uniqid('mopi-', true));
        $id = date('ymdHi') . '-' . $uniq_key;
        $ext = $uploadedFile->extension();

        $Data = array();
        $Data['id']          = $id;
        $Data['name']        = $id . '.' . $ext;
        $Data['client_name'] = $uploadedFile->getClientOriginalName();
        $Data['link_uri']    = $id . '.' . $ext;
        $Data['thumbnail_uri'] = 'thumbnail/' . $id . '.png';
        $Data['extension']   = $ext;
        $Data['mime_type']   = $uploadedFile->getMimeType();
        $Data['size']        = $uploadedFile->getSize();
        return $Data;
    }
}
