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
        if ($request->get('type') == 'minecraft') {
            if ($request->get('username')) {
                $username = $request->get('username');
                $userId = false;
            }
            if ($request->get('id')) {
                $username=false;
                $userId = $request->get('id');
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
        } elseif ($request->get('type')=='steam') {
            if ($request->get("username")) {
                die("Steam only supports IDs");
            } else {
                $id = $request->get("id");
                $guzzle = new Client();
                $url = "https://ident.tebex.io/usernameservices/4/username/{$id}";

                $match = json_decode($guzzle->get($url)->getBody()->getContents());

                return [
                    'username' => $match->username,
                    'id' => $match->id,
                    'avatar' => $match->meta->avatar
                ];
            }

        } elseif($request->get('type') === 'xbl') {
            if ($request->get("username")) {
                $guzzle = new Client();
                $response = $guzzle->get("https://ident.tebex.io/usernameservices/3/username/" . $request->get("username") . "?type=username");
                $profile = json_decode($response->getBody()->getContents());

                return [
                    'username' => $profile->username,
                    'id' => $profile->id,
                    'avatar' => $profile->meta->avatar
                ];
            }

            if ($request->get("id")) {
                $id = $request->get("id");
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
        die();
    }
}
