<?php

namespace spec\MattCannon\Lang2Csv;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImporterSpec extends ObjectBehavior
{
    function let(){
        $this->beConstructedThrough('withBaseDirectory',[getcwd()."/tests/lang/"]);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('MattCannon\Lang2Csv\Importer');
    }
    function it_should_be_able_to_import_a_csv(){
        $this->fromCsvWithLanguageCode('export/en_export.csv','es');
    }
}
