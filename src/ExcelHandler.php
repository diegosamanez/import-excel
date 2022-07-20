<?php
namespace Agregalel\ImportExcel;

class ExcelHandler
{
    public static function import(OnEachRow $onEachRow, $file)
    {
        $onEachRow->file = $file->path();
        $document = $onEachRow->getDocument();

        $row = new Row($document);
        for($i = 1; $i <= $document->getHighestDataRow(); $i++){
            $row->setIndex($i);
            $onEachRow->onRow($row);
        }
    }
}
