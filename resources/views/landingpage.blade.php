<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CustiCast - Smart Visitor & Dining Forecasting for Malls</title>
    <meta name="description" content="AI-powered forecasting platform for malls and F&B tenants. Predict customer flow and optimize performance using visitor data, weather, holidays, and events." />
    <meta name="author" content="CustiCast" />
    <meta name="keywords" content="mall analytics, F&B forecasting, visitor prediction, retail analytics, AI forecasting, customer flow" />

    <meta property="og:title" content="CustiCast - Smart Visitor & Dining Forecasting" />
    <meta property="og:description" content="Transform your mall and F&B operations with AI-powered forecasting that considers weather, holidays, and events." />
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
                  Predict Customer Flow.
                  <span class="text-primary">Optimize F&B Performance.</span>
                </h1>
                <p class="hero-subtitle">
                  CustiCast combines visitor data, transactions, and external conditions like weather, 
                  national holidays, and events to deliver accurate forecasts and actionable insights.
                </p>
              </div>
              
              <div class="hero-buttons">
                <button class="btn btn-hero btn-lg group">
                  Get Started
                  <svg class="icon-sm ml-2 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                  </svg>
                </button>
                <button class="btn btn-demo btn-lg group">
                  <svg class="icon-sm mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"></path>
                  </svg>
                  See Demo
                </button>
              </div>

              <!-- Key Stats -->
              <div class="hero-stats">
                <div class="stat">
                  <div class="stat-number">95%</div>
                  <div class="stat-label">Accuracy</div>
                </div>
                <div class="stat">
                  <div class="stat-number">24/7</div>
                  <div class="stat-label">Monitoring</div>
                </div>
                <div class="stat">
                  <div class="stat-number">15+</div>
                  <div class="stat-label">Data Sources</div>
                </div>
              </div>
            </div>

            <!-- Hero Image -->
            <div class="hero-image-container">
              <div class="hero-image">
                <img
                  src="assets/hero-dashboard.jpg"
                  alt="CustiCast Analytics Dashboard"
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
                    <div class="floating-card-number">+12%</div>
                    <div class="floating-card-label">Traffic Increase</div>
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
              Powered by AI and designed specifically for malls and F&B businesses
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
                Uses AI and machine learning to predict visitor traffic and F&B sales with exceptional accuracy.
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
                Considers not just mall traffic but also external factors like weather, public holidays, and events.
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
                Interactive charts, heatmaps, and statistics to show traffic flow, peak hours, and conversion.
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
                Recommendations for staffing, inventory, and promotions based on intelligent predictions.
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
            <h2 class="section-title">Built for Every Stakeholder</h2>
            <p class="section-subtitle">
              Tailored insights for different roles in the mall ecosystem
            </p>
          </div>

          <div class="use-cases-grid">
            <div class="use-case-card">
              <div class="use-case-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
              <h3 class="use-case-title">Mall Management</h3>
              <p class="use-case-description">
                Plan staffing schedules, optimize marketing campaigns, and coordinate mall-wide events based on predicted traffic patterns.
              </p>
              <ul class="use-case-benefits">
                <li>Staff optimization during peak hours</li>
                <li>Event planning with traffic forecasts</li>
                <li>Marketing budget allocation</li>
              </ul>
            </div>

            <div class="use-case-card">
              <div class="use-case-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 3H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
              </div>
              <h3 class="use-case-title">F&B Tenants</h3>
              <p class="use-case-description">
                Predict customer demand, reduce food waste, and optimize inventory management with accurate sales forecasting.
              </p>
              <ul class="use-case-benefits">
                <li>Demand-based inventory planning</li>
                <li>Waste reduction strategies</li>
                <li>Promotional timing optimization</li>
              </ul>
            </div>

            <div class="use-case-card">
              <div class="use-case-icon">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <h3 class="use-case-title">Analytics Teams</h3>
              <p class="use-case-description">
                Monitor performance trends, identify opportunities, and improve operational efficiency with comprehensive data insights.
              </p>
              <ul class="use-case-benefits">
                <li>Performance trend analysis</li>
                <li>Operational efficiency metrics</li>
                <li>Strategic planning support</li>
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
                See the Future of Mall & F&B Analytics
              </h2>
              <p class="cta-subtitle">
                CustiCast helps you make smarter decisions by combining your data with external conditions. 
                Join the revolution in retail forecasting.
              </p>
            </div>

            <!-- Key Value Props -->
            <div class="cta-stats">
              <div class="cta-stat">
                <div class="cta-stat-number">95%</div>
                <div class="cta-stat-label">Forecast Accuracy</div>
              </div>
              <div class="cta-stat">
                <div class="cta-stat-number">15+</div>
                <div class="cta-stat-label">External Data Sources</div>
              </div>
              <div class="cta-stat">
                <div class="cta-stat-number">24/7</div>
                <div class="cta-stat-label">Real-time Monitoring</div>
              </div>
            </div>

            <!-- CTA Buttons -->
            <div class="cta-buttons">
              <button class="btn btn-cta-primary">
                <svg class="icon-sm mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Request a Demo
                <svg class="icon-sm ml-2 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7"></path>
                </svg>
              </button>
              <button class="btn btn-cta-secondary">
                <svg class="icon-sm mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Contact Sales
              </button>
            </div>

            <!-- Trust Indicators -->
            <div class="trust-indicators">
              <p class="trust-text">
                Trusted by leading malls and F&B chains across the region
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
                Smart visitor and dining forecasting for malls and F&B tenants. 
                Leveraging AI to predict customer flow and optimize business performance.
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
            Powered by AI • Built for the future of retail
          </div>
        </div>
      </div>
    </footer>

    <script src="script.js"></script>
  </body>
</html>