<?php

namespace App\Dto\Github;

class RepositoryDto
{
    private string $fullName;
    private string $description;
    private string $cloneUrl;
    private int $stars;
    private \DateTimeImmutable $createdAt;

    function __construct(
        string $fullName,
        string $description,
        string $cloneUrl,
        int $stargazersCount,
        \DateTimeImmutable $createdAt
    ) {
        $this->fullName = $fullName;
        $this->description = $description;
        $this->cloneUrl = $cloneUrl;
        $this->stars = $stargazersCount;
        $this->createdAt = $createdAt;
    }

    function getFullName(): string {
        return $this->fullName;
    }

    function getDescription(): string {
        return $this->description;
    }

    function getCloneUrl(): string {
        return $this->cloneUrl;
    }

    function getStars(): int {
        return $this->stars;
    }

    function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }
}
