<?php

namespace App\Http\Middleware;

use App\Exceptions\UserException;
use App\Interfaces\UserServiceInterface;
use Closure;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Api
{
    public function __construct(public UserServiceInterface $userService) {}

    public function handle($request, Closure $next): mixed
    {
        // Get API Key
        $apiKey = trim($request->header('x-api-key'));
        if (empty($apiKey) || strlen($apiKey) != 60) {
            return $this->denied('Invalid API Key specified');
        }

        // Try to find a user
        try {
            $user = $this->userService->getByApiKey($apiKey);
            if (!$user) {
                return $this->denied('API Key does not exist');
            }

            $request->apiUser = $user;
        } catch (UserException $e) {
            return $this->denied('Cannot check API Key');
        }

        return $next($request);
    }

    private function denied(string $message)
    {
        return response($message, SymfonyResponse::HTTP_UNAUTHORIZED);
    }
}
