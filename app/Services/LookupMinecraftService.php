<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\LookupContract;
use App\Services\LookupService;

class LookupMinecraftService extends LookupService implements LookupContract
{
    public function getUrl(?string $id, ?string $username): string
    {
        if ($username) {
            return "https://api.mojang.com/users/profiles/minecraft/{$username}";
        } elseif ($id) {
            return "https://sessionserver.mojang.com/session/minecraft/profile/{$id}";
        } else {
            return '';
        }
    }

    public function extractUserDetails(mixed $response): array
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
