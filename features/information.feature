@information
Feature: Test Information resources

  Scenario: Test collection of Information resources
    Given I am not authenticated
    When I request "/api/information"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/Information"
    And the response key "@id" is "/api/information"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "10"
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
    And the response key "totalItems" is "<total_items>"
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
    And the response key "information" matches "~Praesentium nam tempore mollitia.~"
    And the response key "informationType" is "faq"
    And the response key "active" is "true"
    And the response key "sortOrder" is "1"
    And the response key "createdBy" is "SYSTEM"

  Scenario Outline: Test Blog Post resource update with authorised user
    Given I am authenticated as "<user>"
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
    And the response key "title" is "<title>"
    And the response key "information" is "<information>"
    And the response key "informationType" is "<information_type>"
    And the response key "active" is boolean "<active>"
    And the response key "sortOrder" is "<sort_order>"
    And the response key "createdBy" is "<created_by>"
    Examples:
      | user      | information_id                        | title       | information      | information_type | active | sort_order | created_by  |
      | ADMIN_2   | 3c2a5006-4bb7-3f5b-8711-8b111c8da976  | Test title  | Test information | services         | false  | 20         | SYSTEM      |

  Scenario Outline: Test Blog Post resource update with unauthorised user
    Given I am authenticated as "<user>"
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
      | user          | response_code |
      | MODERATOR_1   | 405           |
      | BLOG_AUTHOR_1 | 405           |
      | USER_1        | 405           |

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
      Then the response code is "405"

  Scenario Outline: Test Blog Post resource patch with authorised user
    Given I am authenticated as "<user>"
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
      | user    | information_id                        | title       | information      | information_type | active | sort_order | created_by  |
      | ADMIN_2 | 3c2a5006-4bb7-3f5b-8711-8b111c8da976  | Test title  | Test information | faq              | true   | 3          | SYSTEM      |

  Scenario Outline: Test Blog Post resource patch with unauthorised user
    Given I am authenticated as "<user>"
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
        | user          | response_code |
        | MODERATOR_1   | 403           |
        | BLOG_AUTHOR_1 | 403           |
        | USER_1        | 403           |

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
    Given I am authenticated as "ADMIN_2"
    And the request body is:
    """
      {
        "title": "Create information for Automation Testing",
        "information": "Test information",
        "informationType": "services",
        "active": true,
        "sortOrder": 1
      }
    """
    When I request "/api/information" with HTTP "POST"
    Then the response code is "201"
    And the response key "title" is "Create information for Automation Testing"
    And the response key "information" matches "~Test information~"
    And the response key "informationType" is "services"
    And the response key "active" is boolean true
    And the response key "sortOrder" is 1

    Scenario Outline: Test Information resource creation with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
      {
        "title": "Create information for Automation Testing",
        "information": "Test information",
        "informationType": "services",
        "active": true,
        "sortOrder": 1
      }
    """
    When I request "/api/information" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | user                          | response_code |
      | EDITOR_1                     | 403           |
      | MODERATOR_1                  | 403           |
      | BLOG_AUTHOR_1                | 403           |
      | USER_1                       | 403           |

  Scenario: Test Information resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
      {
        "title": "Create information for Automation Testing",
        "information": "Test information",
        "informationType": "services",
        "active": true,
        "sortOrder": 1
      }
    """
    When I request "/api/information" with HTTP "POST"
    Then the response code is "401"