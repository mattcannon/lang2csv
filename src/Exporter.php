<?php

namespace MattCannon\Lang2Csv;

use League\Csv\Writer;
use SplFileObject;

/**
 * Class Exporter
 * @package MattCannon\Lang2Csv
 */
class Exporter
{
    /**
     * @var string
     */
    private $baseDirectory = './';

    /**
     * Exporter constructor.
     */
    private function __construct()
    {
    }

    /**
     * Returns an exporter object using the passed in directory as the file root.
     * @param $directory
     * @return Exporter
     */
    public static function withBaseDirectory($directory)
    {
        $exporter = new Exporter();
        $exporter->baseDirectory = $directory;
        return $exporter;
    }

    /** 
     * @param $language
     * @param $destination
     */
    public function exportLanguageTo($language, $destination)
    {
        $translations = $this->getFlattenedTranslationsForLanguage($language);
        $destinationPath = $this->getDestinationPathForCsv($destination, $language);
        if(!file_exists(dirname($destinationPath))){
            mkdir(dirname($destinationPath));
        }
        $this->writeToCsv($translations, $destinationPath);
        
    }

    /**
     * @param $languageCode
     * @return array
     */
    public function getValuesFromFiles($languageCode)
    {
        return $this->mapTranslationsToRows($this->getLanguageDirectory($languageCode));
    }

    /**
     * @param $destination
     * @param $language
     * @return string
     */
    public function getDestinationPathForCsv($destination, $language)
    {
        
        return $this->baseDirectory.$destination.'/'.$language.'_export.csv';
    }

    /**
     * @param $rows
     * @param $destinationPath
     */
    public function writeToCsv($rows, $destinationPath)
    {
        $csv = Writer::createFromPath($destinationPath,'w+');
        $csv->insertAll($rows);  
    }

    /**
     * @param $language
     * @return array
     */
    private function getFlattenedTranslationsForLanguage($language)
    {
        $translations = $this->getValuesFromFiles($language);
        $translations = array_dot($translations);
        $rows = [];
        foreach($translations as $k=>$v){
            $rows[] = [$k,$v];
        }
        return $rows;
    }

    /**
     * @param $languageCode
     * @return string
     */
    private function getLanguageDirectory($languageCode)
    {
        return $this->baseDirectory . $languageCode . '/';
    }

    /**
     * @param $basePath
     * @return array
     */
    private function mapTranslationsToRows($basePath)
    {
        $files = $this->getLanguageFilesForPath($basePath);
        $values = [];
        foreach ($files as $file) {
            $values[$this->convertFileNameToKey($basePath, $file)] = include($file);
        }
        return $values;
    }

    /**
     * @param $basePath
     * @return array
     */
    private function getLanguageFilesForPath($basePath)
    {
        $files = glob($basePath . '*.php');
        return $files;
    }

    /**
     * @param $basePath
     * @param $file
     * @return string
     */
    private function convertFileNameToKey($basePath, $file)
    {
        return substr($file, strlen($basePath), -4);
    }
}
