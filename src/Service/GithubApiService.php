<?php

namespace App\Service;

use App\Dto\Github\UserDto;

final class GithubApiService
{
    public function getUserInfo(
        string $login
    ): UserDto {
        return new UserDto(
            $login,
            'b',
            'c',
            new \DateTimeImmutable()
        );
    }
}
