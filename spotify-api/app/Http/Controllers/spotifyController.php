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
        $temperature = this::getTemperature($request);

    }
    
    public function getTemperature(Request $request) {
        //validate data return the error if the response wasnt 200.
        //hide api KEY
        $response = Http::get('api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}&units={unidade}', [
            'q' => $request->cidade,
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
        
    }
}
