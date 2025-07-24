@region
Feature: Test Region resource

  Scenario: Test collection of Region resources
    Given I am not authenticated
    When I request "/api/regions"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Region"
    And the response key "@id" is "/api/regions"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "10"
    And the response collection is a JSON array of length "10"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "id"
    And the response collection item has a JSON key "name"
    And the response collection item has a JSON key "active"
    And the response collection item has a JSON key "sortOrder"

  Scenario: Test single Region resource response properties
    Given I am not authenticated
    When I request "/api/regions/EUROPE"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Region"
    And the response key "@id" is "/api/regions/EUROPE"
    And the response key "@type" is "Region"
    And the response key "id" exists
    And the response key "name" exists
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
    And the response key "id" is "<region_code>"
    And the response key "name" is "<region_name>"
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
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
    {
      "name": "Africa updated",
      "sortOrder": 2,
      "active": false
    }
    """
    When I request "/api/regions/AFRICA" with HTTP "PUT"
    Then the response code is "405"

  Scenario Outline: Test Region resource update with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "name": "Africa updated",
      "sortOrder": 2,
      "active": false
    }
    """
    When I request "/api/regions/AFRICA" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | user                          | response_code  |
      | EDITOR_1                     | 405            |
      | MODERATOR_1                  | 405            |
      | BLOG_AUTHOR_1                | 405            |
      | USER_1                       | 405            |

  Scenario: Test Region resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "name": "Africa updated",
      "sortOrder": 2,
      "active": false
    }
    """
    When I request "/api/regions/AFRICA" with HTTP "PUT"
    Then the response code is "405"

  Scenario: Test Region resource patch with authorised user
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
    {
      "name": "Europe updated",
      "sortOrder": 2,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/regions/EUROPE" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "name" is "Europe updated"
    And the response key "sortOrder" is 2
    And the response key "active" is boolean "false"

  Scenario Outline: Test Region resource patch with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "name": "Europe updated",
      "sortOrder": 2,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/regions/EUROPE" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
        | user                          | response_code  |
        | EDITOR_1                     | 403            |
        | MODERATOR_1                  | 403            |
        | BLOG_AUTHOR_1                | 403            |
        | USER_1                       | 403            |

  Scenario: Test Region resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "name": "Europe updated",
      "sortOrder": 2,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/regions/EUROPE" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Region resource creation with authorised user
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
    {   "id": "NEW_REGION",
        "name": "New Region",
        "briefDescription": "Brief description",
        "shortDescription": "Short description",
        "longDescription": "Long description",
        "active": true,
        "sortOrder": 20
    }
    """
    And the "Content-Type" request header is "application/ld+json"
    When I request "/api/regions" with HTTP "POST"
    Then the response code is "201"
    And the response key "id" is "NEW_REGION"
    And the response key "name" is "New Region"
    And the response key "sortOrder" is 20
    And the response key "active" is boolean "true"

  Scenario Outline: Test Region resource creation with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "id": "NEW_REGION",
      "name": "New Region",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/regions" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | user                         | response_code  |
      | EDITOR_1                     | 403            |
      | MODERATOR_1                  | 403            |
      | BLOG_AUTHOR_1                | 403            |
      | USER_1                       | 403            |

  Scenario: Test Region resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "id": "NEW_REGION",
      "name": "New Region",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/regions" with HTTP "POST"
    Then the response code is "401"