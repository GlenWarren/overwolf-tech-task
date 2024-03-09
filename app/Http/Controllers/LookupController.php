<?php declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 **/
class LookupController extends Controller
{
    /**
     * Composition
     * Inheritance
     * Contracts (Interfaces)
     * Clean
     * Maintainable
     * PSR-12 standards
     * SOLID principles
     * OOP
     * Dependency Injection (In Laravel this also includes use of the Service Container)
     * 
     * BONUS
     * Due to rate limits enforced by the underlying services, consider how data can be cached or persisted so that we're not having to call the underlying service every time.
     * Implement some 'defensive programming' (consider how and why the application might fail and implement appropriate precautions).
     * Consider how error/fail states should be communicated back to the user.
     **/

    public function lookup(Request $request)
    {
        $type = $request->get('type', null);
        $id = $request->get('id', null);
        $username = $request->get('username', null);

        if (is_null($type) || is_null($id) && is_null($username)) {
            // do something?
            // Should these checks happen in the services instead? Or perhaps in the provider?
            return;
        }

        switch ($type) {
            case 'minecraft':
                $service_name = 'LookupMinecraftService';
                break;
            case 'steam':
                $service_name = 'LookupSteamService';
                break;
            case 'xbl':
                $service_name = 'LookupXBLService';
                break;
            default:
                // do something to handle scenario where type is not valid
                // probably remove the is_null chack above    
               return;
        }

        $lookup_service = app()->makeWith($service_name, [$id, $username]);

        // Should we be immediately returning the response from the service? Or constructing the controller response here?
        return $lookup_service->lookup();

        // We can't handle this - maybe provide feedback?
        // die();
    }
}
