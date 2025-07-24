@auth
Feature: Test User authentication
  @test
  Scenario Outline: Test User authentication with multiple users
    Given I am authenticating as "<user>"
    When I request "/api/login_check" using HTTP POST
    Then the response code is "200"
    And the response key "token" exists
    Examples:
    | user          |
    | ADMIN_1       |
    | EDITOR_1      |
    | MODERATOR_1   |
    | BLOG_AUTHOR_1 |
    | USER_1        |
    | USER_2        |

    Scenario: Test authentication with invalid credentials
      Given I am authenticating as "INVALID_USER"
      When I request "/api/login_check" using HTTP POST
      Then the response code is "401"
      Then the response code is "401"

    Scenario: Test unauthenticated user
        Given I am not authenticated
        When I request "/api/users" with HTTP "GET"
        Then the response code is "401"

    Scenario: Test authorised authenticated user
      Given I am authenticated as "ADMIN_1"
      When I request "/api/users" with HTTP "GET"
      Then the response code is "200"

    Scenario: Test unauthorised authenticated user
      Given I am authenticated as "USER_1"
      When I request "/api/users" with HTTP "GET"
      Then the response code is "403"
