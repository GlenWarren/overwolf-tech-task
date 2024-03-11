<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;
use App\Traits\LookupTrait;

class LookupMinecraftService implements LookupContract
{
    use LookupTrait;

    private $guzzle;
    private $id;
    private $username;

    public function __construct($guzzle, ?string $id, ?string $username)
    {
        $this->guzzle = $guzzle;
        $this->id = $id;
        $this->username = $username;
    }

    public function lookup()
    {
        $url = $this->getUrl();

        $response = $this->getResponse($url);

        return $this->extractUserDetails($response);
    }

    public function getUrl(): string
    {
        if ($this->username) {
            return "https://api.mojang.com/users/profiles/minecraft/{$this->username}";
        } elseif ($this->id) {
            return "https://sessionserver.mojang.com/session/minecraft/profile/{$this->id}";
        } else {
            return '';
        }
    }

    public function extractUserDetails($response): array
    {
        $username = $response->name ?? null;
        $id = $response->id ?? null;

        return [
            'username' => $username,
            'id' => $id,
            'avatar' => "https://crafatar.com/avatars{$id}"
        ];
    }
}
