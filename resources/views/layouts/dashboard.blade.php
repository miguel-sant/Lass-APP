@extends('layouts.app')

@section('content')
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
                        <div class="meal-period-chart-container mx-auto" data-meal-type="Manhã" data-bs-toggle="modal" data-bs-target="#foodSearchModal">
                            <canvas id="morningChart"></canvas>
                            <div class="meal-period-icon">
                                <i class="fas fa-mug-hot"></i>
                            </div>
                        </div>
                        <div class="mt-2 fw-bold">Manhã</div>
                        <div class="small text-muted" id="morning-calories">0 / {{ round($user->daily_calorie_target / 3) }} kcal</div>
                    </div>
                    <div class="col">
                         <div class="meal-period-chart-container mx-auto" data-meal-type="Tarde" data-bs-toggle="modal" data-bs-target="#foodSearchModal">
                            <canvas id="afternoonChart"></canvas>
                             <div class="meal-period-icon">
                                <i class="fas fa-sun"></i>
                            </div>
                        </div>
                        <div class="mt-2 fw-bold">Tarde</div>
                        <div class="small text-muted" id="afternoon-calories">0 / {{ round($user->daily_calorie_target / 3) }} kcal</div>
                    </div>
                    <div class="col">
                        <div class="meal-period-chart-container mx-auto" data-meal-type="Noite" data-bs-toggle="modal" data-bs-target="#foodSearchModal">
                            <canvas id="eveningChart"></canvas>
                            <div class="meal-period-icon">
                                <i class="fas fa-moon"></i>
                            </div>
                        </div>
                        <div class="mt-2 fw-bold">Noite</div>
                        <div class="small text-muted" id="evening-calories">0 / {{ round($user->daily_calorie_target / 3) }} kcal</div>
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
        </div>
    </div>

    @include('partials._food_search_modal')

    @push('scripts')
        <script>
            $(function() {
                // Configura o CSRF para chamadas AJAX
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
                    // Opcional: Limpar busca anterior ao abrir o modal
                    $('#searchInput').val('');
                    $('#results').html('');
                    $('#foodSearchModalLabel').text('Adicionar em: ' + currentMealType);
                });
                
                $('#addFoodForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = $(this).serializeArray();
                    formData.push({name: "meal_type", value: currentMealType});

                    $.post("{{ route('meal.store') }}", formData)
                    .done(function(response) {
                        if(response.success) {
                            foodSearchModal.hide();
                            location.reload(); 
                        }
                    }).fail(function() {
                        alert('Ocorreu um erro ao adicionar o alimento.');
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
                    const proteinPercent = goals.protein > 0 ? Math.min(100, (consumed.protein / goals.protein) * 100) : 0;
                    $('#protein-progress').css('width', proteinPercent + '%').attr('aria-valuenow', proteinPercent);
                    const carbsPercent = goals.carbs > 0 ? Math.min(100, (consumed.carbs / goals.carbs) * 100) : 0;
                    $('#carbs-progress').css('width', carbsPercent + '%').attr('aria-valuenow', carbsPercent);
                    const fatPercent = goals.fat > 0 ? Math.min(100, (consumed.fat / goals.fat) * 100) : 0;
                    $('#fat-progress').css('width', fatPercent + '%').attr('aria-valuenow', fatPercent);

                    // --- Renderizar Gráfico de Calorias Principal ---
                    renderDonutChart('caloriesChart', [consumed.calories, remainingCalories], ['#3b82f6', '#e5e7eb'], '80%');
                
                    // --- Renderizar Gráficos por Turno ---
                    const periodGoal = Math.round(goals.calories / 3);
                    
                    const morningConsumed = Math.round(sumsByPeriod.Manhã.calories);
                    const morningRemaining = Math.max(0, periodGoal - morningConsumed);
                    $('#morning-calories').text(`${morningConsumed} / ${periodGoal} kcal`);
                    renderDonutChart('morningChart', [morningConsumed, morningRemaining], ['#facc15', '#f3f4f6'], '75%');

                    const afternoonConsumed = Math.round(sumsByPeriod.Tarde.calories);
                    const afternoonRemaining = Math.max(0, periodGoal - afternoonConsumed);
                    $('#afternoon-calories').text(`${afternoonConsumed} / ${periodGoal} kcal`);
                    renderDonutChart('afternoonChart', [afternoonConsumed, afternoonRemaining], ['#fb923c', '#f3f4f6'], '75%');

                    const eveningConsumed = Math.round(sumsByPeriod.Noite.calories);
                    const eveningRemaining = Math.max(0, periodGoal - eveningConsumed);
                    $('#evening-calories').text(`${eveningConsumed} / ${periodGoal} kcal`);
                    renderDonutChart('eveningChart', [eveningConsumed, eveningRemaining], ['#60a5fa', '#f3f4f6'], '75%');
                
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

                    let mealsByPeriod = { Manhã: [], Tarde: [], Noite: [] };
                    recentMeals.forEach(meal => {
                        if (mealsByPeriod[meal.meal_type]) {
                            mealsByPeriod[meal.meal_type].push(meal);
                        }
                    });
                    
                    const renderList = (period, meals) => {
                        const $list = $(`#meal-list-${period.toLowerCase()} ul`);
                        if(meals.length > 0) {
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
                                legend: { display: false },
                                tooltip: { enabled: false }
                            },
                            events: [] // Desabilita interações com o gráfico
                        }
                    });
                }

                // Carga inicial
                updateDashboardUI();
            });
        </script>
    @endpush
@endsection