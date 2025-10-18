<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $source;

    protected $apiKey;

    protected $baseUrls = [
        'weatherapi' => 'http://api.weatherapi.com/v1/',
        'openweathermap' => 'http://api.openweathermap.org/data/2.5/',
        'openweathermap_history' => 'https://history.openweathermap.org/data/2.5/history/',
    ];

    public function __construct()
    {
        $this->source = config('services.weather.source', 'weatherapi');
        $this->apiKey = config('services.weather.'.$this->source.'.key');
    }

    /**
     * Get current weather for a location
     *
     * @param  string  $location
     * @return array
     */
    public function getCurrentWeather($location)
    {
        if ($this->source === 'weatherapi') {
            return $this->getCurrentWeatherFromWeatherApi($location);
        } elseif ($this->source === 'openweathermap') {
            return $this->getCurrentWeatherFromOpenWeatherMap($location);
        }

        return ['error' => 'Invalid weather source'];
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
        if ($this->source === 'weatherapi') {
            return $this->getForecastFromWeatherApi($location, $days);
        } elseif ($this->source === 'openweathermap') {
            return $this->getForecastFromOpenWeatherMap($location, $days);
        }

        return ['error' => 'Invalid weather source'];
    }

    /**
     * Get historical weather for a location on a specific date
     *
     * @param  string  $location
     * @param  string  $date  YYYY-MM-DD format
     * @return array
     */
    public function getHistoricalWeather($location, $date)
    {
        if ($this->source === 'weatherapi') {
            return $this->getHistoricalWeatherFromWeatherApi($location, $date);
        } elseif ($this->source === 'openweathermap') {
            return ['error' => 'Historical weather is not supported for OpenWeatherMap in the free tier'];
        }

        return ['error' => 'Invalid weather source'];
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
            'source' => 'openweathermap_history',
        ]);

        $response = Http::timeout(30)->get($this->baseUrls['openweathermap_history'].'city', [
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
        ];

        Log::error('WeatherService: Failed to fetch historical weather data', $errorData);

        return ['error' => 'Unable to fetch historical weather data from OpenWeatherMap'];
    }

    private function getCurrentWeatherFromWeatherApi($location)
    {
        $response = Http::get($this->baseUrls['weatherapi'].'current.json', [
            'key' => $this->apiKey,
            'q' => $location,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Unable to fetch current weather data from WeatherAPI'];
    }

    private function getForecastFromWeatherApi($location, $days)
    {
        $response = Http::get($this->baseUrls['weatherapi'].'forecast.json', [
            'key' => $this->apiKey,
            'q' => $location,
            'days' => $days,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Unable to fetch forecast data from WeatherAPI'];
    }

    private function getCurrentWeatherFromOpenWeatherMap($location)
    {
        $response = Http::get($this->baseUrls['openweathermap'].'weather', [
            'q' => $location,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Unable to fetch current weather data from OpenWeatherMap'];
    }

    private function getForecastFromOpenWeatherMap($location, $days)
    {
        // OpenWeatherMap forecast is for 5 days, 3-hourly
        $response = Http::get($this->baseUrls['openweathermap'].'forecast', [
            'q' => $location,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Unable to fetch forecast data from OpenWeatherMap'];
    }

    private function getHistoricalWeatherFromWeatherApi($location, $date)
    {
        $response = Http::get($this->baseUrls['weatherapi'].'history.json', [
            'key' => $this->apiKey,
            'q' => $location,
            'dt' => $date,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Unable to fetch historical weather data from WeatherAPI'];
    }
}
