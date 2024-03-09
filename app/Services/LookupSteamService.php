<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;

class LookupSteamService implements LookupContract
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
            'username' => $match->username,
            'id' => $match->id,
            'avatar' => $match->meta->avatar
        ];
    }

    public function getUrl(): string
    {
        if ($this->username) {
            // TODO: change this
            die("Steam only supports IDs");
        } elseif ($this->id) {
            return "https://ident.tebex.io/usernameservices/4/username/{$this->id}";
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
