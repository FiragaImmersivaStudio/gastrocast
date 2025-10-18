# Forecast Feature Documentation

## Overview
The Forecast feature provides comprehensive sales and operational forecasting for restaurants using a hybrid approach combining statistical methods with AI-powered insights.

## Key Features

### 1. Sales Forecasting
- Predicts daily sales revenue for up to 90 days
- Uses exponential smoothing with trend analysis
- Provides confidence intervals based on historical variance

### 2. Profit Prediction
- Estimates profit based on 22% average margin
- Adjusts predictions based on sales trends
- Accounts for seasonal variations

### 3. Visitor Count Forecasting
- Predicts daily customer counts
- Analyzes party size patterns
- Identifies growth trends

### 4. Peak Hours Analysis
- Generates 18-hour x 7-day heatmap
- Identifies busiest hours across weekdays
- Color-coded intensity levels (0-3)
- Average visitor counts per hour

### 5. AI-Generated Summaries
- Uses Llama 3.1-70b-versatile via Groq API
- Generates insights in Indonesian language
- Provides actionable recommendations
- Extracts key action items

### 6. Accuracy Metrics
- Calculates MAPE (Mean Absolute Percentage Error)
- Tracks confidence levels
- Historical accuracy tracking

## Validation Rules

### Backend Validation
1. **Start Date**: Must be in the future (tomorrow or later)
2. **End Date**: Must be after start date
3. **Period**: Maximum 90 days
4. **Restaurant**: Must exist and be accessible by user

### Frontend Validation
1. **Date Inputs**: HTML5 date validation with min/max
2. **JavaScript Validation**: Real-time feedback
3. **Error Messages**: User-friendly in Indonesian

## API Endpoints

### POST /api/forecast/run
Generate a new forecast

**Request Body:**
```json
{
  "start_date": "2025-10-20",
  "end_date": "2025-11-20",
  "metrics": ["sales", "profit", "customer_count", "peak_hours"]
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "daily_predictions": [...],
    "peak_hours_heatmap": [...],
    "summary_metrics": {...},
    "ai_summary": {...},
    "processing_time_ms": 1234
  }
}
```

### GET /api/forecast
List recent forecasts

### GET /api/forecast/{id}
View specific forecast details

### GET /api/forecast/summary
Get forecast summary statistics

## Statistical Methods

### Exponential Smoothing
- Alpha value: 0.3 (30% weight on recent data)
- Captures short-term trends
- Handles seasonality

### Trend Analysis
- Linear regression on historical data
- Slope calculation for growth rate
- Extrapolates future values

### Confidence Calculation
- Based on coefficient of variation
- Range: 50% - 95%
- Lower variance = higher confidence

## Data Sources
- **orders table**: Transaction data
- **order_items table**: Item-level details
- Historical window: Last 90 days

## Performance Optimization

### Database Queries
- Single aggregated query with GROUP BY
- Efficient date range filtering
- Indexed columns for fast lookups

### Large Dataset Handling
- Aggregation at query level
- Summary metrics calculation
- Chunked data processing for AI

### Caching Strategy
- LLM summaries cached for 1 hour
- Historical data cached per request
- Redis support for production

## AI Integration

### Model Selection
- **Primary**: llama-3.1-70b-versatile
- **Fallback**: Statistical methods only
- **Language**: Indonesian (id-ID)

### Prompt Engineering
```
Berdasarkan data KPI berikut:
- Total Prediksi Penjualan: Rp X
- Total Prediksi Keuntungan: Rp Y
- Total Prediksi Pengunjung: Z orang
...

Analisa performa restoran dan berikan:
1. Executive summary (2-3 kalimat)
2. 3-4 action items spesifik
3. Fokus pada improvement
```

### Token Management
- Max tokens: 1024 per request
- Temperature: 0.7 (balanced creativity)
- Timeout: 30 seconds

## UI Components

### Summary Cards
1. **Predicted Sales**: Total and daily average
2. **Predicted Profit**: Total with margin info
3. **Expected Visitors**: Total and daily average
4. **Accuracy**: Based on historical forecasts

### Charts
- **Dual-axis line chart**: Sales (left) + Visitors (right)
- **Responsive design**: Adapts to screen size
- **Interactive tooltips**: Hover for details

### Heatmap
- **Grid**: 18 hours (6 AM - 11 PM) x 7 days
- **Colors**: 
  - Light gray: < 15 visitors (low)
  - Light yellow: 15-29 visitors (medium-low)
  - Yellow: 30-49 visitors (medium)
  - Red: 50+ visitors (high)
- **Tooltips**: Show exact visitor count

### Loading States
- Modal spinner during generation
- Full-page overlay with message
- Progress indicators

## Error Handling

### Frontend
- Form validation before submission
- API error display in alerts
- Network error handling
- Graceful degradation

### Backend
- Try-catch blocks in service layer
- Detailed error logging
- User-friendly error messages
- Fallback to statistical methods

## Security Considerations

### Input Validation
- Date range validation
- Restaurant access control
- SQL injection prevention (parameterized queries)
- XSS prevention (escaped output)

### Authentication
- Laravel Sanctum middleware
- Session-based restaurant selection
- User-restaurant relationship validation

### API Security
- CSRF token validation
- Rate limiting (future)
- API key protection for Groq

## Configuration

### Environment Variables
```env
GROQ_API_KEY=your_api_key_here
LLM_PROVIDER=groq
```

### Service Configuration
```php
// config/services.php
'groq' => [
    'api_key' => env('GROQ_API_KEY'),
    'default_model' => env('GROQ_DEFAULT_MODEL', 'llama-3.1-70b-versatile'),
],
```

## Testing

### Unit Tests
- ForecastService methods
- Statistical calculations
- Data aggregation

### Feature Tests
- API endpoint validation
- Date range validation
- Authentication checks
- Response structure

### Manual Testing
1. Generate forecast with valid dates
2. Test date validation (past dates, > 90 days)
3. Verify AI summary generation
4. Check chart rendering
5. Test heatmap interaction

## Future Enhancements

### Planned Features
1. Multiple forecasting models (ARIMA, Prophet)
2. Seasonal adjustment algorithms
3. Weather correlation analysis
4. Event-based predictions
5. Menu item-level forecasting
6. Export to PDF/Excel
7. Scheduled forecast generation
8. Email notifications
9. Comparison with actual results
10. MAPE calculation after period ends

### Performance Improvements
1. Background job processing
2. Redis caching layer
3. Query optimization
4. Database indexing
5. CDN for static assets

## Troubleshooting

### Common Issues

**Issue**: "Insufficient historical data for forecasting"
- **Cause**: Less than 2 days of order history
- **Solution**: Import more historical data or wait for more orders

**Issue**: "Groq API Error"
- **Cause**: Invalid API key or rate limit exceeded
- **Solution**: Check GROQ_API_KEY in .env, verify account status

**Issue**: Forecast chart not displaying
- **Cause**: JavaScript error or missing Chart.js
- **Solution**: Check browser console, verify CDN availability

**Issue**: Dates not validating
- **Cause**: Browser date format issues
- **Solution**: Clear cache, check browser date settings

## Support

For issues or questions:
1. Check this documentation
2. Review error logs in `storage/logs`
3. Verify environment configuration
4. Test with sample data
5. Contact development team

## Version History

### v1.0.0 (October 2025)
- Initial release
- Basic forecasting with AI
- Peak hours heatmap
- 90-day limit validation
- Statistical methods implementation
