<?php

namespace MattCannon\Lang2Csv\Providers;


use Illuminate\Support\ServiceProvider;
use MattCannon\Lang2Csv\Commands\ExportCommand;
use MattCannon\Lang2Csv\Commands\ImportCommand;

class LanguageExportServiceProvider extends ServiceProvider
{
    private $commands = [
        ImportCommand::class,
        ExportCommand::class
    ];
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}