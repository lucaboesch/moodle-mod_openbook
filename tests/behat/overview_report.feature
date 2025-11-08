@mod @mod_openbook
Feature: Testing overview integration in openbook activity
  In order to summarize the openbook activity
  As a user
  I need to be able to see the openbook activity overview

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | 1        | student1@example.com |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category | enablecompletion |
      | Course 1 | C1        | 0        | 1                |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And the following "activity" exists:
      | course                | C1                                |
      | activity              | openbook                          |
      | name                  | Openbook resource folder activity |
      | intro                 | description                       |
      | idnumber              | openbook1                         |

  Scenario: The Openbook resource folder activity overview report should generate log events
    Given I am on the "Course 1" "course > activities" page logged in as "teacher1"
    And I click on "Expand" "link" in the "openbook_overview_collapsible" "region"
    When I am on the "Course 1" "course" page logged in as "teacher1"
    And I navigate to "Reports" in current page administration
    And I click on "Logs" "link"
    And I click on "Get these logs" "button"
    Then I should see "Course activities overview page viewed"
    And I should see "viewed the instance list for the module 'openbook'"

  Scenario: The Openbook resource folder activity index redirect to the activities overview
    When I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I add the "Activities" block
    And I click on "Openbook resource folders" "link" in the "Activities" "block"
    Then I should see "An overview of all activities in the course"
    And I should see "Name" in the "openbook_overview_collapsible" "region"
    And I should see "Upload until" in the "openbook_overview_collapsible" "region"
    And I should see "Students who submitted" in the "openbook_overview_collapsible" "region"
    And I should see "Actions" in the "openbook_overview_collapsible" "region"
