# Forecast Feature - Quick Start Guide

## Setup Instructions

### 1. Environment Configuration

Add the following to your `.env` file:

```env
# Groq API Configuration (Required for AI summaries)
GROQ_API_KEY=your_groq_api_key_here
LLM_PROVIDER=groq

# Optional: Specify a different model
GROQ_DEFAULT_MODEL=llama-3.1-70b-versatile
```

### 2. Database Migration

Run the migration to add the new forecast fields:

```bash
php artisan migrate
```

This will add the following tables/fields:
- `forecasts` table (if not exists)
- Additional AI-related fields to forecasts table

### 3. Clear Cache

```bash
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

## Usage Guide

### Accessing the Forecast Feature

1. Log in to your GastroCast account
2. Select a restaurant from your dashboard
3. Navigate to **Forecast & Insights** from the sidebar menu
4. You'll see the forecast dashboard with summary cards and charts

### Creating a New Forecast

1. Click the **"Run New Forecast"** button in the top-right corner
2. In the modal that appears:
   - **Start Date**: Select a future date (tomorrow or later)
   - **End Date**: Select an end date (max 90 days from start)
   - The form will automatically validate your selections
3. Click **"Run Forecast"** to generate predictions
4. Wait for the processing to complete (usually 5-10 seconds)

### Understanding the Results

#### AI Summary Card (Top)
- **Natural language summary** of the forecast in Indonesian
- **Key insights** about sales trends, visitor patterns
- **Action items** - specific recommendations
- **Model info** - shows which AI model was used
- **Performance metrics** - tokens used and processing time

#### Summary Cards (Row 1)
1. **Predicted Sales**: Total sales and daily average for the period
2. **Predicted Profit**: Estimated profit based on historical margins
3. **Expected Visitors**: Total and average daily visitor count
4. **Forecast Accuracy**: Confidence level based on historical data

#### Sales & Visitors Chart (Bottom Left)
- **Blue line**: Predicted daily sales (left Y-axis)
- **Orange line**: Predicted daily visitors (right Y-axis)
- **Interactive**: Hover over points to see exact values
- **Date labels**: Shows each day in the forecast period

#### Peak Hours Heatmap (Bottom Right)
- **7 columns**: Monday through Sunday
- **18 rows**: Hours from 6:00 AM to 11:00 PM
- **Color intensity**: 
  - Light gray = Very low traffic (< 15 visitors)
  - Light yellow = Low traffic (15-29 visitors)
  - Yellow = Medium traffic (30-49 visitors)
  - Red = High traffic (50+ visitors)
- **Hover**: See exact visitor count for each hour

#### Recent Forecasts Table (Bottom)
- Lists your last 10 forecasts
- Shows run date, period, accuracy, and model used
- Click **"View"** to load a previous forecast

### Best Practices

1. **Regular Updates**: Run new forecasts weekly to adapt to changing patterns
2. **Compare Results**: Check actual vs predicted after the period ends
3. **Historical Data**: Ensure at least 30 days of order history for accurate predictions
4. **Peak Hours**: Use the heatmap to optimize staffing schedules
5. **Action Items**: Review and implement AI-generated recommendations

### Date Selection Tips

✅ **Valid Selections:**
- Start: Tomorrow or any future date
- End: Up to 90 days after start date
- Example: Start: Oct 20, End: Nov 20 (31 days) ✓

❌ **Invalid Selections:**
- Start date in the past
- End date before start date
- Period longer than 90 days
- Example: Start: Oct 1 (past), End: Oct 31 ✗

### Troubleshooting

#### "Insufficient historical data for forecasting"
**Cause**: Your restaurant has fewer than 2 days of order history
**Solution**: 
- Import historical order data via the Datasets feature
- Wait for more orders to accumulate
- Minimum recommended: 30 days of history

#### "Tanggal mulai harus di masa depan"
**Cause**: Selected start date is today or in the past
**Solution**: Select tomorrow or a later date

#### "Periode forecast tidak boleh lebih dari 90 hari"
**Cause**: Date range exceeds 90 days
**Solution**: Choose an end date within 90 days of start date

#### AI Summary Not Showing
**Cause**: Groq API key not configured or invalid
**Solution**: 
1. Check `.env` file has valid `GROQ_API_KEY`
2. Verify API key at https://console.groq.com
3. Check API rate limits
4. Review logs in `storage/logs/laravel.log`

#### Chart Not Displaying
**Cause**: JavaScript error or missing Chart.js library
**Solution**:
1. Check browser console for errors (F12)
2. Verify internet connection (Chart.js loads from CDN)
3. Clear browser cache
4. Try a different browser

## API Usage (Advanced)

### Generate Forecast Programmatically

```javascript
// Using Fetch API
fetch('/api/forecast/run', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        start_date: '2025-10-20',
        end_date: '2025-11-20',
        metrics: ['sales', 'profit', 'customer_count', 'peak_hours']
    })
})
.then(response => response.json())
.then(data => {
    console.log('Forecast:', data);
})
.catch(error => {
    console.error('Error:', error);
});
```

### Get Recent Forecasts

```javascript
fetch('/api/forecast', {
    headers: {
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    console.log('Recent forecasts:', data.data);
});
```

### View Specific Forecast

```javascript
const forecastId = 123;
fetch(`/api/forecast/${forecastId}`, {
    headers: {
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    console.log('Forecast details:', data.data);
});
```

## Understanding the Metrics

### Sales Forecast
- **Method**: Exponential smoothing with trend analysis
- **Factors**: Historical sales, day-of-week patterns, recent trends
- **Confidence**: Higher with consistent historical data

### Profit Prediction
- **Calculation**: Predicted sales × average profit margin (22%)
- **Accuracy**: Depends on cost consistency
- **Usage**: Budget planning, financial forecasting

### Visitor Count
- **Method**: Similar to sales, but based on party_size
- **Factors**: Historical traffic, seasonal patterns
- **Usage**: Staffing optimization, capacity planning

### Peak Hours
- **Analysis**: 90-day historical average per hour
- **Granularity**: Hourly breakdown, 7-day week view
- **Usage**: Staff scheduling, inventory preparation

### Accuracy Score
- **Calculation**: 100 - MAPE (Mean Absolute Percentage Error)
- **Range**: 50% - 99%
- **Interpretation**:
  - 90%+ = Excellent accuracy
  - 80-89% = Good accuracy
  - 70-79% = Fair accuracy
  - <70% = Poor accuracy (review historical data)

## Integration with Other Features

### Staffing Planner
Use peak hours data to:
- Schedule more staff during busy periods
- Reduce staff during slow periods
- Optimize labor costs

### Inventory Management
Use sales forecasts to:
- Order ingredients in advance
- Reduce waste from over-ordering
- Ensure availability during high-demand periods

### Menu Engineering
Use visitor count predictions to:
- Plan special menu items
- Schedule promotions
- Adjust pricing strategies

### What-If Analysis
Combine with what-if scenarios to:
- Test impact of menu changes
- Evaluate promotional campaigns
- Assess pricing adjustments

## Support & Feedback

For questions or issues:
1. Check the [full documentation](FORECAST_FEATURE.md)
2. Review error messages in the UI
3. Check Laravel logs: `storage/logs/laravel.log`
4. Contact your system administrator

## What's Next?

After setting up forecasts, explore:
- **What-If Lab**: Test scenarios before implementing
- **Staffing Planner**: Optimize team schedules
- **Reports & Export**: Share insights with stakeholders
- **Promotions**: Plan campaigns based on predictions
