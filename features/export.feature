Feature: Export Languages to CSV 
  I should be able to export a directory of laravel language files to a single csv file.
  
  Scenario: I export a language directory.
    Given there is a directory called "en"
    And "en" contains 2 example language files
    When I export "en" to "exports"
    Then I should have a CSV file called "en_export.csv" in the "exports" directory
    
   
  