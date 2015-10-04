<?php

namespace MattCannon\Lang2Csv\Commands;


use Illuminate\Console\Command;
use MattCannon\Lang2Csv\Importer;

class ImportCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'language:import {file_path} {language_code}';
    protected $description = 'Import a language CSV to language directory';

    private $importer;


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->argument('file_path');   
        $languageCode = $this->argument('language_code');
        $this->importer = Importer::withBaseDirectory(getcwd().'/resources/lang/');
        $this->importer->fromCsvWithLanguageCode($path,$languageCode);
    }
}