<?php
namespace Agregalel\ImportExcel;

class RowConfig {
    private $hasImage;

    public function __construct()
    {
        $this->hasImage = false;
    }

    public function getHasImage()
    {
        return $this->hasImage;
    }

    public function hasImage($hasImage)
    {
        $this->hasImage = $hasImage;
    }
}
