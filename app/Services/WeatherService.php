<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $apiKey;

    protected $baseUrls = [
        'current' => 'http://api.openweathermap.org/data/2.5/',
        'history' => 'https://history.openweathermap.org/data/2.5/history/',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.weather.openweathermap.key');
        
        Log::info('WeatherService initialized', [
            'api_key_configured' => !empty($this->apiKey),
            'api_key_length' => $this->apiKey ? strlen($this->apiKey) : 0,
        ]);
    }

    /**
     * Get current weather for a location
     *
     * @param  string  $location
     * @return array
     */
    public function getCurrentWeather($location)
    {
        Log::info('WeatherService: Getting current weather', ['location' => $location]);
        
        $response = Http::timeout(30)->get($this->baseUrls['current'].'weather', [
            'q' => $location,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            Log::info('WeatherService: Current weather fetched successfully');
            return $response->json();
        }

        Log::error('WeatherService: Failed to fetch current weather', [
            'status_code' => $response->status(),
            'response_body' => $response->body(),
        ]);

        return ['error' => 'Unable to fetch current weather data from OpenWeatherMap'];
    }

    /**
     * Get weather forecast for a location
     *
     * @param  string  $location
     * @param  int  $days
     * @return array
     */
    public function getForecast($location, $days = 7)
    {
        Log::info('WeatherService: Getting forecast', ['location' => $location, 'days' => $days]);
        
        // OpenWeatherMap forecast is for 5 days, 3-hourly
        $response = Http::timeout(30)->get($this->baseUrls['current'].'forecast', [
            'q' => $location,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            Log::info('WeatherService: Forecast fetched successfully');
            return $response->json();
        }

        Log::error('WeatherService: Failed to fetch forecast', [
            'status_code' => $response->status(),
            'response_body' => $response->body(),
        ]);

        return ['error' => 'Unable to fetch forecast data from OpenWeatherMap'];
    }

    /**
     * Get historical weather from OpenWeatherMap for specific coordinates and time
     *
     * @param  float  $lat  Latitude
     * @param  float  $lon  Longitude
     * @param  int  $start  Unix timestamp for start time
     * @return array
     */
    public function getHistoricalWeatherFromOpenWeatherMapByCoords($lat, $lon, $start)
    {
        Log::info('WeatherService: Fetching historical weather data', [
            'lat' => $lat,
            'lon' => $lon,
            'start' => $start,
            'start_datetime' => date('Y-m-d H:i:s', $start),
            'api_url' => $this->baseUrls['history'].'city',
        ]);

        $response = Http::timeout(30)->get($this->baseUrls['history'].'city', [
            'lat' => $lat,
            'lon' => $lon,
            'type' => 'hour',
            'start' => $start,
            'cnt' => 150,
            'appid' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Log::info('WeatherService: Successfully fetched historical weather data', [
                'status_code' => $response->status(),
                'data_count' => isset($data['list']) ? count($data['list']) : 0,
            ]);

            return $data;
        }

        $errorData = [
            'status_code' => $response->status(),
            'response_body' => $response->body(),
            'error_message' => 'Unable to fetch historical weather data from OpenWeatherMap',
            'api_key_length' => strlen($this->apiKey),
        ];

        Log::error('WeatherService: Failed to fetch historical weather data', $errorData);

        return ['error' => 'Unable to fetch historical weather data from OpenWeatherMap'];
    }
}
