@blog_post
Feature: Test Blog Post resources

  Scenario Outline: Get all blogs from authorised user
    Given I am authenticated as "<user>"
    When I request "/api/blog_posts" with HTTP "GET"
    Then the response code is "<response_code>"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "300"
    And the response collection is a JSON array of length "300"
    And the response collection item has a JSON key "@id"
    And the response collection item has a JSON key "@type"
    And the response collection item has a JSON key "id"
    And the response collection item has a JSON key "blogPostId"
    And the response collection item has a JSON key "blogCategory"
    And the response collection item has a JSON key "title"
    And the response collection item has a JSON key "content"
    And the response collection item has a JSON key "status"
    And the response collection item has a JSON key "slug"
    And the response collection item has a JSON key "createdBy"
    And the response collection item has a JSON key "blogPostComments"
    And the response collection item has a JSON key "blogPostImages"
    Examples:
      | user                       | response_code  |
      | EDITOR_1                   | 200            |
      | ADMIN_1                    | 200            |

  Scenario Outline: Get all blogs from unauthorised user
    Given I am authenticated as "<user>"
    When I request "/api/blog_posts" with HTTP "GET"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | MODERATOR_1                | 403            |
      | BLOG_AUTHOR_1              | 403            |
      | USER_1                     | 403            |

  Scenario: Get all blogs from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts"
    Then the response code is "401"

  Scenario: Get all featured blogs from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/featured"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/featured"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "10"

  Scenario: Get all published blogs from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/published"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/published"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "292"

  Scenario Outline: Get all blogs by author from authorised user
    Given I am authenticated as "<user>"
    When I request "/api/blog_posts/author" with HTTP "GET"
    Then the response code is "<response_code>"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/author"
    And the response key "@type" is "Collection"
    Examples:
      | user                       | response_code  |
      | BLOG_AUTHOR_1              | 200            |
      | BLOG_AUTHOR_2              | 200            |
      | BLOG_AUTHOR_3              | 200            |
      | BLOG_AUTHOR_4              | 200            |
      | BLOG_AUTHOR_5              | 200            |

  Scenario Outline: Get all blogs by author from unauthorised user
    Given I am authenticated as "<user>"
    When I request "/api/blog_posts/author" with HTTP "GET"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | ADMIN_1                    | 403            |
      | EDITOR_1                   | 403            |
      | MODERATOR_1                | 403            |
      | USER_1                     | 403            |

  Scenario: Get all blogs by author from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/author"
    Then the response code is "401"

  Scenario: Test single Blog Post resource response properties
    Given I am not authenticated
    When I request "/api/blog_posts/3c2a5006-4bb7-3f5b-8711-8b111c8da974" with HTTP "GET"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/3c2a5006-4bb7-3f5b-8711-8b111c8da974"
    And the response key "@type" is "BlogPost"
    And the response key "blogPostId" is "3c2a5006-4bb7-3f5b-8711-8b111c8da974"
    And the response key "title" is "Demo blog post"
    And the response key "content" matches "~Welcome to the demo blog.~"
    And the response key "status" is "published"
    And the response key "slug" is "welcome-to-the-demo-blog-post"
    And the response key "featured" does not exist
    And the response key "createdBy" is "Robert Walker"
    And the response key "blogPostImages" is a JSON array of length "0"

  Scenario: Test Blog Post resource update with authorised user
    Given I am authenticated as "BLOG_AUTHOR_2"
    And the request body is:
    """
    {
      "title": "Demo blog post for Automation Testing update",
      "content": "Welcome to the demo blog post for Automation Testing update content"
    }
    """
    When I request "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882" with HTTP "PUT"
    Then the response code is "405"

  Scenario Outline: Test Blog Post resource update with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "title": "Demo blog post for Automation Testing update",
      "content": "Welcome to the demo blog post for Automation Testing update content"
    }
    """
    When I request "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882" with HTTP "PUT"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | MODERATOR_1                | 405            |
      | USER_1                     | 405            |

  Scenario: Test Blog Post resource update with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "title": "Demo blog post for Automation Testing update",
      "content": "Welcome to the demo blog post for Automation Testing update content"
    }
    """
    When I request "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882" with HTTP "PUT"
    Then the response code is "405"

  Scenario: Test Blog Post resource patch with authorised user
    Given I am authenticated as "BLOG_AUTHOR_2"
    And the request body is:
    """
    {
      "title": "Demo blog post for Automation Testing update",
      "content": "Welcome to the demo blog post for Automation Testing update content"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882" with HTTP "PATCH"
    Then the response code is "200"

  Scenario Outline: Test Blog Post resource patch with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "title": "Demo blog post for Automation Testing update",
      "content": "Welcome to the demo blog post for Automation Testing update content"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | MODERATOR_1                | 403            |
      | USER_1                     | 403            |

  Scenario: Test Blog Post resource patch with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "title": "Demo blog post for Automation Testing update",
      "content": "Welcome to the demo blog post for Automation Testing update content"
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/af1b8f69-7074-39bc-9f2b-1250500be882" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Blog Post resource creation with authorised user
    Given I am authenticated as "BLOG_AUTHOR_2"
    And the request body is:
    """
    {
      "title": "Create blog post for Automation Testing",
      "slug": "test-blog-post-creation",
      "content": "Create blog post for Automation Testing content",
      "blogCategory": "/api/blog_categories/TRAVEL",
      "featured": 10
    }
    """
    When I request "/api/blog_posts" with HTTP "POST"
    Then the response code is "201"
    And the response key "title" is "Create blog post for Automation Testing"
    And the response key "content" matches "~Create blog post for Automation Testing content~"
    And the response key "status" is "draft"
    And the response key "slug" is "test-blog-post-creation"
    And the response key "featured" is 10

  Scenario Outline: Test Blog Post resource creation with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "title": "Create blog post for Automation Testing",
      "slug": "test-blog-post-creation",
      "content": "Create blog post for Automation Testing content",
      "blogCategory": "/api/blog_categories/TRAVEL",
      "featured": 10
    }
    """
    When I request "/api/blog_posts" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | ADMIN_1                    | 403            |
      | EDITOR_1                   | 403            |
      | MODERATOR_1                | 403            |
      | USER_1                     | 403            |

  Scenario: Test Blog Post resource creation with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "title": "Create blog post for Automation Testing",
      "slug": "test-blog-post-creation",
      "content": "Create blog post for Automation Testing content",
      "blogCategory": "/api/blog_categories/TRAVEL",
      "featured": 10
    }
    """
    When I request "/api/blog_posts" with HTTP "POST"
    Then the response code is "401"

  Scenario: Test Blog Post resource submit from draft with authorised user
    Given I am authenticated as "BLOG_AUTHOR_5"
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/4619273a-eed3-38ae-95c9-3ee4007722a2/submit" with HTTP "PATCH"
    Then the response code is "200"

  Scenario Outline: Test Blog Post resource submit from draft with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/4619273a-eed3-38ae-95c9-3ee4007722a2/submit" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | EDITOR_1                   | 403            |
      | MODERATOR_1                | 403            |
      | BLOG_AUTHOR_1              | 403            |
      | USER_2                     | 403            |

  Scenario: Test Blog Post resource submit from draft with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/4619273a-eed3-38ae-95c9-3ee4007722a2/submit" with HTTP "PATCH"
    Then the response code is "401"

  Scenario: Test Blog Post resource submit from rejected with authorised user
    Given I am authenticated as "BLOG_AUTHOR_3"
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/43f0cf60-26a9-3794-8407-862b5ed13745/submit" with HTTP "PATCH"
    Then the response code is "200"

  Scenario Outline: Test Blog Post resource submit from rejected with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/43f0cf60-26a9-3794-8407-862b5ed13745/submit" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | EDITOR_1                   | 403            |
      | MODERATOR_1                | 403            |
      | USER_2                     | 403            |

  Scenario: Test Blog Post resource submit from rejected with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/43f0cf60-26a9-3794-8407-862b5ed13745/submit" with HTTP "PATCH"
    Then the response code is "401"

  Scenario Outline: Test Blog Post resource submit from invalid status with blog author
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for submit."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/<blogPostId>/submit" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  | blogPostId                                 |
      | BLOG_AUTHOR_2              | 400            | dd5b3dfe-7756-3280-a439-7d33f22e859b       |
      | BLOG_AUTHOR_4              | 400            | 7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0       |
      | BLOG_AUTHOR_1              | 400            | 05f74dba-4759-3109-9de2-bc99004f914d       |

  Scenario: Test Blog Post resource reject from submitted with authorised user
    Given I am authenticated as "EDITOR_1"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0/reject" with HTTP "PATCH"
    Then the response code is "200"

  Scenario Outline: Test Blog Post resource reject from submitted with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0/reject" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | MODERATOR_1                | 403            |
      | BLOG_AUTHOR_4              | 403            |
      | USER_2                     | 403            |

  Scenario: Test Blog Post resource reject from submitted with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0/reject" with HTTP "PATCH"
    Then the response code is "401"

  Scenario Outline: Test Blog Post resource reject from invalid status with blog editor
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for reject."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/<blogPostId>/reject" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
        | user                       | response_code  | blogPostId                                 |
        | EDITOR_1                   | 400            | 4619273a-eed3-38ae-95c9-3ee4007722a2       |
        | EDITOR_2                   | 400            | 43f0cf60-26a9-3794-8407-862b5ed13745       |
        | EDITOR_1                   | 400            | dd5b3dfe-7756-3280-a439-7d33f22e859b       |
        | EDITOR_2                   | 400            | 05f74dba-4759-3109-9de2-bc99004f914d       |

  Scenario: Test Blog Post resource publish from submitted with authorised user
    Given I am authenticated as "EDITOR_1"
    And the request body is:
    """
    {
      "remarks": "Test remarks for publish."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0/publish" with HTTP "PATCH"
    Then the response code is "200"

  Scenario Outline: Test Blog Post resource publish from submitted with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for publish."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0/publish" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | MODERATOR_1                | 403            |
      | BLOG_AUTHOR_4              | 403            |
      | USER_2                     | 403            |

  Scenario: Test Blog Post resource publish from submitted with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for publish."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0/publish" with HTTP "PATCH"
    Then the response code is "401"

  Scenario Outline: Test Blog Post resource publish from invalid status with blog editor
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for publish."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/<blogPostId>/publish" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  | blogPostId                                 |
      | EDITOR_1                   | 400            | 4619273a-eed3-38ae-95c9-3ee4007722a2       |
      | EDITOR_2                   | 400            | 43f0cf60-26a9-3794-8407-862b5ed13745       |
      | EDITOR_1                   | 400            | dd5b3dfe-7756-3280-a439-7d33f22e859b       |

  Scenario: Test Blog Post resource archive from published with authorised user
    Given I am authenticated as "EDITOR_1"
    And the request body is:
    """
    {
      "remarks": "Test remarks for archive."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/dd5b3dfe-7756-3280-a439-7d33f22e859b/archive" with HTTP "PATCH"
    Then the response code is "200"

  Scenario Outline: Test Blog Post resource archive from published with unauthorised user
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for archive."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/dd5b3dfe-7756-3280-a439-7d33f22e859b/archive" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | MODERATOR_1                | 403            |
      | BLOG_AUTHOR_4              | 403            |
      | USER_2                     | 403            |

  Scenario: Test Blog Post resource archive from published with unauthenticated user
    Given I am not authenticated
    And the request body is:
    """
    {
      "remarks": "Test remarks for archive."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/dd5b3dfe-7756-3280-a439-7d33f22e859b/archive" with HTTP "PATCH"
    Then the response code is "401"

  Scenario Outline: Test Blog Post resource archive from invalid status with blog editor
    Given I am authenticated as "<user>"
    And the request body is:
    """
    {
      "remarks": "Test remarks for archive."
    }
    """
    And the "Content-Type" request header is "application/merge-patch+json"
    When I request "/api/blog_posts/<blogPostId>/archive" with HTTP "PATCH"
    Then the response code is "<response_code>"
    Examples:
        | user                       | response_code  | blogPostId                                 |
        | EDITOR_1                   | 400            | 4619273a-eed3-38ae-95c9-3ee4007722a2       |
        | EDITOR_2                   | 400            | 43f0cf60-26a9-3794-8407-862b5ed13745       |

  Scenario Outline: Export Blog Post resource collection by blog author with authorised user
    Given I am authenticated as "<email>" with password "<password>"
    When I request "/api/blog_posts/export/blogger" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | email                         | password  | response_code   |
      #| blogauthor1@example.com       | Demo1234  | 200             |
      #| blogauthor2@example.com       | Demo1234  | 200             |
      #| blogauthor3@example.com       | Demo1234  | 200             |
      #| blogauthor4@example.com       | Demo1234  | 200             |
      #| blogauthor5@example.com       | Demo1234  | 200             |

  Scenario Outline: Export Blog Post resource collection by blog author with unauthorised user
    Given I am authenticated as "<user>"
    When I request "/api/blog_posts/export/blogger" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | ADMIN_1                    | 403            |
      | EDITOR_1                   | 403            |
      | MODERATOR_1                | 403            |
      | USER_2                     | 403            |

  Scenario: Export Blog Post resource collection by blog author with unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/export/blogger" with HTTP "POST"
    Then the response code is "401"

  Scenario Outline: Export all Blog Post resource collection with authorised user
    Given I am authenticated as "<email>" with password "<password>"
    When I request "/api/blog_posts/export/admin" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      #| email                         | password  | response_code   |
      #| admin1@example.com            | Demo1234  | 200             |
      #| editor1@example.com           | Demo1234  | 200             |

  Scenario Outline: Export all Blog Post resource collection with unauthorised user
    Given I am authenticated as "<user>"
    When I request "/api/blog_posts/export/admin" with HTTP "POST"
    Then the response code is "<response_code>"
    Examples:
      | user                       | response_code  |
      | BLOG_AUTHOR_1              | 403            |
      | MODERATOR_1                | 403            |
      | USER_2                     | 403            |

  Scenario: Export all Blog Post resource collection with unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/export/blogger" with HTTP "POST"
    Then the response code is "401"

  Scenario: Get annual blog post report by authors from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/reports/annual/authors"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/reports/annual/authors"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "2"
    And the response collection is a JSON array of length "2"
    And the response collection item has a JSON key "blogPostAuthors"

  Scenario: Get annual blog post report by categories from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/reports/annual/categories"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/reports/annual/categories"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "2"
    And the response collection is a JSON array of length "2"
    And the response collection item has a JSON key "blogPostCategories"

  Scenario: Get monthly blog post report by authors from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/reports/monthly/authors"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/reports/monthly/authors"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "41"
    And the response collection is a JSON array of length "41"
    And the response collection item has a JSON key "blogPostAuthors"

  Scenario: Get monthly blog post report by categories from unauthenticated user
    Given I am not authenticated
    When I request "/api/blog_posts/reports/monthly/categories"
    Then the response code is "200"
    And the response key "@context" is "/api/contexts/BlogPost"
    And the response key "@id" is "/api/blog_posts/reports/monthly/categories"
    And the response key "@type" is "Collection"
    And the response key "totalItems" is "41"
    And the response collection is a JSON array of length "41"
    And the response collection item has a JSON key "blogPostCategories"