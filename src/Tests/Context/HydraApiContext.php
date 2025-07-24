<?php

declare(strict_types=1);

namespace App\Tests\Context;

use Imbo\BehatApiExtension\Context\ApiContext;
use PHPUnit\Framework\Assert;

class HydraApiContext extends ApiContext
{
    private ?array $responseJson = null;

    private ?string $token = null;

    /**
     * @Given I am authenticated as :user
     */
    public function iAmAuthenticatedAs(string $user): static
    {
        $data = [
            'username' => $this->getUserEmail($user),
            'password' => $this->getTestPassword(),
        ];

        $this->setRequestBody(json_encode($data));
        $this->addRequestHeader('Content-Type', 'application/json');

        $this->requestPath('/api/login_check', 'POST');
        $this->sendRequest();
        $responseJson = json_decode($this->response->getBody()->getContents(), true);
        $token = $responseJson['token'];

        // Store the token in the context
        $this->token = $token;

        return $this;
    }

    /**
     * @Given I am authenticating as :user
     */
    public function iAmAuthenticatingAs(string $user): static
    {
        $data = [
            'username' => $this->getUserEmail($user),
            'password' => $this->getTestPassword(),
        ];

        $this->setRequestBody(json_encode($data));
        $this->addRequestHeader('Content-Type', 'application/json');

        return $this;
    }

    /**
     * @Given I am not authenticated
     */
    public function iAmNotAuthenticated(): static
    {
        $this->token = null;

        return $this;
    }

    /**
     * @When I request a :resourcePath resource with key :key and value :value
     */
    public function iRequestAResourceWithKeyAndValue(string $resourcePath, string $key, string $value): static
    {
        $url = sprintf('%s?%s=%s', $resourcePath, $key, $value);
        $this->requestPath($url);
        $responseJson = json_decode($this->response->getBody()->getContents(), true);

        if (isset($responseJson['member'][0]['id'])) {
            $id = $responseJson['member'][0]['id'];

            $this->requestPath($resourcePath.'/'.$id);
        } else {
            Assert::assertFalse(true, 'Invalid response format. Missing "member" or "id"');
        }

        return $this;
    }

    /**
     * @When I request :path with HTTP :method
     */
    public function iRequestWithHttp(string $path, string $method): static
    {
        // If the token is not null, add the Authorization header with the bearer token
        if (null !== $this->token) {
            $this->addRequestHeader('Authorization', 'Bearer '.$this->token);
        }

        $this->setRequestPath($path);
        $this->setRequestMethod($method);

        return $this->sendRequest();
    }

    /**
     * @When the header includes a bearer token
     */
    public function theHeaderIncludesABearerToken(): static
    {
        if (null !== $this->token) {
            $this->addRequestHeader('Authorization', 'Bearer '.$this->token);
        }

        return $this;
    }

    /**
     * @Then the response hydra collection is an empty JSON array
     */
    public function theResponseCollectionIsEmptyJsonArray(): static
    {
        $this->theResponseKeyIsEmptyJsonArray('member');

        return $this;
    }

    /**
     * @Then the response collection is a JSON array of length :length
     */
    public function theResponseCollectionIsJsonArrayOfLength(int $length): void
    {
        $this->theResponseKeyIsJsonArrayOfLength('member', $length);
    }

    /**
     * @Then the response collection item does not have a JSON key :key
     */
    public function theResponseCollectionItemDoesNotHaveAJsonKey(string $key): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        // Check if the key exists in any element of the "member" array
        foreach ($this->responseJson['member'] as $element) {
            if (isset($element[$key])) {
                // Key found, fail the step
                Assert::assertFalse(true, "Key '{$key}' found in the response hydra collection.");
            }
        }
    }

    /**
     * @Then the response collection item has a JSON key :key
     */
    public function theResponseCollectionItemHasAJsonKey(string $key): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        // Check if the key exists in any element of the "member" array
        foreach ($this->responseJson['member'] as $element) {
            if (isset($element[$key])) {
                return; // Key found, so the step passes
            }
        }

        // Key not found in any element, fail the step
        Assert::assertFalse(true, "Key '{$key}' not found in the response hydra collection.");
    }

    /**
     * @Then the response hydra total items is :totalItems
     */
    public function theResponseHydraTotalItemsIs(int $totalItems): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey('totalItems', $this->responseJson);
        Assert::assertEquals((int) $totalItems, $this->responseJson['totalItems']);
    }

    /**
     * @Then the response key :key contains array item :expectedValue
     */
    public function theResponseKeyContainsArrayItem(string $key, string $expectedValue): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        $this->theResponseKeyIsAJsonArray($key);

        Assert::assertContains($expectedValue, $this->responseJson[$key]);
    }

    /**
     * @Then the response key :key does not exist
     */
    public function theResponseKeyDoesNotExist(string $key): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayNotHasKey($key, $this->responseJson);
    }

    /**
     * @Then the response key :key exists
     */
    public function theResponseKeyExists(string $key): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey($key, $this->responseJson);
    }

    /**
     * @Then the response key :key is :expectedValue
     */
    public function theResponseKeyIs(string $key, string|int $expectedValue): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey($key, $this->responseJson);
        Assert::assertEquals($expectedValue, $this->responseJson[$key]);
    }

    /**
     * @Then the response key :key is a JSON array
     */
    public function theResponseKeyIsAJsonArray(string $key): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey($key, $this->responseJson);
        Assert::assertIsArray($this->responseJson[$key]);
    }

    /**
     * @Then the response key :key is boolean :expectedValue
     */
    public function theResponseKeyIsBoolean(string $key, string $expectedValue): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        $expectedBooleanValue = 'true' === $expectedValue;

        Assert::assertArrayHasKey($key, $this->responseJson);
        Assert::assertEquals($expectedBooleanValue, (bool) $this->responseJson[$key]);
    }

    /**
     * @Then the response key :key is an empty JSON array
     */
    public function theResponseKeyIsEmptyJsonArray(string $key): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey($key, $this->responseJson);
        Assert::assertIsArray($this->responseJson[$key]);
        Assert::assertEmpty($this->responseJson[$key]);
    }

    /**
     * @Then the response key :key is a JSON array of length :length
     */
    public function theResponseKeyIsJsonArrayOfLength(string $key, int $length): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey($key, $this->responseJson);
        Assert::assertIsArray($this->responseJson[$key]);
        Assert::assertCount((int) $length, $this->responseJson[$key]);
    }

    /**
     * @Then the response key :key matches :pattern
     */
    public function theResponseKeyMatches(string $key, string $pattern): void
    {
        if (null === $this->responseJson) {
            $this->responseJson = json_decode($this->response->getBody()->getContents(), true);
        }

        Assert::assertArrayHasKey($key, $this->responseJson);
        Assert::assertMatchesRegularExpression($pattern, $this->responseJson[$key]);
    }

    private function getUserEmail(string $user): string
    {
        $map = [
            'ADMIN_1' => 'admin1@example.com',
            'ADMIN_2' => 'admin2@example.com',
            'EDITOR_1' => 'editor1@example.com',
            'EDITOR_2' => 'editor2@example.com',
            'MODERATOR_1' => 'moderator1@example.com',
            'MODERATOR_2' => 'moderator2@example.com',
            'BLOG_AUTHOR_1' => 'blogauthor1@example.com',
            'BLOG_AUTHOR_2' => 'blogauthor2@example.com',
            'BLOG_AUTHOR_3' => 'blogauthor3@example.com',
            'BLOG_AUTHOR_4' => 'blogauthor4@example.com',
            'BLOG_AUTHOR_5' => 'blogauthor5@example.com',
            'USER_1' => 'user1@example.com',
            'USER_2' => 'user2@example.net',
            'USER_3' => 'user3@example.org',
            'USER_4' => 'user4@example.com',
            'USER_5' => 'user5@example.net',
            'INVALID_USER' => 'invaliduser@example.com',
        ];

        if (!isset($map[$user])) {
            throw new \InvalidArgumentException("Unknown user key “{$user}”");
        }

        return $map[$user];
    }

    private function getTestPassword(): string
    {
        return $_ENV['TEST_PASSWORD'] ?? $_SERVER['TEST_PASSWORD'] ?? 'Testing123';
    }
}
