<?php

namespace MattCannon\Lang2Csv;

use League\Csv\Writer;
use SplFileObject;

class Exporter
{
    private $baseDirectory = './';

    private function __construct()
    {
    }

    public static function withBaseDirectory($baseDirectory)
    {
        $exporter = new Exporter();
        $exporter->baseDirectory = $baseDirectory;
        return $exporter;
    }

    public function exportLanguageTo($language, $destination)
    {
        $translations = $this->getValuesFromFiles($language);
        $translations = array_dot($translations);
        $rows = [];
        foreach($translations as $key => $value){
            $rows[] = [$key,$value];
        }
        $destinationPath = $this->getDestinationPathForCsv($destination, $language);
//        $this->writeToCsv($translations, $destinationPath);
        
    }

    public function getValuesFromFiles($languageCode)
    {
        $basePath = $this->baseDirectory.$languageCode.'/';
        $files = glob($basePath.'*.php');
        $values = [];
        foreach($files as $file){
            $values[substr($file,strlen($basePath),-4)] = include($file);
        }
        return $values;
    }

    public function getDestinationPathForCsv($destination, $language)
    {
        return $destination.'/'.$language.'_export.csv';
    }

    public function writeToCsv($rows, $destinationPath)
    {
        $csv = Writer::createFromPath($destinationPath,'w+');
        $csv->insertAll($rows);  
    }
}
