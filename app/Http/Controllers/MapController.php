<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    const API_KEY = 'YOUR API GOES HERE';
    const MAX_NUM_OF_COORDS = 30;




    public function proxy(Request $request)
    {
        if ($request->isMethod('post')) {
            $coordinates = $request->input('coordinates');
            $profile = $request->input('profile');

            if (!$this->areCoordinatesValid($coordinates) || !$this->isProfileValid($profile)) {
                Log::error('Invalid data sent.', ['coordinates' => $coordinates, 'profile' => $profile]);
                return response()->json(['error' => 'Invalid data.'], 400);
            }

            $client = new Client(['base_uri' => 'https://api.openrouteservice.org', 'timeout' => 10.0]);
            $radiuses = array_fill(0, count($coordinates), -1);

            try {
                $apiResponse = $client->post('/v2/directions/' . $profile . '/geojson', [
                    'headers' => ['Authorization' => self::API_KEY],
                    'json' => ['coordinates' => $coordinates, 'radiuses' => $radiuses],
                ]);

                return response($apiResponse->getBody(), $apiResponse->getStatusCode())
                    ->header('Content-Type', 'application/json');
            } catch (\Exception $e) {
                Log::error('Open Route Service API call failed.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'System error. Please try again.'], 500);
            }
        }

        return response()->json(['error' => 'Method not allowed.'], 405);
    }

    private function areCoordinatesValid($coordinates)
    {
        if (is_array($coordinates) && count($coordinates) <= self::MAX_NUM_OF_COORDS) {
            foreach ($coordinates as $coord) {
                if (!is_array($coord) || count($coord) !== 2 || !is_numeric($coord[0]) || !is_numeric($coord[1])) {
                    return false;
                }
                if ($coord[0] < -180 || $coord[0] > 180 || $coord[1] < -90 || $coord[1] > 90) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function isProfileValid($profile)
    {
        return in_array($profile, ['driving-car', 'foot-walking']);
    }
}
