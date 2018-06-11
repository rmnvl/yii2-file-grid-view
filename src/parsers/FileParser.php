<?php

namespace rmnvl\yii2FileGridView\src\parsers;

/**
 * Class FileParser
 */
abstract class FileParser
{
    protected $filePath;

    protected $parserParams;

    /**
     * FileParser constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    abstract public function parse();

    abstract public function deleteRow($id);

    abstract public function updateRow($id, $dataRow);
}