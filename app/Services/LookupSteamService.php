<?php declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;
use App\Contracts\LookupContract;
use App\Services\LookupService;

class LookupSteamService extends LookupService implements LookupContract
{
    public function getUrl(?string $id, ?string $username): string
    {
        if ($username) {
            throw new InvalidArgumentException('Steam only supports IDs');
        } elseif ($id) {
            return "https://ident.tebex.io/usernameservices/4/username/{$id}";
        } else {
            return '';
        }
    }
}
