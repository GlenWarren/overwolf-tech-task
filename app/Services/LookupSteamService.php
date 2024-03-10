<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;
use App\Traits\LookupTrait;

class LookupSteamService implements LookupContract
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
}
