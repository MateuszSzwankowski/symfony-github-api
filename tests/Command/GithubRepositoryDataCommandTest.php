<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GithubRepositoryDataCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:github:repo');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'login' => 'MateuszSzwankowski',
            'repoName' => 'tetris'
        ]);

        $output = $commandTester->getDisplay();
        $expectedStrings = [
            '"full_name":"MateuszSzwankowski\/tetris"',
            '"description":"Tetris clone written in Python"',
            '"clone_url":"https:\/\/github.com\/MateuszSzwankowski\/tetris.git"',
            '"stars":0',
            '"created_at":"2018-03-03T01:26:12+00:00"'
        ];

        foreach ($expectedStrings as $expectedString) {
            $this->assertStringContainsString($expectedString, $output);
        }
    }
}
