<?php declare(strict_types=1);

namespace App\Services;

class LookupService
{
    private $guzzle;
    private $type;
    private $id;
    private $username;

    public function __construct($guzzle, string $type, ?string $id, ?string $username)
    {
        $this->guzzle = $guzzle;
        $this->type = $type;
        $this->id = $id;
        $this->username = $username;
    }

    public function lookup()
    {
        switch ($this->type) {
            case 'minecraft':
                return $this->lookupMinecraft();
            case 'steam':
                return $this->lookupSteam();
            case 'xbl':
                return $this->lookupXBL();
            default:
               // do something to handle scenario where type is not valid
               return;
        }
    }

    private function lookupMinecraft(): array
    {
        if ($this->username) {
            $url = "https://api.mojang.com/users/profiles/minecraft/{$this->username}";
        } elseif ($this->id) {
            $url = "https://sessionserver.mojang.com/session/minecraft/profile/{$this->id}";
        } else {
            // do something?
        }

        $match = $this->getResponse($url);

        return [
            'username' => $match->name,
            'id' => $match->id,
            'avatar' => "https://crafatar.com/avatars{$match->id}"
        ];
    }

    private function lookupSteam(): array
    {
        if ($this->username) {
            // TODO: change this
            die("Steam only supports IDs");
        } elseif ($this->id) {
            $url = "https://ident.tebex.io/usernameservices/4/username/{$this->id}";

            $match = $this->getResponse($url);

            return [
                'username' => $match->username,
                'id' => $match->id,
                'avatar' => $match->meta->avatar
            ];
        } else {
            // do something?
        }
    }

    private function lookupXBL(): array
    {
        if ($this->username) {
            $url = "https://ident.tebex.io/usernameservices/3/username/{$this->username}?type=username";
        } elseif ($this->id) {
            $url = "https://ident.tebex.io/usernameservices/3/username/{$this->id}";
        } else {
            // do something?
        }

        $profile = $this->getResponse($url);

        return [
            'username' => $profile->username,
            'id' => $profile->id,
            'avatar' => $profile->meta->avatar
        ];
    }

    private function getResponse(string $url)
    {
        $response = $this->guzzle->get($url);
        return json_decode($response->getBody()->getContents());
    }
}
