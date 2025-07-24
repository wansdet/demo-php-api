@country
Feature: Test Country resources

  Scenario: Test collection of Country resources
    Given I am not authenticated
    When I request "/api/countries"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Country"
    And the response key "@id" is "/api/countries"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "136"
    And the response collection is a JSON array of length "136"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "id"
    And the response collection item has a JSON key "name"
    And the response collection item has a JSON key "active"
    And the response collection item has a JSON key "sortOrder"

  Scenario Outline:: Test collection of Country resources with name partial match filter
    Given I am not authenticated
    When I request "/api/countries?name=<country_name>"
    Then the response code is "200"
    And the response key "totalItems" is "<total_items>"
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
    And the response key "id" exists
    And the response key "name" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "region" exists
    And the response key "createdAt" exists

  Scenario Outline: Test single Country resources
    Given I am not authenticated
    When I request "/api/countries/<id>"
    Then the response code is "200"
    And the response key "@id" is "/api/countries/<id>"
    And the response key "id" is "<id>"
    And the response key "name" is "<country_name>"
    And the response key "active" is "<active>"
    And the response key "sortOrder" is "<sort_order>"
    And the response key "region" is "<region>"
    Examples:
      | id           | country_name      | active | region                      | sort_order |
      | GB           | United Kingdom    | true   | /api/regions/EUROPE         | 245        |
      | US           | United States     | true   | /api/regions/NORTH_AMERICA  | 246        |
      | AU           | Australia         | true   | /api/regions/OCEANIA        | 13         |
      | EG           | Egypt             | true   | /api/regions/MIDDLE_EAST    | 77         |

  Scenario: Test Country resource update with authorised user
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
    {
      "countryName": "Argentina updated",
      "sortOrder": 10,
      "active": false
    }
    """
    When I request "/api/countries/AR" with HTTP "PUT"
    Then the response code is "405"

  Scenario Outline: Test Country resource update with unauthorised user
    Given I am authenticated as "<user>"
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
      | user                        | response_code  |
      | EDITOR_1                    | 405            |
      | MODERATOR_1                 | 405            |
      | BLOG_AUTHOR_1               | 405            |
      | USER_1                      | 405            |

  Scenario: Test Country resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "name": "Argentina updated",
      "sortOrder": 10,
      "active": false
    }
    """
    When I request "/api/countries/AR" with HTTP "PUT"
    Then the response code is "405"

  Scenario: Test Country resource update with authorised user
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
    {
      "name": "Bahamas updated",
      "sortOrder": 20,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/countries/BS" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "name" is "Bahamas updated"
    And the response key "sortOrder" is 20
    And the response key "active" is boolean false

  Scenario Outline: Test Country resource patch with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "name": "Bahamas updated",
      "sortOrder": 20,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/countries/BS" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | EDITOR_1                    | 403            |
      | MODERATOR_1                 | 403            |
      | BLOG_AUTHOR_1               | 403            |
      | USER_1                      | 403            |

  Scenario: Test Country resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "name": "Bahamas updated",
      "sortOrder": 20,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/countries/BS" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Country resource creation with authorised user
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
    {
      "id": "XX",
      "name": "Test Country",
      "region": "/api/regions/EUROPE",
      "sortOrder": 30,
      "active": true
    }
    """
    And the "Content-Type" request header is "application/ld+json"
    When I request "/api/countries" with HTTP "POST"
    Then the response code is "201"
    And the response key "id" is "XX"
    And the response key "name" is "Test Country"
    And the response key "sortOrder" is 30
    And the response key "active" is boolean "true"

  Scenario Outline: Test Country resource creation with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "id": "XX",
      "name": "Test Country",
      "region": "/api/regions/EUROPE",
      "sortOrder": 30,
      "active": true
    }
    """
    When I request "/api/countries" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | EDITOR_1                    | 403            |
      | MODERATOR_1                 | 403            |
      | BLOG_AUTHOR_1               | 403            |
      | USER_1                      | 403            |

  Scenario: Test Country resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "id": "XX",
      "name": "Test Country",
      "region": "/api/regions/EUROPE",
      "sortOrder": 30,
      "active": true
    }
    """
    When I request "/api/countries" with HTTP "POST"
    Then the response code is "401"