<?php
namespace Agregalel\ImportExcel;

use PhpOffice\PhpSpreadsheet\IOFactory;

abstract class OnEachRow
{
    public $file;
    public $sheet = 0;
    public function __construct()
    {}

    public function getDocument()
    {
        $file = IOFactory::load($this->file);
        return $file->getSheet($this->sheet);
    }

    abstract public function onRow(Row $row);
}
