<?php

namespace rmnvl\yii2FileGridView\src\parsers;


/**
 * Class ParserFactory
 */
class ParserFactory
{
    /**
     * @param $filePath
     * @return CsvFileParser
     */
    public static function create($filePath)
    {
        // Some logic

        return new CsvFileParser($filePath);
    }
}