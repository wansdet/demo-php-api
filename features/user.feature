@user
Feature: Test User resources
  Scenario: Test collection of User resources
    Given I am authenticated as "admin1@example.com" with password "Demo1234"
    When I request "/api/users" with HTTP "GET"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/User"
    And the response key "@id" is "/api/users"
    And the response key "@type" is "hydra:Collection"
    And the response key "hydra:totalItems" is "80"
    And the response collection is a JSON array of length "80"
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
    And the response collection item has a JSON key "sex"
    And the response collection item has a JSON key "jobTitle"
    And the response collection item has a JSON key "status"
    And the response collection item has a JSON key "createdAt"
    And the response collection item has a JSON key "createdBy"

  Scenario: Test single User resource
    Given I am authenticated as "admin1@example.com" with password "Demo1234"
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
    And the response key "roles" is a JSON array
    And the response key "sex" exists
    And the response key "jobTitle" exists
    And the response key "status" exists
    And the response key "createdBy" exists
    And the response key "createdAt" exists

  Scenario Outline: Test single User resource properties
    Given I am authenticated as "admin1@example.com" with password "Demo1234"
    When I request "/api/users/<user_id>" with HTTP "GET"
    Then the response code is "200"
    And the response key "email" is "<email>"
    And the response key "firstName" is "<first_name>"
    And the response key "lastName" is "<last_name>"
    And the response key "middleName" is "<middle_name>"
    And the response key "roles" contains array item "<roles>"
    And the response key "sex" is "<sex>"
    And the response key "status" is "<status>"
    And the response key "userId" is "<user_id>"
  Examples:
    | user_id                               | email                         | first_name    | last_name     | middle_name   | roles                 | sex     | status  |
    | 607093b1-e702-4618-8ac9-52cf52afc9fb  | admin1@example.com            | Jane          | Richards      | Elizabeth     | ROLE_ADMIN            | female  | active  |
    | 28b2915e-d054-46d4-bc0b-b674eebfad30  | editor2@example.com           | Kevin         | McDonald      | John          | ROLE_EDITOR           | male    | active  |
    | 98e2d981-dfb5-4258-a14f-e2bc9260345f  | moderator1@example.com        | Kelly         | Stephens      | Anne          | ROLE_MODERATOR        | female  | active  |
    | 3a14d373-8abf-49e7-8c11-3792f0e186db  | finance.director@example.com  | Katherine     | Sutton        | Emily         | ROLE_FINANCE          | female  | active  |
    | b1eae402-25b3-48b4-bcbc-cc36711fa223  | sales.manager1@example.com    | Peter         | Brown         | John          | ROLE_SALES_MANAGER    | male    | active  |
    | 4a1c67fd-8a0c-45ac-9884-ad45dfe04c95  | salesperson1@example.com      | Michael       | Hill          | David         | ROLE_SALESPERSON      | male    | active  |
    | c8beca68-00e9-4efd-a113-a893e8afbbbe  | blogauthor1@example.com       | Robert        | Walker        | Joseph        | ROLE_BLOGGER | male    | active  |
    | 0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7  | user1@example.com             | Mary          | Smith         | Jane          | ROLE_USER             | female  | active  |

  Scenario: Test unauthenticated user access to User collection resource
    Given I am not authenticated
    When I request "/api/users" with HTTP "GET"
    Then the response code is "401"

  Scenario: Test unauthenticated user access to single User resource
    Given I am not authenticated
    When I request "/api/users/607093b1-e702-4618-8ac9-52cf52afc9fb" with HTTP "GET"
    Then the response code is "401"

  Scenario Outline: Test authenticated user access to User collection resource
    Given I am authenticated as "<email>" with password "<password>"
    When I request "/api/users" with HTTP "GET"
    Then the response code is "<response_code>"
  Examples:
    | email                         | password  | response_code  |
    | admin2@example.com            | Demo1234  | 200            |
    | editor1@example.com           | Demo1234  | 200            |
    | moderator1@example.com        | Demo1234  | 200            |
    | finance.director@example.com  | Demo1234  | 200            |
    | sales.manager1@example.com    | Demo1234  | 200            |
    | salesperson1@example.com      | Demo1234  | 200            |
    | blogauthor1@example.com       | Demo1234  | 403            |
    | user1@example.com             | Demo1234  | 403            |

  Scenario Outline: Test authenticated user access to single User resource
    Given I am authenticated as "<email>" with password "<password>"
    When I request "/api/users/28b2915e-d054-46d4-bc0b-b674eebfad30" with HTTP "GET"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | admin2@example.com            | Demo1234  | 200            |
      | editor1@example.com           | Demo1234  | 200            |
      | moderator1@example.com        | Demo1234  | 200            |
      | finance.director@example.com  | Demo1234  | 200            |
      | sales.manager1@example.com    | Demo1234  | 200            |
      | salesperson1@example.com      | Demo1234  | 200            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario Outline: Test User resource update with authenticated user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "status": "active"
    }
    """
    When I request "/api/users/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | admin2@example.com            | Demo1234  | 200            |
      | editor1@example.com           | Demo1234  | 403            |
      | moderator1@example.com        | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test User resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "status": "on_hold"
    }
    """
    When I request "/api/users/cb980fc0-92fc-48c3-9a8c-06006be3131d" with HTTP "PUT"
    Then the response code is "401"

  Scenario Outline: Test User resource patch with authenticated user
    Given I am authenticated as "<email>" with password "<password>"
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
      | email                         | password  | response_code  |
      | admin2@example.com            | Demo1234  | 200            |
      | editor1@example.com           | Demo1234  | 403            |
      | moderator1@example.com        | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

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
    Given I am authenticated as "<email>" with password "Demo1234"
    When I request "/api/user_account" with HTTP "GET"
    Then the response code is "200"
    And the response key "email" is "<email>"
    And the response key "firstName" is "<first_name>"
    And the response key "lastName" is "<last_name>"
    And the response key "middleName" is "<middle_name>"
    And the response key "sex" is "<sex>"
    And the response key "status" is "<status>"
    And the response key "userId" is "<user_id>"
    Examples:
      | user_id                               | email                         | first_name    | last_name     | middle_name   | sex     | status  |
      | 607093b1-e702-4618-8ac9-52cf52afc9fb  | admin1@example.com            | Jane          | Richards      | Elizabeth     | female  | active  |
      | 28b2915e-d054-46d4-bc0b-b674eebfad30  | editor2@example.com           | Kevin         | McDonald      | John          | male    | active  |
      | 98e2d981-dfb5-4258-a14f-e2bc9260345f  | moderator1@example.com        | Kelly         | Stephens      | Anne          | female  | active  |
      | 3a14d373-8abf-49e7-8c11-3792f0e186db  | finance.director@example.com  | Katherine     | Sutton        | Emily         | female  | active  |
      | b1eae402-25b3-48b4-bcbc-cc36711fa223  | sales.manager1@example.com    | Peter         | Brown         | John          | male    | active  |
      | 4a1c67fd-8a0c-45ac-9884-ad45dfe04c95  | salesperson1@example.com      | Michael       | Hill          | David         | male    | active  |
      | c8beca68-00e9-4efd-a113-a893e8afbbbe  | blogauthor1@example.com       | Robert        | Walker        | Joseph        | male    | active  |
      | 0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7  | user1@example.com             | Mary          | Smith         | Jane          | female  | active  |

  Scenario: Test User account resource patch with unauthenticated user
    Given I am not authenticated
    When I request "/api/user_account" with HTTP "GET"
    Then the response code is "401"

  Scenario Outline: Test User account resource update with authenticated user
    Given I am authenticated as "<email>" with password "Demo1234"
    And the request body is:
    """
    {
      "middleName": "Harold",
      "jobTitle": "Senior Manager"
    }
    """
    When I request "/api/user_account/<user_id>" with HTTP "PUT"
    Then the response code is "200"
    And the response key "email" is "<email>"
    And the response key "firstName" is "<first_name>"
    And the response key "lastName" is "<last_name>"
    And the response key "middleName" is "<middle_name>"
    And the response key "sex" is "<sex>"
    And the response key "status" is "<status>"
    And the response key "userId" is "<user_id>"
    And the response key "jobTitle" is "<job_title>"
    Examples:
      | user_id                               | email             | first_name  | last_name | middle_name | sex   | status  | job_title       |
      | cb980fc0-92fc-48c3-9a8c-06006be3131d  | user2@example.net | John        | Richards  | Harold      | male  | active  | Senior Manager  |

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
    Then the response code is "401"