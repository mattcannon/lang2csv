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
        $reader = Reader::createFromPath($this->baseDirectory.'/export/'.$filename);
        $rows = [];
        foreach($reader as $item){
            if(sizeof($item)>1) {
                array_set($rows, $item[0], $item[1]);
            }
        }
        if(!file_exists($this->baseDirectory.$languageCode)) {
            mkdir($this->baseDirectory . $languageCode);
        }
        foreach ($rows as $filename => $value) {
            if(!file_exists($this->baseDirectory.$languageCode.'/'.$filename.'.php')) {
                file_put_contents($this->baseDirectory . $languageCode . '/' . $filename . '.php', '<?php return ' . var_export($value, true).';');
            }
        }
    }
}
