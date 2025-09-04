@php
    $navActive = function($patterns){
        foreach((array)$patterns as $p){
            if(request()->routeIs($p)) return 'is-active';
        }
        return '';
    };
@endphp

<nav class="app-sidebar">
    <div class="sb-header">
        <div class="brand">
            <i class="fas fa-dumbbell"></i><span class="brand-text">Lass</span>
        </div>
        <button class="sb-toggle" id="sidebarToggle" type="button" aria-label="Colapsar">
            <i class="fas fa-angle-left"></i>
        </button>
    </div>

    <ul class="sb-menu">
        <li class="{{ $navActive('dashboard') }}"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i><span>Home</span></a></li>
        <li class="{{ $navActive('profile.*') }}"><a href="#"><i class="fas fa-user"></i><span>Eu</span></a></li>
        <li class="{{ $navActive('diary.*') }}"><a href="#"><i class="fas fa-book"></i><span>Diário</span></a></li>
        <li class="{{ $navActive('reports.*') }}"><a href="#"><i class="fas fa-chart-line"></i><span>Relatórios</span></a></li>
        <li class="{{ $navActive('premium.*') }}"><a href="#"><i class="fas fa-crown"></i><span>Premium</span></a></li>
    </ul>

    <div class="sb-footer">
        <button id="themeSwitcher" class="theme-btn" type="button">
            <i class="fas fa-adjust"></i><span>Tema</span>
        </button>
    </div>
</nav>

<nav class="app-bottom-nav">
    <a href="{{ route('dashboard') }}" class="bn-item {{ $navActive('dashboard') }}"><i class="fas fa-home"></i><span>Home</span></a>
    <a href="#" class="bn-item {{ $navActive('profile.*') }}"><i class="fas fa-user"></i><span>Eu</span></a>
    <a href="#" class="bn-item {{ $navActive('diary.*') }}"><i class="fas fa-book"></i><span>Diário</span></a>
    <a href="#" class="bn-item {{ $navActive('reports.*') }}"><i class="fas fa-chart-line"></i><span>Relatórios</span></a>
    <a href="#" class="bn-item {{ $navActive('premium.*') }}"><i class="fas fa-crown"></i><span>Premium</span></a>
</nav>
