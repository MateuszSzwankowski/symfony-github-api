<?php

namespace App\Controller;

use App\Exception\GithubAuthorizationException;
use App\Service\GithubApiService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/api/github", name="github_api") */
class GithubController extends AbstractFOSRestController
{
    private $githubService;

    public function __construct(
        GithubApiService $githubService
    ) {
        $this->githubService = $githubService;
    }

    /**
     * @Route("/users/{login}")
    */
    public function githubUserData(
        Request $request,
        string $login
    ): View {
        $token = self::extractTokenFromHeader($request);
        $dto = $this->githubService->getUserInfo($login, $token);

        return $this->view($dto, Response::HTTP_OK);
    }

    /**
     * @Route("/repositories/{login}/{repoName}")
    */
    public function githubUserRepositoryData(
        Request $request,
        string $login,
        string $repoName
    ): View {
        $token = $this->extractTokenFromHeader($request);
        $dto = $this->githubService->getRepositoryInfo($login, $repoName, $token);

        return $this->view($dto, Response::HTTP_OK);
    }

    private function extractTokenFromHeader(Request $request): string
    {
        $authHeader = $request->headers->get('Authorization');
        if (substr($authHeader, 0, 6) !== 'token ') {
            throw new GithubAuthorizationException(
                'GitHub token not found in authorization header',
            );
        }
        $token = substr($authHeader, 6); // remove 'token '

        return $token;
    }
}
