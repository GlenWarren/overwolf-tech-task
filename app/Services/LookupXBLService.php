<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;
use App\Services\LookupService;

class LookupXBLService extends LookupService implements LookupContract
{
    public function getUrl(?string $id, ?string $username): string
    {
        if ($username) {
            return "https://ident.tebex.io/usernameservices/3/username/{$username}?type=username";
        } elseif ($id) {
            return "https://ident.tebex.io/usernameservices/3/username/{$id}";
        } else {
            return '';
        }
    }
}
