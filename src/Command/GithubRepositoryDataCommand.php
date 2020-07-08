<?php

namespace App\Command;

use App\Service\GithubApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GithubRepositoryDataCommand extends Command
{
    protected static $defaultName = 'app:github:repo';

    private GithubApiService $githubService;
    private SerializerInterface $serializer;
    private ParameterBagInterface $params;

    public function __construct(
        GithubApiService $githubService,
        SerializerInterface $serializer,
        ParameterBagInterface $params
    ) {
        parent::__construct();
        $this->githubService = $githubService;
        $this->serializer = $serializer;
        $this->params = $params;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Fetch repository data from GitHub api.')
            ->addArgument('login', InputArgument::REQUIRED, 'Github login of repository owner.')
            ->addArgument('repoName', InputArgument::REQUIRED, 'Name of github repository.')
            ->addArgument('token', InputArgument::OPTIONAL, 'Github api token (optional).');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $responseDto = $this->githubService->getRepositoryInfo(
            $input->getArgument('login'),
            $input->getArgument('repoName'),
            $input->getArgument('token') ?? $this->params->get('app.github_token'),
        );

        $data = $this->serializer->serialize(
            $responseDto,
            'json'
        );
        
        $output->writeln($data);
        return Command::SUCCESS;
    }
}
