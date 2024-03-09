<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;

class LookupMinecraftService implements LookupContract
{
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

        $match = $this->getResponse($url);

        return [
            'username' => $match->name,
            'id' => $match->id,
            'avatar' => "https://crafatar.com/avatars{$match->id}"
        ];
    }

    public function getUrl(): string
    {
        if ($this->username) {
            return "https://api.mojang.com/users/profiles/minecraft/{$this->username}";
        } elseif ($this->id) {
            return "https://sessionserver.mojang.com/session/minecraft/profile/{$this->id}";
        } else {
            // do something?
            return '';
        }
    }

    public function getResponse($url)
    {
        $response = $this->guzzle->get($url);
        return json_decode($response->getBody()->getContents());
    }
}
