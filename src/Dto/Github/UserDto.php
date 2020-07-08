<?php

namespace App\Dto\Github;

class UserDto
{
    private string $name;
    private string $url;
    private string $email;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $name,
        string $url,
        string $email,
        \DateTimeImmutable $createdAt
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }
}
