<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use MattCannon\Lang2Csv\Exporter;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    private $basePath = "tests/lang/";

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^there is a directory called "([^"]*)"$/
     */
    public function thereIsADirectoryCalled($directoryName)
    {
        $fullPath = $this->getLanguageDirectoryPath($directoryName);
        if (!file_exists($fullPath))
            mkdir($fullPath);
    }

    /**
     * @Given /^"([^"]*)" contains (\d+) example language files$/
     */
    public function containsExampleLanguageFiles($directoryName, $count)
    {
        $values = [
            'string1' => 'a',
            'string2' => 'b',
            'array1' => [
                'a' => 'test',
                'b' => 'test2'
            ],
        ];
        $fileContents = '<?php return ' . var_export($values, true) . ';';
        for ($i = 0; $i < $count; $i++) {
            file_put_contents($this->getLanguageDirectoryPath($directoryName) . 'lang_file_' . $i . '.php', $fileContents);
        }
    }

    /**
     * @When /^I export "([^"]*)" to "([^"]*)"$/
     */
    public function iExportTo($languageDirectory, $exportDirectory)
    {
        $exporter = Exporter::withBaseDirectory($this->basePath);
        $exporter->exportLanguageTo($languageDirectory, $this->getLanguageDirectoryPath($exportDirectory));
    }

    /**
     * @Then /^I should have a CSV file called "([^"]*)" in the "([^"]*)" directory$/
     */
    public function iShouldHaveACsvFileCalledInTheDirectory($fileName, $directory)
    {
        PHPUnit_Framework_Assert::assertTrue(file_exists($this->getLanguageDirectoryPath($directory) . $fileName));
    }

    /**
     * @param $directoryName
     * @return string
     */
    private function getLanguageDirectoryPath($directoryName)
    {
        $fullPath = $this->basePath . $directoryName . '/';
        return $fullPath;
    }


}
