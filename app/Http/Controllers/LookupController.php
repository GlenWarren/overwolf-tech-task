<?php declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 */
class LookupController extends Controller
{
    public function lookup(Request $request)
    {
        $type = $request->get('type', null);
        $id = $request->get('id', null);
        $username = $request->get('username', null);

        if ($type === 'minecraft') {
            if ($username) {
                $username = $username;
                $userId = false;
            }
            if ($id) {
                $username = false;
                $userId = $id;
            }

            if ($username) {
                $guzzle = new Client();
                $response = $guzzle->get(
                    "https://api.mojang.com/users/profiles/minecraft/{$username}"
                );

                $match = json_decode($response->getBody()->getContents());

                return [
                    'username' => $match->name,
                    'id' => $match->id,
                    'avatar' => "https://crafatar.com/avatars" . $match->id
                ];
            }

            if ($userId) {
                $guzzle = new Client();
                $response = $guzzle->get(
                    "https://sessionserver.mojang.com/session/minecraft/profile/{$userId}"
                );

                $match = json_decode($response->getBody()->getContents());
                return [
                    'username' => $match->name,
                    'id' => $match->id,
                    'avatar' => "https://crafatar.com/avatars" . $match->id
                ];
            }
        } elseif ($type === 'steam') {
            if ($username) {
                die("Steam only supports IDs");
            } else {
                $id = $id;
                $guzzle = new Client();
                $url = "https://ident.tebex.io/usernameservices/4/username/{$id}";

                $match = json_decode($guzzle->get($url)->getBody()->getContents());

                return [
                    'username' => $match->username,
                    'id' => $match->id,
                    'avatar' => $match->meta->avatar
                ];
            }

        } elseif ($type === 'xbl') {
            if ($username) {
                $guzzle = new Client();
                $response = $guzzle->get("https://ident.tebex.io/usernameservices/3/username/" . $username . "?type=username");
                $profile = json_decode($response->getBody()->getContents());

                return [
                    'username' => $profile->username,
                    'id' => $profile->id,
                    'avatar' => $profile->meta->avatar
                ];
            }

            if ($id) {
                $id = $id;
                $guzzle = new Client();
                $response = $guzzle->get("https://ident.tebex.io/usernameservices/3/username/" . $id);
                $profile = json_decode($response->getBody()->getContents());

                return [
                    'username' => $profile->username,
                    'id' => $profile->id,
                    'avatar' => $profile->meta->avatar
                ];
            }
        }
        // We can't handle this - maybe provide feedback?
        // die();
    }
}
