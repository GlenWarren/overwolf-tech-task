<?php declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class LookupService
{
    private $guzzle;
    private $id;
    private $username;

    public function __construct(Client $guzzle, ?string $id, ?string $username)
    {
        $this->guzzle = $guzzle;
        $this->id = $id;
        $this->username = $username;
    }

    public function lookup(): array
    {
        $url = $this->getUrl($this->id, $this->username);

        $response = $this->getResponse($url);

        return $this->extractUserDetails($response);
    }

    public function getResponse(string $url): mixed
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Invalid url. ID or Username missing.');
        }

        $response = $this->guzzle->get($url);
        return json_decode($response->getBody()->getContents());
    }

    public function extractUserDetails(mixed $response): array
    {
        return [
            'username' => $response->username ?? null,
            'id' => $response->id ?? null,
            'avatar' => $response->meta->avatar ?? null
        ];
    }
}
