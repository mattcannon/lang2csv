<?php

namespace MattCannon\Lang2Csv;

use League\Csv\Reader;

class Importer
{
    private $baseDirectory = './';

    private function __construct()
    {
    }

    public static function withBaseDirectory($baseDirectory)
    {
        $importer = new Importer();
        $importer->baseDirectory = $baseDirectory;
        return $importer;
    }

    public function fromCsvWithLanguageCode($filename, $languageCode)
    {
        $csv = Reader::createFromPath($this->baseDirectory . $filename);
        $rows = $this->extractRowsFromCsv($csv);
        $this->ensureDirectoryExists($languageCode);
        $this->writeFilesForLanguageWIthRows($languageCode, $rows);
    }

    /**
     * @param $reader
     * @return array
     */
    private function extractRowsFromCsv($reader)
    {
        $rows = [];
        foreach ($reader as $item) {
            if (sizeof($item) > 1) {
                array_set($rows, $item[0], $item[1]);
            }
        }
        return $rows;
    }

    /**
     * @param $languageCode
     */
    private function ensureDirectoryExists($languageCode)
    {
        if (!file_exists($this->baseDirectory . $languageCode)) {
            mkdir($this->baseDirectory . $languageCode);
        }
    }

    /**
     * @param $value
     * @return string
     */
    private function getFileContentsForValue($value)
    {
        return '<?php return ' . var_export($value, true) . ';';
    }

    /**
     * @param $filename
     * @param $languageCode
     * @return string
     */
    private function getPathForFileWithLanguageCode($filename, $languageCode)
    {
        return $this->baseDirectory . $languageCode . '/' . $filename . '.php';
    }

    /**
     * @param $filename
     * @param $languageCode
     * @param $value
     */
    private function writeFileForLanguageCode($filename, $languageCode, $value)
    {
        $filePath = $this->getPathForFileWithLanguageCode($filename, $languageCode);
        $contents = $this->getFileContentsForValue($value);
        file_put_contents($filePath, $contents);
    }

    /**
     * @param $filename
     * @param $languageCode
     * @return bool
     */
    private function isNotOverwritingExistingFile($filename, $languageCode)
    {
        return !file_exists($this->baseDirectory . $languageCode . '/' . $filename . '.php');
    }

    /**
     * @param $languageCode
     * @param $rows
     * @internal param $filename
     */
    private function writeFilesForLanguageWIthRows( $languageCode, $rows)
    {
        foreach ($rows as $filename => $value) {
            if ($this->isNotOverwritingExistingFile($filename, $languageCode)) {
                $this->writeFileForLanguageCode($filename, $languageCode, $value);
            }
        }
    }
}
