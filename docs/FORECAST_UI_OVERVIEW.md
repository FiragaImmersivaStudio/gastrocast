# Forecast Feature - UI Overview

## Page Layout

```
┌─────────────────────────────────────────────────────────────────────┐
│  [GastroCast Header]                                                 │
│  Forecast & Insights                          [Run New Forecast]    │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│  ┌───────────────────────────────────────────────────────────────┐ │
│  │ 🧠 AI Forecast Summary                    llama-3.1-70b       │ │
│  │                                                                 │ │
│  │  Berdasarkan analisa data historis, restoran Anda              │ │
│  │  menunjukkan tren pertumbuhan yang stabil dengan prediksi      │ │
│  │  penjualan meningkat 12.5% untuk periode ini...                │ │
│  │                                                                 │ │
│  │  Action Items:                                                  │ │
│  │  • Tingkatkan stok bahan baku untuk jam sibuk                  │ │
│  │  • Pertimbangkan menambah staff di weekend                      │ │
│  │  • Optimalkan menu untuk meningkatkan profit margin             │ │
│  │                                                                 │ │
│  │  Generated in 2,456ms | Tokens: 487                            │ │
│  └───────────────────────────────────────────────────────────────┘ │
│                                                                       │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐  ┌───────────┐ │
│  │ 💰 SALES    │  │ 📈 PROFIT   │  │ 👥 VISITORS │  │ 📊 ACCURACY│ │
│  │             │  │             │  │             │  │            │ │
│  │ Rp 2,847,500│  │ Rp 626,450  │  │    1,247    │  │   87.5%   │ │
│  │ Predicted   │  │ Estimated   │  │  Expected   │  │ Historical │ │
│  │ Avg: Rp     │  │ ~22% margin │  │  Avg: 89/day│  │ Based on   │ │
│  │ 203,393/day │  │             │  │             │  │ data       │ │
│  └─────────────┘  └─────────────┘  └─────────────┘  └───────────┘ │
│                                                                       │
│  ┌─────────────────────────────────────┐  ┌────────────────────┐   │
│  │ Sales & Visitors Forecast           │  │ Peak Hours Heatmap │   │
│  │                                      │  │                    │   │
│  │     ┌──────────────────────────┐   │  │ Hour  M T W T F S S│   │
│  │  $  │     ╱╲     ╱╲            │   │  │ 06:00 □ □ □ □ □ □ □│   │
│  │ 3000│    ╱  ╲   ╱  ╲     ╱╲    │   │  │ 07:00 □ □ □ □ □ ░ ░│   │
│  │     │   ╱    ╲ ╱    ╲   ╱  ╲   │   │  │ 08:00 ░ ░ ░ ░ ░ ▓ ▓│   │
│  │ 2500│  ╱      ╳      ╲ ╱    ╲  │   │  │ ...                │   │
│  │     │ ╱      ╱ ╲      ╳      ╲ │   │  │ 12:00 ▓ ▓ ▓ ▓ ▓ █ █│   │
│  │ 2000│╱      ╱   ╲    ╱ ╲      ╲│   │  │ 13:00 ▓ ▓ ▓ ▓ ▓ █ █│   │
│  │     └──────────────────────────┘   │  │ ...                │   │
│  │     Oct 20  Oct 22  Oct 24  Oct 26│  │ 19:00 ▓ ▓ ▓ ▓ ▓ █ █│   │
│  │                                      │  │ 20:00 ▓ ▓ ▓ ▓ ▓ ▓ ▓│   │
│  │ ─── Predicted Sales (Left Axis)    │  │ 21:00 ░ ░ ░ ░ ░ ░ ░│   │
│  │ ─── Predicted Visitors (Right)     │  │ 22:00 □ □ □ □ □ □ □│   │
│  └─────────────────────────────────────┘  │ 23:00 □ □ □ □ □ □ □│   │
│                                             │                    │   │
│  ┌──────────────────────────────────────────┐ Legend:           │   │
│  │ Recent Forecasts                          │ □ Very Low       │   │
│  ├────────┬─────────┬─────┬─────────┬──────┤ ░ Low            │   │
│  │ Date   │ Period  │ Days│ Accuracy│ Model │ ▓ Medium         │   │
│  ├────────┼─────────┼─────┼─────────┼──────┤ █ High           │   │
│  │ Oct 18 │ Oct 20- │  14 │ 89.2% ✓ │ hybrid│                    │   │
│  │ 14:30  │ Nov 02  │     │         │      │                    │   │
│  ├────────┼─────────┼─────┼─────────┼──────┤                    │   │
│  │ Oct 15 │ Oct 17- │  30 │ 85.7% ✓ │ hybrid│                    │   │
│  │ 10:15  │ Nov 15  │     │         │      │                    │   │
│  └────────┴─────────┴─────┴─────────┴──────┘                    │   │
│                                             └────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
```

## Modal: Run New Forecast

```
┌─────────────────────────────────────────────────────┐
│  Run New Forecast                            [X]    │
├─────────────────────────────────────────────────────┤
│                                                      │
│  ⓘ Note: Maximum forecast period is 90 days.       │
│    Start date must be in the future.                │
│                                                      │
│  Start Date *              End Date *               │
│  [2025-10-20      ]        [2025-11-03      ]       │
│                                                      │
│  Forecast Metrics                                   │
│  ☑ Sales Revenue (Required)                         │
│  ☑ Profit Prediction (Required)                     │
│  ☑ Customer Count (Required)                        │
│  ☑ Peak Hours Analysis (Required)                   │
│                                                      │
│                                                      │
│                 [Cancel]  [▶ Run Forecast]          │
└─────────────────────────────────────────────────────┘
```

## Color Scheme

### AI Summary Card
- **Background**: White with blue border
- **Header**: Primary blue (#007bff)
- **Text**: Dark gray (#333)
- **Model badge**: Light blue pill

### Summary Cards
- **Sales**: Green icon and accent (#28a745)
- **Profit**: Blue icon and accent (#17a2b8)
- **Visitors**: Orange icon and accent (#ffc107)
- **Accuracy**: Primary blue icon and accent (#007bff)

### Chart
- **Sales line**: Teal (#4bc0c0)
- **Visitors line**: Orange (#ff9f40)
- **Background**: Light teal/orange with transparency

### Heatmap Colors
- **Very Low**: Light gray (#f8f9fa) - < 15 visitors
- **Low**: Light yellow (#fff3cd) - 15-29 visitors
- **Medium**: Yellow (#ffc107) - 30-49 visitors
- **High**: Red (#dc3545) - 50+ visitors

### Buttons
- **Primary**: Blue (#007bff) - Run Forecast
- **Secondary**: Gray (#6c757d) - Cancel
- **Outline**: Blue border - View buttons

## Interactive Elements

### Date Inputs
- Min date: Tomorrow
- Max period: 90 days from start
- Real-time validation
- Visual feedback (red border on error)

### Chart
- Hover to see exact values
- Tooltips with formatted numbers
- Legend toggle
- Responsive resizing

### Heatmap
- Hover to see visitor count
- Click to see hourly details
- Color transitions on hover

### Recent Forecasts
- Click "View" to load forecast
- Rows highlight on hover
- Badge colors for accuracy

## Responsive Behavior

### Desktop (>1200px)
- 4 summary cards in a row
- Chart takes 8/12 columns, heatmap 4/12
- Full table display

### Tablet (768-1200px)
- 2 summary cards per row
- Chart takes 8/12 columns, heatmap 4/12
- Scrollable table

### Mobile (<768px)
- 1 summary card per row
- Full-width chart
- Full-width heatmap (scrollable)
- Simplified table (cards)

## Loading States

### During Forecast Generation
```
┌─────────────────────────────────────────┐
│                                          │
│              ⌛ (spinner)                │
│                                          │
│         Generating Forecast...          │
│                                          │
│     This may take a few moments         │
│                                          │
└─────────────────────────────────────────┘
```

### Empty State (No Forecasts)
```
┌─────────────────────────────────────────┐
│  Recent Forecasts                        │
├─────────────────────────────────────────┤
│                                          │
│           📊 No forecasts yet            │
│                                          │
│  Click "Run New Forecast" to generate   │
│  your first forecast                     │
│                                          │
└─────────────────────────────────────────┘
```

## Error States

### Validation Error
```
┌─────────────────────────────────────────┐
│  ⚠ Tanggal mulai harus di masa depan    │
└─────────────────────────────────────────┘
```

### API Error
```
┌─────────────────────────────────────────┐
│  ❌ Gagal membuat forecast: Insufficient │
│     historical data                      │
└─────────────────────────────────────────┘
```

## Accessibility Features

- ✅ ARIA labels on interactive elements
- ✅ Keyboard navigation support
- ✅ Focus indicators
- ✅ Screen reader friendly
- ✅ Color contrast WCAG AA compliant
- ✅ Error messages announced
- ✅ Loading states announced

## Performance Features

- ✅ Lazy loading of Chart.js from CDN
- ✅ Debounced date validation
- ✅ Cached API responses
- ✅ Optimized DOM updates
- ✅ Progressive enhancement
- ✅ Graceful degradation

## Browser Compatibility

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)
