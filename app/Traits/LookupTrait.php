<?php declare(strict_types=1);

namespace App\Traits;

use InvalidArgumentException;

trait LookupTrait
{
    public function getResponse($url)
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Invalid url. ID or Username missing.');
        }
        $response = $this->guzzle->get($url);
        return json_decode($response->getBody()->getContents());
    }

    public function extractUserDetails($response): array
    {
        return [
            'username' => $response->username ?? null,
            'id' => $response->id ?? null,
            'avatar' => $response->meta->avatar ?? null
        ];
    }
}
