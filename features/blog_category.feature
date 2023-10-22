@blog_category
Feature: Test Blog Category resources
  Scenario: Test collection of Blog Category resources
    Given I am not authenticated
    When I request "/api/blog_categories"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogCategory"
    And the response key "@id" is "/api/blog_categories"
    And the response key "@type" is "hydra:Collection"
    And the response key "hydra:totalItems" is "8"
    And the response collection is a JSON array of length "8"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "blogCategoryCode"
    And the response collection item has a JSON key "blogCategoryName"
    And the response collection item has a JSON key "active"
    And the response collection item has a JSON key "sortOrder"

  Scenario: Test single Blog Category resource response properties
    Given I am not authenticated
    When I request "/api/blog_categories/COOKERY"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogCategory"
    And the response key "@id" is "/api/blog_categories/COOKERY"
    And the response key "@type" is "BlogCategory"
    And the response key "blogCategoryCode" exists
    And the response key "blogCategoryName" exists
    And the response key "active" exists
    And the response key "sortOrder" exists
    And the response key "createdAt" exists
    And the response key "createdBy" exists
    
  Scenario Outline: Test single Blog Category resources
    Given I am not authenticated
    When I request "/api/blog_categories/<blog_category_code>"
    Then the response code is "200"
    And the response key "@id" is "/api/blog_categories/<blog_category_code>"
    And the response key "blogCategoryCode" is "<blog_category_code>"
    And the response key "blogCategoryName" is "<blog_category_name>"
    And the response key "active" is "<active>"
    And the response key "sortOrder" is "<sort_order>"
    Examples:
      | blog_category_code  | blog_category_name  | active  | sort_order |
      | COOKERY             | Cookery             | true    | 1          |
      | FASHION             | Fashion             | true    | 2          |
      | FOOD                | Food                | true    | 3          |
      | HOME                | Home                | true    | 4          |
      | LEISURE             | Leisure             | true    | 5          |
      | TECHNOLOGY          | Technology          | true    | 6          |
      | TRANSPORT           | Transport           | true    | 7          |
      | TRAVEL              | Travel              | true    | 8          |

  Scenario: Test Blog Category resource update with authorized user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "blogCategoryName": "Transport Updated",
      "sortOrder": 9,
      "active": false
    }
    """
    When I request "/api/blog_categories/TRANSPORT" with HTTP "PUT"
    Then the response code is "200"
    And the response key "@id" is "/api/blog_categories/TRANSPORT"
    And the response key "blogCategoryCode" is "TRANSPORT"
    And the response key "blogCategoryName" is "Transport Updated"
    And the response key "active" is boolean false

  Scenario Outline: Test Blog Category resource update with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "blogCategoryName": "Transport Updated",
      "sortOrder": 9,
      "active": false
    }
    """
    When I request "/api/blog_categories/TRANSPORT" with HTTP "PUT"
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

  Scenario: Test Blog Category resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "blogCategoryName": "Transport Updated",
      "sortOrder": 9,
      "active": false
    }
    """
    When I request "/api/blog_categories/TRANSPORT" with HTTP "PUT"
    Then the response code is "401"

    Scenario: Test Blog Category resource patch with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "blogCategoryName": "Travel Updated",
      "sortOrder": 10,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_categories/TRAVEL" with HTTP "PATCH"
    Then the response code is "200"
    And the response key "blogCategoryCode" is "TRAVEL"
    And the response key "blogCategoryName" is "Travel Updated"
    And the response key "sortOrder" is 10
    And the response key "active" is boolean false

  Scenario Outline: Test Blog Category resource patch with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "blogCategoryName": "Travel Updated",
      "sortOrder": 10,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_categories/TRAVEL" with HTTP "PATCH"
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

  Scenario: Test Blog Category resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "blogCategoryName": "Travel Updated",
      "sortOrder": 10,
      "active": false
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_categories/TRAVEL" with HTTP "PATCH"
    Then the response code is "401"

  Scenario Outline: Test Blog Category resource creation with authenticated user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "blogCategoryCode": "TEST_BLOG_CATEGORY",
      "blogCategoryName": "Test Blog Category",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/blog_categories" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | admin2@example.com            | Demo1234  | 201            |
      | editor1@example.com           | Demo1234  | 403            |
      | moderator1@example.com        | Demo1234  | 403            |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user1@example.com             | Demo1234  | 403            |

  Scenario: Test Blog Category resource creation with authorised user
    Given I am authenticated as "admin2@example.com" with password "Demo1234"
    And the request body is:
    """
    {
      "blogCategoryCode": "TEST_BLOG_CATEGORY",
      "blogCategoryName": "Test Blog Category",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/blog_categories" with HTTP "POST"
    Then the response code is "201"
    And the response key "blogCategoryCode" is "TEST_BLOG_CATEGORY"
    And the response key "blogCategoryName" is "Test Blog Category"
    And the response key "sortOrder" is 10
    And the response key "active" is boolean true

  Scenario Outline: Test Blog Category resource creation with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "blogCategoryCode": "TEST_BLOG_CATEGORY",
      "blogCategoryName": "Test Blog Category",
      "sortOrder": 10,
      "active": true
    }
    """
    When I request "/api/blog_categories" with HTTP "POST"
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

  Scenario: Test Blog Category resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "blogCategoryCode": "TEST_BLOG_CATEGORY",
      "blogCategoryName": "Test Blog Category",
      "sortOrder": 10,
      "active": true
    }
    """
      When I request "/api/blog_categories" with HTTP "POST"
      Then the response code is "401"
