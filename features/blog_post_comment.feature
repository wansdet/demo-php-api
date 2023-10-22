@blog_post_comment
Feature: Test Blog Comment resources

  Scenario: Get all blog comments
    Given I am not authenticated
    When I request "/api/blog_post_comments"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPostComment"
    And the response key "@id" is "/api/blog_post_comments"
    And the response key "@type" is "hydra:Collection"
    # And the response key "hydra:totalItems" is "612"
    # And the response collection is a JSON array of length "612"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "id"
    And the response collection item has a JSON key "blogPostCommentId"
    And the response collection item has a JSON key "comment"
    And the response collection item has a JSON key "rating"
    And the response collection item has a JSON key "status"
    And the response collection item has a JSON key "createdBy"
    And the response collection item has a JSON key "createdAt"
    And the response collection item has a JSON key "blogPost"
    And the response collection item has a JSON key "author"

  Scenario: Test single Blog Comment resource response properties
    Given I am not authenticated
    When I request "/api/blog_post_comments/564ed8cb-59d2-3bf6-a2b2-213b8f096c8a" with HTTP "GET"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPostComment"
    And the response key "@id" is "/api/blog_post_comments/564ed8cb-59d2-3bf6-a2b2-213b8f096c8a"
    And the response key "@type" is "BlogPostComment"
    And the response key "blogPostCommentId" is "564ed8cb-59d2-3bf6-a2b2-213b8f096c8a"
    And the response key "comment" matches "~Demo blog post comment.~"
    And the response key "rating" is 10
    And the response key "status" is "published"
    And the response key "createdBy" is "Mary Smith"
    And the response key "author" is "/api/users/0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7"
    And the response key "blogPost" is "/api/blog_posts/3c2a5006-4bb7-3f5b-8711-8b111c8da974"

  Scenario Outline: Test Blog Comment resource creation with authorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "comment": "Create blog post comment for API testing",
      "rating": 8,
      "blogPost": "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882"
    }
    """
    When I request "/api/blog_post_comments" with HTTP "POST"
    Then the response code is "<response_code>"
    And the response key "comment" is "Create blog post comment for API testing"
    Examples:
      | email                         | password  | response_code  |
      | editor1@example.com           | Demo1234  | 201            |
      | moderator1@example.com        | Demo1234  | 201            |
      | blogauthor1@example.com       | Demo1234  | 201            |
      | blogauthor5@example.com       | Demo1234  | 201            |
      | finance.director@example.com  | Demo1234  | 201            |
      | sales.manager1@example.com    | Demo1234  | 201            |
      | salesperson1@example.com      | Demo1234  | 201            |
      | user2@example.net             | Demo1234  | 201            |

  Scenario: Test Blog Comment resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "comment": "Create blog post comment for API testing",
      "rating": 8,
      "blogPost": "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882"
    }
    """
    When I request "/api/blog_post_comments" with HTTP "POST"
    Then the response code is "401"

  Scenario Outline: Test Blog Comment resource reject with authorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | editor1@example.com           | Demo1234  | 200            |
      | moderator1@example.com        | Demo1234  | 200            |

  Scenario Outline: Test Blog Comment resource reject with unauthorised user
    Given I am authenticated as "<email>" with password "<password>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code  |
      | blogauthor1@example.com       | Demo1234  | 403            |
      | blogauthor5@example.com       | Demo1234  | 403            |
      | finance.director@example.com  | Demo1234  | 403            |
      | sales.manager1@example.com    | Demo1234  | 403            |
      | salesperson1@example.com      | Demo1234  | 403            |
      | user2@example.net             | Demo1234  | 403            |

  Scenario: Test Blog Comment resource reject with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PUT"
    Then the response code is "401"