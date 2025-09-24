<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>CustiCast - Restaurant Intelligence Platform</title>
    <meta name="description" content="AI-powered restaurant intelligence platform for F&B businesses. Predict customer flow, optimize operations, and boost profitability with smart forecasting and actionable insights." />
    <meta name="author" content="CustiCast" />
    <meta name="keywords" content="restaurant analytics, F&B forecasting, restaurant intelligence, operational optimization, AI forecasting, customer flow, inventory management" />

    <meta property="og:title" content="CustiCast - Restaurant Intelligence Platform" />
    <meta property="og:description" content="Transform your restaurant operations with AI-powered forecasting, inventory optimization, and smart staffing recommendations." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://lovable.dev/opengraph-image-p98pqg.png" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@lovable_dev" />
    <meta name="twitter:image" content="https://lovable.dev/opengraph-image-p98pqg.png" />
    
    <link rel="stylesheet" href="styles.css">
    <link rel="canonical" href="https://custicast.com/">
  </head>

  <body>
    <!-- Navigation -->
    <nav id="navigation" class="navigation">
      <div class="nav-container">
        <div class="nav-content">
          <!-- Logo -->
          <div class="nav-logo">
            <h1 class="logo-text">CustiCast</h1>
          </div>

          <!-- Desktop Menu -->
          <div class="desktop-menu">
            <div class="menu-items">
              <button onclick="scrollToSection('#home')" class="menu-item">Home</button>
              <button onclick="scrollToSection('#features')" class="menu-item">Features</button>
              <button onclick="scrollToSection('#how-it-works')" class="menu-item">How It Works</button>
              <button onclick="scrollToSection('#analytics')" class="menu-item">Analytics</button>
              <button onclick="scrollToSection('#use-cases')" class="menu-item">Use Cases</button>
              <button onclick="scrollToSection('#contact')" class="menu-item">Contact</button>
            </div>
          </div>

          <!-- CTA Button -->
          <div class="desktop-cta">
            <button class="btn btn-hero btn-lg">Request Demo</button>
          </div>

          <!-- Mobile menu button -->
          <div class="mobile-menu-btn">
            <button id="menu-toggle" class="menu-toggle">
              <svg id="menu-icon" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
              <svg id="close-icon" class="icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu hidden">
          <div class="mobile-menu-content">
            <button onclick="scrollToSection('#home')" class="mobile-menu-item">Home</button>
            <button onclick="scrollToSection('#features')" class="mobile-menu-item">Features</button>
            <button onclick="scrollToSection('#how-it-works')" class="mobile-menu-item">How It Works</button>
            <button onclick="scrollToSection('#analytics')" class="mobile-menu-item">Analytics</button>
            <button onclick="scrollToSection('#use-cases')" class="mobile-menu-item">Use Cases</button>
            <button onclick="scrollToSection('#contact')" class="mobile-menu-item">Contact</button>
            <div class="mobile-cta">
              <button class="btn btn-hero btn-lg w-full">Request Demo</button>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <!-- Hero Section -->
      <section id="home" class="hero-section">
        <div class="container">
          <div class="hero-grid">
            <!-- Content -->
            <div class="hero-content">
              <div class="hero-text">
                <h1 class="hero-title">
                  Predict Customer Demand.
                  <span class="text-primary">Optimize Restaurant Performance.</span>
                </h1>
                <p class="hero-subtitle">
                  CustiCast combines transaction data, customer behavior, and external factors like weather and holidays 
                  to deliver precise forecasts, inventory optimization, and staffing recommendations for your restaurant.
                </p>
              </div>
              
              <div class="hero-buttons">
                <a href="{{ route('dashboard') }}" class="btn btn-hero btn-lg group">
                  Get Started
                  <svg class="icon-sm ml-2 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                  </svg>
                </a>
                <button class="btn btn-demo btn-lg group" onclick="showDemoModal()">
                  <svg class="icon-sm mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"></path>
                  </svg>
                  See Demo
                </button>
              </div>

              <!-- Key Stats -->
              <div class="hero-stats">
                <div class="stat">
                  <div class="stat-number">98%</div>
                  <div class="stat-label">Forecast Accuracy</div>
                </div>
                <div class="stat">
                  <div class="stat-number">25%</div>
                  <div class="stat-label">Cost Reduction</div>
                </div>
                <div class="stat">
                  <div class="stat-number">12+</div>
                  <div class="stat-label">Restaurant Modules</div>
                </div>
              </div>
            </div>

            <!-- Hero Image -->
            <div class="hero-image-container">
              <div class="hero-image">
                <img
                  src="assets/hero-dashboard.jpg"
                  alt="CustiCast Restaurant Intelligence Dashboard"
                />
                <div class="hero-overlay"></div>
              </div>
              
              <!-- Floating Stats Card -->
              <div class="floating-card">
                <div class="floating-card-content">
                  <div class="floating-card-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                    </svg>
                  </div>
                  <div>
                    <div class="floating-card-number">+18%</div>
                    <div class="floating-card-label">Revenue Increase</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section id="features" class="features-section">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Why CustiCast?</h2>
            <p class="section-subtitle">
              Powered by AI and designed specifically for restaurant and F&B operations
            </p>
          </div>

          <div class="features-grid">
            <div class="feature-card">
              <div class="feature-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <h3 class="feature-title">Smart Forecasting</h3>
              <p class="feature-description">
                Uses AI and machine learning to predict customer demand, sales, and optimal inventory levels with exceptional accuracy.
              </p>
            </div>

            <div class="feature-card">
              <div class="feature-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                </svg>
              </div>
              <h3 class="feature-title">Multi-Condition Inputs</h3>
              <p class="feature-description">
                Considers transaction history, seasonal patterns, weather conditions, holidays, and local events to provide comprehensive insights.
              </p>
            </div>

            <div class="feature-card">
              <div class="feature-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <h3 class="feature-title">Detailed Analytics</h3>
              <p class="feature-description">
                Interactive dashboards, sales heatmaps, and performance metrics to track revenue, customer patterns, and operational efficiency.
              </p>
            </div>

            <div class="feature-card">
              <div class="feature-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
              </div>
              <h3 class="feature-title">Actionable Insights</h3>
              <p class="feature-description">
                Smart recommendations for staffing schedules, inventory management, menu optimization, and promotional strategies.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- How It Works Section -->
      <section id="how-it-works" class="how-it-works-section">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">How CustiCast Works</h2>
            <p class="section-subtitle">
              Three simple steps to transform your data into actionable business insights
            </p>
          </div>

          <div class="steps-container">
            <div class="connection-line"></div>
            
            <div class="steps-grid">
              <div class="step-card">
                <div class="step-content">
                  <div class="step-number">01</div>
                  <div class="step-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                  </div>
                  <div class="step-text">
                    <h3 class="step-title">Input Your Data</h3>
                    <p class="step-description">
                      Mall traffic counters, POS transactions, and optional external data upload through our secure platform.
                    </p>
                  </div>
                </div>
                <div class="step-arrow">
                  <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                  </svg>
                </div>
              </div>

              <div class="step-card">
                <div class="step-content">
                  <div class="step-number">02</div>
                  <div class="step-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                  </div>
                  <div class="step-text">
                    <h3 class="step-title">AI Forecasting Engine</h3>
                    <p class="step-description">
                      Advanced models analyze time series data combined with external conditions for accurate predictions.
                    </p>
                  </div>
                </div>
                <div class="step-arrow">
                  <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                  </svg>
                </div>
              </div>

              <div class="step-card">
                <div class="step-content">
                  <div class="step-number">03</div>
                  <div class="step-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                  </div>
                  <div class="step-text">
                    <h3 class="step-title">Insight Dashboard</h3>
                    <p class="step-description">
                      View forecasts as detailed charts and receive natural language explanations for easy understanding.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Analytics Section -->
      <section id="analytics" class="analytics-section">
        <div class="container">
          <div class="analytics-grid">
            <div class="analytics-content">
              <h2 class="analytics-title">AI-Powered Analytics</h2>
              <p class="analytics-subtitle">
                Transform raw data into crystal-clear business intelligence
              </p>
              
              <div class="analytics-features">
                <div class="analytics-feature">
                  <div class="analytics-feature-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                  </div>
                  <div>
                    <h3 class="analytics-feature-title">Time Series Forecasting</h3>
                    <p class="analytics-feature-description">Predict visitor patterns and sales trends with 95% accuracy</p>
                  </div>
                </div>

                <div class="analytics-feature">
                  <div class="analytics-feature-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                  </div>
                  <div>
                    <h3 class="analytics-feature-title">Interactive Heatmaps</h3>
                    <p class="analytics-feature-description">Visualize traffic flow patterns by time and location</p>
                  </div>
                </div>

                <div class="analytics-feature">
                  <div class="analytics-feature-icon">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                  </div>
                  <div>
                    <h3 class="analytics-feature-title">Natural Language Insights</h3>
                    <p class="analytics-feature-description">Get explanations in plain English for all predictions</p>
                  </div>
                </div>
              </div>

              <div class="ai-insight">
                <div class="ai-insight-icon">
                  <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                  </svg>
                </div>
                <div class="ai-insight-content">
                  <h4 class="ai-insight-title">AI Insight</h4>
                  <p class="ai-insight-text">
                    "Next weekend traffic is expected to rise by 12% due to public holiday and mall-wide promotions. 
                    Consider increasing staff by 15% and preparing additional inventory for F&B outlets."
                  </p>
                </div>
              </div>
            </div>

            <div class="analytics-image">
              <img src="assets/analytics-charts.jpg" alt="CustiCast Analytics Dashboard" />
            </div>
          </div>
        </div>
      </section>

      <!-- Why CustiCast Section -->
      <section class="why-section">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Beyond Traditional Forecasting</h2>
            <p class="section-subtitle">
              See how CustiCast outperforms generic solutions
            </p>
          </div>

          <div class="comparison-grid">
            <div class="comparison-card traditional">
              <h3 class="comparison-title">Traditional Solutions</h3>
              <ul class="comparison-list">
                <li class="comparison-item negative">Only historical data analysis</li>
                <li class="comparison-item negative">Generic retail models</li>
                <li class="comparison-item negative">Complex technical outputs</li>
                <li class="comparison-item negative">Limited external factors</li>
              </ul>
            </div>

            <div class="comparison-divider">
              <div class="vs-badge">VS</div>
            </div>

            <div class="comparison-card custicast">
              <h3 class="comparison-title">CustiCast</h3>
              <ul class="comparison-list">
                <li class="comparison-item positive">Multi-source data integration</li>
                <li class="comparison-item positive">Mall & F&B specialized models</li>
                <li class="comparison-item positive">Natural language insights</li>
                <li class="comparison-item positive">15+ external conditions</li>
              </ul>
            </div>
          </div>

          <div class="differentiators">
            <div class="differentiator">
              <div class="differentiator-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                </svg>
              </div>
              <div>
                <h4 class="differentiator-title">Weather Integration</h4>
                <p class="differentiator-description">Real-time weather data affects foot traffic patterns</p>
              </div>
            </div>

            <div class="differentiator">
              <div class="differentiator-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div>
                <h4 class="differentiator-title">Holiday Detection</h4>
                <p class="differentiator-description">Automatic adjustment for public holidays and events</p>
              </div>
            </div>

            <div class="differentiator">
              <div class="differentiator-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
              <div>
                <h4 class="differentiator-title">Mall-Specific Models</h4>
                <p class="differentiator-description">Purpose-built for retail and F&B environments</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Use Cases Section -->
      <section id="use-cases" class="use-cases-section">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Built for Every Restaurant Role</h2>
            <p class="section-subtitle">
              Tailored insights for different roles in your restaurant operation
            </p>
          </div>

          <div class="use-cases-grid">
            <div class="use-case-card">
              <div class="use-case-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
              <h3 class="use-case-title">Restaurant Owners</h3>
              <p class="use-case-description">
                Make strategic decisions with comprehensive insights into revenue trends, operational efficiency, and growth opportunities.
              </p>
              <ul class="use-case-benefits">
                <li>Revenue optimization strategies</li>
                <li>Multi-location performance comparison</li>
                <li>ROI analysis for marketing campaigns</li>
              </ul>
            </div>

            <div class="use-case-card">
              <div class="use-case-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 3H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
              </div>
              <h3 class="use-case-title">Restaurant Managers</h3>
              <p class="use-case-description">
                Optimize daily operations with accurate demand forecasting, smart staffing recommendations, and inventory management.
              </p>
              <ul class="use-case-benefits">
                <li>Demand-based inventory planning</li>
                <li>Staff scheduling optimization</li>
                <li>Waste reduction strategies</li>
              </ul>
            </div>

            <div class="use-case-card">
              <div class="use-case-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <h3 class="use-case-title">Operations Teams</h3>
              <p class="use-case-description">
                Monitor kitchen efficiency, track service times, and identify bottlenecks with real-time operational analytics.
              </p>
              <ul class="use-case-benefits">
                <li>Kitchen performance monitoring</li>
                <li>Service time optimization</li>
                <li>Quality control tracking</li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <!-- Call to Action Section -->
      <section id="contact" class="cta-section">
        <!-- Background Pattern -->
        <div class="cta-pattern">
          <div class="pattern-shape pattern-1"></div>
          <div class="pattern-shape pattern-2"></div>
          <div class="pattern-shape pattern-3"></div>
          <div class="pattern-shape pattern-4"></div>
          
          <div class="pattern-icon pattern-icon-1">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v4h8V3h-8z"/>
            </svg>
          </div>
          <div class="pattern-icon pattern-icon-2">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
              <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
            </svg>
          </div>
        </div>

        <div class="container">
          <div class="cta-content">
            <div class="cta-text">
              <h2 class="cta-title">
                Transform Your Restaurant with AI Intelligence
              </h2>
              <p class="cta-subtitle">
                CustiCast helps restaurant owners and managers make smarter decisions by combining your operational data with intelligent forecasting. 
                Join the revolution in restaurant analytics.
              </p>
            </div>

            <!-- Key Value Props -->
            <div class="cta-stats">
              <div class="cta-stat">
                <div class="cta-stat-number">98%</div>
                <div class="cta-stat-label">Forecast Accuracy</div>
              </div>
              <div class="cta-stat">
                <div class="cta-stat-number">25%</div>
                <div class="cta-stat-label">Cost Reduction</div>
              </div>
              <div class="cta-stat">
                <div class="cta-stat-number">24/7</div>
                <div class="cta-stat-label">Real-time Insights</div>
              </div>
            </div>

            <!-- CTA Buttons -->
            <div class="cta-buttons">
              <button class="btn btn-cta-primary" onclick="showRequestDemoModal()">
                <svg class="icon-sm mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Request a Demo
                <svg class="icon-sm ml-2 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                </svg>
              </button>
              <button class="btn btn-cta-secondary" onclick="showContactModal()">
                <svg class="icon-sm mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Contact Sales
              </button>
            </div>

            <!-- Trust Indicators -->
            <div class="trust-indicators">
              <p class="trust-text">
                Trusted by restaurants and F&B chains across Southeast Asia
              </p>
              <div class="trust-logos">
                <div class="trust-logo"></div>
                <div class="trust-logo"></div>
                <div class="trust-logo"></div>
                <div class="trust-logo"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-grid">
          <!-- Company Info -->
          <div class="footer-company">
            <div>
              <h3 class="footer-logo">CustiCast</h3>
              <p class="footer-description">
                Restaurant Intelligence Platform powered by AI. 
                Optimize operations, predict demand, and boost profitability with smart forecasting and actionable insights.
              </p>
            </div>
            
            <div class="footer-contact">
              <div class="footer-contact-item">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span>hello@custicast.com</span>
              </div>
              <div class="footer-contact-item">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <span>+65 1234 5678</span>
              </div>
              <div class="footer-contact-item">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Singapore, Southeast Asia</span>
              </div>
            </div>

            <div class="footer-social">
              <button class="social-btn">
                <svg class="icon" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </button>
              <button class="social-btn">
                <svg class="icon" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- Product Links -->
          <div class="footer-section">
            <h4 class="footer-section-title">Product</h4>
            <ul class="footer-links">
              <li><button onclick="scrollToSection('#features')" class="footer-link">Features</button></li>
              <li><button onclick="scrollToSection('#how-it-works')" class="footer-link">How It Works</button></li>
              <li><button onclick="scrollToSection('#analytics')" class="footer-link">Analytics</button></li>
              <li><button onclick="scrollToSection('#use-cases')" class="footer-link">Use Cases</button></li>
            </ul>
          </div>

          <!-- Company Links -->
          <div class="footer-section">
            <h4 class="footer-section-title">Company</h4>
            <ul class="footer-links">
              <li><a href="#" class="footer-link">About Us</a></li>
              <li><a href="#" class="footer-link">Privacy Policy</a></li>
              <li><a href="#" class="footer-link">Terms of Service</a></li>
              <li><button onclick="scrollToSection('#contact')" class="footer-link">Contact</button></li>
            </ul>
          </div>

          <!-- Support Links -->
          <div class="footer-section">
            <h4 class="footer-section-title">Support</h4>
            <ul class="footer-links">
              <li><a href="#" class="footer-link">Documentation</a></li>
              <li><a href="#" class="footer-link">API Reference</a></li>
              <li><a href="#" class="footer-link">Help Center</a></li>
              <li><a href="#" class="footer-link">System Status</a></li>
            </ul>
          </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
          <div class="footer-copyright">
            © 2024 CustiCast. All rights reserved.
          </div>
          <div class="footer-tagline">
            Powered by AI • Built for restaurant success
          </div>
        </div>
      </div>
    </footer>

    <!-- Demo Video Modal -->
    <div id="demoModal" class="modal" style="display: none;">
      <div class="modal-content">
        <div class="modal-header">
          <h3>CustiCast Demo Video</h3>
          <span class="close" onclick="closeDemoModal()">&times;</span>
        </div>
        <div class="modal-body">
          <div class="video-wrapper">
            <iframe id="demoVideo" width="100%" height="400" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Request Demo Modal -->
    <div id="requestDemoModal" class="modal" style="display: none;">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Request a Demo</h3>
          <span class="close" onclick="closeRequestDemoModal()">&times;</span>
        </div>
        <div class="modal-body">
          <form id="requestDemoForm">
            <div class="form-group">
              <label for="fullName">Full Name *</label>
              <input type="text" id="fullName" name="full_name" required>
            </div>
            <div class="form-group">
              <label for="email">Email Address *</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="company">Restaurant/Company Name *</label>
              <input type="text" id="company" name="company" required>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
              <label for="restaurantType">Restaurant Type</label>
              <select id="restaurantType" name="restaurant_type">
                <option value="">Select Type</option>
                <option value="fast-food">Fast Food</option>
                <option value="casual-dining">Casual Dining</option>
                <option value="fine-dining">Fine Dining</option>
                <option value="cafe">Cafe</option>
                <option value="food-court">Food Court</option>
                <option value="chain">Restaurant Chain</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="locations">Number of Locations</label>
              <select id="locations" name="locations">
                <option value="1">1</option>
                <option value="2-5">2-5</option>
                <option value="6-10">6-10</option>
                <option value="11-25">11-25</option>
                <option value="25+">25+</option>
              </select>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" rows="4" placeholder="Tell us about your restaurant and what you'd like to see in the demo..."></textarea>
            </div>
            <div class="form-actions">
              <button type="button" class="btn btn-secondary" onclick="closeRequestDemoModal()">Cancel</button>
              <button type="submit" class="btn btn-primary">Send Demo Request</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Contact Sales Modal -->
    <div id="contactModal" class="modal" style="display: none;">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Contact Sales</h3>
          <span class="close" onclick="closeContactModal()">&times;</span>
        </div>
        <div class="modal-body">
          <form id="contactForm">
            <div class="form-group">
              <label for="contactName">Full Name *</label>
              <input type="text" id="contactName" name="full_name" required>
            </div>
            <div class="form-group">
              <label for="contactEmail">Email Address *</label>
              <input type="email" id="contactEmail" name="email" required>
            </div>
            <div class="form-group">
              <label for="contactCompany">Restaurant/Company Name *</label>
              <input type="text" id="contactCompany" name="company" required>
            </div>
            <div class="form-group">
              <label for="contactPhone">Phone Number</label>
              <input type="tel" id="contactPhone" name="phone">
            </div>
            <div class="form-group">
              <label for="inquiry">Inquiry Type</label>
              <select id="inquiry" name="inquiry_type">
                <option value="pricing">Pricing Information</option>
                <option value="features">Feature Questions</option>
                <option value="integration">Integration Support</option>
                <option value="enterprise">Enterprise Solutions</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="contactMessage">Message *</label>
              <textarea id="contactMessage" name="message" rows="4" placeholder="How can we help you?" required></textarea>
            </div>
            <div class="form-actions">
              <button type="button" class="btn btn-secondary" onclick="closeContactModal()">Cancel</button>
              <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <style>
      .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
      }
      
      .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.3s;
      }
      
      .modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #7A001F;
        color: white;
        border-radius: 12px 12px 0 0;
      }
      
      .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
      }
      
      .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
      }
      
      .close:hover {
        opacity: 0.7;
      }
      
      .modal-body {
        padding: 25px;
      }
      
      .video-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
      }
      
      .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
      }
      
      .form-group input,
      .form-group select,
      .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s, box-shadow 0.3s;
      }
      
      .form-group input:focus,
      .form-group select:focus,
      .form-group textarea:focus {
        outline: none;
        border-color: #7A001F;
        box-shadow: 0 0 0 3px rgba(122, 0, 31, 0.1);
      }
      
      .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
      }
      
      .btn {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
      }
      
      .btn-primary {
        background-color: #7A001F;
        color: white;
      }
      
      .btn-primary:hover {
        background-color: #5a0017;
        transform: translateY(-1px);
      }
      
      .btn-secondary {
        background-color: #6c757d;
        color: white;
      }
      
      .btn-secondary:hover {
        background-color: #545b62;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }
      
      @keyframes slideIn {
        from { 
          opacity: 0;
          transform: translateY(-50px);
        }
        to { 
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      @media (max-width: 768px) {
        .modal-content {
          margin: 10px;
          width: calc(100% - 20px);
        }
        
        .modal-body {
          padding: 20px;
        }
        
        .form-actions {
          flex-direction: column;
        }
        
        .btn {
          width: 100%;
        }
      }
    </style>

    <script src="script.js"></script>
  </body>
</html>