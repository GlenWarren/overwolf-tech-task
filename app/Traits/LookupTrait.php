<?php declare(strict_types=1);

namespace App\Traits;

trait LookupTrait
{
    public function getResponse($url)
    {
        $response = $this->guzzle->get($url);
        return json_decode($response->getBody()->getContents());
    }
}
