@region
Feature: Test Region resources
  Scenario: Test collection of Region resources
    Given I am not authenticated
    When I request "/api/regions"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Region"
    And the response key "@id" is "/api/regions"
    And the response key "@type" is "hydra:Collection"
    And the response key "hydra:totalItems" is "10"
    And the response collection is a JSON array of length "10"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "regionCode"
    And the response collection item has a JSON key "regionName"
    And the response collection item has a JSON key "active"
    And the response collection item has a JSON key "sortOrder"

  Scenario: Test single Region resource response properties
    Given I am not authenticated
    When I request "/api/regions/EUROPE"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Region"
    And the response key "@id" is "/api/regions/EUROPE"
    And the response key "@type" is "Region"
    And the response key "regionCode" exists
    And the response key "regionName" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "createdAt" exists
    And the response key "createdBy" exists
    And the response key "countries" is a JSON array

  Scenario Outline: Test single Region resources
    Given I am not authenticated
    When I request "/api/regions/<region_code>"
    Then the response code is "200"
    And the response key "@id" is "/api/regions/<region_code>"
    And the response key "countries" is a JSON array of length "<country_count>"
    And the response key "regionCode" is "<region_code>"
    And the response key "regionName" is "<region_name>"
    And the response key "sortOrder" is "<sort_order>"
      Examples:
        | region_code     | country_count | region_code     | region_name     | sort_order |
        | AFRICA          | 11            | AFRICA          | Africa          | 1          |
        | ANTARCTICA      | 3             | ANTARCTICA      | Antarctica      | 10         |
        | ASIA            | 14            | ASIA            | Asia            | 2          |
        | CARIBBEAN       | 19            | CARIBBEAN       | Caribbean       | 3          |
        | CENTRAL_AMERICA | 6             | CENTRAL_AMERICA | Central America | 8          |
        | EUROPE          | 48            | EUROPE          | Europe          | 4          |
        | MIDDLE_EAST     | 9             | MIDDLE_EAST     | Middle East     | 5          |
        | NORTH_AMERICA   | 4             | NORTH_AMERICA   | North America   | 7          |
        | OCEANIA         | 12            | OCEANIA         | Oceania         | 6          |
        | SOUTH_AMERICA   | 10            | SOUTH_AMERICA   | South America   | 9          |

  Scenario: Test Region resource update with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "regionName": "Africa updated",
      "sortOrder": 2,
      "active": false
    }
    """
    When I request "/api/regions/AFRICA" with HTTP "PUT"
    Then the response code is "200"
    And the response key "regionName" is "Africa updated"
    And the response key "sortOrder" is 2
    And the response key "active" is boolean "false"

  Scenario Outline: Test Region resource update with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "regionName": "Africa updated",
      "sortOrder": 2,
      "active": false
    }
    """
    When I request "/api/regions/AFRICA" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | editor1@example.com           | Demo1234  | 403            |
      | moderator1@example.com        | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test Region resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "regionName": "Africa updated",
      "sortOrder": 2,
      "active": false
    }
    """
    When I request "/api/regions/AFRICA" with HTTP "PUT"
    Then the response code is "401"

  Scenario: Test Region resource patch with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "regionName": "Europe updated",
      "sortOrder": 2,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/regions/EUROPE" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "regionName" is "Europe updated"
    And the response key "sortOrder" is 2
    And the response key "active" is boolean "false"

  Scenario Outline: Test Region resource patch with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "regionName": "Europe updated",
      "sortOrder": 2,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/regions/EUROPE" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | editor1@example.com           | Demo1234  | 403            |
      | moderator1@example.com        | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test Region resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "regionName": "Europe updated",
      "sortOrder": 2,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/regions/EUROPE" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Region resource creation with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "regionCode": "NEW_REGION",
      "regionName": "New Region",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/regions" with HTTP "POST"
    Then the response code is "201"
    And the response key "regionCode" is "NEW_REGION"
    And the response key "regionName" is "New Region"
    And the response key "sortOrder" is 10
    And the response key "active" is boolean "true"

  Scenario Outline: Test Region resource creation with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "regionCode": "NEW_REGION",
      "regionName": "New Region",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/regions" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | editor1@example.com           | Demo1234  | 403            |
      | moderator1@example.com        | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test Region resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "regionCode": "NEW_REGION",
      "regionName": "New Region",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/regions" with HTTP "POST"
    Then the response code is "401"