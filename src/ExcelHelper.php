<?php
namespace Agregalel\ImportExcel;

use Agregalel\ImportExcel\Exceptions\ExcelImageException;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExcelHelper
{
    private static $tempFiles = [];
    public static function foreachImage($document, $imageIndex, $index)
    {
        $images = $document->getDrawingCollection();
        $result = [];
        ExcelHelper::$tempFiles = [];
        for ($key=$imageIndex; $key < count($images); $key++) {
            $image = $images[$key];
            $imageIndex = $key;
            $coordinates = explode(',', preg_replace('/([A-Z]+)([0-9]+)/', '$1,$2', $image->getCoordinates()));
            if($coordinates[1] != $index) break;
            $columnIndex = Coordinate::columnIndexFromString($coordinates[0]);
            $result[$columnIndex] = ExcelHelper::convertZipToImage($image->getPath(), $image->getExtension());
        }
        return [
            'data' => $result,
            'index' => $imageIndex
        ];
    }

    public static function convertZipToImage($imageZip, $extension)
    {
        $source = null;
        switch($extension)
        {
            case 'jpg' :
            case 'jpeg':
                $tmpFile = imagecreatefromjpeg($imageZip);
                $source = tmpfile();
                $result = imagejpeg($tmpFile, $source);
                if(!$result) throw new ExcelImageException();
                break;
            case 'png' :
                $tmpFile = imagecreatefrompng($imageZip);
                $source = tmpfile();
                $result = imagejpeg($tmpFile, $source);
                if(!$result) throw new ExcelImageException();
                break;
        }
        $file = new UploadedFile(stream_get_meta_data($source)['uri'], substr(md5(time()), 0, 16).'.'.$extension);
        array_push(ExcelHelper::$tempFiles, $source);
        return $file;
    }
}
