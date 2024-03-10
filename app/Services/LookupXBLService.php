<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;
use App\Traits\LookupTrait;

class LookupXBLService implements LookupContract
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

        $profile = $this->getResponse($url);

        return [
            'username' => $profile->username,
            'id' => $profile->id,
            'avatar' => $profile->meta->avatar
        ];
    }

    public function getUrl(): string
    {
        if ($this->username) {
            return "https://ident.tebex.io/usernameservices/3/username/{$this->username}?type=username";
        } elseif ($this->id) {
            return "https://ident.tebex.io/usernameservices/3/username/{$this->id}";
        } else {
            // do something?
            return '';
        }
    }
}