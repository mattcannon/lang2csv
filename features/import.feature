Feature: Export Languages to CSV
  I should be able to import a csv of translations to a language directory.

  Scenario: I import a language csv.
    Given there is a csv called "en_export.csv" in "tests/lang/export"
    When I import "en_export.csv" with the "es" language code
    Then I should have an "es" directory
    And I should have 2 files in the "es" directory

   
  