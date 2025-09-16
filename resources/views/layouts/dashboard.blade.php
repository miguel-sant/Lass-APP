@extends('layouts.app')

@section('title', 'Controle Nutricional')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* O CSS permanece o mesmo, pois já está correto para o design. */
        :root {
            --body-bg: #F7F8FA;
            --card-bg: #FFFFFF;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --border-color: #E2E8F0;
            --shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
            --c-morning: #FFD66B;
            --c-morning-bg: #FFF9E9;
            --c-afternoon: #FFA86B;
            --c-afternoon-bg: #FFF2E9;
            --c-evening: #A282E8;
            --c-evening-bg: #F3F0FF;
            --c-success: #10B981;
            --c-success-light: #E7F8F3;
            --c-carbs: #3B82F6;
            --c-protein: #EF4444;
            --c-fat: #F59E0B;
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
        }

        .main-content {
            padding: 2rem;
        }

        .fw-medium {
            font-weight: 500;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .card-custom {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .progress-bar-custom {
            height: 8px;
            background-color: #F1F5F9;
            border-radius: 8px;
            overflow: hidden;
        }

        .progress-bar-custom .progress {
            height: 100%;
            border-radius: 8px;
        }

        .meal-card {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            border: none;
            box-shadow: none;
        }

        .meal-card .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .meal-card .icon-bg {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .meal-card .title {
            font-weight: 600;
        }

        .meal-card .calories {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .meal-card .add-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            color: var(--text-secondary);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .meal-card .footer {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .meal-card.morning {
            background-color: var(--c-morning-bg);
        }

        .meal-card.morning .icon-bg {
            background-color: var(--c-morning);
            color: #8C5B00;
        }

        .meal-card.afternoon {
            background-color: var(--c-afternoon-bg);
            border: 1px solid var(--c-afternoon);
        }

        .meal-card.afternoon .icon-bg {
            background-color: var(--c-afternoon);
            color: #8C4600;
        }

        .meal-card.evening {
            background-color: var(--c-evening-bg);
        }

        .meal-card.evening .icon-bg {
            background-color: var(--c-evening);
            color: white;
        }

        .summary-progress-circle {
            position: relative;
            width: 180px;
            height: 180px;
        }

        .summary-progress-circle svg {
            transform: rotate(-90deg);
        }

        .summary-progress-circle .circle-bg {
            stroke: #F1F5F9;
        }

        .summary-progress-circle .circle-progress {
            stroke: var(--c-success);
            stroke-linecap: round;
            transition: stroke-dashoffset 1.5s ease-out;
        }

        .summary-progress-circle .circle-text {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .summary-progress-circle .circle-text .value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
            color: var(--text-primary);
        }

        .summary-progress-circle .circle-text .label {
            font-size: 1rem;
            color: var(--text-secondary);
        }

        .summary-stats .stat-item {
            background-color: #F8FAFC;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
        }

        .summary-stats .stat-item .value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .summary-stats .stat-item .label {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .macros-list .macro-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .macros-list .macro-item+.macro-item {
            margin-top: 1.5rem;
        }

        .macros-list .macro-label {
            width: 100px;
            font-weight: 500;
        }

        .macros-list .macro-bar {
            flex: 1;
        }

        .macros-list .macro-values {
            font-size: 0.9rem;
            color: var(--text-secondary);
            min-width: 90px;
            text-align: right;
        }

        .macros-list .progress-bar-custom {
            height: 10px;
        }

        .streak-card .streak-count {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .streak-card .streak-count .value {
            font-size: 3rem;
            font-weight: 700;
            color: var(--c-success);
            line-height: 1;
        }

        .streak-card .streak-count .label {
            color: var(--text-secondary);
        }

        .streak-calendar .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
        }

        .streak-calendar .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            gap: 0.5rem;
        }

        .streak-calendar .day-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1 / 1;
            border-radius: 12px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .streak-calendar .day-cell.is-streak {
            background-color: var(--c-success-light);
        }

        .streak-calendar .day-cell.is-today {
            background-color: var(--c-success);
            color: white;
            font-weight: 700;
        }

        .streak-calendar .day-cell.other-month {
            visibility: hidden;
        }
    </style>
@endpush

@section('content')
    @php
            $periods = [
        'Manhã' => ['theme' => 'morning', 'icon' => 'fa-sun'],
        'Tarde' => ['theme' => 'afternoon', 'icon' => 'fa-cloud-sun'],
        'Noite' => ['theme' => 'evening', 'icon' => 'fa-moon']
    ];

    // Meta diária e por período
    $calorieGoal = $user->daily_calorie_target ?? 2000;
    $periodGoal = round($calorieGoal / 3);

    // Totais do dia
    $totalCaloriesConsumed = round($sums['calories'] ?? 0);
    $caloriesRemaining = max(0, $calorieGoal - $totalCaloriesConsumed);
    $calorieProgressPercent = $calorieGoal > 0 ? min(100, ($totalCaloriesConsumed / $calorieGoal) * 100) : 0;

    $carbsConsumed = round($sums['carbs'] ?? 0);
    $proteinConsumed = round($sums['protein'] ?? 0);
    $fatConsumed = round($sums['fat'] ?? 0);

    // Lógica do Calendário para Sequência da Dieta (usando a data atual)
    $selectedDate = now();
    $daysInMonth = $selectedDate->daysInMonth;
    $firstDayOfMonth = $selectedDate->copy()->startOfMonth();
        $blanks = $firstDayOfMonth->dayOfWeek; // 0 (Domingo) a 6 (Sábado)
    @endphp

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 fw-bold mb-1">Controle Nutricional</h1>
                <p class="text-secondary mb-0">Gerencie sua alimentação diária</p>
            </div>
            <div class="d-flex align-items-center gap-2 text-secondary fw-medium">
                <i class="far fa-calendar-alt"></i>
                <span>Hoje</span>
            </div>
        </div>

        <div class="row g-4 mb-4">
        @foreach ($periods as $name => $details)
            @php
                $consumed = round($sumsByPeriod[$name]['calories'] ?? 0);
                $remaining = max(0, $periodGoal - $consumed);
                $progress = $periodGoal > 0 ? min(100, ($consumed / $periodGoal) * 100) : 0;
            @endphp
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card-custom meal-card {{ $details['theme'] }}">
                    <div class="header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-bg"><i class="fas {{ $details['icon'] }}"></i></div>
                            <div>
                                <div class="title">{{ $name }}</div>
                                <div class="calories">{{ $consumed }} / {{ $periodGoal }} kcal</div>
                            </div>
                        </div>
                        <button class="add-btn">+</button>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress" style="width: {{ $progress }}%; background-color: var(--c-{{ $details['theme'] }});"></div>
                    </div>
                    <div class="footer">
                        <span>{{ round($progress) }}% consumido</span>
                        <span>{{ $remaining }} restantes</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

        <div class="row g-4">
            {{-- COLUNA DA ESQUERDA --}}
            <div class="col-lg-7">
                {{-- CARD ÚNICO PARA RESUMO E MACROS --}}
                <div class="card-custom">
                    {{-- SEÇÃO RESUMO DO DIA --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="section-title mb-0"><i class="fas fa-chart-pie"></i>Resumo do Dia</h3>
                        <div class="date">{{ $selectedDate->format('d/m/Y') }}</div>
                    </div>
                    <div class="row align-items-center g-4">
                        <div class="col-md-5 d-flex justify-content-center">
                            <div class="summary-progress-circle">
                                <svg viewBox="0 0 100 100">
                                    <circle class="circle-bg" cx="50" cy="50" r="45" stroke-width="10"
                                        fill="none" />
                                    @php
                                        $circumference = 2 * pi() * 45;
                                        $offset = $circumference - ($calorieProgressPercent / 100) * $circumference;
                                    @endphp
                                    <circle class="circle-progress" cx="50" cy="50" r="45" stroke-width="10"
                                        fill="none" stroke-dasharray="{{ $circumference }}"
                                        stroke-dashoffset="{{ $offset }}" />
                                </svg>
                                <div class="circle-text">
                                    <span class="value">{{ $caloriesRemaining }}</span>
                                    <span class="label">Restantes</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="summary-stats row g-3">
                                <div class="col-6">
                                    <div class="stat-item">
                                        <div class="value">{{ $totalCaloriesConsumed }}</div>
                                        <div class="label">Consumidas</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <div class="value">{{ $calorieGoal }}</div>
                                        <div class="label">Meta</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <div class="value">0</div>
                                        <div class="label">Gastas</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <div class="value">{{ round($calorieProgressPercent) }}%</div>
                                        <div class="label">Progresso</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5"> {{-- Divisor visual --}}

                    {{-- SEÇÃO MACRONUTRIENTES (AGORA DENTRO DO MESMO CARD) --}}
                {{-- MACROS --}}
                <h3 class="section-title"><i class="fas fa-utensils"></i>Macronutrientes</h3>
                <div class="macros-list">
                    <div class="macro-item">
                        <div class="macro-label">Carboidratos</div>
                        <div class="macro-bar">
                            <div class="progress-bar-custom">
                                <div class="progress"
                                    style="width: {{ $user->daily_carbs_target > 0 ? min(100, ($carbsConsumed / $user->daily_carbs_target) * 100) : 0 }}%; background-color: var(--c-carbs);">
                                </div>
                            </div>
                        </div>
                        <div class="macro-values">{{ $carbsConsumed }}g / {{ $user->daily_carbs_target }}g</div>
                    </div>
                    <div class="macro-item">
                        <div class="macro-label">Proteínas</div>
                        <div class="macro-bar">
                            <div class="progress-bar-custom">
                                <div class="progress"
                                    style="width: {{ $user->daily_protein_target > 0 ? min(100, ($proteinConsumed / $user->daily_protein_target) * 100) : 0 }}%; background-color: var(--c-protein);">
                                </div>
                            </div>
                        </div>
                        <div class="macro-values">{{ $proteinConsumed }}g / {{ $user->daily_protein_target }}g</div>
                    </div>
                    <div class="macro-item">
                        <div class="macro-label">Gorduras</div>
                        <div class="macro-bar">
                            <div class="progress-bar-custom">
                                <div class="progress"
                                    style="width: {{ $user->daily_fat_target > 0 ? min(100, ($fatConsumed / $user->daily_fat_target) * 100) : 0 }}%; background-color: var(--c-fat);">
                                </div>
                            </div>
                        </div>
                        <div class="macro-values">{{ $fatConsumed }}g / {{ $user->daily_fat_target }}g</div>
                    </div>
                </div>
            </div>
        </div>

            {{-- COLUNA DA DIREITA --}}
            <div class="col-lg-5">
                <div class="card-custom streak-card">
                    <h3 class="section-title"><i class="fas fa-chart-line"></i>Sequência Dieta</h3>
                    <div class="streak-count">
                        <div class="value">{{ $currentStreak ?? 0 }}</div>
                        <div class="label">dias consecutivos</div>
                    </div>
                    <div class="streak-calendar">
                        <div class="calendar-header">
                            @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $day)
                                <div>{{ $day }}</div>
                            @endforeach
                        </div>
                        <div class="calendar-grid">
                            @for ($i = 0; $i < $blanks; $i++)
                                <div class="day-cell other-month"></div>
                            @endfor
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $currentDayDate = $selectedDate->copy()->day($day);
                                    $dateString = $currentDayDate->format('Y-m-d');
                                    $isToday = $currentDayDate->isToday();
                                    $isStreak = isset($streaks[$dateString]);
                                @endphp
                                <div
                                    class="day-cell {{ $isToday ? 'is-today' : '' }} {{ $isStreak && !$isToday ? 'is-streak' : '' }}">
                                    {{ $day }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label small">Adicionar por foto (IA)</label>
            <input type="file" id="aiImage" accept="image/*" class="form-control form-control-sm mb-2">
            <button type="button" id="btnAnalyzeAI" class="btn btn-outline-primary btn-sm">Analisar Foto</button>
            <div id="ai-status" class="small text-muted mt-1"></div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#btnAnalyzeAI').on('click', function() {
                    const f = $('#aiImage')[0]?.files[0];
                    if (!f) {
                        alert('Selecione uma imagem.');
                        return;
                    }
                    const fd = new FormData();
                    fd.append('image', f);
                    fd.append('goal', 'Maintain weight');

                    $('#btnAnalyzeAI').prop('disabled', true);
                    $('#ai-status').text('Analisando...');

                    fetch('/api/nutrition/analyze', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: fd
                    }).then(r => r.json()).then(j => {
                        $('#btnAnalyzeAI').prop('disabled', false);
                        if (!j.success || !j.data) {
                            $('#ai-status').text('Falha IA');
                            return;
                        }
                        const d = j.data;
                        console.log(d);
                        $('#ai-status').html(
                            'Detectado: ' + (d.identified_foods || []).join(', ') + '<br>' +
                            'Calorias: ' + (d.nutrients?.calories || 0) + ' kcal<br>' +
                            'Proteína: ' + (d.nutrients?.protein || 0) + 'g<br>' +
                            'Carboidratos: ' + (d.nutrients?.carbohydrates || 0) + 'g<br>' +
                            'Gorduras: ' + (d.nutrients?.fat || 0) + 'g'
                        );

                        const now = new Date();
                        let period = 'Manhã';
                        if (now.getHours() >= 12 && now.getHours() < 18) period = 'Tarde';
                        if (now.getHours() >= 18) period = 'Noite';
                        console.log(d.nutrients.calories);
                        $.post('/api/meals', {
                            meal_type: period,
                            calories: d.nutrients?.calories || 0,
                            protein: d.nutrients?.protein || 0,
                            carbs: d.nutrients?.carbohydrates || 0,
                            fat: d.nutrients?.fat || 0,
                            consumed_at: now.toISOString().slice(0, 19).replace('T', ' ')
                        }, function(resp) {
                            location.reload();
                        });
                    }).catch(() => {
                        $('#btnAnalyzeAI').prop('disabled', false);
                        $('#ai-status').text('Erro na requisição.');
                    });
                });
            });
        </script>
    @endpush
@endsection
