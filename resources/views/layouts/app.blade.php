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
    :root {
      --nav-width:250px;--nav-collapsed:76px;
      --primary:#3b82f6;--primary-soft:#e0f2fe;
      --text:#111827;--text-muted:#6b7280;
      --bg:#f5f7fa;--card-bg:#ffffff;
      --bottom-height:62px;
    }
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,sans-serif;background:var(--bg);color:var(--text);}
    body.has-sidebar{display:flex;min-height:100vh;}
    .app-sidebar{width:var(--nav-width);background:var(--card-bg);border-right:1px solid #e5e7eb;display:flex;flex-direction:column;padding:12px 12px 16px;position:sticky;top:0;height:100vh;z-index:104;transition:width .25s;}
    .app-sidebar.collapsed{width:var(--nav-collapsed);}
    .sb-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
    .brand{display:flex;align-items:center;gap:8px;font-weight:600;font-size:1.05rem;}
    .sb-toggle{background:transparent;border:none;color:var(--text-muted);cursor:pointer;padding:6px 8px;border-radius:10px;}
    .sb-toggle:hover{background:rgba(0,0,0,.06);}
    .sb-menu{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:4px;}
    .sb-menu li a{display:flex;align-items:center;gap:14px;padding:10px 12px;text-decoration:none;font-size:.88rem;color:var(--text-muted);border-radius:14px;font-weight:500;transition:background .18s,color .18s;}
    .sb-menu li a:hover{background:rgba(0,0,0,.05);color:var(--text);}
    .sb-menu li.is-active>a{background:var(--primary-soft);color:var(--primary);font-weight:600;}
    .sb-footer{margin-top:auto;}
    .theme-btn{display:flex;align-items:center;gap:12px;background:rgba(0,0,0,.05);border:0;padding:10px 12px;border-radius:14px;font-size:.85rem;color:var(--text-muted);cursor:pointer;}
    .theme-btn:hover{background:rgba(0,0,0,.08);color:var(--text);}
    .main-content{flex:1;min-width:0;padding:0;}
    .app-bottom-nav{position:fixed;left:0;right:0;bottom:0;height:var(--bottom-height);background:var(--card-bg);border-top:1px solid #e5e7eb;display:flex;justify-content:space-around;align-items:center;padding:4px 4px 6px;z-index:1100;}
    .app-bottom-nav .bn-item{text-decoration:none;color:var(--text-muted);font-size:.68rem;display:flex;flex-direction:column;align-items:center;gap:4px;flex:1;padding:4px 0;font-weight:500;}
    .app-bottom-nav .bn-item i{font-size:1.1rem;}
    .app-bottom-nav .bn-item.is-active,.app-bottom-nav .bn-item:hover{color:var(--primary);}
    @media (min-width:992px){.app-bottom-nav{display:none;}}
    @media (max-width:991.98px){.app-sidebar{display:none;}body.has-sidebar{flex-direction:column;} .main-content{padding-bottom:var(--bottom-height);}}
    body.dark{--bg:#0f172a;--card-bg:#162233;--text:#f1f5f9;--text-muted:#94a3b8;}
    body.dark .app-sidebar{border-right:1px solid #1e293b;}
    body.dark .sb-menu li a:hover{background:rgba(255,255,255,.07);}
    body.dark .sb-menu li.is-active>a{background:rgba(59,130,246,.18);}
    body.dark .app-bottom-nav{background:var(--card-bg);border-top:1px solid #1e293b;}
    body.dark .theme-btn{background:rgba(255,255,255,.06);}
    body.dark .theme-btn:hover{background:rgba(255,255,255,.12);}
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

    <!-- Chart.js sem integrity para não ser bloqueado -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
      (function(){
        const body=document.body;
        const sidebar=document.querySelector('.app-sidebar');
        const toggle=document.getElementById('sidebarToggle');
        const savedTheme=localStorage.getItem('ui-theme');
        if(savedTheme==='dark') body.classList.add('dark');
        toggle?.addEventListener('click', ()=>{
          sidebar.classList.toggle('collapsed');
          localStorage.setItem('sb-collapsed', sidebar.classList.contains('collapsed')?'1':'0');
        });
        if(localStorage.getItem('sb-collapsed')==='1') sidebar.classList.add('collapsed');
        document.getElementById('themeSwitcher')?.addEventListener('click', ()=>{
          body.classList.toggle('dark');
          localStorage.setItem('ui-theme', body.classList.contains('dark')?'dark':'light');
        });
        document.querySelectorAll('.app-bottom-nav .bn-item').forEach(a=>{
          if(a.href === window.location.href) a.classList.add('is-active');
        });
      })();
    </script>
    @stack('scripts')
</body>
</html>