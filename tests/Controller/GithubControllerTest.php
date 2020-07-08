<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GithubControllerTest extends WebTestCase
{   
    public function testGetGithubUserData()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token ' . $_ENV['GITHUB_API_TOKEN']
        ]);

        $client->request('GET', '/api/github/users/MateuszSzwankowski');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($data['name'], 'Mateusz Szwankowski');
        $this->assertEquals($data['url'], 'https://api.github.com/users/MateuszSzwankowski');
        $this->assertEquals($data['email'], null);
        $this->assertEquals($data['created_at'], '2018-02-27T14:04:09+00:00');
    }

    public function testGetGithubUserDataWithInvalidToken()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token invalid_token'
        ]);;
        $client->request('GET', '/api/github/users/MateuszSzwankowski');

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetGithubUserDataWithoutToken()
    {
        $client = static::createClient();
        $client->request('GET', '/api/github/users/MateuszSzwankowski');

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetGithubUnexistingUserData()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token ' . $_ENV['GITHUB_API_TOKEN']
        ]);
        $client->request('GET', '/api/github/users/czxdsaaeqwneqwofsaneqwn');

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetGithubRepoData()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token ' . $_ENV['GITHUB_API_TOKEN']
        ]);

        $client->request('GET', '/api/github/repositories/MateuszSzwankowski/tetris');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($data['full_name'], 'MateuszSzwankowski/tetris');
        $this->assertEquals($data['description'], 'Tetris clone written in Python');
        $this->assertEquals($data['clone_url'], 'https://github.com/MateuszSzwankowski/tetris.git');
        $this->assertEquals($data['stars'], 0);
        $this->assertEquals($data['created_at'], '2018-03-03T01:26:12+00:00');
    }

    public function testGetGithubRepoDataWithInvalidToken()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token invalid_token'
        ]);;
        $client->request('GET', '/api/github/repositories/MateuszSzwankowski/tetris');

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetGithubRepoDataWithoutToken()
    {
        $client = static::createClient();
        $client->request('GET', '/api/github/repositories/MateuszSzwankowski/tetris');

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetGithubRepoDataForUnexistingUser()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token ' . $_ENV['GITHUB_API_TOKEN']
        ]);
        $client->request('GET', '/api/github/repositories/czxdsaaeqwneqwofsaneqwn/invalid_name');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testGetGithubUnexistingRepoData()
    {
        $client = static::createClient([], [
            'HTTP_Authorization' => 'token ' . $_ENV['GITHUB_API_TOKEN']
        ]);
        $client->request('GET', '/api/github/repositories/MateuszSzwankowski/invalid_name');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
