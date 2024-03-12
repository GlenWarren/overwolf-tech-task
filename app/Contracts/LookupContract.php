<?php declare(strict_types=1);

namespace App\Contracts;

interface LookupContract
{
    public function lookup(): array;
    public function getUrl(?string $id, ?string $username): string;
    public function getResponse(string $url): mixed;
    public function extractUserDetails(mixed $response): array;
}
