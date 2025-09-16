<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>@yield('title','Lass')</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    /* Modern Design System - Inspirado no design React criado */
    :root {
      /* Layout */
      --nav-width: 280px;
      --nav-collapsed: 80px;
      --bottom-height: 72px;
      --radius: 12px;
      
      /* Colors - Sistema de cores moderno */
      --background: hsl(248, 50%, 95%);
      --foreground: hsl(210, 100%, 12%);
      --card: hsl(0, 0%, 100%);
      --card-foreground: hsl(210, 100%, 12%);
      --primary: hsl(142, 76%, 36%);
      --primary-foreground: hsl(0, 0%, 100%);
      --secondary: hsl(210, 40%, 96.1%);
      --secondary-foreground: hsl(210, 100%, 12%);
      --muted: hsl(210, 40%, 96.1%);
      --muted-foreground: hsl(215.4, 16.3%, 46.9%);
      --accent: hsl(210, 40%, 96.1%);
      --accent-foreground: hsl(210, 100%, 12%);
      --border: hsl(214.3, 31.8%, 91.4%);
      --input: hsl(214.3, 31.8%, 91.4%);
      --ring: hsl(142, 76%, 36%);
      
      /* Health & Nutrition Colors */
      --success: hsl(142, 76%, 36%);
      --success-foreground: hsl(0, 0%, 100%);
      --warning: hsl(38, 92%, 50%);
      --warning-foreground: hsl(0, 0%, 100%);
      --info: hsl(217, 91%, 60%);
      --info-foreground: hsl(0, 0%, 100%);
      
      /* Meal Time Colors */
      --morning: hsl(45, 93%, 47%);
      --morning-light: hsl(48, 100%, 88%);
      --afternoon: hsl(38, 92%, 50%);
      --afternoon-light: hsl(43, 100%, 87%);
      --evening: hsl(259, 94%, 51%);
      --evening-light: hsl(262, 83%, 88%);
      
      /* Macro Colors */
      --carbs: hsl(204, 100%, 40%);
      --protein: hsl(348, 83%, 47%);
      --fat: hsl(38, 92%, 50%);
      
      /* Gradients */
      --gradient-morning: linear-gradient(135deg, hsl(45, 93%, 47%) 0%, hsl(38, 92%, 50%) 100%);
      --gradient-afternoon: linear-gradient(135deg, hsl(38, 92%, 50%) 0%, hsl(24, 95%, 53%) 100%);
      --gradient-evening: linear-gradient(135deg, hsl(259, 94%, 51%) 0%, hsl(236, 72%, 63%) 100%);
      --gradient-primary: linear-gradient(135deg, hsl(142, 76%, 36%) 0%, hsl(158, 64%, 52%) 100%);
      --gradient-card: linear-gradient(145deg, hsl(0, 0%, 100%) 0%, hsl(210, 40%, 98%) 100%);
      
      /* Shadows */
      --shadow-card: 0 4px 6px -1px hsl(210, 100%, 12% / 0.1), 0 2px 4px -1px hsl(210, 100%, 12% / 0.06);
      --shadow-card-hover: 0 10px 15px -3px hsl(210, 100%, 12% / 0.1), 0 4px 6px -2px hsl(210, 100%, 12% / 0.05);
      --shadow-elevated: 0 20px 25px -5px hsl(210, 100%, 12% / 0.1), 0 10px 10px -5px hsl(210, 100%, 12% / 0.04);
      --sidebar-shadow: 0 0 0 1px hsl(214.3, 31.8%, 91.4%), 0 4px 6px -1px hsl(210, 100%, 12% / 0.1);
    }

    /* Dark Mode */
    body.dark {
      --background: hsl(222.2, 84%, 4.9%);
      --foreground: hsl(210, 40%, 98%);
      --card: hsl(222.2, 84%, 4.9%);
      --card-foreground: hsl(210, 40%, 98%);
      --primary: hsl(158, 64%, 52%);
      --primary-foreground: hsl(222.2, 47.4%, 11.2%);
      --secondary: hsl(217.2, 32.6%, 17.5%);
      --secondary-foreground: hsl(210, 40%, 98%);
      --muted: hsl(217.2, 32.6%, 17.5%);
      --muted-foreground: hsl(215, 20.2%, 65.1%);
      --accent: hsl(217.2, 32.6%, 17.5%);
      --accent-foreground: hsl(210, 40%, 98%);
      --border: hsl(217.2, 32.6%, 17.5%);
      --input: hsl(217.2, 32.6%, 17.5%);
      --ring: hsl(158, 64%, 52%);
      --success: hsl(158, 64%, 52%);
      --sidebar-shadow: 0 0 0 1px hsl(217.2, 32.6%, 17.5%), 0 4px 6px -1px hsl(210, 100%, 12% / 0.2);
    }

    /* Base Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
      background: var(--background);
      color: var(--foreground);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    body.has-sidebar {
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar Styles */
    .app-sidebar {
      width: var(--nav-width);
      background: var(--card);
      box-shadow: var(--sidebar-shadow);
      display: flex;
      flex-direction: column;
      padding: 20px 16px 24px;
      position: sticky;
      top: 0;
      height: 100vh;
      z-index: 104;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-right: 1px solid var(--border);
    }

    .app-sidebar.collapsed {
      width: var(--nav-collapsed);
    }

    .sb-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 700;
      font-size: 1.25rem;
      color: var(--foreground);
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .sb-toggle {
      background: var(--secondary);
      border: none;
      color: var(--muted-foreground);
      cursor: pointer;
      padding: 8px;
      border-radius: 8px;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
    }

    .sb-toggle:hover {
      background: var(--accent);
      color: var(--accent-foreground);
      transform: scale(1.05);
    }

    .sb-menu {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .sb-menu li a {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 12px 16px;
      text-decoration: none;
      font-size: 0.9rem;
      color: var(--muted-foreground);
      border-radius: var(--radius);
      font-weight: 500;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .sb-menu li a::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: var(--gradient-primary);
      opacity: 0;
      transition: opacity 0.2s ease;
      z-index: -1;
    }

    .sb-menu li a:hover {
      color: var(--foreground);
      transform: translateX(4px);
      box-shadow: var(--shadow-card);
    }

    .sb-menu li a:hover::before {
      opacity: 0.05;
    }

    .sb-menu li.is-active > a {
      background: var(--gradient-primary);
      color: var(--primary-foreground);
      font-weight: 600;
      box-shadow: var(--shadow-card);
    }

    .sb-menu li.is-active > a::before {
      opacity: 0;
    }

    .sb-footer {
      margin-top: auto;
      padding-top: 16px;
      border-top: 1px solid var(--border);
    }

    .theme-btn {
      display: flex;
      align-items: center;
      gap: 12px;
      background: var(--secondary);
      border: 0;
      padding: 12px 16px;
      border-radius: var(--radius);
      font-size: 0.9rem;
      color: var(--muted-foreground);
      cursor: pointer;
      transition: all 0.2s ease;
      width: 100%;
      font-weight: 500;
    }

    .theme-btn:hover {
      background: var(--accent);
      color: var(--accent-foreground);
      transform: translateY(-1px);
      box-shadow: var(--shadow-card);
    }

    /* Main Content */
    .main-content {
      flex: 1;
      min-width: 0;
      padding: 0;
      background: var(--background);
    }

    /* Bottom Navigation */
    .app-bottom-nav {
      position: fixed;
      left: 0;
      right: 0;
      bottom: 0;
      height: var(--bottom-height);
      background: var(--card);
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 8px 8px 12px;
      z-index: 1100;
      box-shadow: 0 -4px 6px -1px hsl(210, 100%, 12% / 0.1);
    }

    .app-bottom-nav .bn-item {
      text-decoration: none;
      color: var(--muted-foreground);
      font-size: 0.75rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
      flex: 1;
      padding: 8px 4px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .app-bottom-nav .bn-item i {
      font-size: 1.2rem;
      transition: transform 0.2s ease;
    }

    .app-bottom-nav .bn-item.is-active,
    .app-bottom-nav .bn-item:hover {
      color: var(--primary);
      background: var(--primary-light, hsl(142, 76%, 96%));
    }

    .app-bottom-nav .bn-item.is-active i,
    .app-bottom-nav .bn-item:hover i {
      transform: scale(1.1);
    }

    /* Responsive Design */
    @media (min-width: 992px) {
      .app-bottom-nav {
        display: none;
      }
    }

    @media (max-width: 991.98px) {
      .app-sidebar {
        display: none;
      }
      
      body.has-sidebar {
        flex-direction: column;
      }
      
      .main-content {
        padding-bottom: var(--bottom-height);
      }
    }

    /* Utility Classes */
    .card-modern {
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow-card);
      transition: all 0.3s ease;
    }

    .card-modern:hover {
      box-shadow: var(--shadow-card-hover);
      transform: translateY(-2px);
    }

    .btn-gradient {
      background: var(--gradient-primary);
      color: var(--primary-foreground);
      border: none;
      border-radius: var(--radius);
      padding: 12px 24px;
      font-weight: 600;
      transition: all 0.2s ease;
      box-shadow: var(--shadow-card);
    }

    .btn-gradient:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-card-hover);
      color: var(--primary-foreground);
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background: var(--muted);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--muted-foreground);
      border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--accent-foreground);
    }
    </style>
    @stack('styles')
</head>
<body class="has-sidebar">
    @include('partials.navigation')

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
      (function(){
        const body = document.body;
        const sidebar = document.querySelector('.app-sidebar');
        const toggle = document.getElementById('sidebarToggle');
        
        // Theme management
        const savedTheme = localStorage.getItem('ui-theme');
        if (savedTheme === 'dark') body.classList.add('dark');
        
        // Sidebar toggle
        toggle?.addEventListener('click', () => {
          sidebar.classList.toggle('collapsed');
          localStorage.setItem('sb-collapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
        });
        
        // Restore sidebar state
        if (localStorage.getItem('sb-collapsed') === '1') {
          sidebar.classList.add('collapsed');
        }
        
        // Theme switcher
        document.getElementById('themeSwitcher')?.addEventListener('click', () => {
          body.classList.toggle('dark');
          localStorage.setItem('ui-theme', body.classList.contains('dark') ? 'dark' : 'light');
        });
        
        // Active navigation state
        document.querySelectorAll('.app-bottom-nav .bn-item').forEach(a => {
          if (a.href === window.location.href) {
            a.classList.add('is-active');
          }
        });

        // Smooth animations on load
        document.addEventListener('DOMContentLoaded', () => {
          document.body.style.opacity = '1';
        });
      })();
    </script>
    @stack('scripts')
</body>
</html>