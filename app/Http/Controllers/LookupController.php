<?php declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use InvalidArgumentException;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 **/
class LookupController extends Controller
{
    public function lookup(Request $request)
    {
        $type = $request->get('type', null);
        $id = $request->get('id', null);
        $username = $request->get('username', null);

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
                throw new BadRequestHttpException("Type '{$type}' is not valid");
        }

        if (is_null($id) && is_null($username)) {
            throw new BadRequestHttpException('An ID or Username is required');
        }

        $lookup_service = app()->makeWith($service_name, [$id, $username]);

        try {
            $results = $lookup_service->lookup();
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (in_array(null, array_values($results))) {
            throw new HttpException(500, 'There was a problem');
        }
        
        return $results;
    }
}
