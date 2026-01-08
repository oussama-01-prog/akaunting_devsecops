<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Akaunting - Free Accounting Software for Small Businesses</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary: #10B981;
      --primary-light: #34D399;
      --primary-dark: #059669;
      --secondary: #3B82F6;
      --accent: #8B5CF6;
      --text: #111827;
      --text-light: #6B7280;
      --text-lighter: #9CA3AF;
      --border: #E5E7EB;
      --border-light: #F3F4F6;
      --bg-light: #F9FAFB;
      --bg-white: #FFFFFF;
      --glass-bg: rgba(255, 255, 255, 0.8);
      --glass-border: rgba(255, 255, 255, 0.2);
      --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
      --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      --radius: 12px;
      --radius-lg: 20px;
      --radius-xl: 30px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    html {
      scroll-behavior: smooth;
    }
    
    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      color: var(--text);
      background: var(--bg-white);
      line-height: 1.6;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    
    a {
      color: inherit;
      text-decoration: none;
      transition: var(--transition);
    }
    
    .container {
      width: 100%;
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 24px;
    }
    
    /* Enhanced Navbar */
    .nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      z-index: 1000;
      transition: var(--transition);
      padding: 8px 0;
    }
    
    .nav.scrolled {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: var(--shadow-lg);
      border-bottom: 1px solid rgba(229, 231, 235, 0.5);
    }
    
    .nav-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 0;
    }
    
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 900;
      font-size: 1.5rem;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .logo {
      width: 44px;
      height: 44px;
      border-radius: 14px;
      background: var(--gradient-primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 900;
      font-size: 1.8rem;
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
      transition: var(--transition);
    }
    
    .brand:hover .logo {
      transform: rotate(15deg) scale(1.1);
    }
    
    .nav-links {
      display: flex;
      gap: 32px;
      align-items: center;
    }
    
    .nav-link {
      font-weight: 600;
      font-size: 0.95rem;
      color: var(--text-light);
      position: relative;
      padding: 8px 0;
    }
    
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--gradient-primary);
      transition: var(--transition);
    }
    
    .nav-link:hover {
      color: var(--primary);
    }
    
    .nav-link:hover::after {
      width: 100%;
    }
    
    .nav-link.active {
      color: var(--primary);
      font-weight: 700;
    }
    
    .nav-link.active::after {
      width: 100%;
    }
    
    .nav-actions {
      display: flex;
      gap: 16px;
      align-items: center;
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 28px;
      border-radius: var(--radius);
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      border: none;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }
    
    .btn:hover::before {
      left: 100%;
    }
    
    .btn-outline {
      background: transparent;
      color: var(--text);
      border: 2px solid var(--border);
    }
    
    .btn-outline:hover {
      border-color: var(--primary);
      color: var(--primary);
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }
    
    .btn-primary {
      background: var(--gradient-primary);
      color: white;
      border: none;
    }
    
    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(16, 185, 129, 0.4);
    }
    
    /* Premium Hero Section */
    .hero-section {
      padding: 160px 0 100px;
      background: linear-gradient(135deg, #F0FDF4 0%, #F9FAFB 100%);
      position: relative;
      overflow: hidden;
    }
    
    .hero-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }
    
    .hero-bg::before {
      content: '';
      position: absolute;
      top: -300px;
      right: -200px;
      width: 800px;
      height: 800px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0) 70%);
    }
    
    .hero-bg::after {
      content: '';
      position: absolute;
      bottom: -300px;
      left: -200px;
      width: 600px;
      height: 600px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0) 70%);
    }
    
    .hero {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 80px;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    
    .hero-content {
      max-width: 600px;
    }
    
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: rgba(16, 185, 129, 0.1);
      color: var(--primary);
      padding: 8px 16px;
      border-radius: 50px;
      font-size: 0.9rem;
      font-weight: 600;
      margin-bottom: 24px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(16, 185, 129, 0.2);
      animation: float 6s ease-in-out infinite;
    }
    
    .hero-title {
      font-size: 3.5rem;
      line-height: 1.1;
      margin-bottom: 24px;
      letter-spacing: -0.02em;
      font-weight: 900;
      background: linear-gradient(135deg, var(--text) 0%, var(--text-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .hero-title span {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .hero-desc {
      font-size: 1.2rem;
      color: var(--text-light);
      margin-bottom: 40px;
      line-height: 1.7;
      max-width: 540px;
    }
    
    .hero-cta {
      display: flex;
      gap: 20px;
      margin-bottom: 32px;
      flex-wrap: wrap;
    }
    
    .hero-stats {
      display: flex;
      gap: 32px;
      margin-top: 40px;
      flex-wrap: wrap;
    }
    
    .stat {
      display: flex;
      flex-direction: column;
    }
    
    .stat-value {
      font-size: 2.5rem;
      font-weight: 800;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .stat-label {
      font-size: 0.95rem;
      color: var(--text-light);
      font-weight: 500;
    }
    
    .hero-image {
      position: relative;
    }
    
    .hero-img-container {
      position: relative;
      border-radius: var(--radius-xl);
      overflow: hidden;
      transform: perspective(1000px) rotateY(-15deg) rotateX(5deg);
      box-shadow: var(--shadow-xl);
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
    }
    
    .hero-img-container:hover {
      transform: perspective(1000px) rotateY(0) rotateX(0);
    }
    
    .hero-img {
      width: 100%;
      height: auto;
      display: block;
      transition: transform 0.5s ease;
    }
    
    .hero-img-container:hover .hero-img {
      transform: scale(1.05);
    }
    
    .hero-img-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
      padding: 30px;
      color: white;
    }
    
    /* Enhanced Features Section */
    .features-section {
      padding: 100px 0;
      background: var(--bg-white);
      position: relative;
    }
    
    .section-header {
      text-align: center;
      max-width: 800px;
      margin: 0 auto 80px;
      position: relative;
    }
    
    .section-subtitle {
      display: inline-block;
      color: var(--primary);
      font-weight: 700;
      font-size: 0.95rem;
      margin-bottom: 16px;
      text-transform: uppercase;
      letter-spacing: 2px;
      position: relative;
      padding: 8px 20px;
      background: rgba(16, 185, 129, 0.1);
      border-radius: 50px;
    }
    
    .section-title {
      font-size: 3rem;
      font-weight: 900;
      margin-bottom: 24px;
      line-height: 1.1;
      background: linear-gradient(135deg, var(--text) 0%, var(--text-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .section-desc {
      color: var(--text-light);
      font-size: 1.2rem;
      line-height: 1.7;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 32px;
      margin-top: 40px;
    }
    
    .feature-card {
      background: var(--bg-white);
      border-radius: var(--radius-lg);
      padding: 40px;
      border: 1px solid rgba(229, 231, 235, 0.5);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(10px);
    }
    
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 0;
      background: var(--gradient-primary);
      transition: var(--transition);
    }
    
    .feature-card:hover {
      transform: translateY(-12px);
      box-shadow: var(--shadow-xl);
      border-color: transparent;
    }
    
    .feature-card:hover::before {
      height: 100%;
    }
    
    .feature-icon {
      width: 70px;
      height: 70px;
      border-radius: 20px;
      background: rgba(16, 185, 129, 0.1);
      color: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      margin-bottom: 28px;
      transition: var(--transition);
    }
    
    .feature-card:hover .feature-icon {
      background: var(--gradient-primary);
      color: white;
      transform: scale(1.1) rotate(5deg);
    }
    
    .feature-title {
      font-size: 1.6rem;
      font-weight: 800;
      margin-bottom: 20px;
    }
    
    .feature-desc {
      color: var(--text-light);
      line-height: 1.7;
      margin-bottom: 24px;
    }
    
    .feature-link {
      color: var(--primary);
      font-weight: 600;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 8px;
      position: relative;
      width: fit-content;
    }
    
    .feature-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--gradient-primary);
      transition: var(--transition);
    }
    
    .feature-link:hover {
      gap: 12px;
    }
    
    .feature-link:hover::after {
      width: 100%;
    }
    
    /* Premium CTA Section */
    .cta-section {
      padding: 100px 0;
      background: linear-gradient(135deg, #ECFDF5 0%, #EFF6FF 100%);
      position: relative;
      overflow: hidden;
    }
    
    .cta-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310B981' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .cta-card {
      background: rgba(255, 255, 255, 0.9);
      border-radius: var(--radius-xl);
      padding: 80px;
      max-width: 900px;
      margin: 0 auto;
      box-shadow: var(--shadow-xl);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      text-align: center;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .cta-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0) 70%);
      z-index: -1;
    }
    
    .cta-title {
      font-size: 3rem;
      font-weight: 900;
      margin-bottom: 20px;
      line-height: 1.1;
    }
    
    .cta-desc {
      color: var(--text-light);
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto 40px;
      line-height: 1.7;
    }
    
    /* Enhanced Footer */
    .footer {
      background: var(--text);
      color: white;
      padding: 80px 0 40px;
      position: relative;
    }
    
    .footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--primary), transparent);
    }
    
    .footer-content {
      display: grid;
      grid-template-columns: 1.5fr repeat(3, 1fr);
      gap: 60px;
      margin-bottom: 60px;
    }
    
    .footer-col h3 {
      font-size: 1.3rem;
      margin-bottom: 28px;
      font-weight: 700;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .footer-logo {
      font-size: 2rem;
      font-weight: 900;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .footer-about {
      color: #D1D5DB;
      line-height: 1.7;
      margin-bottom: 24px;
    }
    
    .social-links {
      display: flex;
      gap: 16px;
    }
    
    .social-link {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }
    
    .social-link:hover {
      background: var(--gradient-primary);
      transform: translateY(-3px);
    }
    
    .footer-links {
      list-style: none;
    }
    
    .footer-links li {
      margin-bottom: 16px;
    }
    
    .footer-links a {
      color: #9CA3AF;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .footer-links a:hover {
      color: white;
      transform: translateX(5px);
    }
    
    .footer-links a i {
      font-size: 0.8rem;
      opacity: 0;
      transition: var(--transition);
    }
    
    .footer-links a:hover i {
      opacity: 1;
    }
    
    .copyright {
      text-align: center;
      padding-top: 40px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: #9CA3AF;
      font-size: 0.9rem;
    }
    
    /* Animations */
    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .fade-in {
      animation: fadeInUp 0.8s ease-out forwards;
      opacity: 0;
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
      .hero {
        gap: 60px;
      }
      
      .hero-title {
        font-size: 3rem;
      }
      
      .section-title {
        font-size: 2.5rem;
      }
    }
    
    @media (max-width: 1024px) {
      .hero {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 60px;
      }
      
      .hero-content {
        max-width: 100%;
        margin: 0 auto;
      }
      
      .hero-desc {
        margin: 0 auto 40px;
      }
      
      .hero-cta {
        justify-content: center;
      }
      
      .hero-stats {
        justify-content: center;
      }
      
      .footer-content {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
      }
    }
    
    @media (max-width: 768px) {
      .nav-links {
        display: none;
      }
      
      .hero-section {
        padding: 140px 0 80px;
      }
      
      .hero-title {
        font-size: 2.5rem;
      }
      
      .section-title {
        font-size: 2rem;
      }
      
      .features-grid {
        grid-template-columns: 1fr;
      }
      
      .feature-card {
        padding: 32px;
      }
      
      .cta-card {
        padding: 50px 30px;
      }
      
      .cta-title {
        font-size: 2.2rem;
      }
      
      .hero-img-container {
        transform: none;
      }
      
      .hero-img-container:hover {
        transform: scale(1.02);
      }
    }
    
    @media (max-width: 640px) {
      .hero-cta {
        flex-direction: column;
        width: 100%;
      }
      
      .hero-cta .btn {
        width: 100%;
      }
      
      .hero-stats {
        flex-direction: column;
        align-items: center;
        gap: 24px;
      }
      
      .footer-content {
        grid-template-columns: 1fr;
      }
      
      .container {
        padding: 0 20px;
      }
      
      .nav-actions {
        flex-direction: column;
        gap: 12px;
        width: 100%;
        max-width: 200px;
      }
      
      .btn {
        width: 100%;
      }
    }
    
    @media (max-width: 480px) {
      .hero-title {
        font-size: 2rem;
      }
      
      .section-title {
        font-size: 1.8rem;
      }
      
      .cta-title {
        font-size: 1.8rem;
      }
      
      .stat-value {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <!-- Premium Navbar -->
  <div class="nav" id="navbar">
    <div class="container">
      <div class="nav-inner">
        <a class="brand" href="/">
          <div class="logo">A</div>
          <span>Akaunting</span>
        </a>
        
        <div class="nav-links">
          <a class="nav-link active" href="/">Home</a>
          <a class="nav-link" href="{{ route('features') }}">Features</a>
          <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
          <a class="nav-link" href="{{ route('about') }}">About</a>
          <a class="nav-link" href="{{ route('blog') }}">Blog</a>
        </div>
        
        <div class="nav-actions">
          <a class="btn btn-outline" href="/auth/login">Login</a>
          <a class="btn btn-primary" href="{{ route('register') }}">
            <i class="fas fa-rocket"></i> Get Started Free
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Premium Hero Section -->
  <section class="hero-section">
    <div class="hero-bg"></div>
    <div class="container">
      <div class="hero">
        <div class="hero-content fade-in">
          <div class="hero-badge">
            <i class="fas fa-crown"></i>
            <span>Premium Accounting Solution</span>
          </div>
          
          <h1 class="hero-title">
            Smart Accounting for <span>Smart Businesses</span>
          </h1>
          
          <p class="hero-desc">
            Revolutionize your financial management with AI-powered insights, automated workflows, and real-time reporting. 
            Focus on growing your business while we handle the numbers.
          </p>
          
          <div class="hero-cta">
            <a class="btn btn-primary" href="/auth/register">
              <i class="fas fa-magic"></i> Start Free Trial
            </a>
            <a class="btn btn-outline" href="#features">
              <i class="fas fa-play-circle"></i> See Features
            </a>
          </div>
          
          <div class="hero-stats">
            <div class="stat">
              <div class="stat-value">150K+</div>
              <div class="stat-label">Businesses Trust Us</div>
            </div>
            <div class="stat">
              <div class="stat-value">98%</div>
              <div class="stat-label">Customer Satisfaction</div>
            </div>
            <div class="stat">
              <div class="stat-value">24/7</div>
              <div class="stat-label">Premium Support</div>
            </div>
          </div>
        </div>
        
        <div class="hero-image fade-in" style="animation-delay: 0.2s">
          <div class="hero-img-container">
            <img class="hero-img" src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Akaunting Dashboard">
            <div class="hero-img-overlay">
              <h3 style="color: white; margin-bottom: 8px;">Live Financial Dashboard</h3>
              <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">Real-time insights and analytics</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Premium Features Section -->
  <section class="features-section" id="features">
    <div class="container">
      <div class="section-header fade-in">
        <div class="section-subtitle">Enterprise Features</div>
        <h2 class="section-title">Powerful Tools for Modern Businesses</h2>
        <p class="section-desc">Designed with cutting-edge technology to streamline your financial operations and drive growth.</p>
      </div>
      
      <div class="features-grid">
        <div class="feature-card fade-in" style="animation-delay: 0.1s">
          <div class="feature-icon">
            <i class="fas fa-robot"></i>
          </div>
          <h3 class="feature-title">AI-Powered Insights</h3>
          <p class="feature-desc">Get intelligent financial forecasts, automated categorization, and predictive analytics to make data-driven decisions.</p>
          <a href="/features/ai-insights" class="feature-link">
            Explore AI Features <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        
        <div class="feature-card fade-in" style="animation-delay: 0.2s">
          <div class="feature-icon">
            <i class="fas fa-bolt"></i>
          </div>
          <h3 class="feature-title">Automated Workflows</h3>
          <p class="feature-desc">Set up rules for recurring invoices, expense approvals, and payment reminders to save hours of manual work.</p>
          <a href="/features/automation" class="feature-link">
            See Automation <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        
        <div class="feature-card fade-in" style="animation-delay: 0.3s">
          <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3 class="feature-title">Bank-Level Security</h3>
          <p class="feature-desc">Enterprise-grade encryption, GDPR compliance, and regular security audits to protect your financial data.</p>
          <a href="/features/security" class="feature-link">
            View Security <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        
        <div class="feature-card fade-in" style="animation-delay: 0.4s">
          <div class="feature-icon">
            <i class="fas fa-chart-network"></i>
          </div>
          <h3 class="feature-title">Multi-Currency Support</h3>
          <p class="feature-desc">Handle international transactions with real-time exchange rates and automatic currency conversion.</p>
          <a href="/features/multi-currency" class="feature-link">
            Learn More <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        
        <div class="feature-card fade-in" style="animation-delay: 0.5s">
          <div class="feature-icon">
            <i class="fas fa-sync-alt"></i>
          </div>
          <h3 class="feature-title">Real-Time Sync</h3>
          <p class="feature-desc">Automatically sync data across all devices and integrations for up-to-the-minute financial information.</p>
          <a href="/features/sync" class="feature-link">
            Explore Sync <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        
        <div class="feature-card fade-in" style="animation-delay: 0.6s">
          <div class="feature-icon">
            <i class="fas fa-headset"></i>
          </div>
          <h3 class="feature-title">Priority Support</h3>
          <p class="feature-desc">Get dedicated support from accounting experts with fast response times and personalized guidance.</p>
          <a href="/features/support" class="feature-link">
            Get Support <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Premium CTA Section -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-card fade-in">
        <h2 class="cta-title">Ready to Transform Your Accounting?</h2>
        <p class="cta-desc">Join industry leaders who trust Akaunting for their financial operations. Experience the future of accounting today.</p>
        
        <div class="hero-cta" style="justify-content: center; margin-top: 40px;">
          <a class="btn btn-primary" href="/auth/register" style="padding: 16px 40px; font-size: 1.1rem;">
            <i class="fas fa-gem"></i> Start Premium Trial
          </a>
          <a class="btn btn-outline" href="/demo" style="padding: 16px 40px; font-size: 1.1rem;">
            <i class="fas fa-video"></i> Watch Live Demo
          </a>
        </div>
        
        <div class="hero-stats" style="justify-content: center; margin-top: 40px;">
          <div class="stat">
            <div class="stat-value">14-day</div>
            <div class="stat-label">Free Trial</div>
          </div>
          <div class="stat">
            <div class="stat-value">No CC</div>
            <div class="stat-label">Required</div>
          </div>
          <div class="stat">
            <div class="stat-value">Cancel</div>
            <div class="stat-label">Anytime</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Premium Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-col">
          <div class="footer-logo">
            <div class="logo">A</div>
            <span>Akaunting</span>
          </div>
          <p class="footer-about">Enterprise-grade accounting software designed for modern businesses. Simple, powerful, and secure.</p>
          <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        
        <div class="footer-col">
          <h3>Product</h3>
          <ul class="footer-links">
            <li><a href="/features">Features <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/pricing">Pricing <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/mobile">Mobile App <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/integrations">Integrations <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/changelog">Changelog <i class="fas fa-chevron-right"></i></a></li>
          </ul>
        </div>
        
        <div class="footer-col">
          <h3>Resources</h3>
          <ul class="footer-links">
            <li><a href="/blog">Blog <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/help">Help Center <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/community">Community <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/developers">Developers <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/api">API Docs <i class="fas fa-chevron-right"></i></a></li>
          </ul>
        </div>
        
        <div class="footer-col">
          <h3>Company</h3>
          <ul class="footer-links">
            <li><a href="/about">About Us <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/careers">Careers <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/contact">Contact <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/partners">Partners <i class="fas fa-chevron-right"></i></a></li>
            <li><a href="/legal">Legal <i class="fas fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
      
      <div class="copyright">
        <p>&copy; 2023 Akaunting. All rights reserved. Built with Laravel and ❤️</p>
        <p style="margin-top: 8px; font-size: 0.85rem;">ISO 27001 Certified | GDPR Compliant | SOC 2 Type II</p>
      </div>
    </div>
  </footer>

  <script>
    // Enhanced Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 20) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Enhanced animations on scroll
    document.addEventListener('DOMContentLoaded', function() {
      // Animate elements on load
      const fadeElements = document.querySelectorAll('.fade-in');
      fadeElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
      });
      
      // Intersection Observer for scroll animations
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, observerOptions);
      
      // Observe all fade-in elements
      fadeElements.forEach(el => {
        observer.observe(el);
      });
      
      // Enhanced hover effects
      const featureCards = document.querySelectorAll('.feature-card');
      featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0) scale(1)';
        });
      });
      
      // Button ripple effect
      const buttons = document.querySelectorAll('.btn');
      buttons.forEach(button => {
        button.addEventListener('click', function(e) {
          const ripple = document.createElement('span');
          const rect = this.getBoundingClientRect();
          const size = Math.max(rect.width, rect.height);
          const x = e.clientX - rect.left - size / 2;
          const y = e.clientY - rect.top - size / 2;
          
          ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            width: ${size}px;
            height: ${size}px;
            top: ${y}px;
            left: ${x}px;
          `;
          
          this.appendChild(ripple);
          
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });
      
      // Add ripple animation
      const style = document.createElement('style');
      style.textContent = `
        @keyframes ripple {
          to {
            transform: scale(4);
            opacity: 0;
          }
        }
      `;
      document.head.appendChild(style);
    });
  </script>
</body>
</html>