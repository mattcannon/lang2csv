<?php

namespace spec\MattCannon\Lang2Csv;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExporterSpec extends ObjectBehavior
{
    /*
     * $exporter = new \MattCannon\Lang2Csv\Exporter::withBaseDirectory($this->basePath);
     * $exporter->exportLanguageTo($languageDirectory,$exportDirectory);
     */
    function let()
    {
        $this->beConstructedThrough('withBaseDirectory', ['tests/lang/']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MattCannon\Lang2Csv\Exporter');
    }

    function it_can_export_a_language_directory()
    {
        $this->exportLanguageTo('en', 'exports/');
    }
}
