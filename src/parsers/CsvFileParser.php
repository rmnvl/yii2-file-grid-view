<?php

namespace rmnvl\yii2FileGridView\src\parsers;

use yii\base\Exception;

/**
 * Class CsvFileParser
 * @package rmnvl\yii2FileGridView\src\parsers
 */
class CsvFileParser extends FileParser
{
    const DEFAULT_COLUMN_DELIMITER = ';';

    private $columnDelimiter;

    private $columnNames;

    /**
     * @return array|bool
     */
    public function parse()
    {
        $this->setParserParams();
        $rr = [];
        $handle = fopen($this->filePath, 'r');
        while (($data = fgetcsv($handle, 100, self::DEFAULT_COLUMN_DELIMITER)) !== false) {
            $rr[] = $data;
        }
        $this->columnNames = array_shift($rr);
        $result = [];
        foreach ($rr as $r) {
            $result[] = $this->juxtoposeDataWithCNames($r);
        }

        return $result;
    }


    /**
     * @param array $rowData
     * @return array
     */
    private function juxtoposeDataWithCNames($rowData)
    {
        $r = array_combine($this->columnNames, $this->columnNames);
        foreach ($rowData as $k => $item) {
            $r[$this->columnNames[$k]] = null;
            if (isset($this->columnNames[$k])) {
                $r[$this->columnNames[$k]] = $item;
            }
        }

        return $r;
    }


    private function setParserParams()
    {
        /**
         * TODO identify column delimiter
         */
        $this->columnDelimiter = self::DEFAULT_COLUMN_DELIMITER;
    }


    /**
     * @param $id
     * @return bool
     */
    public function deleteRow($id)
    {
        $data = $this->parse();
        unset($data[$id]);

        return $this->saveFile($data);
    }

    /**
     * @param $id
     * @param $rowData
     * @return bool
     * @throws Exception
     */
    public function updateRow($id, $rowData)
    {
        $data = $this->parse();
        if (!isset($data[$id])) {
            throw new Exception();
        }
        $data[$id] = json_decode($rowData, true);
        return $this->saveFile($data);
    }

    /**
     * @param $list
     * @param null $filePath
     * @return bool
     */
    private function saveFile($list, $filePath = null)
    {
        $fp = fopen($this->filePath, 'w');

        $this->writeRow($this->columnNames, $fp);
        foreach ($list as $fields) {
            $this->writeRow($fields, $fp);
        }

        return fclose($fp);
    }

    /**
     * @param $fields
     * @param $fp
     */
    private function writeRow($fields, $fp)
    {
        fputcsv($fp, $fields, $this->columnDelimiter);
    }
}
