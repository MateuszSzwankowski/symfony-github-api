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
     * @Route("/user/{login}")
    */
    public function githubUserData(
        string $login
    ): View {
        $dto = $this->githubService->getUserInfo($login);
        dump($dto);die;
    }
}
