<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class spotifyController extends Controller
{
    /**
     * This function calls all the other functions
     * @param Request
     */
    public function main(Request $request) {
        //validate data return the error if the response wasnt 200.
        $temperature = 0;
        if($request->cidade != null) {
            $temperature = self::getTemperatureByCityName($request);
        }
        elseif ($request->lat != null && $request->lon != null) {
            $temperature = self::getTemperatureByLatLon($request);
        }

        $musicGenre = self::getMusicGenre($temperature);
        dd($musicGenre);
    }

    public function getTemperatureByCityName(Request $request) {
        //hide api KEY
        $response = Http::get('api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}&units={unidade}', [
            'q' => $request->cidade,
            'appid' => '813d0004620489e9adf3ad77846ba91c',
            'units' => 'metric'
        ])->json();
        
        $temperature = $response['main']['temp'];

        return $temperature;
    }

    public function getTemperatureByLatLon(Request $request) {
        $response = Http::get('api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={API key}&units={unidade}', [
            'lat' => $request->lat,
            'lon' => $request->lon,
            'appid' => '813d0004620489e9adf3ad77846ba91c',
            'units' => 'metric'
        ])->json();

        $temperature = $response['main']['temp'];

        return $temperature;
    }

    /**
     * Returns the music genre by the temperature
     * @param int temperature
     * @return string genre
     */
    public function getMusicGenre($temperature) {
        if ($temperature > 30) {
            return 'festa';
        } elseif ($temperature >= 15) {
            return 'pop';
        } elseif ($temperature > 10) {
            return 'rock';
        } else {
            return 'classicas';
        }
    }

    // Client ID 71e5072f3ef34b25bf965f1eda24e441
    // Client Secret 03dd54a0503e423384974abeab874592
    public function getPlaylist() {
        $musicGenre = 'mood';
        $token = 'BQBa5FcKGZIVhf30ns-mwfsrfokCnkqRZ5e8AtRf9c0JFATj4GkQXNbsEc9xvLXF697msC_2ZNshNx8kY3Zmta5EDjuWbv2EDebpUFsoIiVkcwBKIXYATq73FCbqojUEDOOCCVBnK00oYdrnR7--4LidsNjujDYpihjAX_6Efc4_BJAb5ylATgouvArfEdPCjRDM0HvlRN-ZNHuCRZgT7x9esKorw2Uwkc54fisLQE-K_Azhkso1NxssU0pPu5yk2DgrsDjEW-iB6C1G';
        $response = Http::get('https://api.spotify.com/v1/browse/categories/'. $musicGenre .'/playlists', 
        )->header('Bearer-Token', $token)->json();
    }
}
