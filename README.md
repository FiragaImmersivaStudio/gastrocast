# CustiCast - Restaurant Intelligence Platform

A comprehensive multi-tenant restaurant analytics and forecasting platform built with **Laravel 10**, featuring AI-powered insights, operational optimization, and advanced reporting capabilities.

## 🎯 Overview

CustiCast is a sophisticated restaurant intelligence platform that provides:
- **Multi-tenant Architecture**: Users can manage multiple restaurant locations
- **AI-Powered Insights**: LLM-generated summaries and actionable recommendations
- **Advanced Forecasting**: Predict traffic, revenue, and demand patterns
- **Operational Optimization**: Staff scheduling, inventory management, menu engineering
- **Real-time Analytics**: Interactive dashboards with Highcharts visualizations

## 🏗️ Architecture

### Technology Stack
- **Backend**: Laravel 10 (PHP 8.2+)
- **Database**: MySQL/PostgreSQL/SQLite
- **Authentication**: Laravel Sanctum
- **UI Framework**: Bootstrap 5 with custom theming
- **Charts**: Highcharts
- **Frontend**: jQuery + AJAX
- **PDF Generation**: DomPDF
- **Permissions**: Spatie Laravel Permission
- **Activity Logging**: Spatie Laravel ActivityLog
- **LLM Integration**: Groq API / Router API

### Database Schema
The platform includes 24+ tables covering:
- **Multi-tenancy**: Users, restaurants, role-based access
- **Operations**: Orders, menu items, inventory, staff management
- **Analytics**: Hourly/daily metrics, forecasts, LLM summaries
- **Advanced Features**: What-if scenarios, promotions, kitchen workflow

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- Database (MySQL/PostgreSQL/SQLite)
- Redis (optional, for sessions/cache)

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/FiragaImmersivaStudio/gastrocast.git
cd gastrocast
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure your `.env` file**
```env
APP_NAME="CustiCast"
DB_CONNECTION=mysql
DB_DATABASE=custicast
DB_USERNAME=your_username
DB_PASSWORD=your_password

# LLM Integration
LLM_PROVIDER=groq
GROQ_API_KEY=your_groq_api_key_here

# Feature Flags
EMAIL_VERIFICATION_ENABLED=true
WHATIF_ENABLED=true

# Theme Colors
THEME_PRIMARY=#7A001F
THEME_ACCENT=#FFC107
```

5. **Database setup**
```bash
php artisan migrate
php artisan db:seed
```

6. **Build assets**
```bash
npm run build
```

7. **Start the development server**
```bash
php artisan serve
```

## 📊 Core Features

### 1. Overview Dashboard
- **KPI Cards**: Visitors, Transactions, GMV, Conversion Rate, AOV, MAPE
- **Forecast Charts**: Time series with confidence intervals
- **LLM Summaries**: AI-generated insights and recommendations
- **Quick Actions**: Generate forecasts, export reports

### 2. Restaurant Management
- **Multi-location Support**: Each restaurant = separate tenant
- **Role-based Access**: Owner, Manager, Staff permissions
- **Settings**: Operating hours, contact info, preferences
- **Activity Logging**: Track all changes and access

### 3. Data & Analytics
- **CSV Import**: Orders, menu items, inventory, staff data
- **Data Validation**: Automatic error detection and reporting
- **Forecasting Engine**: Time series forecasting with confidence intervals
- **Performance Metrics**: MAPE, MAE, RMSE

### 4. Operational Optimization
- **Staffing Planner**: Demand-based scheduling
- **Inventory Management**: Safety stock, reorder points
- **Menu Engineering**: Popularity vs. Profitability analysis
- **What-If Laboratory**: Scenario modeling and A/B comparisons

## 🔧 API Endpoints

All API endpoints are defined in `routes/web.php` with the `/api` prefix:

### Authentication
- `POST /api/auth/login` - User login with Remember Me
- `POST /api/auth/register` - User registration
- `POST /api/auth/logout` - User logout

### Restaurants
- `GET /api/restaurants` - List user's restaurants
- `POST /api/restaurants` - Create new restaurant
- `PUT /api/restaurants/{id}` - Update restaurant

### Forecasting
- `POST /api/forecast/run` - Generate forecast
- `GET /api/forecast/summary` - Get LLM summary
- `GET /api/forecast/{id}` - Get forecast details

### Analytics
- `GET /api/metrics/overview` - Dashboard KPIs
- `GET /api/metrics/trends` - Time series data
- `GET /api/metrics/heatmap` - Hour×Day heatmap data

## 🗂️ Data Import Formats

### Orders CSV
```csv
order_no,order_dt,channel,gross_amount,net_amount,waiting_time_sec,party_size
ORD-001,2024-01-15 12:30:00,dine_in,45.50,42.75,720,2
```

### Menu Items CSV
```csv
sku,name,category,cogs,price,is_active
BURGER-001,Classic Burger,Mains,8.50,15.95,true
```

### Inventory Items CSV
```csv
sku,name,uom,safety_stock,reorder_point
BEEF-PATTY,Beef Patty,pcs,50,20
```

## 🎨 Design System

### Color Palette
- **Primary**: `#7A001F` (Maroon)
- **Accent**: `#FFC107` (Yellow)
- **Neutral**: Various shades of gray

### UI Components
- **Cards**: Rounded corners, subtle shadows
- **Tables**: Responsive with pagination
- **Charts**: Highcharts with custom theming
- **Forms**: Bootstrap-styled with validation
- **Navigation**: Collapsible sidebar + top navbar

## 🔐 Security & Permissions

### Authentication
- **Laravel Sanctum**: Stateful authentication for SPAs
- **CSRF Protection**: All forms protected
- **Email Verification**: Optional via system parameters
- **Remember Me**: Extended session duration

### Authorization
- **Multi-tenant Scoping**: Automatic data isolation
- **Role-based Access**: Owner > Manager > Staff hierarchy
- **Route Protection**: Middleware-based access control

## 🤖 AI & LLM Integration

### Supported Providers
- **Groq**: Fast inference with Llama models
- **Router API**: Internal model routing system

### Use Cases
- **Executive Summaries**: Weekly performance insights
- **Forecasting Explanations**: Why metrics are trending
- **Actionable Recommendations**: Specific next steps
- **Anomaly Interpretation**: Unusual pattern explanations

## 📞 Support & Contributing

### Demo Account
- **Email**: `demo@custicast.com`
- **Password**: `demo123`
- **Restaurants**: 2 demo locations with sample data

### Sample Data
The seeder creates:
- 1 demo user account
- 2 sample restaurants
- 3 months of historical orders
- Sample menu items and inventory
- Demo staff and schedules

## 📝 License

This project is licensed under the MIT License.

---

**Built with ❤️ for the restaurant industry**

Transform your restaurant operations with data-driven insights and AI-powered recommendations.