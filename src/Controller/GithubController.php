<?php

namespace App\Controller;

use App\Service\GithubApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/api/github", name="github_api") */
class GithubController extends AbstractController
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
        string $login
    ): View {
        $dto = $this->githubService->getUserInfo($login, $_ENV['GITHUB_API_TOKEN']);
        dump($dto);die;
    }

    /**
     * @Route("/repositories/{login}/{repoName}")
    */
    public function githubRepositoryData(
        string $login,
        string $repoName
    ): View {
        $dto = $this->githubService->getRepositoryInfo($login, $repoName, $_ENV['GITHUB_API_TOKEN']);
        dump($dto);die;
    }
}
