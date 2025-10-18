# Weather Data Integration for Sales Orders

## Overview

This feature automatically fetches historical weather data from OpenWeatherMap API when processing sales dataset uploads. The weather conditions at the time of each order are stored directly in the orders table for later analysis.

## Database Changes

### New Columns in `orders` Table

The following columns have been added to store weather information:

- `weather_temp` (decimal): Temperature in Kelvin
- `weather_condition` (string): Main weather condition (e.g., "Rain", "Clear", "Clouds")
- `weather_description` (string): Detailed weather description (e.g., "moderate rain", "clear sky")
- `weather_humidity` (integer): Humidity percentage (0-100)
- `weather_pressure` (integer): Atmospheric pressure in hPa
- `weather_wind_speed` (decimal): Wind speed in meters per second
- `weather_fetched_at` (timestamp): When the weather data was fetched from the API

## How It Works

### 1. Sales Data Processing

When a sales dataset is uploaded and processed:
1. Orders are created/updated with sales data as usual
2. After all orders are saved, the weather fetching process begins automatically

### 2. Weather Data Fetching

The system fetches weather data from OpenWeatherMap's Historical Weather API:

- **API Endpoint**: `https://history.openweathermap.org/data/2.5/history/city`
- **Parameters**:
  - `lat` & `lon`: Restaurant's latitude and longitude
  - `type`: "hour" (hourly data)
  - `start`: Unix timestamp of the earliest order
  - `cnt`: 150 (maximum records per request)
  - `appid`: OpenWeatherMap API key

### 3. Batch Processing

Due to API limitations (150 hours of data per request):

- The system identifies the time range of all orders in the dataset
- Splits the range into 150-hour chunks
- Makes multiple API calls to cover the entire time range
- Adds a 5-second delay between calls to prevent spam detection
- Stores all weather data in memory

### 4. Matching Weather to Orders

For each order:
- The system finds the closest weather record within 1 hour
- Updates the order with the weather information
- Records the fetch timestamp

## Configuration

### Required Environment Variables

Add these to your `.env` file:

```env
WEATHER_SOURCE=openweathermap
OPENWEATHERMAP_KEY=your_api_key_here
```

### Restaurant Setup

Each restaurant must have:
- Valid latitude coordinate
- Valid longitude coordinate

These are used to fetch location-specific weather data.

## API Rate Limiting

The implementation includes:
- 5-second delay between API calls
- 30-second timeout per request
- Error handling for failed requests
- Non-blocking execution (weather fetch failures don't stop order processing)

## Error Handling

- If restaurant coordinates are missing, weather fetch is skipped
- If API calls fail, errors are logged but don't affect order processing
- Orders without matching weather data are logged for investigation
- Weather data is considered supplementary, not critical to order processing

## Job Timeout

The `ProcessDataset` job timeout has been increased to 600 seconds (10 minutes) to accommodate:
- Original data processing time
- Multiple API calls with delays
- Large datasets with many orders

## Example Weather Data

Sample response from OpenWeatherMap API:

```json
{
  "dt": 1578384000,
  "main": {
    "temp": 275.45,
    "feels_like": 271.7,
    "pressure": 1014,
    "humidity": 74,
    "temp_min": 274.26,
    "temp_max": 276.48
  },
  "wind": {
    "speed": 2.16,
    "deg": 87
  },
  "clouds": {
    "all": 90
  },
  "weather": [
    {
      "id": 501,
      "main": "Rain",
      "description": "moderate rain",
      "icon": "10n"
    }
  ]
}
```

## Logging

The system logs:
- Start/end of weather fetch process
- Number of API calls made
- Number of weather records retrieved
- Number of orders updated
- Any errors or warnings
- Orders without matching weather data

## Usage in Analysis

The weather data can be used for:
- Correlating sales patterns with weather conditions
- Demand forecasting based on weather predictions
- Inventory planning for weather-sensitive items
- Marketing campaign optimization
- Customer behavior analysis

## Migration

To apply the database changes:

```bash
php artisan migrate
```

To rollback:

```bash
php artisan migrate:rollback
```
