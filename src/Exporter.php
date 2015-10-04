<?php

namespace MattCannon\Lang2Csv;

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
        // TODO: write logic here
    }
}
