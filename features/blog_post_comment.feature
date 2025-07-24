@blog_post_comment
Feature: Test Blog Comment resources

  Scenario: Get all blog comments
    Given I am not authenticated
    When I request "/api/blog_post_comments"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPostComment"
    And the response key "@id" is "/api/blog_post_comments"
    And the response key "@type" is "Collection"
    # And the response key "totalItems" is "612"
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
    And the response key "createdBy" is "Aaliyah Aaron"
    And the response key "author" is "/api/users/0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7"
    And the response key "blogPost" is "/api/blog_posts/3c2a5006-4bb7-3f5b-8711-8b111c8da974"

  Scenario Outline: Test Blog Comment resource creation with authorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "comment": "Create blog post comment for Automation Testing",
      "rating": 8,
      "blogPost": "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882"
    }
    """
    When I request "/api/blog_post_comments" with HTTP "POST"
    Then the response code is "<response_code>"
    And the response key "comment" is "Create blog post comment for Automation Testing"
    Examples:
      | user                        | response_code  |
      | EDITOR_1                    | 201            |
      | MODERATOR_1                 | 201            |
      | BLOG_AUTHOR_1               | 201            |
      | BLOG_AUTHOR_5               | 201            |
      | USER_2                      | 201            |

  Scenario: Test Blog Comment resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "comment": "Create blog post comment for Automation Testing",
      "rating": 8,
      "blogPost": "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882"
    }
    """
    When I request "/api/blog_post_comments" with HTTP "POST"
    Then the response code is "401"

  Scenario Outline: Test Blog Comment resource reject with authorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | EDITOR_1                    | 405            |
      | MODERATOR_1                 | 405            |

  Scenario Outline: Test Blog Comment resource reject with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | BLOG_AUTHOR_1               | 405            |
      | BLOG_AUTHOR_5               | 405            |
      | USER_2                      | 405            |

  Scenario: Test Blog Comment resource reject with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PUT"
    Then the response code is "405"

  Scenario Outline: Test Blog Comment resource reject with authorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | EDITOR_1                    | 200            |
      | MODERATOR_1                 | 200            |

  Scenario Outline: Test Blog Comment resource reject with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                        | response_code  |
      | BLOG_AUTHOR_1               | 403            |
      | BLOG_AUTHOR_5               | 403            |
      | USER_2                      | 403            |

  Scenario: Test Blog Comment resource reject with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_post_comments/28b86172-470c-38a4-8ca5-8d27e07ef9be/reject" with HTTP "PATCH"
    Then the response code is "401"