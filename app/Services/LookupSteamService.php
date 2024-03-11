<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;
use App\Traits\LookupTrait;
use InvalidArgumentException;

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

        $response = $this->getResponse($url);

        return $this->extractUserDetails($response);
    }

    public function getUrl(): string
    {
        if ($this->username) {
            throw new InvalidArgumentException('Steam only supports IDs');
        } elseif ($this->id) {
            return "https://ident.tebex.io/usernameservices/4/username/{$this->id}";
        } else {
            return '';
        }
    }
}
