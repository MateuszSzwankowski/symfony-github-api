<?php

namespace App\Service;

use App\Dto\Github\RepositoryDto;
use App\Dto\Github\UserDto;
use App\Exception\GithubResourceNotFoundException;
use App\Exception\GithubAuthorizationException;
use App\Exception\GithubConnectionException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class GithubApiService
{
    private const BASE_URL = 'https://api.github.com';
    private const UNKNOWN_EXCEPTION_MESSAGE = 'Unknown error. Try again later.';
    private const NOT_FOUND_EXCEPTION_MESSAGE = 'Resource not found.';
    private const TOKEN_EXCEPTION_MESSAGE = 'Invalid GitHub token.';

    private HttpClientInterface $client;
    private SerializerInterface $serializer;

    public function __construct(
        HttpClientInterface $client,
        SerializerInterface $serializer
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function getUserInfo(
        string $login,
        ?string $githubToken
    ): UserDto {
        $url = sprintf('%s/users/%s', self::BASE_URL, $login);
        $content = $this->handleRequest($url, $githubToken);

        return $this->serializer->deserialize(
            $content,
            UserDto::class,
            'json'
        );
    }

    public function getRepositoryInfo(
        string $login,
        string $repoName,
        string $githubToken
    ): RepositoryDto {
        $url = sprintf('%s/repos/%s/%s', self::BASE_URL, $login, $repoName);
        $content = $this->handleRequest($url, $githubToken);

        return $this->serializer->deserialize(
            $content,
            RepositoryDto::class,
            'json'
        );
    }

    private function handleRequest(
        string $url,
        string $githubToken
    ): string {
        $headers = $this->prepareRequestHeaders($githubToken);
        try {
            $response = $this->client->request('GET', $url, [
                'headers' => $headers
            ]);
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new GithubConnectionException(self::UNKNOWN_EXCEPTION_MESSAGE);
        }
        
        if ($statusCode === 200) {
            return $response->getContent();
        } else {
            $this->handleRequestException($statusCode);
        }
    }

    private function prepareRequestHeaders(
        string $githubToken
    ): array {
        return ['Authorization' => 'token ' . $githubToken];
    }

    private function handleRequestException(int $statusCode): void
    {
        if ($statusCode === 401) {
            throw new GithubAuthorizationException(self::TOKEN_EXCEPTION_MESSAGE);
        } elseif ($statusCode === 404) {
            throw new GithubResourceNotFoundException(self::NOT_FOUND_EXCEPTION_MESSAGE);
        } else {
            throw new GithubConnectionException(self::UNKNOWN_EXCEPTION_MESSAGE);
        }
    }
}
