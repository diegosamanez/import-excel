<?php
namespace Agregalel\ImportExcel;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Row
{
    private $index;
    private $document;
    private $config;
    private $imageIndex = 0;
    public function __construct(Worksheet $document)
    {
        $this->document = $document;
        $this->config = new RowConfig();
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }

    public function config(RowConfig $data){
        $this->config = $data;
    }

    public function toArray()
    {
        $finalColumn = Coordinate::columnIndexFromString($this->document->getHighestDataColumn($this->index));
        $columns = [];
        $images = null;
        if($this->config->getHasImage()) $images = ExcelHelper::foreachImage(
            $this->document,
            $this->imageIndex,
            $this->index
        );

        $this->imageIndex = $images['index'];
        $images = $images['data'];

        for($i = 1; $i <= $finalColumn; $i++)
        {
            $cell = $this->document->getCellByColumnAndRow($i, $this->index);
            if($this->config->getHasImage()) {
                if(array_key_exists($i, $images)){
                    array_push($columns, $images[$i]);
                    continue;
                }
            }
            array_push($columns, $cell->getValue());
        }

        return $columns;
    }
}
