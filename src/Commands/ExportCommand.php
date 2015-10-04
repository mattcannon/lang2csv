<?php

namespace MattCannon\Lang2Csv\Commands;


use Illuminate\Console\Command;
use MattCannon\Lang2Csv\Exporter;
use MattCannon\Lang2Csv\Importer;

class ExportCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'language:export {language_code}';
    protected $description = 'Export a language directory to a CSV file for easy editing';


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
        $languageCode = $this->argument('language_code');
        $this->exporter = Exporter::withBaseDirectory(getcwd().'/resources/lang/');
        $this->exporter->exportLanguageTo($languageCode,'.');
    }
}