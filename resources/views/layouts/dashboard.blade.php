@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        dashboard-wrapper {
            --bg: #f5f7fa;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --text: #111827;
            --text-muted: #6b7280;
            --primary: #3b82f6;
            --primary-soft: #e0f2fe;
            --warn: #facc15;
            --danger: #f87171;
            --success: #10b981;
            --fat: #facc15;
            --carb: #3b82f6;
            --protein: #f87171;
            --radius: 24px;
            --shadow: 0 4px 12px -2px rgba(0, 0, 0, .06), 0 2px 4px -1px rgba(0, 0, 0, .04);
            background: var(--bg);
            color: var(--text);
            padding: 0.5rem 0.75rem 3rem;
        }

        .dashboard-wrapper.dark {
            --bg: #0f141b;
            --card-bg: #18222e;
            --card-border: #243040;
            --text: #f3f4f6;
            --text-muted: #9ca3af;
            --primary: #60a5fa;
            --primary-soft: #1e3a5f;
            --shadow: 0 4px 14px -2px rgba(0, 0, 0, .55);
        }

        .dashboard-wrapper .card,
        .dashboard-wrapper .meeting-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: background .25s, color .25s, border-color .25s;
        }

        .dashboard-wrapper .toggle-theme {
            position: absolute;
            top: 14px;
            right: 14px;
            font-size: 12px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            user-select: none;
        }

        .dashboard-wrapper.dark .toggle-theme {
            color: #fff;
        }

        .fab-add {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 18px;
            font-size: 26px;
            box-shadow: 0 6px 18px -4px rgba(0, 0, 0, .3);
            cursor: pointer;
            z-index: 900;
            transition: transform .18s, background .25s;
        }

        .dashboard-wrapper.dark .fab-add {
            background: var(--primary-soft);
        }

        .fab-add:hover {
            transform: scale(1.07);
        }

        .macros-inline {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .macro-chip {
            flex: 1;
            height: 8px;
            border-radius: 8px;
            background: #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .dashboard-wrapper.dark .macro-chip {
            background: #1f2a36;
        }

        .macro-chip span {
            position: absolute;
            inset: 0;
            border-radius: 8px;
            transition: width .5s;
        }

        .macro-chip[data-type="carb"] span {
            background: var(--carb);
        }

        .macro-chip[data-type="protein"] span {
            background: var(--protein);
        }

        .macro-chip[data-type="fat"] span {
            background: var(--fat);
        }

        /* Calendário */
        .streak-card .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .75rem;
        }

        .streak-card .month-select {
            background: var(--primary-soft);
            border: none;
            border-radius: 18px;
            padding: 6px 14px;
            font-size: .85rem;
            cursor: pointer;
            appearance: none;
            position: relative;
            font-weight: 500;
        }

        .streak-card .month-select:focus {
            outline: 2px solid var(--primary);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            justify-items: center;
            margin-bottom: 10px;
        }

        .calendar-grid .cell {
            width: 44px;
            aspect-ratio: 1/1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            font-size: .72rem;
            color: var(--text-muted);
            border-radius: 12px;
            transition: background .2s, transform .15s;
        }

        .calendar-grid .cell .num {
            font-size: .85rem;
            font-weight: 500;
            color: var(--text);
            line-height: 1;
            margin-bottom: 2px;
        }

        .dashboard-wrapper.dark .calendar-grid .cell {
            color: var(--text-muted);
        }

        .calendar-grid .cell.today {
            background: var(--warn);
            box-shadow: 0 0 0 3px rgba(250, 204, 21, .35);
        }

        .calendar-grid .cell.today .num {
            color: #111;
        }

        .calendar-grid .cell.hit::after {
            content: '✔';
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: .65rem;
            color: #111;
            background: rgba(255, 255, 255, .6);
            padding: 2px 4px;
            border-radius: 6px;
        }

        .calendar-grid .cell:hover {
            transform: translateY(-3px);
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-size: .65rem;
            letter-spacing: .5px;
            margin-bottom: 4px;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Indicadores (opcional manter) */
        .indicator-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
        }

        .indicator-line {
            height: 2px;
            flex: 1;
            background: #d1d5db;
            position: relative;
            border-radius: 2px;
        }

        .dashboard-wrapper.dark .indicator-line {
            background: #2c3a49;
        }

        .indicator-dot {
            width: 8px;
            height: 8px;
            background: #cbd5e1;
            border-radius: 50%;
            transform: scale(.9);
            opacity: .6;
        }

        .indicator-dot.indicator-active {
            background: var(--primary);
            transform: scale(1.2);
            opacity: 1;
        }

        :root {
            --bg: #f5f7fa;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --text: #111827;
            --text-muted: #6b7280;
            --primary: #3b82f6;
            --primary-soft: #e0f2fe;
            --warn: #facc15;
            --danger: #f87171;
            --success: #10b981;
            --fat: #facc15;
            --carb: #3b82f6;
            --protein: #f87171;
            --radius: 24px;
            --shadow: 0 4px 12px -2px rgba(0, 0, 0, .06), 0 2px 4px -1px rgba(0, 0, 0, .04);
        }

        .dark {
            --bg: #0f141b;
            --card-bg: #18222e;
            --card-border: #243040;
            --text: #f3f4f6;
            --text-muted: #9ca3af;
            --primary: #60a5fa;
            --primary-soft: #1e3a5f;
            --shadow: 0 4px 14px -2px rgba(0, 0, 0, .55);
        }

        body {
            background: var(--bg);
            color: var(--text);
        }

        .card,
        .meeting-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: background .25s, color .25s;
        }

        .day-item {
            transition: background .2s, transform .15s;
        }

        .day-item.day-active .day-number {
            background: var(--warn);
            color: #111;
            border-radius: 50%;
        }

        .day-item:hover {
            transform: translateY(-2px);
        }

        .macros-inline {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .macro-chip {
            flex: 1;
            height: 8px;
            border-radius: 8px;
            background: #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .macro-chip span {
            position: absolute;
            inset: 0;
            border-radius: 8px;
            transition: width .5s;
        }

        .macro-chip[data-type="carb"] span {
            background: var(--carb);
        }

        .macro-chip[data-type="protein"] span {
            background: var(--protein);
        }

        .macro-chip[data-type="fat"] span {
            background: var(--fat);
        }

        .fab-add {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 18px;
            font-size: 26px;
            box-shadow: 0 6px 18px -4px rgba(0, 0, 0, .3);
            cursor: pointer;
            z-index: 900;
            transition: transform .2s, background .25s;
        }

        .fab-add:hover {
            transform: scale(1.07);
        }

        .dark .fab-add {
            background: var(--primary-soft);
        }

        .toggle-theme {
            position: absolute;
            top: 14px;
            right: 14px;
            font-size: 12px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            user-select: none;
        }

        .dark .toggle-theme {
            color: #fff;
        }

        /* Card alimentação por turno */
        .dashboard-period-card {
            border-radius: 16px;
            background: var(--card-bg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            padding: 1.25rem 1rem 1.4rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-period-card h6 {
            font-size: .9rem;
            font-weight: 600;
            text-align: center;
            margin: 0 0 1rem;
        }

        .meal-periods {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .meal-period {
            flex: 1;
            min-width: 100px;
            max-width: 140px;
            text-align: center;
            position: relative;
        }

        .meal-period-chart-container {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto 6px;
        }

        .meal-period-chart-container canvas {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
        }

        .meal-period-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 20px;
            font-weight: 500;
        }

        .dark .meal-period-icon {
            background: #1e293b;
            color: #cbd5e1;
        }

        .meal-period-title {
            font-weight: 600;
            font-size: .82rem;
            margin-bottom: 2px;
        }

        .meal-period-kcal {
            font-size: .68rem;
            color: var(--text-muted);
            line-height: 1.1;
        }

        @media (max-width: 575px) {
            .meal-period-chart-container {
                width: 78px;
                height: 78px;
            }

            .meal-period-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }
    </style>
    <button class="fab-add" id="quickAddBtn" aria-label="Adicionar alimento">+</button>

    {{-- Inserir barra compacta depois do donut --}}
    <div class="macros-inline">
        <div class="macro-chip" data-type="carb"><span style="width:0%"></span></div>
        <div class="macro-chip" data-type="protein"><span style="width:0%"></span></div>
        <div class="macro-chip" data-type="fat"><span style="width:0%"></span></div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Hoje</h4>
        <div>
            {{-- O modal agora será aberto pelos botões de turno --}}
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-lg-7">

            <div class="card card-compact p-3 p-md-4 mb-4">
                <h6 class="mb-4 text-center">Alimentação por Turno</h6>
                <div class="row text-center">
                    <div class="col">
                        <div class="meal-period-chart-container mx-auto" data-meal-type="Manhã" data-bs-toggle="modal"
                            data-bs-target="#foodSearchModal">
                            <canvas id="morningChart"></canvas>
                            <div class="meal-period-icon">
                                <i class="fas fa-mug-hot"></i>
                            </div>
                        </div>
                        <div class="mt-2 fw-bold">Manhã</div>
                        <div class="small text-muted" id="morning-calories">0 / {{ round($user->daily_calorie_target / 3) }}
                            kcal</div>
                    </div>
                    <div class="col">
                        <div class="meal-period-chart-container mx-auto" data-meal-type="Tarde" data-bs-toggle="modal"
                            data-bs-target="#foodSearchModal">
                            <canvas id="afternoonChart"></canvas>
                            <div class="meal-period-icon">
                                <i class="fas fa-sun"></i>
                            </div>
                        </div>
                        <div class="mt-2 fw-bold">Tarde</div>
                        <div class="small text-muted" id="afternoon-calories">0 /
                            {{ round($user->daily_calorie_target / 3) }} kcal</div>
                    </div>
                    <div class="col">
                        <div class="meal-period-chart-container mx-auto" data-meal-type="Noite" data-bs-toggle="modal"
                            data-bs-target="#foodSearchModal">
                            <canvas id="eveningChart"></canvas>
                            <div class="meal-period-icon">
                                <i class="fas fa-moon"></i>
                            </div>
                        </div>
                        <div class="mt-2 fw-bold">Noite</div>
                        <div class="small text-muted" id="evening-calories">0 / {{ round($user->daily_calorie_target / 3) }}
                            kcal</div>
                    </div>
                </div>
            </div>

            <div class="card card-compact p-3 p-md-4">
                <h6 class="mb-3 text-center text-md-start">Resumo do Dia</h6>

                <div class="bg-light rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div style="width: 180px; height: 180px; position: relative;">
                            <canvas id="caloriesChart"></canvas>
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;">
                                <span id="calories-remaining" class="h2 fw-bold mb-0">...</span>
                                <span class="small text-muted">Restantes</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center small">
                        <div class="col">
                            <div class="fw-bold" id="calories-consumed">0</div>
                            <div class="text-muted">Consumidas</div>
                        </div>
                        <div class="col border-start border-end">
                            <div class="fw-bold">{{ $user->daily_calorie_target }}</div>
                            <div class="text-muted">Meta</div>
                        </div>
                        <div class="col">
                            <div class="fw-bold" id="calories-burned">0</div>
                            <div class="text-muted">Gastas</div>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="fw-bold">Carboidratos</span>
                            <span class="text-muted" id="carbs-details">0 / {{ $user->daily_carbs_target }}g</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div id="carbs-progress" class="progress-bar" role="progressbar"
                                style="width: 0%; background-color: #60a5fa;" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="fw-bold">Proteínas</span>
                            <span class="text-muted" id="protein-details">0 / {{ $user->daily_protein_target }}g</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div id="protein-progress" class="progress-bar" role="progressbar"
                                style="width: 0%; background-color: #f87171;" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="fw-bold">Gorduras</span>
                            <span class="text-muted" id="fat-details">0 / {{ $user->daily_fat_target }}g</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div id="fat-progress" class="progress-bar" role="progressbar"
                                style="width: 0%; background-color: #facc15;" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- From Uiverse.io by juyi_2230 -->
        <div id="dashboardWrapper" class="dashboard-wrapper">
            <button class="fab-add" id="quickAddBtn" aria-label="Adicionar alimento">+</button>

            {{-- restante do conteúdo existente (cards, gráficos etc) --}}

            {{-- Substituir o bloco atual da "Sequência Dieta" pelo abaixo  --}}
            <div class="meeting-card streak-card mt-4 p-3">
                <div class="calendar-header">
                    <div class="title m-0" style="font-weight:600; font-size:1.05rem;">
                        Sequência<br>Dieta
                    </div>
                    <form id="monthForm" method="GET" style="margin:0;">
                        <select class="month-select" name="month"
                            onchange="document.getElementById('monthForm').submit()">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        <select class="month-select" name="year"
                            onchange="document.getElementById('monthForm').submit()">
                            @for ($y = now()->year - 1; $y <= now()->year + 1; $y++)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>

                @php
                    $firstWeekday = \Carbon\Carbon::create($selectedYear, $selectedMonth, 1)->dayOfWeekIso; //1=Mon
                    $daysInMonth = count($monthDays);
                    $blanks = $firstWeekday - 1;
                @endphp

                <div class="calendar-weekdays">
                    @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $wd)
                        <div>{{ $wd }}</div>
                    @endforeach
                </div>

                <div class="calendar-grid">
                    @for ($i = 0; $i < $blanks; $i++)
                        <div class="cell" style="visibility:hidden;"></div>
                    @endfor

                    @foreach ($monthDays as $d)
                        @php
                            $hit = !empty($streaks[$d['date']]);
                            $classes = [];
                            if ($d['is_today']) {
                                $classes[] = 'today';
                            }
                            if ($hit) {
                                $classes[] = 'hit';
                            }
                        @endphp
                        <div class="cell {{ implode(' ', $classes) }}" title="{{ $d['date'] }}">
                            <div class="num">{{ $d['day'] }}</div>
                            <div class="wk">{{ $d['weekday'] }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="indicator-container">
                    <div class="indicator-line"></div>
                    @foreach ($weekDays as $day)
                        <div class="indicator-dot {{ $day['is_today'] ? 'indicator-active' : '' }}"></div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- 
        <div class="col-lg-5">
            <div class="card card-compact p-3">
                <h6 class="mb-2">Refeições de Hoje</h6>
                <div id="meal-list-morning">
                    <small class="text-muted fw-bold">MANHÃ</small>
                    <ul class="list-group list-group-flush mb-2"></ul>
                </div>
                <div id="meal-list-afternoon">
                    <small class="text-muted fw-bold">TARDE</small>
                    <ul class="list-group list-group-flush mb-2"></ul>
                </div>
                <div id="meal-list-evening">
                    <small class="text-muted fw-bold">NOITE</small>
                    <ul class="list-group list-group-flush"></ul>
                </div>
                <div id="no-meals-today" class="list-group-item text-muted" style="display: none;">
                    Nenhum alimento registrado hoje.
                </div>
            </div>
        </div> --}}
    </div>

    @include('partials._food_search_modal')

    @push('scripts')
        <script>
            (function() {
                const wrapper = document.getElementById('dashboardWrapper');
                if (!wrapper) return;
                const saved = localStorage.getItem('dash-theme');
                if (saved === 'dark') wrapper.classList.add('dark');
                document.getElementById('themeToggle').addEventListener('click', () => {
                    wrapper.classList.toggle('dark');
                    localStorage.setItem('dash-theme', wrapper.classList.contains('dark') ? 'dark' : 'light');
                });
                document.getElementById('quickAddBtn').addEventListener('click', () => {
                    const mealType = 'Manhã';
                    document.getElementById('meal_type_input')?.setAttribute('value', mealType);
                    const label = document.getElementById('foodSearchModalLabel');
                    if (label) label.textContent = 'Adicionar em: ' + mealType;
                    const modalEl = document.getElementById('foodSearchModal');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();
                    }
                });
            })();
        </script>
        <script>
            $(function() {
                // Configura o CSRF para chamadas AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Pega os dados passados pelo Controller
                const sums = @json($sums);
                const sumsByPeriod = @json($sumsByPeriod);
                const recentMeals = @json($recent);
                const userGoals = @json($user);

                // --- Lógica do Modal ---
                const foodSearchModal = new bootstrap.Modal(document.getElementById('foodSearchModal'));
                let currentMealType = ''; // Manhã, Tarde ou Noite

                $('.meal-period-chart-container').on('click', function() {
                    currentMealType = $(this).data('meal-type');
                    $('#meal_type_input').val(currentMealType); // <-- Atualiza o input hidden
                    $('#searchInput').val('');
                    $('#results').html('');
                    $('#foodSearchModalLabel').text('Adicionar em: ' + currentMealType);
                });

                $('#addFoodForm').on('submit', function(e) {
                    e.preventDefault();
                    if (!currentMealType) {
                        alert('Selecione o período (Manhã, Tarde ou Noite) antes de adicionar.');
                        return;
                    }
                    const formData = $(this).serializeArray();
                    formData.push({
                        name: "meal_type",
                        value: currentMealType
                    });

                    const data = {};
                    formData.forEach(function(item) {
                        data[item.name] = item.value;
                    });

                    $.post("{{ route('meal.store') }}", payload)
                        .done(res => {
                            if (res.success) {
                                bootstrap.Modal.getInstance($('#foodSearchModal')[0]).hide();
                                location.reload();
                            }
                        })
                        .fail(jq => {
                            console.error('Fail', jq.status, jq.responseText);
                            if (jq.status === 422) {
                                const errs = jq.responseJSON?.errors || {};
                                alert('Erros:\n' + Object.entries(errs).map(([k, v]) => k + ': ' + v.join(
                                    ', ')).join('\n'));
                            } else {
                                alert('Falha (' + jq.status + ')');
                            }
                        });
                });

                function updateDashboardUI() {
                    const consumed = {
                        calories: Math.round(sums.calories),
                        protein: Math.round(sums.protein),
                        carbs: Math.round(sums.carbs),
                        fat: Math.round(sums.fat)
                    };
                    const goals = {
                        calories: userGoals.daily_calorie_target,
                        protein: userGoals.daily_protein_target,
                        carbs: userGoals.daily_carbs_target,
                        fat: userGoals.daily_fat_target
                    };
                    const remainingCalories = Math.max(0, goals.calories - consumed.calories);

                    // --- Atualizar Resumo do Dia ---
                    $('#calories-consumed').text(consumed.calories);
                    $('#calories-remaining').text(remainingCalories);
                    $('#protein-details').text(`${consumed.protein} / ${goals.protein}g`);
                    $('#carbs-details').text(`${consumed.carbs} / ${goals.carbs}g`);
                    $('#fat-details').text(`${consumed.fat} / ${goals.fat}g`);

                    // --- Atualizar Barras de Progresso de Macros ---
                    const proteinPercent = goals.protein > 0 ? Math.min(100, (consumed.protein / goals.protein) * 100) :
                        0;
                    $('#protein-progress').css('width', proteinPercent + '%').attr('aria-valuenow', proteinPercent);
                    const carbsPercent = goals.carbs > 0 ? Math.min(100, (consumed.carbs / goals.carbs) * 100) : 0;
                    $('#carbs-progress').css('width', carbsPercent + '%').attr('aria-valuenow', carbsPercent);
                    const fatPercent = goals.fat > 0 ? Math.min(100, (consumed.fat / goals.fat) * 100) : 0;
                    $('#fat-progress').css('width', fatPercent + '%').attr('aria-valuenow', fatPercent);

                    // --- Renderizar Gráfico de Calorias Principal ---
                    renderDonutChart('caloriesChart', [consumed.calories, remainingCalories], ['#3b82f6', '#e5e7eb'],
                        '80%');

                    // --- Renderizar Gráficos por Turno ---
                    const periodGoal = Math.round(goals.calories / 3);

                    const morningConsumed = Math.round(sumsByPeriod.Manhã.calories);
                    const morningRemaining = Math.max(0, periodGoal - morningConsumed);
                    $('#morning-calories').text(`${morningConsumed} / ${periodGoal} kcal`);
                    renderDonutChart('morningChart', [morningConsumed, morningRemaining], ['#facc15', '#f3f4f6'],
                        '75%');

                    const afternoonConsumed = Math.round(sumsByPeriod.Tarde.calories);
                    const afternoonRemaining = Math.max(0, periodGoal - afternoonConsumed);
                    $('#afternoon-calories').text(`${afternoonConsumed} / ${periodGoal} kcal`);
                    renderDonutChart('afternoonChart', [afternoonConsumed, afternoonRemaining], ['#fb923c', '#f3f4f6'],
                        '75%');

                    const eveningConsumed = Math.round(sumsByPeriod.Noite.calories);
                    const eveningRemaining = Math.max(0, periodGoal - eveningConsumed);
                    $('#evening-calories').text(`${eveningConsumed} / ${periodGoal} kcal`);
                    renderDonutChart('eveningChart', [eveningConsumed, eveningRemaining], ['#60a5fa', '#f3f4f6'],
                        '75%');

                    // --- Renderizar Lista de Refeições ---
                    updateMealList();
                }

                function updateMealList() {
                    // Limpa listas existentes
                    $('#meal-list-morning ul, #meal-list-afternoon ul, #meal-list-evening ul').empty();

                    if (recentMeals.length === 0) {
                        $('#no-meals-today').show();
                        $('#meal-list-morning, #meal-list-afternoon, #meal-list-evening').hide();
                        return;
                    }

                    $('#no-meals-today').hide();
                    $('#meal-list-morning, #meal-list-afternoon, #meal-list-evening').show();

                    let mealsByPeriod = {
                        Manhã: [],
                        Tarde: [],
                        Noite: []
                    };
                    recentMeals.forEach(meal => {
                        if (mealsByPeriod[meal.meal_type]) {
                            mealsByPeriod[meal.meal_type].push(meal);
                        }
                    });
                    console.log(mealsByPeriod);
                    const renderList = (period, meals) => {
                        const $list = $(`#meal-list-${period.toLowerCase()} ul`);
                        if (meals.length > 0) {
                            $(`#meal-list-${period.toLowerCase()}`).show();
                            meals.forEach(meal => {
                                $list.append(`
                                <li class="list-group-item d-flex justify-content-between align-items-center small p-2">
                                    <div>
                                        <div class="fw-bold">${meal.food.name}</div>
                                        <div class="text-muted">${meal.amount}g</div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">${Math.round(meal.calories)} kcal</span>
                                </li>`);
                            });
                        } else {
                            $(`#meal-list-${period.toLowerCase()}`).hide();
                        }
                    };

                    renderList('Manhã', mealsByPeriod.Manhã);
                    renderList('Tarde', mealsByPeriod.Tarde);
                    renderList('Noite', mealsByPeriod.Noite);
                }

                function renderDonutChart(canvasId, data, colors, cutout) {
                    const ctx = document.getElementById(canvasId).getContext('2d');
                    // Destruir gráfico antigo se existir para evitar sobreposição
                    if (window[canvasId] instanceof Chart) {
                        window[canvasId].destroy();
                    }
                    window[canvasId] = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: data,
                                backgroundColor: colors,
                                borderWidth: 0,
                                borderRadius: 5,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: cutout,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false
                                }
                            },
                            events: [] // Desabilita interações com o gráfico
                        }
                    });
                }

                // Carga inicial
                updateDashboardUI();
            });
        </script>
        <script>
            let currentFood = null;

            $('#foodSearchForm').on('submit', function(e) {
                e.preventDefault();
                const q = $('#searchInput').val().trim();
                if (!q) return;
                $('#results').html('<div class="px-2 py-1 small text-muted">Carregando...</div>');
                $.getJSON('/api/foods/search', {
                    q
                }, function(list) {
                    const $r = $('#results').empty();
                    if (!list.length) {
                        $r.append('<div class="px-2 py-1 small text-muted">Nada encontrado.</div>');
                        return;
                    }
                    list.forEach(f => {
                        $r.append(
                            `<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center food-result" data-id="${f.id}">
          <span>${f.name}</span>
          <span class="badge bg-secondary">${Math.round(f.calories)} kcal/100g</span>
        </button>`
                        );
                    });
                });
            });

            $(document).on('click', '.food-result', function() {
                const id = $(this).data('id');
                $.getJSON(`/foods/${id}`, function(food) {
                    currentFood = food;
                    showFoodDetail(food);
                });
            });

            $('#backToResults').on('click', () => {
                $('#food-detail-view').hide();
                $('#food-search-view').show();
                currentFood = null;
            });

            function showFoodDetail(food) {
                $('#food-search-view').hide();
                $('#food-detail-view').show();
                $('#fd-name').text(food.name);
                $('#fd-food-id').val(food.id);
                const portions = (food.portions && food.portions.length) ? food.portions : [{
                    name: '100 g',
                    grams: 100
                }];
                const $sel = $('#fd-portion').empty();
                portions.forEach(p => $sel.append(`<option value="${p.grams}">${p.name}</option>`));
                updateDetailMacros();
            }

            $('#fd-portion, #fd-qty').on('input', updateDetailMacros);

            function updateDetailMacros() {
                if (!currentFood) return;
                const gramsPerPortion = parseFloat($('#fd-portion').val());
                const qty = parseFloat($('#fd-qty').val());
                const totalGrams = gramsPerPortion * qty;

                // Assumindo que calories/protein/carbs/fat são por 100g
                const cals = (currentFood.calories * totalGrams) / 100;
                const prot = (currentFood.protein * totalGrams) / 100;
                const carbs = (currentFood.carbs * totalGrams) / 100;
                const fat = (currentFood.fat * totalGrams) / 100;

                $('#fd-calories').text(Math.round(cals));
                $('#fd-protein').text(prot.toFixed(2) + 'g');
                $('#fd-carbs').text(carbs.toFixed(2) + 'g');
                $('#fd-fat').text(fat.toFixed(2) + 'g');

                const rows = [{
                        label: 'Energia',
                        value: Math.round(cals) + ' kcal'
                    },
                    {
                        label: 'Carboidratos',
                        value: carbs.toFixed(2) + ' g'
                    },
                    {
                        label: 'Proteínas',
                        value: prot.toFixed(2) + ' g'
                    },
                    {
                        label: 'Gorduras',
                        value: fat.toFixed(2) + ' g'
                    },
                ];
                const $tbody = $('#fd-nutrition-rows').empty();
                rows.forEach(r => $tbody.append(`<tr><td>${r.label}</td><td class="text-end">${r.value}</td></tr>`));
            }

            $('#addFoodForm').on('submit', function(e) {
                e.preventDefault();
                if (!currentFood) return;
                const gramsPerPortion = parseFloat($('#fd-portion').val());
                const qty = parseFloat($('#fd-qty').val());
                const totalGrams = gramsPerPortion * qty;

                $.post("{{ route('meal.store') }}", {
                    _token: '{{ csrf_token() }}',
                    food_id: $('#fd-food-id').val(),
                    meal_type: $('#meal_type_input').val() || 'Manhã',
                    portion_name: $('#fd-portion option:selected').text(),
                    portion_grams: gramsPerPortion,
                    quantity: qty,
                    total_grams: totalGrams
                }).done(res => {
                    if (res.success) {
                        bootstrap.Modal.getInstance(document.getElementById('foodSearchModal')).hide();
                        location.reload();
                    } else alert('Erro ao salvar.');
                }).fail(() => alert('Erro ao salvar.'));
            });
        </script>
        
    @endpush
@endsection
