@information
Feature: Test Information resources

  Scenario: Test collection of Information resources
    Given I am not authenticated
    When I request "/api/information"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Information"
    And the response key "@id" is "/api/information"
    And the response key "@type" is "hydra:Collection"
    And the response key "hydra:totalItems" is "10"
    And the response collection is a JSON array of length "10"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "informationId"
    And the response collection item has a JSON key "title"
    And the response collection item has a JSON key "information"
    And the response collection item has a JSON key "active"
    And the response collection item has a JSON key "sortOrder"

  Scenario Outline: Test collection of Information resources
    Given I am not authenticated
    When I request "/api/information?informationType=<information_type>"
    Then the response code is "200"
    And the response key "hydra:totalItems" is "<total_items>"
    Examples:
    | information_type  | total_items |
    | faq               | 10          |
    | services          | 0           |

  Scenario: Test single Information resource response properties
    Given I am not authenticated
    When I request "/api/information/3c2a5006-4bb7-3f5b-8711-8b111c8da974"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Information"
    And the response key "@type" is "Information"
    And the response key "informationId" exists
    And the response key "title" exists
    And the response key "information" exists
    And the response key "informationType" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "createdBy" exists
    And the response key "createdAt" exists
    And the response key "informationId" is "3c2a5006-4bb7-3f5b-8711-8b111c8da974"
    And the response key "information" matches "~Libero et incidunt aut.~"
    And the response key "informationType" is "faq"
    And the response key "active" is "true"
    And the response key "sortOrder" is "1"
    And the response key "createdBy" is "SYSTEM"

  Scenario Outline: Test Blog Post resource update with authorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "title": "<title>",
      "information": "<information>",
      "informationType": "<information_type>",
      "active": <active>,
      "sortOrder": <sort_order>
    }
    """
    When I request "/api/information/<information_id>" with HTTP "PUT"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Information"
    And the response key "@type" is "Information"
    And the response key "informationId" exists
    And the response key "title" exists
    And the response key "information" exists
    And the response key "informationType" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "createdBy" exists
    And the response key "createdAt" exists
    And the response key "informationId" is "<information_id>"
    And the response key "title" is "<title>"
    And the response key "information" is "<information>"
    And the response key "informationType" is "<information_type>"
    And the response key "active" is boolean "<active>"
    And the response key "sortOrder" is "<sort_order>"
    And the response key "createdBy" is "<created_by>"
    Examples:
      | email               | password  | information_id                        | title       | information      | information_type | active | sort_order | created_by  |
      | admin2@example.com  | Demo1234  | 3c2a5006-4bb7-3f5b-8711-8b111c8da976  | Test title  | Test information | services         | false  | 20         | SYSTEM      |

  Scenario Outline: Test Blog Post resource update with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "title": "<title>",
      "information": "<information>",
      "informationType": "<information_type>",
      "active": <active>,
      "sortOrder": <sort_order>
    }
    """
    When I request "/api/information/3c2a5006-4bb7-3f5b-8711-8b111c8da976" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | moderator1@example.com        | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test Blog Post resource update with unauthenticated user
    Given I am not authenticated
      And the request body is:
      """
      {
        "title": "Test title",
        "information": "Test information",
        "informationType": "faq",
        "active": true,
        "sortOrder": 1
      }
      """
      When I request "/api/information/3c2a5006-4bb7-3f5b-8711-8b111c8da976" with HTTP "PUT"
      Then the response code is "401"

  Scenario Outline: Test Blog Post resource patch with authorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "title": "Vitae deserunt nemo et ducimus aut optio rem.",
      "information": "Illo totam voluptas qui consectetur nihil minus non. Voluptate sequi deleniti est eaque dignissimos doloribus nulla. Qui eveniet illum quibusdam vel. Sed eius et dignissimos hic. Ut minima eius illum hic iusto.",
      "informationType": "<information_type>",
      "active": <active>,
      "sortOrder": <sort_order>
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/information/<information_id>" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Information"
    And the response key "@type" is "Information"
    And the response key "informationId" exists
    And the response key "title" exists
    And the response key "information" exists
    And the response key "informationType" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "createdBy" exists
    And the response key "createdAt" exists
    And the response key "informationId" is "<information_id>"
    And the response key "title" is "Vitae deserunt nemo et ducimus aut optio rem."
    And the response key "information" is "Illo totam voluptas qui consectetur nihil minus non. Voluptate sequi deleniti est eaque dignissimos doloribus nulla. Qui eveniet illum quibusdam vel. Sed eius et dignissimos hic. Ut minima eius illum hic iusto."
    And the response key "informationType" is "<information_type>"
    And the response key "active" is boolean "<active>"
    And the response key "sortOrder" is "<sort_order>"
    And the response key "createdBy" is "<created_by>"
    Examples:
      | email               | password  | information_id                        | title       | information      | information_type | active | sort_order | created_by  |
      | admin2@example.com  | Demo1234  | 3c2a5006-4bb7-3f5b-8711-8b111c8da976  | Test title  | Test information | faq              | true   | 3          | SYSTEM      |

  Scenario Outline: Test Blog Post resource patch with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "title": "<title>",
      "information": "<information>",
      "informationType": "<information_type>",
      "active": <active>,
      "sortOrder": <sort_order>
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/information/3c2a5006-4bb7-3f5b-8711-8b111c8da976" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | moderator1@example.com        | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test Blog Post resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
      """
      {
        "title": "Test title",
        "information": "Test information",
        "informationType": "faq",
        "active": true,
        "sortOrder": 1
      }
      """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/information/3c2a5006-4bb7-3f5b-8711-8b111c8da976" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Information resource creation with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
      """
      {
        "title": "Create information for API testing",
        "information": "Test information",
        "informationType": "services",
        "active": true,
        "sortOrder": 1
      }
    """
    When I request "/api/information" with HTTP "POST"
    Then the response code is "201"
    And the response key "title" is "Create information for API testing"
    And the response key "information" matches "~Test information~"
    And the response key "informationType" is "services"
    And the response key "active" is boolean true
    And the response key "sortOrder" is 1

    Scenario Outline: Test Information resource creation with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
      """
      {
        "title": "Create information for API testing",
        "information": "Test information",
        "informationType": "services",
        "active": true,
        "sortOrder": 1
      }
    """
    When I request "/api/information" with HTTP "POST"
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

  Scenario: Test Information resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
      """
      {
        "title": "Create information for API testing",
        "information": "Test information",
        "informationType": "services",
        "active": true,
        "sortOrder": 1
      }
    """
    When I request "/api/information" with HTTP "POST"
    Then the response code is "401"