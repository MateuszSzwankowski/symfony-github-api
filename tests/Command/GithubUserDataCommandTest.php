<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GithubUserDataCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:github:user');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'login' => 'MateuszSzwankowski',
        ]);

        $output = $commandTester->getDisplay();
        $expectedStrings = [
            '"name":"Mateusz Szwankowski"',
            '"url":"https:\/\/api.github.com\/users\/MateuszSzwankowski"',
            '"email":null',
            '"created_at":"2018-02-27T14:04:09+00:00"',
        ];

        foreach ($expectedStrings as $expectedString) {
            $this->assertStringContainsString($expectedString, $output);
        }
    }
}