<?php

namespace spec\MattCannon\Lang2Csv;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExporterSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedThrough('withBaseDirectory', ['tests/lang/']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MattCannon\Lang2Csv\Exporter');
    }

    function it_can_get_values_from_files()
    {
        $this->getValuesFromFiles("en");
    }

    function it_can_export_a_language_directory()
    {
        $this->exportLanguageTo('en', 'export/');
    }

    function it_can_return_the_expected_filepath_for_an_exported_file()
    {
        $this->getDestinationPathForCsv('test/lang/export', 'en');
    }

    function it_can_write_to_csv()
    {
        $rows = [
            ['lang_file_0.string1', 'a'],
            ['lang_file_0.string2', 'b'],
            ['lang_file_0.array1.a', 'test'],
            ['lang_file_0.array1.b', 'test2'],
            ['lang_file_1.string1', 'a'],
            ['lang_file_1.string2', 'b'],
            ['lang_file_1.array1.a', 'test'],
            ['lang_file_1.array1.b', 'test2'],
        ];
        $this->writeToCsv($rows, getcwd().'/tests/lang/export/en_export.csv');
    }
}
