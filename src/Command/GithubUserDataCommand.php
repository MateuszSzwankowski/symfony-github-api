<?php

namespace App\Command;

use App\Service\GithubApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GithubUserDataCommand extends Command
{
    protected static $defaultName = 'app:github:user';

    private GithubApiService $githubService;
    private ParameterBagInterface $params;

    public function __construct(
        GithubApiService $githubService,
        ParameterBagInterface $params
    ) {
        parent::__construct();
        $this->githubService = $githubService;
        $this->params = $params;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Fetch user data from GitHub api.')
            ->addArgument('login', InputArgument::REQUIRED, 'Searched Github login.')
            ->addArgument('token', InputArgument::OPTIONAL, 'Github api token (optional).');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $responseDto = $this->githubService->getUserInfo(
            $input->getArgument('login'),
            $input->getArgument('token') ?? $this->params->get('app.github_token')
        );

        dump($responseDto);
        return Command::SUCCESS;
    }
}
