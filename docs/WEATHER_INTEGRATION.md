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

The system provides comprehensive logging to help diagnose issues with weather data fetching and storage:

### Dataset Processing Logs

- **Start of sales data processing**: 
  ```
  Processing sales data for dataset {id}
  ```
- **End of sales data processing**:
  ```
  Finished processing sales data, now fetching weather data...
  ```

### Weather Fetch Initialization Logs

- **Start of weather fetch process**:
  ```
  Starting weather data fetch for dataset {id}
  ```
- **Restaurant coordinates**:
  ```
  Restaurant coordinates: lat={latitude}, lon={longitude}
  ```
- **Orders found**:
  ```
  Found {count} orders without weather data for dataset {id}
  ```
- **Order date range**:
  ```
  Order date range: {earliest_date} to {latest_date}
  ```

### API Request Logs

For each API call, the system logs:

- **WeatherService request details**:
  ```
  WeatherService: Fetching historical weather data
  [lat, lon, start, start_datetime, source]
  ```
- **Successful API response**:
  ```
  WeatherService: Successfully fetched historical weather data
  [status_code, data_count]
  ```
- **Failed API response**:
  ```
  WeatherService: Failed to fetch historical weather data
  [status_code, response_body, error_message]
  ```
- **Number of weather records fetched**:
  ```
  Fetched {count} weather records
  ```
- **API errors with response data**:
  ```
  Failed to fetch weather data: {error}
  Weather API response: {json_encoded_response}
  ```

### Weather Data Matching Logs

- **Start of matching process**:
  ```
  Starting to match weather data to {count} orders...
  ```
- **Empty weather data warning**:
  ```
  No weather data was retrieved from the API. Cannot update orders.
  ```

### Individual Order Update Logs

For each order being updated:

- **Weather data validation**:
  ```
  Invalid weather data structure for order {id}
  [weather_data]
  ```
- **Successful update preparation**:
  ```
  Updating order {id} (order_no: {order_no}, order_dt: {datetime}) with weather data
  [weather_data: {temp, condition, description, humidity, pressure, wind_speed, fetched_at}, time_diff_seconds]
  ```
- **Successful database update**:
  ```
  Successfully updated order {id} with weather data
  ```
- **Failed database update**:
  ```
  Failed to update order {id} with weather data - update() returned false
  ```
- **Exception during update**:
  ```
  Exception while updating order {id} with weather data: {error_message}
  [exception, order_id, order_dt]
  ```
- **No matching weather data**:
  ```
  No weather data found for order {id} (order_no: {order_no}) at {datetime}
  ```

### Summary Logs

- **Final update summary**:
  ```
  Weather data update summary for dataset {id}: Updated={count}, Failed={count}, NotFound={count}, Total={count}
  ```
- **Overall completion**:
  ```
  Completed weather data fetch. Made {count} API calls. Retrieved {count} weather records.
  ```

### Error Logs

- **Top-level error**:
  ```
  Failed to fetch weather data for dataset {id}: {error_message}
  ```

### Log Levels

The logging uses different levels for different severity:

- **Info**: Normal operation and progress updates
- **Debug**: Detailed successful operations (order updates)
- **Warning**: Non-critical issues (missing weather data, empty API responses)
- **Error**: Critical failures (invalid data structure, update exceptions)

### Viewing Logs

To view logs in Laravel:

```bash
# View latest log file
tail -f storage/logs/laravel.log

# Search for weather-related logs
grep -i "weather" storage/logs/laravel.log

# Search for a specific dataset
grep "dataset 123" storage/logs/laravel.log

# View only errors
grep -i "error.*weather" storage/logs/laravel.log
```

### Troubleshooting with Logs

1. **Weather data not being saved**:
   - Check for "No weather data was retrieved from the API" warning
   - Look for API response errors with status codes
   - Check for "Failed to update order" messages

2. **API issues**:
   - Look for "WeatherService: Failed to fetch" errors
   - Check the response_body in error logs for API error details
   - Verify coordinates and timestamps in request logs

3. **Database update issues**:
   - Check for "update() returned false" messages
   - Look for exception messages with stack traces
   - Verify order IDs and timestamps in error logs

4. **Data validation issues**:
   - Look for "Invalid weather data structure" errors
   - Check the weather_data field in error logs to see what structure was received

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
