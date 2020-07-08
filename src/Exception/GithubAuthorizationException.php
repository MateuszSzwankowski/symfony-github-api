<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GithubAuthorizationException extends UnauthorizedHttpException
{
    public function __construct(string $message = null, \Throwable $previous = null, ?int $code = 0, array $headers = [])
    {
        $challenge = 'token realm=\"api.github.com\"';
        parent::__construct($challenge, $message, $previous, $code, $headers);
    }
}
