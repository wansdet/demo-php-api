@user
Feature: Test User resources

  Scenario: Test collection of User resources
    Given I am authenticated as "ADMIN_1"
    When I request "/api/users" with HTTP "GET"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/User"
    And the response key "@id" is "/api/users"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "70"
    And the response collection is a JSON array of length "70"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "id"
    And the response collection item has a JSON key "userId"
    And the response collection item has a JSON key "email"
    And the response collection item has a JSON key "firstName"
    And the response collection item has a JSON key "lastName"
    And the response collection item has a JSON key "middleName"
    And the response collection item has a JSON key "displayName"
    And the response collection item does not have a JSON key "password"
    And the response collection item has a JSON key "roles"
    And the response collection item has a JSON key "gender"
    And the response collection item has a JSON key "jobTitle"
    And the response collection item has a JSON key "status"
    And the response collection item has a JSON key "createdAt"
    And the response collection item has a JSON key "createdBy"

  Scenario: Test single User resource
    Given I am authenticated as "ADMIN_1"
    When I request "/api/users/607093b1-e702-4618-8ac9-52cf52afc9fb" with HTTP "GET"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/User"
    And the response key "@type" is "User"
    And the response key "id" does not exist
    And the response key "userId" exists
    And the response key "email" exists
    And the response key "firstName" exists
    And the response key "lastName" exists
    And the response key "middleName" exists
    And the response key "displayName" exists
    And the response key "description" exists
    And the response key "roles" is a JSON array
    And the response key "gender" exists
    And the response key "jobTitle" exists
    And the response key "status" exists
    And the response key "createdBy" exists
    And the response key "createdAt" exists

  Scenario Outline: Test single User resource properties
    Given I am authenticated as "ADMIN_1"
    When I request "/api/users/<user_id>" with HTTP "GET"
    Then the response code is "200"
    And the response key "email" is "<email>"
    And the response key "firstName" is "<first_name>"
    And the response key "lastName" is "<last_name>"
    And the response key "middleName" is "<middle_name>"
    And the response key "roles" contains array item "<roles>"
    And the response key "gender" is "<gender>"
    And the response key "status" is "<status>"
    And the response key "userId" is "<user_id>"
  Examples:
    | user_id                               | email                         | first_name    | last_name     | middle_name   | roles                 | gender     | status  |
    | 607093b1-e702-4618-8ac9-52cf52afc9fb  | admin1@example.com            | Jane          | Richards      | Elizabeth     | ROLE_ADMIN            | female  | active  |
    | 28b2915e-d054-46d4-bc0b-b674eebfad30  | editor2@example.com           | Kevin         | McDonald      | John          | ROLE_EDITOR           | male    | active  |
    | 98e2d981-dfb5-4258-a14f-e2bc9260345f  | moderator1@example.com        | Kelly         | Stephens      | Anne          | ROLE_MODERATOR        | female  | active  |
    | 0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7  | user1@example.com             | Aaliyah       | Aaron         | Jane          | ROLE_USER             | female  | active  |

  Scenario: Test unauthenticated user access to User collection resource
    Given I am not authenticated
    When I request "/api/users" with HTTP "GET"
    Then the response code is "401"

  Scenario: Test unauthenticated user access to single User resource
    Given I am not authenticated
    When I request "/api/users/607093b1-e702-4618-8ac9-52cf52afc9fb" with HTTP "GET"
    Then the response code is "401"

  Scenario Outline: Test authenticated user access to User collection resource
    Given I am authenticated as "<user>"
    When I request "/api/users" with HTTP "GET"
    Then the response code is "<response_code>"
  Examples:
    | user                        | response_code  |
    | ADMIN_2                     | 200            |
    | EDITOR_1                    | 200            |
    | MODERATOR_1                 | 200            |
    | BLOG_AUTHOR_1               | 403            |
    | USER_1                      | 403            |

  Scenario Outline: Test authenticated user access to single User resource
    Given I am authenticated as "<user>"
    When I request "/api/users/28b2915e-d054-46d4-bc0b-b674eebfad30" with HTTP "GET"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | ADMIN_2                     | 200            |
      | EDITOR_1                    | 200            |
      | BLOG_AUTHOR_1               | 403            |
      | USER_1                      | 403            |

  Scenario Outline: Test User resource update with authenticated user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "status": "active"
    }
    """
    When I request "/api/users/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | ADMIN_2                     | 405            |
      | EDITOR_1                    | 405            |
      | MODERATOR_1                 | 405            |
      | BLOG_AUTHOR_1               | 405            |
      | USER_1                      | 405            |

  Scenario: Test User resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "status": "on_hold"
    }
    """
    When I request "/api/users/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PUT"
    Then the response code is "405"

  Scenario Outline: Test User resource patch with authenticated user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "status": "on_hold"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/users/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | ADMIN_2                     | 200            |
      | EDITOR_1                    | 403            |
      | MODERATOR_1                 | 403            |
      | BLOG_AUTHOR_1               | 403            |
      | USER_1                      | 403            |

  Scenario: Test User resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "status": "on_hold"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/users/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PATCH"
    Then the response code is "401"

  Scenario Outline: Test User account resource with authenticated user
    Given I am authenticated as "<user>"
    When I request "/api/user_account" with HTTP "GET"
    Then the response code is "200"
    And the response key "email" is "<email>"
    And the response key "firstName" is "<first_name>"
    And the response key "lastName" is "<last_name>"
    And the response key "middleName" is "<middle_name>"
    And the response key "gender" is "<gender>"
    And the response key "status" is "<status>"
    And the response key "userId" is "<user_id>"
    Examples:
      | user_id                               | user               | email                    | first_name    | last_name     | middle_name   | gender  | status  |
      | 607093b1-e702-4618-8ac9-52cf52afc9fb  | ADMIN_1            | admin1@example.com       | Jane          | Richards      | Elizabeth     | female  | active  |
      | 28b2915e-d054-46d4-bc0b-b674eebfad30  | EDITOR_2           | editor2@example.com      | Kevin         | McDonald      | John          | male    | active  |
      | 98e2d981-dfb5-4258-a14f-e2bc9260345f  | MODERATOR_1        | moderator1@example.com   | Kelly         | Stephens      | Anne          | female  | active  |
      | 0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7  | USER_1             | user1@example.com        | Aaliyah       | Aaron         | Jane          | female  | active  |

  Scenario: Test User account resource patch with unauthenticated user
    Given I am not authenticated
    When I request "/api/user_account" with HTTP "GET"
    Then the response code is "401"

  Scenario Outline: Test User account resource update with authenticated user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "middleName": "Harold",
      "jobTitle": "Senior Manager"
      "description: "Test user account resource update"
    }
    """
    When I request "/api/user_account/<user_id>" with HTTP "PUT"
    Then the response code is "405"
    Examples:
      | user_id                               | user            |
      | cb980fc0-92fc-48c3-9a8c-06006be3131d  | USER_2          |

  Scenario: Test User account resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "middleName": "Harold",
      "jobTitle": "Senior Manager"
    }
    """
    When I request "/api/user_account/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PUT"
    Then the response code is "405"

  Scenario Outline: Test User account resource update with authenticated user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "middleName": "Harold",
      "jobTitle": "Senior Manager",
      "description": "Test description"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/user_account/<user_id>" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "email" is "<email>"
    And the response key "firstName" is "<first_name>"
    And the response key "lastName" is "<last_name>"
    And the response key "middleName" is "<middle_name>"
    And the response key "gender" is "<gender>"
    And the response key "status" is "<status>"
    And the response key "userId" is "<user_id>"
    And the response key "jobTitle" is "<job_title>"
    And the response key "description" is "<description>"
    Examples:
      | user_id                               | user    | email             | first_name  | last_name | middle_name | gender   | status  | job_title       | description       |
      | cb980fc0-92fc-48c3-9a8c-06006be3131d  | USER_2  | user2@example.net | John        | Richards  | Harold      | male     | active  | Senior Manager  | Test description  |

  Scenario: Test User account resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "middleName": "Harold",
      "jobTitle": "Senior Manager"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/user_account/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PATCH"
    Then the response code is "401"