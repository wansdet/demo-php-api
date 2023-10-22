@country
Feature: Test Country resources
  Scenario: Test collection of Country resources
    Given I am not authenticated
    When I request "/api/countries"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Country"
    And the response key "@id" is "/api/countries"
    And the response key "@type" is "hydra:Collection"
    And the response key "hydra:totalItems" is "136"
    And the response collection is a JSON array of length "136"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "countryCode"
    And the response collection item has a JSON key "countryName"
    And the response collection item has a JSON key "active"
    And the response collection item has a JSON key "sortOrder"

  Scenario Outline:: Test collection of Country resources with countryName partial match filter
    Given I am not authenticated
    When I request "/api/countries?countryName=<country_name>"
    Then the response code is "200"
    And the response key "hydra:totalItems" is "<total_items>"
  Examples:
    | country_name  | total_items |
    | Be            | 4           |
    | BE            | 4           |
    | be            | 4           |
    | ca            | 8           |

  Scenario: Test single Country resource response properties
    Given I am not authenticated
    When I request "/api/countries/GB"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Country"
    And the response key "@id" is "/api/countries/GB"
    And the response key "@type" is "Country"
    And the response key "countryCode" exists
    And the response key "countryName" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "region" exists
    And the response key "createdAt" exists
    And the response key "createdBy" exists

  Scenario Outline: Test single Country resources
    Given I am not authenticated
    When I request "/api/countries/<country_code>"
    Then the response code is "200"
    And the response key "@id" is "/api/countries/<country_code>"
    And the response key "countryCode" is "<country_code>"
    And the response key "countryName" is "<country_name>"
    And the response key "active" is "<currency>"
    And the response key "sortOrder" is "<sort_order>"
    And the response key "region" is "<region>"
  Examples:
    | country_code | country_name      | active | region                      | sort_order |
    | GB           | United Kingdom    | true   | /api/regions/EUROPE         | 245        |
    | US           | United States     | true   | /api/regions/NORTH_AMERICA  | 246        |
    | AU           | Australia         | true   | /api/regions/OCEANIA        | 13         |
    | EG           | Egypt             | true   | /api/regions/MIDDLE_EAST    | 77         |

  Scenario: Test Country resource update with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "countryName": "Argentina updated",
      "sortOrder": 10,
      "active": false
    }
    """
    When I request "/api/countries/AR" with HTTP "PUT"
    Then the response code is "200"
    And the response key "countryName" is "Argentina updated"
    And the response key "sortOrder" is 10
    And the response key "active" is boolean false

  Scenario Outline: Test Country resource update with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "countryName": "Argentina updated",
      "sortOrder": 10,
      "active": false
    }
    """
    When I request "/api/countries/AR" with HTTP "PUT"
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

  Scenario: Test Country resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "countryName": "Argentina updated",
      "sortOrder": 10,
      "active": false
    }
    """
    When I request "/api/countries/AR" with HTTP "PUT"
    Then the response code is "401"

  Scenario: Test Country resource update with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "countryName": "Bahamas updated",
      "sortOrder": 20,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/countries/BS" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "countryName" is "Bahamas updated"
    And the response key "sortOrder" is 20
    And the response key "active" is boolean false

  Scenario Outline: Test Country resource patch with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "countryName": "Bahamas updated",
      "sortOrder": 20,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/countries/BS" with HTTP "PATCH"
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

  Scenario: Test Country resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "countryName": "Bahamas updated",
      "sortOrder": 20,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/countries/BS" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Country resource creation with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "countryCode": "XX",
      "countryName": "Test Country",
      "region": "/api/regions/EUROPE",
      "sortOrder": 30,
      "active": true
    }
    """
    When I request "/api/countries" with HTTP "POST"
    Then the response code is "201"
    And the response key "countryCode" is "XX"
    And the response key "countryName" is "Test Country"
    And the response key "sortOrder" is 30
    And the response key "active" is boolean "true"

  Scenario Outline: Test Country resource creation with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "countryCode": "XX",
      "countryName": "Test Country",
      "region": "/api/regions/EUROPE",
      "sortOrder": 30,
      "active": true
    }
    """
    When I request "/api/countries" with HTTP "POST"
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

  Scenario: Test Country resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "countryCode": "XX",
      "countryName": "Test Country",
      "region": "/api/regions/EUROPE",
      "sortOrder": 30,
      "active": true
    }
    """
    When I request "/api/countries" with HTTP "POST"
    Then the response code is "401"